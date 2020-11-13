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
		<link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
        crossorigin="anonymous"/>

		<!-- EXTERNAL CSS -->
		<link rel="stylesheet" href="../css/style.css" />

        <!-- favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

		<title>Profile Page | Mentoree</title>

		<style>
			.margin {
				margin: 10px 0px;
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

		<!-- MAIN -->
		<div class="container-fluid">

			<!-- Meetup buttons -->
			<div class="row justify-content-end">
                <a type="button" class="btn btn-primary m-2" href="../meetingpoint/allMeetingPoint.php">View Meeting Points</a><br>
			</div>

			
			<div class="row mx-auto justify-content-center">
                <?php
                    $fullname = $firstName . " " . $lastName;
                    $phoneNum = $user->getPhoneNum();
                    $whyJoin = $user->getWhyJoin();
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
                                    <p class='card-text'>$whyJoin</p>
                                </div>
                            </div>
                        </div>";
                ?>
                <br>
                <!-- Edit profile button -->
                <div class="row">
                    <a role="button" href="editmenteeprofile.php" class="btn btn-secondary btn-block">Edit Profile</a>
                </div>
                </div>
            </div>

			<br><br>

			<!-- Workshop list -->
			<div class="col-11 mx-auto">
				<h3>Workshops</h3>
				<div class='row margin' id='workshopList'>
                <?php
                    $email = $user->getEmail();
					$workshopdao = new WorkshopDAO();
					$workshoplist = $workshopdao->retrievePartWorkshop($email);
					if ($workshoplist == []) {
						echo "<div class='col'>No workshops signed up</div>";
					} else {
                        $i=0;
						foreach ($workshoplist as $workshop) {
							$name = $workshop->getWorkshopName();
							$date = $workshop->getDate();
                            $starttime = $workshop->getTimeStart();
                            $endtime = $workshop->getTimeEnd();
							$descr = $workshop->getDescr();
							$img = $workshop->getImgPath();
                            $location = $workshop->getLocation();

							echo "<div class='card mb-3'>
                                    <h5 class='card-header'>$name</h5>
                                    <div class='row no-gutters'>
                                        <div class='col-md-4'>
                                            <img src='../img/$img' class='card-img'>
                                        </div>
                                        <div class='col-md-8'>
                                            <div class='card-body'>
                                                <h6 class='card-subtitle mb-2 text-muted'>Date: $date | Time: $starttime - $endtime<br>Location: $location</h6>
                                                <p class='collapse' id='collapse$i' aria-expanded='false'>$descr</p>
                                                <a role='button' class='collapsed' data-toggle='collapse' href='#collapse$i' aria-expanded='false' aria-controls='collapse$i'></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            $i++;
                        }
					}
				?>
				</div>
            			
			<!-- Mentor Details -->
			<?php
			$mentordao = new MentorDAO();
			$mentor = $mentordao->retrieveMentorForMentee($email);
			if ($mentor != ""){
				$mentorEmail = $mentor->getEmail();
				$name = $mentor->getFirstName() . ' ' . $mentor->getLastName();
				$phoneNum = $mentor-> getPhoneNum();
				$gender = $mentor->getGender();
				$age = $mentor->getAge();
				$img = $mentor->getProfilePath();
                echo "<h3>Mentor Details</h3>
						<div class='card mb-3' max-width='540px'>
                            <div class='row no-gutters'>
                                <img src='../img/$img' class='card-img-top pic' alt='Mentor'>
                                <div class='col'>
                                    <div class='card-body'>
                                        <h5 class='card-title font-weight-bold'>$name</h5>
                                        <h6 class='card-subtitle mb-2 text-muted'>Contact number: $phoneNum </h6>
                                        <p class='card-text'>Gender: $gender <br>Age: $age <br>Email: $mentorEmail</p>
                                    </div>
                                </div>
                            </div>
                        </div";
            }
            else {
                echo "<h3>Mentor Details</h3>
                        <div class='row margin'>
                        <div class='col'>No mentor yet</div>
                            <a type='button' class='btn btn-primary m-2' href='selectmentor.php'>Select Mentor</a><br>
                    </div>";
            }
            ?>
            
            <!-- Trouble button -->
            <!-- <div class="co1-11 mx-auto"> -->
                <div class="row justify-content-start margin">
                    <a type="button" class="btn btn-outline-danger btn-sm" href="../faq.php">Having issues with your mentor?</a><br>
                </div>
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

		<!-- BOOTSTRAP JS -->
		<script src="../js/jquery-3.5.1.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- EXTERNAL JS -->
		<script src="../js/script.js"></script>

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