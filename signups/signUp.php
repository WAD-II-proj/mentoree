<?php 
require_once "../model/common.php";
session_start();
date_default_timezone_set("Singapore");
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

        <!-- Vuejs -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

        <!-- Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- jQuery -->
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <title>Sign Up | Mentoree</title>

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            .banner {
                background-image: url("https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop");
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

        $minYear = date("Y")-16;
        $maxDate = "max='$minYear-12-31'";
        ?>        

        <div class="h-75">
        <!-- Navbar -->
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
        
        <!-- MAIN -->
        <header class="banner mb-3">
            <span class="banner-text">
                Sign Up
            </span>
        </header>

		<div class="container-fluid">
            <div class="col-4 mx-auto">
                <form action="upload.php" oninput='cfmPassword.setCustomValidity(cfmPassword.value != password.value ? "Passwords do not match." : "")' id="form1" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <!-- Name -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                            <div class="invalid-feedback">
                                Please provide your first name
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                            <div class="invalid-feedback">
                                Please provide your last name
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- DOB -->
                        <div class="col-md-6 mb-3">
                            <div class='form-group'>
                                <label for='dob'>Date of Birth <span class="required">*</span></label><br>
                                <input type='date' style="width: 100%;" class='form-control' id='dob' name='dob' <?php echo $maxDate ?> required/>
                            </div>
                            <div class="invalid-feedback">
                                Please provide a date of birth.
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6 mb-3">
                            <div class="form-row">
                                <label for="gender">Gender <span class="required">*</span></label>
                                <select class="custom-select" id="gender" name='gender' aria-describedby="genderFeedback" required>
                                <option selected disabled value="">Choose...</option>
                                <option value='M'>Male</option>
                                <option value='F'>Female</option>
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
                            <input type="number" required name='phoneNum' class="form-control" min="10000000" max="99999999" id="phoneNum">
                            <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-row">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" name='email' id="email" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-row my-3">
                        <label for="password">Password <span class="required">*</span></label>
                        <input type="password" id="password" name='password' class="form-control" title="Password must be 8-20 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}" aria-describedby="passwordHelpInline" required>
                        <i class="far fa-eye toggle" id="togglePassword" onclick="togglePsw()"></i>
                        <small id="passwordHelpInline" class="text-muted ml-auto">
                        Password must be 8-20 characters including 1 uppercase letter, 1 lowercase letter and numeric characters
                        </small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-row my-3">
                        <label for="cfmPassword">Confirm Password <span class="required">*</span></label>
                        <input type="password" id="cfmPassword" name='cfmPassword' class="form-control" required>
                        <i class="far fa-eye toggle" id="toggleCfmPassword" onclick="toggleCfmPsw()"></i>
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- Position -->
                        <div class="col-md-6 mb-3">
                            <div class="form-row">
                                <label for="position">Position <span class="required">*</span></label>
                                <select class="custom-select" id="position" name='position' v-model='selected' aria-describedby="positionFeedback" required>
                                <option selected disabled value="">Choose...</option>
                                <option value='mentor'>Mentor</option>
                                <option value='mentee'>Mentee</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor -->
                    <div v-if='selected == "mentor"'>
                        <!-- Reason for Joining -->
                        <div class="form-row mb-3">
                            <label for="whyChooseMe">Reason for being a Mentor <span class="required">*</span></label>
                            <textarea class="form-control" id="whyChooseMe" name='whyChooseMe' placeholder="I will be able to help mentees by..." rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please enter a short description on how you can help mentees.
                            </div>
                        </div>

                        <!-- Resume -->
                        <div class="form-row">
                            <label for="resume">Resume <span class="required">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="form-control-file" name="resume" id="resume" required>
                            </div>
                        </div>

                        <!-- Profile Picture -->
                        <div class="form-row my-2">
                            <label for="profileImg">Profile Picture <span class="required">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="profileImg" id="profileImg" required> 
                            </div>
                            <small id="passwordHelpInline" class="text-muted ml-auto mb-2">
                            * Please name your files in the following format:<br>e.g. if your email is xxx@gmail.com, name your file as xxx.pdf or xxx.docsx and xxx.png or xxx.jpg<br>* Maximum file size is 2MB
                            </small>
                        </div>
                    </div>

                    <!-- Mentee -->
                    <div v-else-if='selected == "mentee"'>
                        <!-- Reason for Joining -->
                        <div class="form-row mb-3">
                            <label for="validationTextarea">Reason for Joining <span class="required">*</span></label>
                            <textarea class="form-control" name="whyJoin" id="validationTextarea" placeholder="I want to join because..." rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please enter a short description on why you want to join.
                            </div>
                        </div>

                        <!-- Transcript -->
                        <div class="form-row">
                            <label for="transcript">Transcript <span class="required">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="form-control-file" name="transcript" id="transcript" required>
                            </div>
                        </div>

                        <!-- Profile Picture -->
                        <div class="form-row my-2">
                            <label for="profileImg">Profile Picture <span class="required">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="profileImg" id="profileImg" required> 
                            </div>
                            <small id="profileHelpInline" class="text-muted mb-2">
                            * Please name your files in the following format:<br>e.g. if your email is xxx@gmail.com, name your file as xxx.pdf or xxx.docsx and xxx.png or xxx.jpg<br>* Maximum file size is 2MB
                            </small>
                        </div>
                    </div>

                    <div class="g-recaptcha h-100" data-sitekey="6LeWlt4ZAAAAAGnP_hOp8-7h6rhln8j-YHPgIZb9"></div>

                    <div v-if='selected == "mentor"'>
                        <button class="btn btn-primary my-3" id="submit" name="submit" value="mentor">Sign up</button>
                    </div>
                    <div v-else-if='selected == "mentee"'>
                        <button class="btn btn-primary my-3" type="submit" name="submit" value="mentee">Sign up</button>
                    </div>
                    <div v-else>
                        <button class="btn btn-primary my-3" type="submit" name="submit" disabled>Sign up</button>
                    </div>

                </form>
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
		<script src="../js/jquery-3.5.1.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- EXTERNAL JS -->
		<script src="../js/script.js"></script>

		<!-- INTERNAL JS -->
		<script>
            // Check position
            const vm = new Vue({
                el: '#form1',
                data: {
                    selected: '',
                }
            });


            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            console.log(event);
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                                //   console.log(form)
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