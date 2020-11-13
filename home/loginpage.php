<?php 
require_once "../model/common.php";
session_start();

 ?>

<!DOCTYPE html>
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

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

    <title>Login | Mentoree </title>

</head>
<body>

   <!-- NAVBAR -->
   <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-0 px-1  w-100">
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
                 <a class="nav-link" href="../workshop/workshops.php">Join our Workshops</a>
               </li>
               <?php
                  if (empty($_SESSION['email'])) {
                    echo' <li class="nav-item">
                        <a class="nav-link" href="loginpage.php">Login</a>
                      </li>';
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
                            <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                            </li>';
                    }
                ?>
             </ul>
           </div>
         </nav>


    <!-- JUMBOTRON -->
    <header class="banner mb-3" style="background-image:url('https://images.unsplash.com/photo-1560457079-9a6532ccb118?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=967&q=80'); ">;
      <span class="banner-text">
      Log In
      </span>
    </header>

   <div class="container-fluid">


   <form action="process_login.php" method="POST" class="col-5 mx-auto mt-4">

   <?php
        // Check if there are any errors
        // Display error messages (if any)
        if( isset($_SESSION['errors']) ) {
            $errors = $_SESSION['errors'];
            if( count($errors) > 0 ) {
                echo'<div class="alert alert-danger pb-0" role="alert">
                    <ul>
                    ';

                foreach($errors as $err) {
                    echo "
                        <li>$err</li>
                    ";
                }

                echo "
                    </ul>
                    </div>
                ";
            }

            // Unset 'errors' Session variable
            unset($_SESSION['errors']);
        }
    ?>

    <!-- Email -->
    <div class="form-row my-3">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" aria-describedby="emailHelp">
    </div>

    <!-- Password -->
    <div class="form-row my-3">
        <label for="password">Password</label>
        <input type="password" name="pass" class="form-control" placeholder="Password" id="password">
        <i class="far fa-eye toggle" id="togglePassword" onclick="togglePsw()"></i>
    </div>

    <!-- Position -->
    <div class="form-group mx-auto my-0">
        <input name="position" type="radio" value="applicant" checked id="applicant"/> <label for="applicant">Mentee</label>
        <input class="ml-3" name="position" type="radio" id="mentor" value="mentor"/> <label for="mentor">Mentor</label>
    </div>

    <div><a href="../signups/signUp.php" class="justify-content-center">Sign Up</a></div>
    <div><a href="forgotpsw.php">Forgot my password</a></div><br>
    <div class="text-center">
        <button type="submit" class="btn btn-primary justify-content-center">Log In</button>
    </div>
  </form>
  </div>
  <br>
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
    
    <!-- EXTERNAL JS -->
    <script src="../js/script.js"></script>
</body>

</html>