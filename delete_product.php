<?php
try {
    $dbh = dbConnect();
    $sql = 'DELETE FROM products WHERE `id` = :delete_id';
    $data = array(':delete_id' => $delete_id);
    $stmt = queryPost($dbh, $sql, $data);
    
    header("Location:" . $_SERVER['PHP_SELF']);
} catch ( Exception $e ) {
    error_log('エラー発生:' . $e->getMessage());
    $err_msg['common'] = MSG::UNEXPECTED;
}