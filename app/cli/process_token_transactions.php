<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */

require(__DIR__ . '/../bootstrap.php');

try {
    $transactions = $db->query('select id, amount, sender_id, recipient_relysia_paymail, `count`  from token_transactions where is_completed = false')
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
            error_log('Successfully sent to: ' . $transaction['recipient_relysia_paymail'] . ', Response: ' . json_encode([$response, $transaction]));
        } else {
            $db->query(sprintf("UPDATE token_transactions SET count = count + 1 WHERE id = %s",
                secure($transaction['id'], 'int'))) or _error("SQL_ERROR_THROWEN", $db);
        }
    }

} catch (Exception $e) {
    error_log('Processing transactions failed ' . $e->getMessage());
}
