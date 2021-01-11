<?php

require_once('../Connection.php');
require_once('../vendor/autoload.php');

class UserUpdateInfo {
    private string $id;
    private string $userName;
    private string $email;
    private string $phoneNumber;

    static array $errors = array();

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
            if (mb_strlen($this->userName) >= 3 && mb_strlen($this->userName) <= 15):
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
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)):
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
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $phoneNumberProto = $phoneUtil->parse($this->phoneNumber);
                $isValid = $phoneUtil->isValidNumber($phoneNumberProto);

                if ($isValid == true):
                    try {
                        $sql = "UPDATE users SET phoneNumber = '$this->phoneNumber' WHERE id = '$this->id'";
                        $stmt = Connection::getConn()->prepare($sql);
                        $stmt->execute();
                    } catch(PDOException $e) {
                        echo 'Error '.$e->getMessage();
                    }
                else:
                    array_push(self::$errors, 'invalid-phonenumber');
                endif;
            } catch(\libphonenumber\NumberParseException $e) {
                array_push(self::$errors, 'invalid-phonenumber');
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