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

        <!-- Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- jQuery -->
        <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>

        <title>Edit Workshops | Mentoree</title>

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            /* col padding */ 
            .nocolpad {
                padding-left: 0px;
            }

            label {
                margin-top: 10px;
            }

            .banner {
                background-image:  url("https://images.unsplash.com/flagged/photo-1556542623-03456d0e2301?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80");
            }

        </style>

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
        
        <!-- MAIN -->
        <header class="banner mb-3">
            <span class="banner-text">
                Edit Workshops
            </span>
        </header>
        <br>

		<div class="container-fluid">
            <div class="col-4 mx-auto">
                <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <!-- Workshop Dropdown -->
                    <div class="dropdown text-center"  >
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Workshops
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php
                                $workshopdao = new WorkshopDAO();

                                $workshopList = $workshopdao->retrieveAllWorkshops();
                                // var_dump($workshopList);
                                foreach($workshopList as $workshop){
                                    // var_dump($workshop);
                                    $id = $workshop->getWorkshopID();
                                    // var_dump($id);
                                    $name = $workshop->getWorkshopName();
                                    echo"
                                        <li style='width: 500px;'>
                                            <button type='submit' class='form-control btn btn-link' name='yes' value='$id'>$name</button>
                                        </li>";
                                }
                            ?>
                        </ul>
                    </div>
                    
                    <?php

                        if (isset($_POST["yes"])){
                            $workshopID = $_POST['yes'];
                            $btnVal = "value='$workshopID'";
                            // var_dump($workshopID);
                            $workshopdao = new WorkshopDAO();
                            $workshop = $workshopdao->retrieveWorkshop($workshopID);
                            $workshopName =  "value='" . $workshop ->getWorkshopName() . "'";
                            $numOfPart = $workshop -> getAvailSpaces();
                            $wdate = "value='" . $workshop->getDate() . "'";
                            $wtimeStart = "value='" . $workshop ->getTimeStart() . "'";
                            $wtimeEnd = "value='" . $workshop ->getTimeEnd() . "'";
                            $wlocation = "value='" . $workshop -> getLocation() . "'";
                            $descr = $workshop->getDescr();
                        }

                        else {
                            $btnVal = "disabled";
                            $workshop = "";
                            $workshopName =  "";
                            $availSpaces = "";
                            $wdate = "";
                            $wtimeStart = "";
                            $wtimeEnd = "";
                            $wlocation = "";
                            $descr = "";
                        }

                    ?>
                    </form>
                    
                    <form action='workshopupload.php' method="post">
                    <!-- Name -->
                    <div class="row">
                        <label for="workshopName">Workshop Name</label>
                        <input type="text" class="form-control" id="workshopName" name="workshopName" <?php echo $workshopName?>>
                    </div>


                    
                    <!-- No. of Participants -->
                    <div class="row">
                        <label for="numOfPart">No. of Participants</label>
                        <select class="form-control" id="numOfPart" name="numOfPart">
                            <?php 
                                for ($i = 1; $i <= 100; $i++) {
                                    if (isset($numOfPart)){
                                        if ($numOfPart == $i){
                                            echo "<option selected>$i</option>";
                                        } else {
                                            echo "<option>$i</option>";
                                        }
                                    } else {
                                        echo "<option>$i</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="row">
                        <div class="col nocolpad">
                            <div class='form-group'>
                                <label for='datepicker'>Date of Workshop</label>
                                <input type='date' style="width: 100%;" class='form-control' id='wdate' name='wdate' <?php echo $wdate?>required/>
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="row">
                        <div class="col nocolpad">
                            <div class='form-group'>
								<label for='timepicker'>Start Time</label>
								<input type='time' style="width: 100%" class='form-control' id='wtimeStart' name='wtimeStart' <?php echo $wtimeStart?>/>
							</div>
                        </div>
                        <div class="col nocolpad">
                            <div class='form-group'>
								<label for='timepicker'>End Time</label>
								<input type='time' style="width: 100%" class='form-control' id='wtimeEnd' name='wtimeEnd' <?php echo $wtimeEnd?>/>
							</div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="row">
                        <label for="wlocation">Location</label>
                        <input type="text" class="form-control" id="wlocation" name="wlocation" <?php echo $wlocation?>>
                        <!-- <div class="invalid-feedback">
                            Please provide the location of the Workshop
                        </div> -->
                    </div>

                    <!-- Img of workshop -->
                    <div class="row">
                        <label for="workshopImg">Workshop Image</label>
                        <div class="custom-file">
                            <input type="file" name="workshopImg" id="workshopImg"> 
                        </div>
                        <small id="imageHelpInline" class="text-muted mb-2">
                        * Maximum file size is 2MB
                        </small>
                    </div>
                    
                    <!-- Description of Workshop -->
                    <div class="row">
                        <label for="validationTextarea">Description of Workshop</label>
                        <textarea class="form-control" name="descr" id="validationTextarea" placeholder="This workshop is about ..." rows="4"><?php echo $descr?></textarea>
                    </div>
                    <div class="row">
                        <button class="btn btn-primary my-3" type="submit" name="workshopID" <?php echo $btnVal ?>>Update</button>
                    </div>
                </form>
            </div>              
        </div>		
        
        <script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

		<!-- EXTERNAL JS -->
		<script src="js/script.js"></script>

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
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	</body>

</html>