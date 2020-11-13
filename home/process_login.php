<?php

require_once "../model/common.php";
session_start();

if(isset($_POST['position'])) {
    if($_POST['position'] == "mentor") {
        $dao = new MentorDAO();

        $errors = [];
    
        if( isset($_POST['email']) && isset($_POST['pass']) ) {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
        
            $account = $dao->retrieveMentor($email);
        
            // Check if email is found
            if( $account == null) {
                $errors[] = 'Email is not registered';
            }
            else {
                $status = password_verify($pass, $account->getPassword() );
        
                if( !$status ) {
                    $errors[] = 'Password is incorrect!';
                }

                $checked = $dao->isCheckedYet($email);
                if (!$checked) {
                    $errors[] = 'Account has not been approved yet!';
                }
            }
        
            if( count($errors) > 0 ) {
                $_SESSION['errors'] = $errors;
                header('Location: loginpage.php');
                exit;
            }
            else {
                // No Errors
                $_SESSION['email'] = $email;
                $_SESSION['position'] = "mentor";
                $_SESSION['user'] = $dao->retrieveMentor($email);
                header('Location: home.php');
                exit;
            }
        }
        else {
            header('Location: loginpage.php');
            exit;
        }
    } else {
            $dao = new MenteeDAO();

            $errors = [];
        
            if( isset($_POST['email']) && isset($_POST['pass']) ) {
                $email = $_POST['email'];
                $pass = $_POST['pass'];
            
                $account = $dao->retrieveMentee($email);
            
                // Check if email is found
                if( $account == null) {
                    $errors[] = 'Email is not registered';
                }
                else {
                    $status = password_verify( $pass, $account->getPassword() );
            
                    if( !$status ) {
                        $errors[] = 'Password is incorrect!';
                    }

                    $checked = $dao->isCheckedYet($email);
                    if (!$checked) {
                        $errors[] = 'Account has not been approved yet!';
                    }
                }
            
                if( count($errors) > 0 ) {
                    $_SESSION['errors'] = $errors;
                    header('Location: loginpage.php');
                    exit;
                }
                else {
                    // No Errors
                    $_SESSION['email'] = $email;
                    $_SESSION['position'] = "mentee";
                    $_SESSION['user'] = $dao->retrieveMentee($email);
                    header('Location: home.php');
                    exit;
                }
            }
            else {
                header('Location: loginpage.php');
                exit;
            }
    }
}

?>