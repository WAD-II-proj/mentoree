These are the steps for a complete walkthrough of the website, from start to finish. If you simply wish to log in and see some of the preset features, you may use these login credentials:

--Mentee--
Email: 		xx@gmail.com
Password: 	Hello123
*Ensure that Mentee is selected when logging in*

--Mentor--
Email: 		fang@gmail.com
Password: 	Hello123
*Ensure that Mentor is selected when logging in*

--START--
When deploying locally:

phpMyAdmin -> Import SQL Table from /app/model/sqltables.sql
           -> Ensure that /app/model/ConnectionManager.php 's settings is set correctly
                i.e. $username = 'root'; // For WAMP
                     $password = '';

                     $username = 'root'; // For MAMP
                     $password = 'root';

Starting Page: /app/home/home.php

Step 1: Create a Mentee
    -> Click on "Join us as Mentee/Mentor" to be redirected to Sign Up page

Fill in the details as follows:
    First name:         New
    Last name:          Mentee
    Date of Birth:      <Enter ANY date>
    Gender:             <Select ANY gender>
    Phone Number:       <Enter ANY 8 digit number>
    Email:              mentee@gmail.com !!IMPORTANT!!
    Password:           Hello123 // Must follow password convention
    Confirm Password:   Hello123
    Position:           Mentee
    Reason:             <Enter ANY text>
    Transcript:         mentee.pdf // Find File in App Folder
    Profile Picture:    mentee.jpg // Find File in App Folder

    Check "I'm not a robot" captcha

    // If testing while not following guidelines, do take note that transcript and profile picture's FILE NAME must be the same as email. i.e. xxx@gmail.com, xxx.pdf, xxx.jpg

    -> Click "Sign Up"
    -> Click "Back to Home Page" to be redirected to Home Page


Step 2: Create a Mentor
    -> Click on "Join us as Mentee/Mentor" to be redirected to Sign Up page

Fill in the details as follows:
    First name:         New
    Last name:          Mentor
    Date of Birth:      <Enter ANY date>
    Gender:             <Select ANY gender>
    Phone Number:       <Enter ANY 8 digit number>
    Email:              mentor@gmail.com !!IMPORTANT!!
    Password:           Hello123 // Must follow password convention
    Confirm Password:   Hello123
    Position:           Mentor
    Reason:             <Enter ANY text>
    Profile Picture:    mentor.jpg // Find File in App Folder

    Check "I'm not a robot" captcha

    // If testing while not following guidelines, do take note that profile picture's FILE NAME must be the same as email. i.e. xxx@gmail.com, xxx.pdf, xxx.jpg
    -> Click "Sign Up"

    -> Click "Back to Home Page" to be redirected to Home page


Step 3: As ADMIN, approve Mentee
    Navigate to /app/admin/menteeEligible.php // Have to type in URL as Admin is meant to be accessed separately.
    -> Click "Eligible" for New Mentee


Step 4: As ADMIN, approve Mentor
    -> Click on Mentor (Opens Drop Down)
        -> Mentor Eligibility
    -> Click "Accept" for New Mentor


Step 5: Login as Mentee
    -> Click "Mentoree" Icon on NAV BAR to be redirected to Home page
    -> Click "Login" on NAV BAR to be redirected to Login page
    Email:              mentee@gmail.com
    Password:           Hello123
    Ensure that Mentee option is SELECTED

    -> Click "Log In" to be logged in


Step 6: View About Us Page
    -> Click "About Us" on NAV BAR OR FOOTER


Step 7: View Guidelines Page
    -> Click "Guidelines" on FOOTER


Step 8: View FAQ Page
    -> Click "FAQ" on FOOTER


Step 9: Select a "New Mentor" as Mentor
    -> Click "New Mentee" on NAV BAR (Opens Drop Down)
        -> Click "Profile"
    -> Click "Select Mentor" to be redirected to Select Mentor page
    -> Click "SELECT ME" for New Mentor

    // New Mentor is now the Mentor of New Mentee!


Step 10: Join a Workshop
    -> Click "Join our Workshops" on NAV BAR to be redirected to Workshops page
    -> [Optional] Click on "+ Show More" to view more description
    -> Click "Sign Up" for GLOBAL INNOVATION IMMERSION (GII) Workshop to be redirected to Workshop Sign Up page

    Workshop:               GLOBAL INNOVATION IMMERSION (GII)

    Check "I'm not a robot" captcha

    -> Click "Sign Up"
    -> Click "Back to Home Page" to be redirected to Home page

    -> Click "Join our Workshops" on NAV BAR to be redirected to Workshops page
    // Note that Number of Slots have increased by 1

    -> Click "New Mentee" on NAV BAR (Opens Drop Down)
        -> Click "Profile"
    // Note that Workshop has been added to Profile page


