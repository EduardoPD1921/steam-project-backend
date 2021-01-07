<?php

require_once('../Connection.php');

class UserUpdateInfo {
    private $id;
    private $userName;
    private $email;
    private $phoneNumber;

    static $errors = array();

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
            if (mb_strlen($this->userName) >= 3 && mb_strlen($this->userName) <=15):
                try {
                    $sql = "UPDATE users SET displayName = '$this->userName' WHERE id = '$this->id'";
                    $stmt = Connection::getConn()->prepare($sql);
                    $stmt->execute();
                } catch(PDOException $e) {
                    echo 'Error! '.$e->getMessage();
                }
            else:
                array_push(self::$errors, 'invalid-username');
            endif;
        endif;

        if (isset($this->email)):
            if (mb_strlen($this->email) > 3):
                try {
                    $sql = "UPDATE users SET email = '$this->email' WHERE id = '$this->id'";
                    $stmt = Connection::getConn()->prepare($sql);
                    $stmt->execute();
                } catch(PDOException $e) {
                    echo 'Error! '.$e->getMessage();
                }
            else:
                array_push(self::$errors, 'invalid-email');
            endif;
        endif;

        if (isset($this->phoneNumber)):
            try {
                $sql = "UPDATE users SET phoneNumber = '$this->phoneNumber' WHERE id = '$this->id'";
                $stmt = Connection::getConn()->prepare($sql);
                $stmt->execute();
            } catch(PDOException $e) {
                echo 'Error! '.$e->getMessage();
            }
        endif;

        if (empty(self::$errors)):
            echo 'changes-saved';
        else:
            http_response_code(400);
            echo json_encode(self::$errors);
        endif;
    }
}