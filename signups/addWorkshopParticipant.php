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

        <title>Workshop Sign Up | Mentoree</title>

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
                if (empty($_SESSION['email'])) {
                echo "<li class='nav-item'>
                    <a class='nav-link' href='../home/loginpage.php'>Login</a>
                    </li>";
                } else {
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
                }
            ?>
            </ul>
        </div>
    </nav>

<?php

// Verifying captcha response
$response = $_POST['g-recaptcha-response'];
if ($response == "") {
    $_SESSION['error'] = "Please fill in the captcha given";
    header("Location: workshopSignUp.php");
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
        <h3 mx-5>We have detected the possibility of bot activity.</h3>
        If you think this is an error, please try submitting the form again or contact us through our live chat. Thank you.
        </br></br>Back to <a href='workshopSignUp.php'>Workshop Sign Up</a>
        </div>";
} else {

    $workshopdao = new WorkshopDAO();
    $workshopID = $_POST["workshopID"];

    // Check if logged in
    if (isset($_SESSION["email"])){
        $email = $_SESSION["email"];
        $form = array(
            "email" => $email,
            "workshopID" => $workshopID);
    } else {
        $email = $_POST["email"];
        $form = array(
            "email" => $email,
            "firstName" => $_POST["firstName"],
            "lastName" => $_POST["lastName"],
            "dob" => $_POST["dob"],
            "phoneNum" => $_POST["phoneNum"],
            "gender" => $_POST["gender"],
            "workshopID" => $workshopID
        );
    }
    $partWorkshops = $workshopdao->retrievePartWorkshop($email);
    $workshop = $workshopdao->retrieveWorkshop($workshopID);

    if (in_array($workshop, $partWorkshops)){
        $_SESSION['error'] = "Participant has already signed up for this workshop.";
        header("Location: workshopSignUp.php");
        exit;
    }

    if ($workshopdao->addWorkshopParticipant($form)) {
        
        $workshopName = $workshop->getWorkshopName();
        echo "<div class='col'><br>
            <h3 mx-5>You have successfully signed up for $workshopName.</h3>
            Thank you for signing up, we hope to see you soon!
            </br></br>Back to <a href='../home/home.php'>Home Page</a>
            </div>";

    }else{
        echo "There was an issue with signing up, please go back to the sign up page to resubmit or contact us through our live chat for help.";
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