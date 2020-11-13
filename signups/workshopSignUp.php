<?php 
require_once "../model/common.php";
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
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
        
        <!-- jQuery -->
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>
        <title>Workshop Sign Up | Mentoree</title>

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            
            .banner {
                background-image: url("https://images.unsplash.com/photo-1512758017271-d7b84c2113f1?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80");
               
            }
        </style>

	</head>

	<body>
        
        <?php
        if (isset($_SESSION["error"])) {
            $error = $_SESSION["error"];
            unset($_SESSION['error']);
            echo "<script>alert('$error')</script>";
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
                    if (empty($_SESSION['email'])) {
                        echo "<li class='nav-item'>
                            <a class='nav-link' href='../home/loginpage.php'>Login</a>
                        </li>";
                        $firstName = "required";
                        $lastName = "required";
                        $dob = "required";
                        $gender = ["","required"];
                        $phoneNum = "required";
                        $email = "required";
                        $position = "required";
                    } else {
                        $user = $_SESSION['user'];
                        $firstName = $user->getFirstName();
                        $lastName = $user->getLastName();
                        $dob = $user->getDOB();
                        $gender = $user->getGender();
                        $phoneNum = $user->getPhoneNum();
                        $email = $_SESSION['email'];
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
                        $firstName = "value='$firstName' disabled";
                        $lastName = "value='$lastName' disabled";
                        $dob = "value='$dob' disabled";
                        $gender = [$gender, 'disabled'];
                        $phoneNum = "value='$phoneNum' disabled";
                        $email = "value='$email' disabled";
                    }
                ?>
                </ul>
            </div>
        </nav>
        
        <!-- MAIN -->
        <header class="banner mb-3">
            <span class="banner-text">
                Workshop Sign Up
            </span>
        </header>

		<div class="container-fluid">
            <div class="col-4 mx-auto">
                <form action="addWorkshopParticipant.php" method="post" class="needs-validation" novalidate>

                    <!-- Workshop -->
                    <div class="form-row">
                        <label for="workshop">Workshop <span class="required">*</span></label>
                        <select class="custom-select" name="workshopID" id="workshop" aria-describedby="workshopFeedback" required>
                          <option selected disabled value="">Choose...</option>
                          <?php
                            $workshopdao = new WorkshopDAO();
                            $workshops = $workshopdao->retrieveAllWorkshops();
                            if ($workshops == []) {
                                echo "<option disabled value=''>No workshop available at the moment, sorry!</option>";
                            } else {
                                foreach ($workshops as $workshop) {
                                        $workshopID = $workshop->getWorkshopID();
                                        $workshopName = $workshop->getWorkshopName();
                                    if ($workshop->getAvailStatus()){
                                        echo "<option value=$workshopID>$workshopName</option>";
                                    } else {
                                        echo "<option disabled value=''>$workshopName --FILLED--</option>";
                                    }
                                }
                            }
                          ?>
                        </select>
                        <div id="workshopFeedback" class="invalid-feedback">
                            Please select a workshop.
                        </div>
                    </div>
                    </br>

                    <!-- Name -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="firstName" id="firstName" <?php echo $firstName ?>>
                            <div class="invalid-feedback">
                                Please provide your first name
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="lastName" id="lastName" <?php echo $lastName ?>>
                            <div class="invalid-feedback">
                                Please provide your last name
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- DOB -->
                        <div class="col-md-6 mb-3">
                            <label for="dob">Date of Birth <span class="required">*</span></label>
                            <input type='date' id='dob' name='dob' <?php echo $dob ?>>
                            <div class="invalid-feedback">
                                Please provide a date of birth.
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6 mb-3">
                            <div class="form-row">
                                <label for="gender">Gender <span class="required">*</span></label>
                                <select class="custom-select" id="gender" name="gender" aria-describedby="genderFeedback" <?php echo $gender[1] ?>>
                                <option selected disabled value="">Choose...</option>
                                <option value='M' <?php if($gender[0]=='M'){echo "selected";} ?>>Male</option>
                                <option value='F' <?php if($gender[0]=='F'){echo "selected";} ?>>Female</option>
                                </select>
                                <div id="genderFeedback" class="invalid-feedback">
                                    Please select a gender.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phone Number -->
                    Phone Number <span class="required">*</span>
                    <div class="form-group row my-2">
                        <label for="phoneNum" class="col-sm-2 col-form-label">+65</label>
                        <div class="col-sm-10">
                            <input type="number" name='phoneNum' class="form-control" min="10000000" max="99999999" id="phoneNum" <?php echo $phoneNum ?>>
                            <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-row">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" <?php echo $email ?>>
                        <div class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div>
                    <br>

                    <div class="g-recaptcha" data-sitekey="6LeWlt4ZAAAAAGnP_hOp8-7h6rhln8j-YHPgIZb9"></div>
                    </br>

                    <button class="btn btn-primary my-3" type="submit">Sign up</button>
                </form>
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
		<script src="../js/jquery-3.5.1.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- EXTERNAL JS -->
		<script src="../js/script.js"></script>

		<!-- INTERNAL JS -->
		<script>
            
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
              'use strict';
              window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              }, false);
            })();
            
            // disable scroller for number input
            $(document).on("wheel", "input[type=number]", function (e) {
                $(this).blur();
            });
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