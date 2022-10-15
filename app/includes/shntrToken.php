<?php


/**
 * @var mysqli $db
 * @var User $db
 */
class shntrToken
{
    private const AVOIDABLES = [
        'design.shntr.com', 'localhost'
    ];
    private const ENCRYPTION_ALGO = 'bf-cbc';
    private const TOKEN_ID = '9a0e862be07d8aa56311e5b211a4fdf9ddf03b2f-BNAF';
    private const API_BASE_URL = 'https://api.relysia.com/v1';

    public static function getshntrTreasure($key): ?string
    {
        $treasure = [
            'username' => getenv('shntr_TOKEN_USERNAME'),
            'password' => getenv('shntr_TOKEN_PASSWORD'),
            'paymail' => getenv('shntr_TOKEN_PAYMAIL'),
            'address' => getenv('shntr_TOKEN_ADDRESS'),
        ];

        return $treasure[$key] ?? null;
    }

    private static function encrypt(string $data): string
    {
        return openssl_encrypt($data, self::ENCRYPTION_ALGO, getenv('shntr_TOKEN_PASSPHRASE'));
    }

    private static function decrypt(string $data): string|bool
    {
        return openssl_decrypt($data, self::ENCRYPTION_ALGO, getenv('shntr_TOKEN_PASSPHRASE'));
    }

    public static function register(string $username): false|string
    {
        $password = generate_random_string();

        $host = $_SERVER['SERVER_NAME'] === 'localhost' ? "local.shntr.com" : $_SERVER['SERVER_NAME'];
        $email = strtolower($username) . '@' . $host;

        $response = http_call(self::API_BASE_URL . '/signUp',
            'POST',
            [
                'email' => $email,
                'password' => $password,
            ],
            [
                "content-type: application/json",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if (($response['statusCode'] ?? null) !== 200 || !isset($response['data']['token'])) {
            return false;
        }

        $response = http_call(self::API_BASE_URL . '/createWallet',
            'GET',
            [],
            [
                'walletTitle: 00000000-0000-0000-0000-000000000000',
                'paymailActivate: true',
                "authToken: {$response['data']['token']}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        return self::encrypt($password);
    }

    public static function paymail(string $token): false|array
    {
        $response = http_call(self::API_BASE_URL . '/address',
            'GET',
            [],
            [
                "authToken: {$token}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if (($response['statusCode'] ?? null) !== 200 || !isset($response['data']['paymail'])) {
            return false;
        }

        return [
            $response['data']['paymail'], $response['data']['address']
        ];
    }

    public static function auth(string $username, string $password): false|string
    {
        $host = $_SERVER['SERVER_NAME'] === 'localhost' ? "local.shntr.com" : $_SERVER['SERVER_NAME'];
        $email = $username === 'relysia@shntr.com' ? 'relysia@shntr.com' : strtolower($username) . '@' . $host;
        $password = self::decrypt($password);

        $response = http_call(self::API_BASE_URL . '/auth',
            'POST',
            [
                'email' => $email,
                'password' => $password,
            ],
            [
                "content-type: application/json",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if (($response['statusCode'] ?? null) !== 200 ||  !isset($response['data']['token'])) {
            return false;
        }

        return $response['data']['token'];
    }

    /**
     * @deprecated
     */
    public static function generateWallet()
    {
        return [
            'private' => self::encrypt('private'),
            'public' => 'public',
            'address' => 'address',
        ];
    }

    public static function getRelysiaBalance(string $user_name = null, string $password = null): float
    {
        global $user;

        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) || str_contains(SYS_URL, 'ngrok')) {
            return 1000;
        }

        if (in_array(null, [$user_name, $password])) {
            $user_name = null;
            $password = null;
        }

        $token = static::auth(
            $user_name ?? $user->_data['user_name'],
            $password ?? $user->_data['user_relysia_password']
        );

        if (!$token) {
            return 0;
        }

        $response = http_call(self::API_BASE_URL . '/balance',
            'GET',
            [],
            [
                "authToken: {$token}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if (($response['statusCode'] ?? null) !== 200 ||  !isset($response['data']['coins'])) {
            return 0;
        }

        $tokens = array_filter($response['data']['coins'], function($coin) {
            if (!array_key_exists('amount', $coin) || !array_key_exists('tokenId', $coin)) {
                return false;
            }

            return $coin['tokenId'] === static::TOKEN_ID;
        });

        return array_sum(array_column($tokens, 'amount'));
    }

    public static function payRelysia(float $amount, string $recipientPaymail, int $senderId = null): array
    {
        global $user, $db;

        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) || str_contains(SYS_URL, 'ngrok')) {
            return [
                'amount' => $amount,
                'message' => "{$amount} tokens sent successfully",
            ];
        }

        if ($senderId === null) {
            $senderUsername = $user->_data['user_name'];
            $senderPassword = $user->_data['user_relysia_password'];
        } elseif ($senderId === 0) {
            $senderUsername = static::getshntrTreasure('username');
            $senderPassword = static::getshntrTreasure('password');
        } else {
            [$senderUsername, $senderPassword] = $db->query(
                sprintf(
                    'select user_name, user_relysia_password from users where user_id = %s', secure($senderId)
                )
            )->fetch_row();
        }

        $senderToken = static::auth($senderUsername, $senderPassword);

        $balance = static::getRelysiaBalance($senderUsername, $senderPassword);

        if ($balance < $amount) {
            return [
                'amount' => $amount,
                'message' => "Not enough funds to pay {$amount} token(s).",
            ];
        }

        $response = http_call(self::API_BASE_URL . '/send',
            'POST',
            [
                'dataArray' => [
                    [
                        'to' => $recipientPaymail,
                        'amount' => $amount,
                        'tokenId' => static::TOKEN_ID,
                    ]
                ],
            ],
            [
                "content-type: application/json",
                "authToken: {$senderToken}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if ($response['statusCode'] != 200) {
            error_log('Payment fail: ' . json_encode($response, JSON_PRETTY_PRINT));
            return [
                'amount' => $amount,
                'message' => $response['msg'] ?? json_encode($response, JSON_PRETTY_PRINT),
            ];
        }

        return [
            'amount' => $amount,
            'message' => "{$amount} token(s) sent successfully",
        ];
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
                if(sender_id = 0, \'TREASURE\', snd.user_name) as sender_name,
                if(recipient_id = 0, \'TREASURE\', rcp.user_name) as recipient_name,
                note,
                coalesce(
                   concat(\'/events/\', e.event_id),
                   concat(\'/pages/\', pg.page_name),
                   concat(\'/groups/\', g.group_name),
                   concat(\'/posts/\', pd.post_id),
                   concat(\'/\', u.user_name)
                ) as link
            from token_transactions
                left join users as snd on snd.user_id = sender_id
                left join users as rcp on rcp.user_id = recipient_id
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
                if(sender_id = 0, 'TREASURE', snd.user_name) as sender_name,
                if(recipient_id = 0, 'TREASURE', rcp.user_name) as recipient_name,
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
                left join users as snd on snd.user_id = sender_id
                left join users as rcp on rcp.user_id = recipient_id
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
