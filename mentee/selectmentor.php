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

    <!-- favicon -->
    <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>


    <title>Select Mentor | Mentoree</title>
  </head>

  <body class='d-flex flex-column h-100'>
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
            echo '<li class="nav-item">
                  <a class="nav-link" href="../home/loginpage.php">Login</a>
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
                      <a class="dropdown-item" href="../home/logout.php">Logout</a>
                    </div>
                  </li>';
          }
          ?>
        </ul>
      </div>
    </nav>

        <form method="POST">
        <div class="container-fluid p-0">
            <div class='col-2'></div>
            <div class="col-8 my-3 mx-auto" id='workshopList'>
                <?php
                    $mentordao = new MentorDAO();
                    $mentorList = $mentordao->retrieveAllMentors();
                    // var_dump($mentorList);
                    $i = 0;
                    foreach($mentorList as $mentor){
                        $email = $mentor->getEmail();
                        $name = $mentor->getFirstName() . " " . $mentor->getLastName();
                        $profilePath = $mentor->getProfilePath();
                        $whyChooseMe = $mentor->getWhyChooseMe();
                        echo "<div class='card mb-3'>
                                <div class='row no-gutters'>
                                    <div class='col-md-4'>
                                        <img src='../img/" . $profilePath . "' class='card-img profile'>
                                    </div>
                                    <div class='col-md-8'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>" . $name . "</h5>
                                            <p class='collapse' id='collapse$i' aria-expanded='false'>" . $whyChooseMe . "</p>
                                            <a role='button' class='collapsed' data-toggle='collapse' href='#collapse$i' aria-expanded='false' aria-controls='collapse$i'></a>
                                        </div>
                                    </div>
                                </div>
                                <div class='card-footer'>
                                    <button type='submit' class='btn btn-primary' name='mentorEmail' value='". $email ."'>SELECT ME</button>
                                </div>
                            </div>";
                        $i++;
                    }
                ?>
                <div class='col-2'></div>
            </div>
        </form>
        </div>

        <?php
        if (isset($_POST['mentorEmail'])){
            $mentorEmail = $_POST['mentorEmail'];
            // var_dump($mentorEmail);
            $email = $_SESSION['email'];
            $menteedao = new MenteeDAO();
            $menteedao->addMentorEmail($email, $mentorEmail);
            echo '<META HTTP-EQUIV="refresh" content="0;URL=menteeProfile.php">';
        }
        
        ?>
        <!--BOOTSTRAP JS-->
        <script src="../js/jquery-3.5.1.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

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