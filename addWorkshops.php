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

        <title>Add Workshop | Mentoree</title>

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

            .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            }

            .dropdown {
            position: relative;
            display: inline-block;
            }

            .dropdown-content {
            display: none;
            position: absolute;
            /* background-color: #f1f1f1; */
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            }

            .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            }

            .dropdown-content a:hover {background-color: #ddd;}

            .dropdown:hover .dropdown-content {display: block;}

            .dropdown:hover .dropbtn {background-color: #3e8e41;}

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
                Add Workshops
            </span>
        </header>
        <br>

		<div class="container-fluid">
            <div class="col-4 mx-auto">
                <form action="workshopupload.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <!-- Name -->
                    <div class="row">
                        <label for="workshopName">Workshop Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="workshopName" name="workshopName" required>
                        <div class="invalid-feedback">
                            Please provide the Workshop Name
                        </div>
                    </div>
                    
                    <!-- Workshop ID & No. of Participants -->
                    <div class="row">
                        <div class="col nocolpad">
                            <label for="numOfPart">No. of Participants <span class="required">*</span></label>
                            <select class="form-control" id="numOfPart" name="numOfPart">
                                <?php 
                                for ($i = 1; $i <= 100; $i++) {
                                    echo "<option>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="row">
                        <div class="col nocolpad">
                            <div class='form-group'>
                                <label for='datepicker'>Date of Workshop <span class="required">*</span></label>
                                <input type='date' style="width: 100%;" class='form-control' id='datepicker' name='wdate' required/>
                            </div>
                            <div class="invalid-feedback">
                                Please provide the date of the workshop.
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="row">
                        <div class="col nocolpad">
                            <div class='form-group'>
								<label for='timepicker'>Start Time <span class="required">*</span></label>
								<input type='time' style="width: 100%" class='form-control' id='timepicker' name='wtimeStart' required/>
							</div>
                            <div class="invalid-feedback">
                                Please provide the start time of the workshop.
                            </div>
                        </div>
                        <div class="col nocolpad">
                            <div class='form-group'>
								<label for='timepicker'>End Time <span class="required">*</span></label>
								<input type='time' style="width: 100%" class='form-control' id='timepicker' name='wtimeEnd' required/>
							</div>
                            <div class="invalid-feedback">
                                Please provide the end time of the workshop.
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="row">
                        <label for="wlocation">Location <span class="required">*</span></label>
                        <input type="text" class="form-control" id="wlocation" name="wlocation" required>
                        <div class="invalid-feedback">
                            Please provide the location of the Workshop
                        </div>
                    </div>

                    <!-- Img of workshop -->
                    <div class="row">
                        <label for="workshopImg">Workshop Image <span class="required">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="workshopImg" id="workshopImg" required> 
                        </div>
                        <small id="imageHelpInline" class="text-muted mb-2">
                        * Maximum file size is 2MB
                        </small>
                    </div>
                    
                    <!-- Description of Workshop -->
                    <div class="row">
                        <label for="validationTextarea">Description of Workshop <span class="required">*</span></label>
                        <textarea class="form-control" name="descr" id="validationTextarea" placeholder="This workshop is about ..." rows="4" required></textarea>
                        <div class="invalid-feedback">
                            Please enter a short description about the workshop.
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="g-recaptcha" data-sitekey="your_site_key"></div> -->
                        <button class="btn btn-primary my-3" type="submit" name="submit">Save</button>
                    </div>
                </form>
            </div>              
        </div>
        
        <!-- your_site_key = 
        <form action="?" method="POST">
            <div class="g-recaptcha" data-sitekey="your_site_key"></div>
            <br/>
            <input type="submit" value="Submit">
        </form> -->

		<!-- BOOTSTRAP JS -->
		<script src="js/jquery-3.5.1.min.js"></script>
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