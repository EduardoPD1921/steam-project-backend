<?php
require_once('../Connection.php');

$token = $_GET['token'];
$validate_token = md5($token);

$sql = "UPDATE users SET account_auth = 1 WHERE validate_token = '$validate_token'";

$stmt = Connection::getConn()->prepare($sql);
$stmt->execute();

echo 'Conta validada';