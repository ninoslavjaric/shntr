<?php


/**
 * @var mysqli $db
 * @var User $db
 */
class shntrToken
{
    /*
     * every wrong token
 {
  "statusCode": 401,
  "data": {
    "status": "error",
    "msg": "Invalid authToken provided"
  }
}
     */
    private const AVOIDABLES = [
        'design.shntr.com', 'localhost', 'host.docker.internal'
    ];
    private const ENCRYPTION_ALGO = 'bf-cbc';
    private const TREASURY_USER = 'relysia@shntr.com';
    private const TOKEN_ID = '9a0e862be07d8aa56311e5b211a4fdf9ddf03b2f-SHNATST';
    private const API_BASE_URL_V1 = 'https://api.relysia.com/v1';
    private const API_BASE_URL_V2 = 'https://api.relysia.com/v2';

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

    public static function encrypt(string $data): string
    {
        return openssl_encrypt($data, self::ENCRYPTION_ALGO, getenv('shntr_TOKEN_PASSPHRASE'));
    }

    public static function decrypt(string $data): string|bool
    {
        return openssl_decrypt($data, self::ENCRYPTION_ALGO, getenv('shntr_TOKEN_PASSPHRASE'));
    }

    public static function register(string $username): false|string
    {
        $password = generate_random_string();

        $host = $_SERVER['SERVER_NAME'] === 'localhost' ? "local.shntr.com" : $_SERVER['SERVER_NAME'];
        $email = strtolower($username) . '@' . $host;

        $response = http_call(self::API_BASE_URL_V1 . '/signUp',
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

        if ($response['statusCode'] === 400 && $response['data']['msg'] === 'EMAIL_EXISTS') {
            error_log('Signup fail, email on relysia taken: ' . json_encode($response));
            return $response['data']['msg'];
        }

        if (($response['statusCode'] ?? null) !== 200 || !isset($response['data']['token'])) {
            error_log('Signup fail: ' . json_encode($response));
            return false;
        }

        $response = http_call(self::API_BASE_URL_V1 . '/createWallet',
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
        $response = http_call(self::API_BASE_URL_V1 . '/address',
            'GET',
            [],
            [
                "authToken: {$token}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if (($response['statusCode'] ?? null) !== 200 || !isset($response['data']['paymail'])) {
            error_log('Paymail fail: ' . json_encode($response));
            return false;
        }

        return [
            $response['data']['paymail'], $response['data']['address']
        ];
    }

    private static function auth(string $username, string $password): false|string
    {
        $host = in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) ? "local.shntr.com" : $_SERVER['SERVER_NAME'];
        $email = $username === 'relysia@shntr.com' ? 'relysia@shntr.com' : strtolower($username) . '@' . $host;
        $password = self::decrypt($password);

        $response = http_call(self::API_BASE_URL_V1 . '/auth',
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
            error_log('Auth fail ' . json_encode([$response, $username]));
            return false;
        }

        return $response['data']['token'];
    }

    public static function getAccessToken(?int $user_id): string
    {
        global $db;

        @[$token] = $db->query(
            sprintf(
                'select access_token from users_relysia where user_id = %s and access_token_expiration_date + INTERVAL 30 MINUTE > NOW()', secure($user_id ?? 0)
            )
        )->fetch_row();

        if ($token) {
            return $token;
        }

        @[$relysiaUser, $password] = $user_id
            ? $db->query(
                sprintf(
                    'select user_relysia_username, user_relysia_password from users where user_id = %s', secure($user_id)
                )
            )->fetch_row()
        : [static::getshntrTreasure('username'), static::getshntrTreasure('password')];

        if (!($token = static::auth(strval($relysiaUser), strval($password)))) {
            error_log('GetAccessToken fail: ' . json_encode([$relysiaUser, $password]));

            if (php_sapi_name() != 'cli') {
                _error(403);
            } else {
                throw new Exception('GetAccessToken fail: ' . json_encode($relysiaUser));
            }
        }

        $db->query(
            sprintf(
                'INSERT INTO users_relysia (user_id, access_token) VALUES (%1$s, %2$s) ON DUPLICATE KEY UPDATE access_token = %2$s, access_token_expiration_date = NOW()',
                secure($user_id ?? 0), secure($token)
            )
        ) or _error(400, $db->error);

        return $token;
    }

    public static function sync(int $user_id): array
    {
        global $db;

        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) || str_contains(SYS_URL, 'ngrok')) {
            return [
                "statusCode" => 200,
                "data" => [
                    "status" => "success",
                    "msg" => "migration started successfully"
                ]
            ];
        }

        $token = static::getAccessToken($user_id);

        return http_call(self::API_BASE_URL_V1 . '/tokenMetrics',
            'GET',
            [],
            [
                "authToken: {$token}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );
    }

    private static function syncTransactionGenerator(string $token, int $user_id): Generator
    {
        $historyMapper = function($item) use ($user_id) {
            $ajtems = [];
            foreach ($item['to'] as $recipient) {
                if ($recipient['tokenId'] !== self::TOKEN_ID) {
                    continue;
                }
                $ajtems[] = [
                    'user_id' => $user_id,
                    'to' => $recipient['to'],
                    'txId' => $recipient['txId'],
                    'from' => $item['from'],
                    'timestamp' => $item['timestamp'],
                    'balance_change' => $recipient['amount'],
                    'docId' => $item['docId'],
                    'notes' => $item['notes'] ?? '',
                    'type' => $item['type'],
                    'protocol' => $recipient['protocol'],
                ];
            }
            return $ajtems;
        };

        $headers = [
            "authToken: {$token}",
            "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            'version: 1.1.0',
        ];
        $response = http_call(self::API_BASE_URL_V1 . '/history',
            'GET',
            [],
            $headers
        );

        if (!isset($response['data']['histories'])) {
            throw new Exception('Transaction history fail: ' . json_encode($response));
        }

        $nextPageTokenId = $response['data']['meta']['nextPageToken'];

        yield array_merge(...array_map($historyMapper, $response['data']['histories']));

        while ($nextPageTokenId) {
            $response = http_call(self::API_BASE_URL_V1 . '/history?nextPageToken=' . $nextPageTokenId,
                'GET',
                [],
                $headers
            );

            if (!isset($response['data']['histories'])) {
                error_log('Transaction history fail: ' . json_encode($response));
            }

            $nextPageTokenId = $response['data']['meta']['nextPageToken'];
            yield array_merge(...array_map($historyMapper, $response['data']['histories']));
        }
    }

    public static function syncTransactions(?int $user_id, bool $increment = true): array
    {
        global $db;

        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) || str_contains(SYS_URL, 'ngrok')) {
            return [
                'message' => 'Sync have just started',
            ];
        }

        @[$syncInProgress] = $db->query(
            sprintf(
                'select transaction_in_progress from users_relysia where user_id = %s', secure($user_id)
            )
        )->fetch_row();

        if ($syncInProgress) {
            return [
                'message' => 'Sync is still in progress'
            ];
        }

        $token = static::getAccessToken($user_id);

        $db->query(
            sprintf('update users_relysia set transaction_in_progress = 1 where user_id = %s', secure($user_id))
        );

        return [
            'message' => 'Sync have just started',
            'callback' => function() use ($token, $user_id, $db, $increment) {
                try {
                    if (!$increment) {
                        $db->query("delete from users_relysia_transactions where user_id = {$user_id}") or error_log('Transaction insert fail: ' . $db->error);
                    }
                    [$maxDate] = $db->query("select max(timestamp) from users_relysia_transactions where user_id = {$user_id}")->fetch_row();
                    $maxDate = $maxDate ? new DateTime($maxDate) : (new DateTime())->setTimestamp(0);
                    foreach (self::syncTransactionGenerator($token, $user_id) as $histories) {
                        foreach ($histories as $history) {
                            if (new DateTime($history['timestamp']) <= $maxDate) {
                                goto finish_iteration;
                            }

                            $history['user_id'] = $user_id;
                            $sql = self::transformInsertQuery($history, 'users_relysia_transactions', true);
                            $db->query($sql) or error_log('Transaction insert fail: ' . $db->error);
                        }
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
                finish_iteration:
                $db->query(
                    sprintf('update users_relysia set transaction_in_progress = 0 where user_id = %s', secure($user_id))
                );
            }
        ];
    }

    public static function getCredentials(int $user_id): array
    {
        global $db;

        [$username, $password] = $db->query(
            "select user_relysia_username, user_relysia_password from users where user_id = {$user_id}"
        )->fetch_row();

        $host = in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) ? "local.shntr.com" : $_SERVER['SERVER_NAME'];
        $email = $username === 'relysia@shntr.com' ? 'relysia@shntr.com' : strtolower($username) . '@' . $host;

        return [$email, self::decrypt($password)];
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

    public static function getRelysiaBalance(?int $user_id, bool $force = false): float
    {
        global $db;

        if (in_array($_SERVER['SERVER_NAME'], self::AVOIDABLES) || str_contains(SYS_URL, 'ngrok')) {
            return 1000;
        }

        if (!$force) {
            $query = $db->query(
                sprintf('select balance from users_relysia where user_id = %s', secure($user_id ?? 0))
            ) or _error('SQL_ERROR_THROWEN', $db->error);

            [$balance] = $query->fetch_row();

            if (!is_null($balance)) {
                return $balance;
            }
        }

        $token = static::getAccessToken($user_id);

        if (!$token) {
            return 0;
        }

        $response = http_call(self::API_BASE_URL_V2 . '/balance',
            'GET',
            [],
            [
                "authToken: {$token}",
                "serviceID: 9ab1b69e-92ae-4612-9a4f-c5a102a6c068",
            ]
        );

        if (($response['data']['status'] ?? null) !== 'success' || !isset($response['data']['coins'])) {
            error_log('Balance fail: ' . json_encode($response));
            return 0;
        }

        $tokens = array_filter($response['data']['coins'], function ($coin) {
            if (!array_key_exists('amount', $coin) || !array_key_exists('tokenId', $coin)) {
                return false;
            }

            return $coin['tokenId'] === static::TOKEN_ID;
        });

        $balance = array_sum(array_column($tokens, 'amount'));

        $db->query(
            sprintf(
                'update users_relysia set balance = %s where user_id = %s',
                secure($balance),
                secure($user_id)
            )
        ) or _error('SQL_ERROR_THROWEN');

        return $balance;
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
            $senderId = $user->_data['user_id'];
            $senderUsername = $user->_data['user_name'];
            $senderPassword = $user->_data['user_relysia_password'];
        } elseif ($senderId === 0) {
            $senderId = null;
            $senderUsername = static::getshntrTreasure('username');
            $senderPassword = static::getshntrTreasure('password');
        } else {
            [$senderUsername, $senderPassword] = $db->query(
                sprintf(
                    'select user_name, user_relysia_password from users where user_id = %s', secure($senderId)
                )
            )->fetch_row();
        }

        $senderToken = static::getAccessToken($senderId);

        $balance = static::getRelysiaBalance($senderId);

        if ($balance < $amount) {
            return [
                'amount' => $amount,
                'message' => "Not enough funds to pay {$amount} token(s).",
            ];
        }

        $response = http_call(self::API_BASE_URL_V1 . '/send',
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

    private static function transformInsertQuery(
        array $params, string $tableName = 'token_transactions', $insertIgnore = false
    ): string
    {
        global $db;

        $values = array_map(function ($value) use ($db) {
            return is_null($value) ? 'NULL' : ("'" . $db->escape_string($value) . "'");
        }, array_values($params));

        return sprintf(
            'insert%s into %s (%s) values (%s)',
            $insertIgnore ? ' ignore' : '',
            $tableName,
            '`' . implode('`, `', array_keys($params)) . '`',
            implode(', ', $values)
        );
    }

    public static function noteTransaction(
        float $amount, int $senderId, int $recipientId, ?string $basisName = null, ?int $basisId = null, ?string $note = null, ?string $senderMsg = null
    )
    {
        global $db;
        $columns = array_slice(
            ['amount', 'sender_id', 'recipient_id', 'basis_name', 'basis_entity_id', 'note', 'sender_msg'], 0, func_num_args()
        );

        $db->query(self::transformInsertQuery(array_combine($columns, func_get_args())));

        return $db->insert_id;
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
                token_transactions.sender_msg,
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

    public static function gatTokenTransactionById(int $id = 0)
    {
        global $db;

        $get_transaction = $db->query(sprintf("SELECT id, amount, sender_id, recipient_id, basis_name, created_at FROM token_transactions WHERE id = %s", secure($id, 'int'))) or _error("SQL_ERROR_THROWEN");
        if ($get_transaction->num_rows == 0) {
            _error(403);
        }

        $transaction = $get_transaction->fetch_assoc();
        return $transaction;
    }
}
