<?php


/**
 * @var mysqli $db
 */
class shntrToken
{
    private const AVOIDABLES = [
        'design.shntr.com', 'localhost'
    ];
    private const ENCRYPTION_ALGO = 'bf-cbc';

    public static function getPurse()
    {
        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES)) {
            return [
                'satoshis' => 1000,
            ];
        }

        return http_call(shntr_TOKEN_SERVICE . '/purse');
    }

    private static function encrypt(string $data): string
    {
        return openssl_encrypt($data, self::ENCRYPTION_ALGO, getenv('shntr_TOKEN_PASSPHRASE'));
    }

    private static function decrypt(string $data): string|bool
    {
        return openssl_decrypt($data, self::ENCRYPTION_ALGO, getenv('shntr_TOKEN_PASSPHRASE'));
    }

    public static function generateWallet()
    {
        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES)) {
            return [
                'private' => self::encrypt('private'),
                'public' => 'public',
                'address' => 'address',
            ];
        }

        $params = http_call(shntr_TOKEN_SERVICE . '/generate-wallet');

        $params['private'] = self::encrypt($params['private']);

        return $params;
    }

    public static function getBalance()
    {
        global $user;

        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES)) {
            return [
                'amount' => 1000,
            ];
        }

        return http_call(shntr_TOKEN_SERVICE . '/balance', 'GET', [], [
            "x-key: {$user->_data['user_token_private_key']}"
        ]);
    }

    public static function pay($senderPrivateKey, $recipientAddress, $amount)
    {
        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES)) {
            return [
                'message' => "{$amount} tokens sent successfully",
            ];
        }

        $senderPrivateKey = self::decrypt($senderPrivateKey);

        $paymentMessage = http_call(
            shntr_TOKEN_SERVICE . '/pay',
            'POST',
            [
                'recipientAddress' => $recipientAddress,
                'amount' => floatval($amount),
            ],
            [
                "x-key: {$senderPrivateKey}",
                "content-type: application/json",
            ],
        );

        if (!$paymentMessage) {
            _error('PAYMENT_shntr');
        }

        return $paymentMessage;
    }

    private static function transformInsertQuery(array $params): string
    {
        global $db;

        $values = array_map(function($value) use ($db) {
            return is_null($value) ? 'NULL' : ("'" . $db->escape_string($value) . "'");
        }, array_values($params));

        return sprintf(
            'insert into token_transactions (%s) values (%s)',
            implode(', ', array_keys($params)),
            implode(', ', $values)
        );
    }

    public static function noteTransaction(
        float $amount, int $senderId, int $recipientId, ?string $basisName = null, ?int $basisId = null, ?string $note = null
    )
    {
        global $db;
        $columns = array_slice(
            ['amount', 'sender_id', 'recipient_id', 'basis_name', 'basis_entity_id', 'note'], 0, func_num_args()
        );

        $db->query(self::transformInsertQuery(array_combine($columns, func_get_args())));
    }

    public static function getEntireHistory()
    {
        global $db;

        return $db->query(
            'select 
                amount, 
                created_at, 
                snd.user_name as sender_name, 
                rcp.user_name as recipient_name, 
                note,
                coalesce(
                   concat(\'/events/\', e.event_id),
                   concat(\'/pages/\', pg.page_name),
                   concat(\'/groups/\', g.group_name),
                   concat(\'/posts/\', pd.post_id),
                   concat(\'/\', u.user_name)
                ) as link
            from token_transactions
                inner join users as snd on snd.user_id = sender_id
                inner join users as rcp on rcp.user_id = recipient_id
                left join events as e on e.event_id = basis_entity_id and basis_name = \'events\'
                left join pages as pg on pg.page_id = basis_entity_id and basis_name = \'pages\'
                left join `groups` as g on g.group_id = basis_entity_id and basis_name = \'groups\'
                left join posts_products as pd on (pd.post_id = basis_entity_id and basis_name = \'products\') OR (pd.product_id = basis_entity_id and basis_name = \'post_products\')
                left join users as u on u.user_id = basis_entity_id and basis_name in (\'users\',\'paywalls\')
            order by created_at desc'
        )->fetch_all(MYSQLI_ASSOC);
    }

    public static function getHistory(int $userId = 0)
    {
        global $db;

        return $db->query(
            "select 
                amount, 
                if(sender_id = {$userId}, 'outgoing', 'incoming') as type, 
                created_at, 
                note, 
                snd.user_name as sender_name, 
                rcp.user_name as recipient_name,
                basis_name, 
                basis_entity_id,
                coalesce(
                   concat('/events/', e.event_id),
                   concat('/pages/', pg.page_name),
                   concat('/groups/', g.group_name),
                   concat('/posts/', pd.post_id),
                   concat('/', u.user_name)
                ) as link
            from token_transactions
                inner join users as snd on snd.user_id = sender_id
                inner join users as rcp on rcp.user_id = recipient_id
                left join events as e on e.event_id = basis_entity_id and basis_name = 'events'
                left join pages as pg on pg.page_id = basis_entity_id and basis_name = 'pages'
                left join `groups` as g on g.group_id = basis_entity_id and basis_name = 'groups'
                left join posts_products as pd on (pd.post_id = basis_entity_id and basis_name = 'products') OR (pd.product_id = basis_entity_id and basis_name = 'post_products')
                left join users as u on u.user_id = basis_entity_id and basis_name in ('users', 'paywalls')
            where {$userId} in (sender_id, recipient_id)
            order by created_at desc"
        )->fetch_all(MYSQLI_ASSOC);
    }
}
