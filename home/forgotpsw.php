<?php 
require_once "../model/common.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en" class='h-100'>
<head>
    <!-- Add code here -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- External CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <!-- favicon -->
    <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

    <title>Forget Password | Mentoree </title>

</head>
<body class='d-flex flex-column h-100'>

   <!-- Add code here -->
   <div class="container-fluid">

    <!-- Add code here -->
    <div class="row">
       <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-0 px-1 w-100">
           <a class="navbar-brand" href="home.php">
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
                 <a class="nav-link" href="../signups/workshopSignUp.php">Join our Workshops</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link" href="loginpage.php">Login</a>
               </li>
             </ul>
           </div>
         </nav>
   </div> <br>

                  <?php
                    $menteedao = new MenteeDAO();
                    $mentordao = new MentorDAO();

                    if(isset($_POST["email"])) { 
                      $email = $_POST["email"];
                      $cfmPassword = $_POST["cfmPassword"];

                      if($menteedao->isExistingMentee($email)) {
                        $user = $menteedao->retrieveMentee($email);
                        $cfmPassword = password_hash($cfmPassword, PASSWORD_DEFAULT);
                        $user = $menteedao->changePsw($email, $cfmPassword);

                      }
                      else {
                        if ($mentordao->isExistingMentor($email)) {
                          $user = $mentordao->retrieveMentor($_SESSION['email']);
                          $user = $mentordao->changePsw($email, $cfmPassword);
                        }
                        
                      }

                      echo'<div class="alert alert-success w-50 mx-auto" role="alert">
                      Your password has been changed!
                    </div>';

                    }
                  
                  ?> <br>

   <div class="container-fluid">
            <div class="col-4 mx-auto">
                <form action="forgotpsw.php" method="POST" oninput='cfmPassword.setCustomValidity(cfmPassword.value != password.value ? "Passwords do not match." : "")' id="form1" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <!-- Email -->
                    <div class="form-row">
                        <label for="email">Email <span class="required">*</span></label></label>
                        <input type="email" class="form-control" name='email' id="email" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div> <br>

                    <!-- Password -->
                    <div class="form-row">
                        <label for="password">New Password <span class="required">*</span></label></label>
                        <input type="password" id="password" name='password' class="form-control" title="Password must be 8-20 characters including 1 uppercase letter, 1 lowercase letter and numeric characters" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}" aria-describedby="passwordHelpInline" required>
                        <i class="far fa-eye toggle" id="togglePassword" onclick="togglePsw()"></i>
                        <small id="passwordHelpInline" class="text-muted ml-auto">
                        Password must be 8-20 characters including 1 uppercase letter, 1 lowercase letter and numeric characters
                        </small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-row my-3">
                        <label for="password">Confirm Password <span class="required">*</span></label></label>
                        <input type="password" id="cfmPassword" name='cfmPassword' class="form-control" required>
                        <i class="far fa-eye toggle" id="toggleCfmPassword" onclick="toggleCfmPsw()"></i>
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary justify-content-center mb-4">Submit</button>
                    </div>
                  </form>

            </div>
      </div>
</div>
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

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  

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
    </script>

    <!-- EXTERNAL JS -->
    <script src="../js/script.js"></script>
</body>
</html>