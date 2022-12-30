<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */
define('CLI_SESSION', 'crontab-' . date('YmdHis'));
require(__DIR__ . '/../bootstrap.php');

try {
    $transactions = $db->query('select id, amount, note, sender_id, recipient_id, recipient_relysia_paymail, `count`  from token_transactions where is_completed = false')
        ->fetch_all(MYSQLI_ASSOC);

    foreach ($transactions as $transaction){

        $time_start = microtime(true);

        $response = shntrToken::sendTransactionRelysia(
            $transaction['amount'],
            $transaction['recipient_relysia_paymail'],
            $transaction['sender_id']
        );

        $time_end = microtime(true);
        $execution_time = $time_end - $time_start;

        $errorBody = [
            'message' => 'Processing transaction',
            'execution time' => $execution_time,
            'transaction' => $transaction,
            'response' => $response
        ];
        trigger_error(json_encode($errorBody));

        if ($response['statusCode'] === 200) {

            $db->query(sprintf("UPDATE token_transactions SET is_completed = 1, count = 1 WHERE id = %s",
                secure($transaction['id'], 'int'))) or _error("SQL_ERROR_THROWEN", $db);

            $time_start = microtime(true);
            $senderBalance = shntrToken::getRelysiaApiBalance($transaction['sender_id']);
            $time_end = microtime(true);
            $execution_time = $time_end - $time_start;
            $errorBody = [
                'message' => 'get balance for sender',
                'execution time' => $execution_time
            ];
            trigger_error(json_encode($errorBody));

            $time_start = microtime(true);
            $recipientBalance = shntrToken::getRelysiaApiBalance($transaction['recipient_id']);
            $time_end = microtime(true);
            $execution_time = $time_end - $time_start;
            $errorBody = [
                'message' => 'get balance for recipient',
                'execution time' => $execution_time
            ];
            trigger_error(json_encode($errorBody));

            $db->query(sprintf('UPDATE users_relysia SET balance = %s WHERE user_id = %s',
                    secure($senderBalance),secure($transaction['sender_id']))
            ) or _error("SQL_ERROR_THROWEN", $db);

            $db->query(sprintf('UPDATE users_relysia SET balance = %s WHERE user_id = %s',
                    secure($recipientBalance),secure($transaction['recipient_id']))
            ) or _error("SQL_ERROR_THROWEN", $db);

            $errorBody = [
                'message' => 'Successfully sent',
                'transaction' => $transaction,
                'response' => $response
            ];
            trigger_error(json_encode($errorBody));
        } else {
            $db->query(sprintf("UPDATE token_transactions SET count = count + 1 WHERE id = %s",
                secure($transaction['id'], 'int'))) or _error("SQL_ERROR_THROWEN", $db);
        }
    }

} catch (Exception $e) {
    trigger_error('Processing transactions failed ' . $e->getMessage());
}
