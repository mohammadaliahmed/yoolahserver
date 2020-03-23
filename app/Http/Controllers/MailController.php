<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'PHPMailer-master/src/Exception.php';
//require 'PHPMailer-master/src/PHPMailer.php';
//require 'PHPMailer-master/src/SMTP.php';

class MailController extends Controller
{
    //

    public function sendMail()
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "m.aliahmed000@gmail.com";
        $mail->Password = "rdvpryqlzjadujem";

        $mail->IsHTML(true);
        $mail->AddAddress("m.aliahmed0@gmail.com", "recipient-name");
        $mail->SetFrom("from-email@gmail.com", "from-name");
        $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
        $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

        $mail->MsgHTML($content);
        if (!$mail->Send()) {
            echo "Error while sending Email.";
            var_dump($mail);
        } else {
            echo "Email sent successfully";
        }

    }
}
