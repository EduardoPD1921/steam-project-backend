<?php
require_once('../models/UserUpdateInfo.php');

$encodedData = file_get_contents('php://input');
$decodedData = json_decode($encodedData, true);

$id = $decodedData['id'];
$email = $decodedData['email'];
$userName = $decodedData['userName'];
$phoneNumber = $decodedData['phoneNumber'];

$userUpdateInfo = new UserUpdateInfo();

$userUpdateInfo->setId($id);
$userUpdateInfo->setEmail($email);
$userUpdateInfo->setUsername($userName);
$userUpdateInfo->setPhoneNumber($phoneNumber);

$userUpdateInfo->update();