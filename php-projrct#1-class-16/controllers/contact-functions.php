<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once 'vendors/PHPMailer/src/Exception.php';
require_once 'vendors/PHPMailer/src/PHPMailer.php';
require_once 'vendors/PHPMailer/src/SMTP.php';

/**
 * Summary of store_contact_from
 * store contact information
 * @throws Exception 
 * @return array
 */
function store_contact_from()
{
    $admin_email = 'mdmuminjap@gmail.com';
    $response = [
        'errors' => [],
        'success' => false,
        'successMessage' => null

    ];


    try {

        //Validation

        if (empty($_POST['name'])) {
            $response['errors']['name'] = "please give a valid name.";
            //throw new Exception("please give a valid name.", 1);
        }

        if (empty($_POST['email'])) {
            $response['errors']['email'] = "please give an Email address.";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $response['errors']['email'] = "please give a valid Email.";
        }

        if (empty($_POST['subject'])) {
            $response['errors']['subject'] = "please give a valid subject.";
        }
        if (empty($_POST['message'])) {
            $response['errors']['message'] = "please give a message.";
        }

        //upload file
        $file_name = null;
        if (!empty($_FILES['attachment']['name'])) {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['attachment']['error']) ||
                is_array($_FILES['attachment']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }
            //check file size
            $file_size = !empty($_FILES['attachment']['size']) ? intval($_FILES['attachment']['size']) : 0;
            $upto_supported_size = 5 * 1024 * 1000; // 5MB


            if ($file_size > $upto_supported_size) {
                $response['errors']['attachment'] = "File size exceeded. Max upload limit is 5MB";
                throw new Exception($errors['attachment'], 1);
            }
            //Mime type file
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $file_ext = array_search(
                $finfo->file($_FILES['attachment']['tmp_name']),
                array(
                    'jpg' => 'image/jpg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'gif1' => 'image/bnf',
                    'pdf' => 'application/pdf'

                ),
            true
            );
            if (false === $file_ext) {
                $response['errors']['attachment'] = "File should be a valid image or PDF file";
                throw new Exception($errors['attachment'], 1);
            }

            //Sanitize file name and make new
            $file_name = 'devsenv-' . time() . '.' . $file_ext;

            //Upload file

            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], "uploads/" . $file_name)) {
                $response['errors']['attachment'] = "File uploads fail please try again.";
                throw new Exception($errors['attachment']);
            }
        }


    } catch (\Exception $e) {
        $response['errors']['global'] = $e->getMessage();
    }

    if (count($response['errors']) > 0) {
        $err_global = "Failed to submit from. Please try again.";
        if (isset($response['errors']['global'])) {
            $err_global .= 'Error:' . $response['errors']['global'];
        }
        $response['errors']['global'] = $err_global;
    } else {
        if (isset($_POST['contact_form'])) {

            //sanitization
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
                'subject' => htmlspecialchars($_POST['subject']),
                'message' => htmlspecialchars($_POST['message']),
                'attachment' => $file_name
            ];

            //var_dump($insert_data);

            //insert into database
            //DB:: insert('contact_us $insert_database')

            //send Mail to that email address

            $response['success'] = true;
            $response['successMessage'] = 'Your contact form has been submitted.';

            //send mail using php
            // mail($data['email'], $data['subject'], $data['message']);


            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication 
                $mail->Username = 'mdmuminjap@gmail.com'; //SMTP username
                $mail->Password = 'xkoqyvjacfcvxitv'; //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
                $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('mdmuminjap@gmail.com', 'MD Momin');
                //send an email to user
                //$mail->addAddress($data['email'], $data['name']); //Add a recipient
                //send an email to admin
                $mail->addAddress($admin_email); //Name is optional

                //Reply address
                $mail->addReplyTo($data['email'], $data['name']);
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = $data['subject'];
                $mail->Body = "You have got an email from " . $data['name'] . "<br> <h3>Message:</h3>" . $data['message'] . "<h3>Email From:</h3>" . $data['name'] . " (" . $data['email'] . ")";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                $response['successMessage'] = "An email also sent to user.";
            } catch (\Exception $e) {
                $response['successMessage'] = "Email could not be sent, please try again later.";
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    return $response;
}
?>