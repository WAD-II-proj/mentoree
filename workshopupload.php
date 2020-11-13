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

        <!-- favicon -->
        <link rel="shortcut icon" type="image/jpg" href="../logo/favicon.ico"/>


        <title>Upload Workshop | Mentoree</title>

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            .banner {
                background-image:  url("https://images.unsplash.com/photo-1433838552652-f9a46b332c40?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80");
                
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

        <?php
            session_start(); 
            require_once "../model/common.php";

            function uploadPic($workshopImg) {
                $target_dir = "../img/";
                $target_file = $target_dir . basename($workshopImg["name"]);
                $uploadOk = 1;
                $errors = [];
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
                // Check file size
                if ($workshopImg["size"] > 2000000) {
                    $errors[] = "Submitted picture is too large.";
                    $uploadOk = 0;
                }
            
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $errors[] = "Your picture is not a JPG, JPEG, or PNG file.";
                    $uploadOk = 0;
                }
            
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    return $errors;
                // if everything is ok, try to upload file
                } else {
                    if (!move_uploaded_file($workshopImg["tmp_name"], $target_file)) {
                    $errors[] = "There was an error uploading your picture. Your file size might have been too large.";
                    }
                    return $errors;
                }
            }

        $workshopdao = new WorkshopDAO();
        
        // upload image
        $errors = [];
        if (isset($_FILES["workshopImg"])){
            $errors += uploadPic($_FILES["workshopImg"]);
        }
        if (sizeof($errors) == 0) {
                
            $form = [];
            
            // retrieve form data
            $form['workshopName'] = $_POST['workshopName'];
            $form['availSpaces'] = $_POST['numOfPart'];
            $form['descr'] = $_POST['descr'];
            $form['wdate'] = $_POST['wdate'];
            $form['wtimeStart'] = $_POST['wtimeStart'];
            $form['wtimeEnd'] = $_POST['wtimeEnd'];
            $form['wlocation'] = $_POST['wlocation'];

            // EDIT WORKSHOP
            if (isset($_POST['workshopID'])){
                
                $form['workshopID'] = $_POST['workshopID'];
                if (isset($_FILES["workshopImg"])){
                    $form['imgPath']  = basename($_FILES["workshopImg"]["name"]);
                } else {
                    $workshop = $workshopdao->retrieveWorkshop($_POST['workshopID']);
                    $form['imgPath'] = $workshop->getImgPath();
                }

                $workshopdao->edit($form);
                echo "<div class='col text-center'><br>
                        <h3>You have successfully edited your workshop</h3>
                        <h2><b>". $form['workshopName'] . "</b></h2>
                    </div>";
            }

            // ADD WORKSHOP
            else {
                $form['imgPath']  = basename($_FILES["workshopImg"]["name"]);
                $workshopdao->createWorkshop($form);
                echo "<div class='col text-center'><br>
                        <h3>You have successfully added your workshop</h3>
                        <h2><b>". $form['workshopName'] . "</b></h2>
                    </div>";
            }
        } else {

            // ERROR WITH UPLOADING FILES
            echo "<div class='col'><br>
                    Your files have failed to upload for the following reasons:<ul>";
            foreach ($errors as $error) {
            echo "<li>$error</li>";
            }
            
            $user = $_POST["submit"];
            echo "</ul>
                Go back to <a href=$user" . "SignUp.php>Sign up</a> page
                </div>";
        }
    
        ?>

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

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    </body>
</html>