<?php

require_once '../Connection.php';
require_once('../models/SendMail.php');

class UserDao {

    public function createUser(User $u) {
        $email = $u->getEmail();
        $displayName = $u->getDisplayName();

        if (mb_strlen($displayName) >= 3 && mb_strlen($displayName) <=15):
        
            if (filter_var($email, FILTER_VALIDATE_EMAIL)):
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $stmt = Connection::getConn()->prepare($sql);
                $stmt->execute();

                if ($stmt->rowCount() > 0):
                    http_response_code(409);
                    echo 'email-already-exists';
                else:
                    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\w$@]{6,}$/', $u->getPassword())):
                    $insert = 'INSERT INTO users (id, displayName, email, createdAt, pssword, validate_token, account_auth) VALUES (?,?,?,?,?,?,?)';

                    $validate_token = uniqid();

                    $stmt = Connection::getConn()->prepare($insert);
                    $stmt->bindValue(1, $u->getId());
                    $stmt->bindValue(2, $u->getDisplayName());
                    $stmt->bindValue(3, $u->getEmail());
                    $stmt->bindValue(4, $u->getCreatedAt());
                    $stmt->bindValue(5, password_hash($u->getPassword(), PASSWORD_DEFAULT));
                    $stmt->bindValue(6, md5($validate_token));
                    $stmt->bindValue(7, 0);
                    $stmt->execute();

                    $sendMail = new SendMail();
                    $sendMail->setTo($u->getEmail());
                    $sendMail->setSubject('Account auth');
                    $sendMail->setMessage("Link para validar sua conta: http://192.168.0.14/appserver/app/database/accountValidate.php?token=$validate_token");
                    $sendMail->sendMailAuth();

                    echo 'email-sent';
                    else:
                        http_response_code(400);
                        echo 'weak-password';
                    endif;
                endif;
            else:
                http_response_code(400);
                echo 'invalid-email';
            endif;
        else:
            http_response_code(400);
            echo 'invalid-username';
        endif;
    }
}