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

        <title>Edit Profile | Mentoree</title>

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
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-0 px-1  w-100">
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
            <?php
                $user = $_SESSION['user'];
                $firstName = $user->getFirstName();
                $lastName = $user->getLastName();
                $position = $_SESSION['position'];
                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                echo "$firstName $lastName";
                echo '</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="../' . $position . '/' . $position . 'Profile.php">Profile</a>
                    <a class="dropdown-item" href="../home/logout.php">Logout</a>
                    </div>
                    </li>';
            ?>
            </ul>
        </div>
    </nav>

<?php

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

$menteedao = new MenteeDAO;
$user = $_SESSION["user"];
$email = $_SESSION["email"];
if ($_POST["phoneNum"] != "") {
    $phoneNum = $_POST["phoneNum"];
} else {
    $phoneNum = $user->getPhoneNum();
}

if ($_POST["whyJoin"] != "") {
    $whyJoin = $_POST["whyJoin"];
} else {
    $whyJoin = $user->getWhyJoin();
}

$errors = [];
if ($_FILES["profileImg"]["name"] !== ""){
    $errors += uploadPic($_FILES["profileImg"],$email);
    $profilePath = basename($_FILES["profileImg"]["name"]);
} else {
    $profilePath = $user->getProfilePath();
}

if (sizeof($errors) == 0) {
    if ($menteedao->update($email, $profilePath, $phoneNum, $whyJoin)) {
        $_SESSION['user'] = $menteedao->retrieveMentee($email);
        $_SESSION['alert'] = "'Profile has been updated successfully'";
    } else {
        $_SESSION['alert'] = "'Profile has failed to update. Please try again or contact us for help.'";
    }
    header("Location: menteeProfile.php");
    exit;
} else {
    echo "<div class='col'><br>
            Your files have failed to upload for the following reasons:<ul>";
    foreach ($errors as $error) {
      echo "<li>$error</li>";
    }
    echo "</ul>
          Please edit your files accordingly and try again.<br>
          Go back to <a href=menteeProfile.php>Profile</a> page
          </div>";
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

</body>

<!-- Site footer -->
<footer class="site-footer mt-auto">
    <div class="container-fluid w-100">
    <div class="row pt-5 mr-5">
        <div class="col-md-4">
        <img src="../img/mentoree.png" width="100%">
        </div>

        <div class="col-sm-2 ml-4">
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
        </div>

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
</html>