<?php
    session_start();
    
    if (isset($_POST['email'])) {

        require "../functions/functions.php";
        require "check.inc.php";

        $name = $_POST['name'];
        $email_from = $_POST['email'];
        $message = preg_replace("/[^a-zA-Z0-9\/!?\':.,$;_ ]/", "", $_POST['message']);
        $subject = preg_replace("/[^a-zA-Z0-9\/!?\':.,$;_ ]/", "", $_POST['subject']);
        
        //Validation
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
            header("Location: ../contact.php?message=/FillInTheForm");
            exit();
        } else {

            if(empty($name)||empty($email_from)||empty($message)) {
                header("Location: ../contact.php?message=/Empty");
                exit();
            } else {

                //Check reCaptcha
                function post_captcha($user_response) {
                    $fields_string = '';
                    $fields = array(
                        'secret' => $config['reCaptcha']['secret_key'],
                        'response' => $user_response
                    );
                    foreach($fields as $key=>$value)
                    $fields_string .= $key . '=' . $value . '&';
                    $fields_string = rtrim($fields_string, '&');
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    return json_decode($result, true);
                }

                // Call the function post_captcha
                $res = post_captcha($_POST['g-recaptcha-response']);
                if (!$res['success']) {
                    header("Location: ../contact.php?message=/ReCaptchaIsRequired");
                    exit();
                } else {

                    //Check if email is valid
    				if(!filter_var($email_from,FILTER_VALIDATE_EMAIL) || !preg_match('%^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$%',stripslashes(trim($email_from)))) {
                        header("Location: ../contact.php?message=/EmailIsIncorrect");
                        exit();
                    } else {

                        //Prevent symbols in name
                        if (!preg_match('%^[A-Za-z0-9 ]{3,30}$%', stripslashes(trim($name)))) {
                            header("Location: ../contact.php?message=/NameMin3Max30WithoutSymbols");
                            exit();
                        } else {

                            //Message length
                            if (strlen($message)<15 || strlen($message)>3000) {
                                header("Location: ../contact.php?message=/MessageShouldBeMin15Max3000Letters");
                                exit();
                            } else {

                                function clean_string($string){
                                    $bad = array("content-type","bcc:","to:","cc:","href");
                                    return str_replace($bad,"",$string);
                                }

                                $email_message = '<h3>Form details below.</h3>\n\n';
                                $email_to = "1990serzhik@mail.ru";
                                $email_message .= "Name: ".clean_string($name)."\n";
                                $email_message .= "Email: ".clean_string($email_from)."\n";
                                $email_message .= "message: ".clean_string($message)."\n";

                                // create email headers
                                $headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n" .'X-Mailer: PHP/' . phpversion();
                                @mail($email_to, $subject, $email_message, $headers);
                                header("Location: ../contact.php?message=/ContactMessageSuccess");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    } else {
        header('Location:../contact.php?message=/FillInTheForm');
        exit();
    }