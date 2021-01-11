<?php

require_once('../Connection.php');
require_once('../vendor/autoload.php');

class UserUpdateInfo {
    private string $id;
    private string $userName;
    private string $email;
    private string $phoneNumber;

    static array $errors = array();
    static array $success = array();

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
                if (filter_var($this->email, FILTER_VALIDATE_EMAIL)):
                    $sql = "SELECT * FROM users WHERE email = '$this->email'";
                    $stmt = Connection::getCOnn()->prepare($sql);
                    $stmt->execute();

                    if ($stmt->rowCount() == 0):
                        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

                        try {
                            $phoneNumberProto = $phoneUtil->parse($this->phoneNumber);
                            $isValid = $phoneUtil->isValidNumber($phoneNumberProto);

                            if ($isValid == true):
                                $sql = "UPDATE users SET email = '$this->email', displayName = '$this->userName', phoneNumber = '$this->phoneNumber' WHERE id = '$this->id'";
                                $stmt = Connection::getConn()->prepare($sql);
                                $stmt->execute();

                                echo 'changes-saved';
                            else:
                                http_response_code(400);
                                echo 'invalid-phonenumber';
                            endif;
                        } catch(\libphonenumber\NumberParseException $e) {
                            http_response_code(400);
                            echo 'invalid-phonenumber';
                        }
                    else:
                        http_response_code(400);
                        echo 'email-already-inuse';
                    endif;
                else:
                    http_response_code(400);
                    echo 'invalid-email';
                endif;
            else:
                http_response_code(400);
                echo 'invalid-username';
            endif;
        endif;
    }
}