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

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

		<!-- EXTERNAL CSS -->
		<link rel="stylesheet" href="../css/style.css" />

		<title>Profile Page | Mentoree</title>

		<style>
			.btn {
				margin: 10px;
            }

		</style>
	</head>

	<body class='d-flex flex-column h-100'>

        <?php
            if (isset($_SESSION["alert"])) {
                $alert = $_SESSION["alert"];
                echo "<script>alert($alert)</script>";
                unset($_SESSION["alert"]);
            }
        ?>

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

		<!-- MAIN -->
		<div class="container-fluid">

			<!-- Meetup buttons -->
			<div class="row justify-content-end">
				<a type="button" class="btn btn-primary" href="../meetingpoint/createMeetingPoint.php">Setup Meeting Point</a>
				<a type="button" class="btn btn-primary" href="../meetingpoint/allMeetingPoint.php">View Meeting Points</a>
			</div>

			
			<div class="row mx-auto justify-content-center">
                    <?php
                        $fullname = $firstName . " " . $lastName;
                        $phoneNum = $user->getPhoneNum();
                        $whyChooseMe = $user->getWhyChooseMe();
                        $profilePath = $user->getProfilePath();
                        // Profile picture
                        echo "
                            <img style='max-height: 250px' class='img-fluid img-thumbnail m-3' alt='Profile Picture' src='../img/$profilePath'>
                            <div class='col-7 my-auto'>";

                        // Profile Info
                        echo "<div class='row'>
                                <div class='card w-100'>
                                    <h5 class='card-header'>$fullname</h5>
                                    <div class='card-body'>
                                        <h6 class='card-subtitle mb-2 text-muted'>Contact number: $phoneNum</h6>
                                        <p class='card-text'>$whyChooseMe</p>
                                    </div>
                                </div>
                            </div>";
                    ?>
					<br>
					<!-- Edit profile button -->
					<div class="row">
						<a role="button" href="editProfile.php" class="btn btn-secondary btn-block">Edit Profile</a>
					</div>
				</div>
			</div>

			<br><br>

			<!-- Mentee list -->
			<div class="col-11 mx-auto">
				<h3>Mentees</h3>
					<?php
                        $menteedao = new MenteeDAO();
						$menteeList = $menteedao->retrieveMenteesUnderMentor($_SESSION["email"]);
						if ($menteeList != []) {
							foreach ($menteeList as $mentee) {
                                $menteeName = $mentee->getFirstName() . " " . $mentee->getLastName();
                                $pic = $mentee->getProfilePath();
                                $mEmail = $mentee->getEmail();
                                $mPhoneNum = $mentee->getPhoneNum();

                                echo "<div class='card mb-3' max-width='540px'>
                                        <div class='row no-gutters'>
                                            <img src='../img/$pic' class='card-img-top pic' alt='Mentee'>

                                            <div class='col'>
                                                <div class='card-body'>
                                                    <h5 class='card-title font-weight-bold'>" . $menteeName . "</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Email: $mEmail</h6>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Phone Number: $mPhoneNum</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                
							}
						} else {
							echo "<div class='col my-5'>There are no mentees under you</div>";
						}
					?>
				
				

                <!-- Trouble button -->
                <div class="row justify-content-start">
                    <a type="button" class="btn btn-outline-danger btn-sm" href="../faq.php">Having issues with your mentee?</a><br>
                </div>

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
		</div>
		


		<!-- BOOTSTRAP JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

		<!-- EXTERNAL JS -->
		<script src="../js/script.js"></script>

		<!-- INTERNAL JS -->
		<script>
		</script>
    </body>

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

</html>