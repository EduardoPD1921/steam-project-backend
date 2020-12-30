<?php

class User {
    private $id;
    private $displayName;
    private $photoUrl;
    private $email;
    private $phoneNumber;
    private $lastLoginAt;
    private $createdAt;
    private $password;

    function __construct() {
        $this->setId();
        $this->setCreatedAt();
    }

    private function setId() {
        $this->id = uniqid();
    }

    public function getId() {
        return $this->id;
    }

    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function setPhotoUrl($photoUrl) {
        $this->photoUrl = $photoUrl;
    }

    public function getPhotoUrl() {
        return $this->photoUrl;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setLastLoginAt($lastLoginAt) {
        $this->lastLoginAt = $lastLoginAt;
    }

    public function getLastLoginAt() {
        return $this->lastLoginAt;
    }

    private function setCreatedAt() {
        $this->createdAt = date('y/m/d');
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }
}