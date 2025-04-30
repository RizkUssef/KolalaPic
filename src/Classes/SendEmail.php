<?php

namespace Rizk\Kolala\Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendEmail
{
    public static function sendEmail($to)
    {
        $mail = new PHPMailer(true);
        $reset_tkn= Session::getSession("csrf_reset_password");
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // or your SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'uoyrizk@gmail.com'; // Your email
            $mail->Password = 'qtzw tyjc ovyu ykze'; // App password, NOT normal password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('uoyrizk@gmail.com', 'Kolala PIC');
            $mail->addAddress($to);
            

            // 
            $mail->AddEmbeddedImage('C:/xampp/htdocs/KolalaPic/public/assets/imgs/logo.png', 'logo_cid');

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = "Forget Password";
            $mail->Body    = "<body style='font-family: Caveat, monospace; font-style: normal; background-color: #F1F0E8; border-radius: 25px; padding: 20px;'>
                                <section style='background-color: #B3C8CF; border-radius: 18px; width: 70%; margin: auto; padding-top: 20px;'>
                                    <img style='margin: auto; display: block;' src='cid:logo_cid' alt='logo'>
                                        <div style='padding: 25px;font-family: Tagesschrift, system-ui; color: #F1F0E8; text-align: center; font-size: 18px;' class='div'>
                                            <h1 style='font-size: xx-large; text-align: center;'>Welcome to our KOLALAPIC</h1>
                                            <p style='text-align: start;'>Hello </p>
                                            <p style='text-align: start; margin-bottom: 50px;'>We noticed you requested a password reset for your Kolala Pic account. No worries—it happens to the best
                                                of us! To create a new password, please click the button below:</p>
                                            <a href='http://localhost:5173/reset password/$reset_tkn'
                                                style=' padding: 10px 20px; background-color: #688990; color: #F1F0E8; text-decoration: none; border-radius: 15px;'>
                                                Reset My Password
                                            </a>
                                            <p style='text-align: start; margin-top: 50px;'>If you didn\'t request a password reset, you can safely ignore this email.</p>
                                            <p style='text-align: start;'><strong style='color: #688990;'>Tip:</strong> To avoid losing access in the future, consider saving your password in a secure
                                                password manager.</p>
                                            <p style='color: #688990; font-size:medium; text-align: center; font-weight: 600;'>Thanks,  Rizk Ussef Rizk</p>
                                        </div>
                                </section>
                              </body>"; // This will be your HTML design
            $mail->AltBody = strip_tags($mail->Body); // fallback text if no HTML

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
