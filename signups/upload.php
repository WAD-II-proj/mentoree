<?php 
require_once "../model/common.php";
session_start(); 
?>

<!DOCTYPE html>
<html lang="en" class='h-100'>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
		<!-- BOOTSTRAP CSS -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
        
		<!-- EXTERNAL CSS -->
        <link rel="stylesheet" href="../css/style.css" />

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

        <!-- Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <title>Sign Up | Mentoree</title>

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
        </style>

	</head>

	<body class='d-flex flex-column h-100'>
    <!-- Navbar -->
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-0 px-1 w-100">
                <a class="navbar-brand" href="../home/home.php">
                    <img src="../img/mentoree.png" height="40" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../workshop/workshops.php">Join our Workshops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../home/loginpage.php">Login</a>
                    </li>
                    </ul>
                </div>
            </nav>
        </div>

<?php

function uploadDocument($document, $email, $docType) {
    if ($docType == "Transcript") {
        $target_dir = "transcripts/";
    } else {
        $target_dir = "resumes/";
    }
    
    $target_file = $target_dir . basename($document["name"]);
    $uploadOk = 1;
    $emailID = explode("@",$email)[0];
    $errors = [];
    $docFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if filename follows correct format
    if (basename($document["name"], "." . pathinfo($target_file,PATHINFO_EXTENSION)) != $emailID) {
        $uploadOk = 0;
        $errors[] = "$docType name is wrong";
    }
    
    // Allow certain file formats
    if($docFileType != "doc" && $docFileType != "docx" && $docFileType != "pdf") {
        $errors[] = "Your $docType is not a DOC, DOCX, or PDF file.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return $errors;
    // if everything is ok, try to upload file
    } else {
        if (!move_uploaded_file($document["tmp_name"], $target_file)) {
        $errors[] = "There was an error uploading your $docType."; 
        }
        return $errors;
    }
}

function uploadPic($profileImg, $email) {
    $target_dir = "../img/";
    $target_file = $target_dir . basename($profileImg["name"]);
    $uploadOk = 1;
    $emailID = explode("@",$email)[0];
    $errors = [];
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if filename follows correct format
    if (basename($profileImg["name"], "." . pathinfo($target_file,PATHINFO_EXTENSION)) != $emailID) {
        $uploadOk = 0;
        $errors[] = "Profile picture name is wrong";
    }

    // Check file size
    if ($profileImg["size"] > 2000000) {
      $errors[] = "Submitted profile picture is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $errors[] = "Your profile picture is not a JPG, JPEG, or PNG file.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return $errors;
    // if everything is ok, try to upload file
    } else {
        if (!move_uploaded_file($profileImg["tmp_name"], $target_file)) {
        $errors[] = "There was an error uploading your profile picture. Your file size might have been too large.";
        }
        return $errors;
    }
}

