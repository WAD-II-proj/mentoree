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
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

		<!-- EXTERNAL CSS -->
        <link rel="stylesheet" href="../css/style.css" />
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

        <!-- Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- jQuery -->
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <title>Edit Profile | Mentoree</title>

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            .banner {
                background-image: url(https://images.unsplash.com/photo-1484807352052-23338990c6c6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80);
                background-position: center;
            }
        </style>

	</head>

	<body>
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
        <header class="banner mb-3" style="url('https://images.unsplash.com/photo-1527689368864-3a821dbccc34?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60')">;
            <span class="banner-text">
                Edit Profile
            </span>
        </header>

		<div class="container-fluid p-0">
            <h5 class="text-center pb-3">
                <u>Please fill in only the information that you wish to change.</u>
            </h5>
            <div class="col-4 mx-auto">
                
                <form action="uploadChanges.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <!-- Phone Number -->
                    New Phone Number
                    <div class="form-group row my-2">
                        <label for="phoneNum" class="col-sm-2 col-form-label">+65</label>
                        <div class="col-sm-10">
                            <input type="number" name='phoneNum' class="form-control" min="10000000" max="99999999" id="phoneNum">
                            <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                        </div>
                    </div>

                    <!-- Reason for Joining -->
                    <div class="form-row mb-3">
                        <label for="whyChooseMe">Reason for being a Mentor</label>
                        <textarea class="form-control" id="whyChooseMe" name='whyChooseMe' placeholder="I will be able to help mentees by..." rows="4"></textarea>
                        <div class="invalid-feedback">
                            Please enter a short description on how you can help mentees.
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div class="form-row my-2">
                        <label for="profileImg">Update Profile Picture</label>
                        <div class="custom-file">
                            <input type="file" name="profileImg" id="profileImg"> 
                        </div>
                        <small id="passwordHelpInline" class="text-muted mb-2">
                        * Please name your files in the following format:<br>e.g. if your email is xxx@gmail.com, name your file as xxx.pdf or xxx.docsx and xxx.png or xxx.jpg<br>* Maximum file size is 2MB
                        </small>
                    </div>

                    <button class="btn btn-primary my-3" type="submit" name="submit">Save Changes</button>

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
              
        </container>


		<!-- BOOTSTRAP JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


		<!-- EXTERNAL JS -->
		<script src="js/script.js"></script>

		<!-- INTERNAL JS -->
		<script>

            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            console.log(event);
                            if (form.checkValidity() === false || validatePsw()) {
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