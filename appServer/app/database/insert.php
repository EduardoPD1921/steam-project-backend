<?php

require_once '../models/UserDao.php';
require_once '../models/User.php';
require_once '../Connection.php';

$encodedData = file_get_contents('php://input');
$decodedData = json_decode($encodedData, true);

$email = $decodedData['email'];
$password = $decodedData['password'];
$displayName = $decodedData['displayName'];

$user = new User();
$userDao = new UserDao();

$user->setEmail($email);
$user->setPassword($password);
$user->setDisplayName($displayName);

$userDao->createUser($user);
