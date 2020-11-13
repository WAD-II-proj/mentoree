<?php 
require_once "../model/common.php"; 
session_start(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- BOOTSTRAP CSS -->
		<link rel="stylesheet" href="../css/bootstrap.min.css" />

		<!-- EXTERNAL CSS -->
		<link rel="stylesheet" href="../css/style.css" />

        <!-- Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- jQuery -->
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

        <title>Mentor Eligibility | Mentoree</title>

    </head>
    <body>
    
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-0 px-1">
            <a class="navbar-brand" href="../home/home.php">
            <img src="../img/mentoree.png" height="40" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mentee</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="adminmentee.php">All Mentees</a>
                                <a class="dropdown-item" href="menteeEligible.php">Mentee Eligibility</a>
                            </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mentor</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="adminmentor.php">All Mentors</a>
                                <a class="dropdown-item" href="mentorEligible.php">Mentor Eligibility</a>
                            </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Workshops</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="adminworkshop.php">Workshop Participants</a>
                                <a class="dropdown-item" href="editWorkshops.php">Edit Workshops</a>
                                <a class="dropdown-item" href="addWorkshops.php">Add Workshops</a>
                            </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminTestimonials.php">Testimonials</a>
                    </li>  
                </ul>
            </div>
        </nav>	

        <!--CODE HERE, DELETE LATER-->
        <div class="container-fluid">
        <br>
        <form method="POST">
            <div class="row row-cols-1 row-cols-md-5">
            <!-- loop for each card -->
            <?php
                $mentordao = new MentorDAO();
                $mentorList = $mentordao->retrieveUncheckedMentors();
                if ($mentorList == []){
                    echo "<div class='col'>No mentors to be checked</div>";
                } else {
                    $i = 0;
                    foreach($mentorList as $mentor){
                    $email = $mentor->getEmail();
                    $name = $mentor->getFirstName() . ' ' . $mentor->getLastName();
                    $profilePath = $mentor->getProfilePath();
                    $whyChooseMe = $mentor->getWhyChooseMe();

                    echo "<div class='col mb-4' style='padding-top: 30px;'>
                                <div class='card h-100'>
                                    <img src='../img/" . $profilePath . "' class='card-img-top' alt='...'>
                                    <div class='card-body'>
                                    <h5 class='card-title'>" . $name . "</h5>
                                    <p class='card-text'>" . $whyChooseMe . "</p>
                                    </div>
                                    <div class='card-footer'>
                                        <input type='hidden' name='$i' value='" . $email . "'>
                                        <button type='submit' class='btn btn-primary' name='Accept' value='A$i'>Accept</button>                  
                                        <button type='submit' class='btn btn-primary' name='Accept' value='R$i'>Reject</button>
                                    </div>
                                </div>
                            </div>";
                    $i++;
                    }
                }
            ?>
        </form>
        <?php
        if (isset($_POST['Accept'])) {
            $result = $_POST['Accept'][0];
            $i = $_POST['Accept'][1];
            $email = $_POST["$i"];
            $mentordao = new MentorDAO();
            if ($result == 'R') {
                $mentordao->deleteMentor($email);
            } else {
                $mentordao->updateCheckedYet($email);
            }

            echo '<meta http-equiv="refresh" content="0">';
        }
        ?>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    </body>
</html>