Step 11: View Testimonials
    -> Click "Mentoree" Icon on NAV BAR to be redirected to Home page
    -> Scroll down to Testimonials and Click "See More"

// Page displays all testimonials, with a Word Cloud generated to highlight key words mentioned frequently in the testimonials [Textvis Word Cloud API]


Step 12: Login as Mentor
    -> Click "New Mentee" on NAV BAR (Opens Drop Down)
        -> Click "Logout"
    -> Click "Login" on NAV BAR to be redirected to Login page
    Email:              mentor@gmail.com
    Password:           Hello123
    Ensure that Mentor option is SELECTED

    -> Click "Log In" to be logged in


Step 13: Setup and View Meeting Point
    -> Click "New Mentor" on NAV BAR (Opens Drop Down)
        -> Click "Profile"
    -> Click "Setup Meeting Point" to be redirected to Create Meeting Point page

    Mentee:             New Mentee
    Meeting Place:      Singapore Management University (Select from Autocomplete) [Google Maps Autocomplete API]
    Date:               <Enter ANY date>
    Time:               <Enter ANY time>

    -> Click "Set Meeting Point" to set up a meeting point and be redirected to All Meeting Point page

    // Forecasted Weather and Temperature is shown for the day on All Meeting Point page to allow Mentee / Mentor to better prepare for their meet up [OpenWeather API] 

    -> Click "View" for Singapore Management University Meeting Point

    // If prompted, Allow Geolocation

    -> Select between "Driving", "Transit" and "Walking" to get different routes between your location and destination

    // Note to Prof: Geolocation code is correct, however, the accuracy of it is not very high. Therefore, your current location may be off.


Step 14: Add / Edit Testimonial
    Navigate to /app/admin/adminTestimonials.php // Have to type in URL as Admin is meant to be accessed separately.

    // In our application, mentees will EMAIL the admin their testimonials. The admin will then upload the testimonial through the Add / Edit testimonial function.

    // For this step, it is assumed that New Mentee has submitted a testimonial, and that the admin is currently uploading it.

    Mentee Email Address:   mentee@gmail.com
    Type Testimonial Here:  Mentoree has helped me find a spot in a great university! I highly recommend those who need some advice to join Mentoree as a mentee!

    -> Click "Save Testimonial"

    -> Click "Mentoree" Icon on NAV BAR to be redirected to Home page
    -> Scroll down to Testimonials

    // Note that Testimonials has been updated with the new Testimonial that was uploaded


Step 15: Add / Workshop
    Navigate to /app/admin/addWorkshops.php // Have to type in URL as Admin is meant to be accessed separately.

    Workshop Name:              Javascript Workshop
    No. of Participant:         20
    Date of Workshop:           <Enter ANY date>
    Start Time:                 <Enter ANY time>
    End Time:                   <Enter ANY time>
    Location:                   <Enter ANY location>
    Workshop Image:             workshop4.jpg // Find File in App Folder
    Description of Workshop:    Learn about Javascript!

    -> Click "Save"

    -> Click "Mentoree" Icon on NAV BAR to be redirected to Home page
    -> Scroll down to Testimonials

    // Note that Workshops carousel has been updated with the new Workshop that was uploaded

    -> Click "Join our Workshops" on NAV BAR to be redirected to Workshops page

    // Note that Workshop has been updated with the new Workshop that was uploaded

Step 16: Edit Workshop
    Navigate to /app/admin/editWorkshops.php

    Select a Workshop from the Dropdown menu to autofill the workshop details on the form

    Edit accordingly

    -> Click "Update" to save your changes

Step 17: Delete Workshop Participants
    Navigate to /app/admin/adminworkshop.php

    Select a Workshop from the Dropdown menu to view workshop participants.

    You may delete participants here if you wish to do so.

Step 18: Delete Mentee / Mentor
    Navigate to either /app/admin/adminmentee.php OR /app/admin/adminmentor.php

    You may delete mentees or mentors here if you wish to do so.



We have a livechat function [Tawk.to]. It is accessible by us on the Tawk website. On the day of the presentation we will be monitoring the Tawk website. Send us a chat and we'll live reply you!