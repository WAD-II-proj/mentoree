<?php 
require_once "../model/common.php";
session_start();
?>

<!DOCTYPE html>
<html class='h-100'>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/style.css">

    <!-- favicon -->
    <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>


    <title>Home | Mentoree </title>

    <style>
      .carousel-item img {
        text-align: center;
        height: 10%;
      }

      .caption {
          background-color: rgb(255, 255, 255, 0.6);
          color: black;
          padding: 10px;
      }

      .testimonial {
        background-color: #d9eefd;
      }

      #carouselWorkshop img {
        height: 600px;
        object-fit: cover; /* Do not scale the image */
        object-position: center; /* Center the image within the element */
      }
    </style>
    
</head>
<body class="d-flex flex-column h-100">
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
                    echo "<li class='nav-item'>
                        <a class='nav-link' href='loginpage.php'>Login</a>
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
                            <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                            </li>';
                    }
                ?>
             </ul>
           </div>
         </nav>
  <div class="container-fluid p-0">

   <!-- JUMBOTRON - JOIN US -->
    <div class='jumbotron-fluid jumbotron-home'>
        <?php
            if (empty($_SESSION['email'])) {
                echo "<div class='text-right'>
                    <a type='button' class='join-button' href='../signups/signUp.php'>Join us as Mentee/Mentor</a><br>
                    </div>";
            }
        ?>
      <div class="words">
        <h3>We guide students from less privileged backgrounds through their <br>higher education journey, for free.</h3>
        <h6>"A mentor is someone who allows you to see the hope inside yourself" - Oprah Winfrey</h6>
      </div>
    </div><br>

    <!-- WORKSHOP IMAGES -->
    <h3 class ="text-center">Workshops</h3>
    <div id="carouselWorkshop" class="carousel slide" data-ride="carousel">
            <div class='carousel-inner'>
            <?php
                $workshopdao = new WorkshopDAO();
                $workshopList = $workshopdao->retrieveAllWorkshops();
                if ($workshopList == []) {
                    echo "<div class='carousel-item active'>
                                <img class='d-block w-75 m-auto' src='../img/noworkshop.jpg'>
                            </div>";
                } else {
                    $i = 0;
                    foreach($workshopList as $workshop) {
                        $imgPath = $workshop->getImgPath();
                        $name = $workshop->getWorkshopName();
                        $desc = $workshop-> getDescr();
                        if($i == 0) {  
                            echo "<div class='carousel-item active'>
                                    <img class='d-block w-100 m-auto' src='../img/$imgPath'>
                                    <div class='carousel-caption d-none d-md-block caption'>
                                    <h5>$name</h5>
                                    <p>$desc</p>
                                    </div>
                                    </div>";
                            $i++;}
                        else {
                            echo "<div class='carousel-item' data-slide-to='$i'>
                                        <img class='d-block w-100 m-auto' src='../img/$imgPath'>
                                        <div class='carousel-caption d-none d-md-block caption'>
                                        <h5>$name</h5>
                                        <p>$desc</p>
                                        </div>
                                    </div>";
                        }
                    }
                
                    echo "<a class='carousel-control-prev' href='#carouselWorkshop' role='button' data-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Previous</span>
                        </a>
                        <a class='carousel-control-next' href='#carouselWorkshop' role='button' data-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Next</span>
                        </a>";
                }
            ?>
            </div>
        </div><br>


    <!-- TESTIMONIALS -->
    <div class="p-3 p-md-3 m-md-3" style="background-color: #a2d6f9;">
    <h3 class ="text-center">Testimonials</h3>
        <div class="row justify-content-start w-100" style="margin: 0px;">
            
                <?php
                    $menteedao = new MenteeDAO();
                    $menteeTestimonial = $menteedao->retrieveMenteesWithTestimonials();
                    // var_dump($menteeTestimonial);
                    if ($menteeTestimonial == []){
                        echo "<div class='col-9 text-center pt-3'>(There are currently no testimonials available)</div>";
                    } else {
                        for($i=0; $i <= 3; $i++){
                            if (isset($menteeTestimonial[$i])) {
                                // var_dump($menteeTestimonial);
                                $testimonial = $menteeTestimonial[$i][1];
                                echo "<div class='col-md border rounded p-3 m-1 testimonial'>$testimonial</div>";
                            } 
                        }
                    }
                    ?>
        </div> <br>
        <div class='text-right'>
            <a type='button' class='btn btn-secondary' href='../testimonial.php'>See more</a><br>
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

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </html>
</html>