// Verifying captcha response
$response = $_POST['g-recaptcha-response'];
if ($response == "") {
    $_SESSION['error'] = "Please verify captcha";
    header("Location: signUp.php");
    exit;
}
$secretKey = "6LeWlt4ZAAAAAH_C4jVBFcFJEnXH8MrU4kthkfxy";
$ip = $_SERVER['REMOTE_ADDR'];
// post request to server
$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode($secretKey) . "&response=" . urlencode($response);
$contents = file_get_contents($url);
$json = json_decode($contents, true);
if (!$json['success']) {
    echo "<div class='col'><br>
        <h3>We have detected the possibility of bot activity.</h3>
        If you think this is an error, please try submitting the form again or contact us through our live chat. Thank you.
        </br></br>Back to <a href='signUp.php'>Sign Up</a>
        </div>";
} else {

    // Check if existing user
    $menteedao = new MenteeDAO;
    $mentordao = new MentorDAO;

    $email = $_POST["email"];
    $exists = $menteedao->isExistingMentee($email);
    if(!$exists){
    $exists = $mentordao->isExistingMentor($email);
    }

    $user = $_POST["submit"];

    if(!$exists){

    // NOT EXISTING USER
    $errors = [];
    if (isset($_FILES["transcript"])) {
        $docType = "Transcript";
        $errors += uploadDocument($_FILES["transcript"],$email, $docType);
    } elseif (isset($_FILES["resume"])) {
        $docType = "Resume";
        $errors += uploadDocument($_FILES["resume"],$email, $docType);
    }

    if (isset($_FILES["profileImg"])){
        $errors += uploadPic($_FILES["profileImg"],$email);
    }

    if (sizeof($errors) == 0) {
        if ($user=="mentee"){

            $password = $_POST["password"];
            $passwordHash = password_hash($password,PASSWORD_DEFAULT);

            // MENTEE SIGN UP
            $form = array(
                "email" => $email,
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "dob" => $_POST["dob"],
                "phoneNum" => $_POST["phoneNum"],
                "transcriptPath" => basename($_FILES["transcript"]["name"]),
                "profilePath" => basename($_FILES["profileImg"]["name"]),
                "gender" => $_POST["gender"],
                "whyJoin" => $_POST["whyJoin"],
                "psw" => $passwordHash
            );
            if($menteedao->signup($form)) {
                echo "<div class='col'><br>
                        <h3>You have successfully submitted your sign up application.</h3>
                        Please wait for 1-2 days as our administrators review your application. Thank you.
                    </br></br><a href='../home/home.php'>Back to Home Page</a>
                    </div>";
            }else{
                echo "There was an issue with submitting your application, please go back to the sign up page and try again.";
            }

        } elseif ($user=="mentor") {
        
            $password = $_POST["password"];
            $passwordHash = password_hash($password,PASSWORD_DEFAULT);

            // MENTOR SIGN UP
            $form = array(
                "email" => $email,
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "dob" => $_POST["dob"],
                "phoneNum" => $_POST["phoneNum"],
                "profilePath" => basename($_FILES["profileImg"]["name"]),
                "resumePath" => basename($_FILES["resume"]["name"]),
                "gender" => $_POST["gender"],
                "whyChooseMe" => $_POST["whyChooseMe"],
                "psw" => $passwordHash
            );
            if($mentordao->signup($form)) {
                echo "<div class='col'><br>
                        <h3>You have successfully submitted your sign up application.</h3>
                        Please wait for 1-2 days as our administrators review your application. Thank you.
                    </br></br><a href='../home/home.php'>Back to Home Page</a>
                    </div>";
            }else{
                echo "There was an issue with submitting your application, please go back to the sign up page and try again.";
            }

        }
        
    } else {

        // ERROR WITH UPLOADING FILES
        echo "<div class='col'><br>
                Your files have failed to upload for the following reasons:<ul>";
        foreach ($errors as $error) {
        echo "<li>$error</li>";
        }
        echo "</ul>
            Please edit your files accordingly and resubmit your application.<br>
            Go back to <a href='signUp.php'>Sign up</a> page
            </div>";
    }

    } else {

        // EMAIL ALREADY EXISTS
        $_SESSION["invalidEmail"] = TRUE;
        header("Location: signUp.php");
        exit;

    }
}
?>

</div>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5f7959374704467e89f4774e/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->

<!-- BOOTSTRAP JS -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<!-- Site footer -->
<footer class="site-footer mt-auto">
    <div class="container-fluid w-100">
    <div class="row pt-5 mr-5">
        <div class="col-md-4">
        <img class="" src="../img/mentoree.png" width="100%">
        </div>

        <?php
        if (isset($_SESSION['email'])) {
            echo '<div class="col-sm-2 ml-4"></div>
                  <div class="col-sm-2 ml-4">
                    <h5>Company</h5>
                    <div class="footer-links">
                      <p><a href="../about.php">About Us</a></p>
                      <p><a href="../guide.php">Guidelines</a></p>
                      <p><a href="../faq.php">FAQ</a></p>
                    </div>
                  </div>';
        }

        else {
            echo '<div class="col-sm-2 ml-4">
                    <h5>Company</h5>
                    <div class="footer-links">
                      <p><a href="../about.php">About Us</a></p>
                      <p><a href="../guide.php">Guidelines</a></p>
                      <p><a href="../faq.php">FAQ</a></p>
                    </div>
                  </div>
  
                  <div class="col-sm-2 ml-4">
                    <h5>Join Us</h5>
                    <div class="footer-links">
                      <p><a href="../signups/signUp.php">Sign Up</a></p>
                    </div>
                  </div>';
        }
        ?>

        <div class="col-sm-3 mx-4">
        <h5>Contact</h5>
        <div class="footer-links">
            <p><img src="../img/email.png" width="20"> admin@mentoree.com</p>
            <p><img src="../img/phone.jpg" width="20"> +65 91234567</p>
        </div>
        </div>

    </div>
    <hr>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-6 col-xs-12">
        <p class="copyright-text mb-3">Copyright &copy; 2017 All Rights Reserved by 
    <a href="#">Scanfcode</a>.
        </p>
        </div>
    </div>
    </div>
</footer>

</body>

</html>