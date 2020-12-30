<?php
require_once('../lib/src/PHPMailer.php');
require_once('../lib/src/SMTP.php');
require_once('../lib/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail {
    private $to;
    private $message;
    private $subject;

    public function setTo($to) {
        $this->to = $to;
    }

    public function getTo() {
        return $this->to;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function sendMailAuth() {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'steamprojectemail@gmail.com';
        $mail->Password = 'Magekiller11';
        $mail->Port = 587;

        $mail->setFrom('steamprojectemail@gmail.com');
        $mail->addAddress($this->to);

        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body = $this->message;

        $mail->send();
    }
}