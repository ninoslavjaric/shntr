<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */

require(__DIR__ . '/../bootstrap.php');

try {
    $transactions = $db->query('select id, amount, sender_id, recipient_id, recipient_relysia_paymail, `count`  from token_transactions where is_completed = false')
        ->fetch_all(MYSQLI_ASSOC);

    foreach ($transactions as $transaction){

        $response = shntrToken::sendTransactionRelysia(
            $transaction['amount'],
            $transaction['recipient_relysia_paymail'],
            $transaction['sender_id']
        );

        error_log('Processing transaction to: ' . $transaction['recipient_relysia_paymail'] . ', Response: ' . json_encode([$response, $transaction]));

        if ($response['statusCode'] === 200) {

            $db->query(sprintf("UPDATE token_transactions SET is_completed = 1, count = 1 WHERE id = %s",
                secure($transaction['id'], 'int'))) or _error("SQL_ERROR_THROWEN", $db);

            $senderBalance = shntrToken::getRelysiaApiBalance($transaction['sender_id']);
            $recipientBalance = shntrToken::getRelysiaApiBalance($transaction['recipient_id']);

            $db->query(sprintf('UPDATE users_relysia SET balance = %s WHERE user_id = %s',
                    secure($senderBalance),secure($transaction['sender_id']))
            ) or _error("SQL_ERROR_THROWEN", $db);

            $db->query(sprintf('UPDATE users_relysia SET balance = %s WHERE user_id = %s',
                    secure($recipientBalance),secure($transaction['recipient_id']))
            ) or _error("SQL_ERROR_THROWEN", $db);

            error_log('Successfully sent to: ' . $transaction['recipient_relysia_paymail'] . ', Response: ' . json_encode([$response, $transaction]));
        } else {
            $db->query(sprintf("UPDATE token_transactions SET count = count + 1 WHERE id = %s",
                secure($transaction['id'], 'int'))) or _error("SQL_ERROR_THROWEN", $db);
        }
    }

} catch (Exception $e) {
    error_log('Processing transactions failed ' . $e->getMessage());
}
