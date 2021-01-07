<?php
require_once('../Connection.php');

class UserLogin {
    private $email;
    private $password;

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function login() {
        $emailValidate = "SELECT * FROM users WHERE email = '$this->email'";

        $stmt = Connection::getConn()->prepare($emailValidate);
        $stmt->execute();

        if ($stmt->rowCount() > 0):
            $passwordValidate = "SELECT password, account_auth FROM users WHERE email = '$this->email'";
            
            $stmt = Connection::getConn()->prepare($passwordValidate);
            $stmt->execute();

            $loginInfo = $stmt->fetch();

            if (password_verify($this->password, $loginInfo['password'])):
                if ($loginInfo['account_auth'] != 0):
                    $userInfo = "SELECT * FROM users WHERE email = '$this->email'";

                    $stmt = Connection::getConn()->prepare($userInfo);
                    $stmt->execute();

                    $user = $stmt->fetch();

                    $response = array(
                        'id' => $user['id'],
                        'displayName' => $user['displayName'],
                        'photoUrl' => $user['photoUrl'],
                        'email' => $user['email'],
                        'phoneNumber' => $user['phoneNumber'],
                        'lastLoginAt' => $user['lastLoginAt'],
                        'createdAt' => $user['createdAt'],
                        'account_auth' => $user['account_auth']
                    );

                    echo json_encode($response);
                else:
                    http_response_code(400);
                    echo 'unverified-account';
                endif;
            else:
                http_response_code(400);
                echo 'incorrect-password';
            endif;
        else:
            http_response_code(400);
            echo 'nonexistent-email';
        endif;
    }
}