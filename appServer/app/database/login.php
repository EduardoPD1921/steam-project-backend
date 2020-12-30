<?php
require_once('../models/UserLogin.php');

$encodedData = file_get_contents('php://input');
$decodedData = json_decode($encodedData, true);

$email = $decodedData['email'];
$password = $decodedData['password'];

$userLogin = new UserLogin();

$userLogin->setEmail($email);
$userLogin->setPassword($password);

$userLogin->login();