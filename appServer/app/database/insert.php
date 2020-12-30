<?php

require_once '../models/UserDao.php';
require_once '../models/User.php';

$encodedData = file_get_contents('php://input');
$decodeData = json_decode($encodedData, true);

$email = $decodeData['email'];
$displayName = $decodeData['displayName'];
$password = $decodeData['password'];

$user = new User();
$userDao = new UserDao();

$user->setEmail($email);
$user->setDisplayName($displayName);
$user->setPassword($password);

$userDao->createUser($user);


