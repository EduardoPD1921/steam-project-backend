<?php

require_once('../Connection.php');

class UserUpdateInfo {
    private $id;
    private $userName;
    private $email;
    private $phoneNumber;

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->userName = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function update() {
        if (isset($this->userName)):
            try {
                $sql = "UPDATE users SET displayName = '$this->userName' WHERE id = '$this->id'";
                $stmt = Connection::getConn()->prepare($sql);
                $stmt->execute();
            } catch(PDOException $e) {
                echo 'Error! '.$e->getMessage();
            }
        endif;

        if (isset($this->email)):
            try {
                $sql = "UPDATE users SET email = '$this->email' WHERE id = '$this->id'";
                $stmt = Connection::getConn()->prepare($sql);
                $stmt->execute();

                echo 'Passed!';
            } catch(PDOException $e) {
                echo 'Error! '.$e->getMessage();
            }
        endif;

        if (isset($this->phoneNumber)):
            try {
                $sql = "UPDATE users SET phoneNumber = '$this->phoneNumber' WHERE id = '$this->id'";
                $stmt = Connection::getConn()->prepare($sql);
                $stmt->execute();

                echo 'Passed!';
            } catch(PDOException $e) {
                echo 'Error! '.$e->getMessage();
            }
        endif;
    }
}