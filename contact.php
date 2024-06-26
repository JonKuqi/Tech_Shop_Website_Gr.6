<?php 
include("includes/header.php");
include('databaseConnection.php');

if(isset($_POST['send'])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){

      
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
        $toEmail = 'kaltrina.krasniqi45@gmail.com';
        
        $errors = [];

        
        if (empty($name)) {
            $errors[] = "Name is required.";
        }
        if (empty($email)) {
            $errors[] = "Email is required.";
        }
        if (empty($number)) {
            $errors[] = "Phone number is required.";
        }

        
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        
        if (!empty($number) && !preg_match('/^\d{3}-\d{3}-\d{3}$/', $number)) {
            
            if (preg_match('/^\d{9}$/', $number)) {
                
                $number = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6, 3);
            } else {
                $errors[] = "Valid phone number is required in format xxx-xxx-xxx.";
            }
        }

        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<script>alert("' . $error . '");</script>';
            }
        } else {
            
            $mailHeaders = "From: $email";

            if(mail($toEmail, $subject, $message, $mailHeaders)){
                echo '<script>alert("Your information is received successfully! We have sent you an email.");</script>';
            } else {
                echo 'Email sending failed. Please try again later.';
            }
        }
    } 
}
?>





<!DOCTYPE html>
<html>

<head>
    <script>
        function validateForm() {
            var name = document.forms["contactForm"]["name"].value;
            var email = document.forms["contactForm"]["email"].value;
            var number = document.forms["contactForm"]["number"].value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var phoneRegex = /^\d{3}-\d{3}-\d{3}$/;
            var phoneDigitsRegex = /^\d{9}$/;

            if (name === "") {
                alert("Name must be filled out.");
                return false;
            }
            if (!emailRegex.test(email)) {
                alert("Invalid email format.");
                return false;
            }
            if (!phoneRegex.test(number)) {
                if (phoneDigitsRegex.test(number)) {
                    
                    number = number.replace(/(\d{3})(\d{3})(\d{3})/, '$1-$2-$3');
                    document.forms["contactForm"]["number"].value = number;
                } else {
                    alert("Phone number must be in format xxx-xxx-xxx.");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>

<body>
    <section class="hero-section position-relative bg-light-blue padding-medium">
        <div class="hero-content">
            <div class="container">
                <div class="row">
                    <div class="text-center padding-large no-padding-bottom">
                        <h1 class="display-2 text-uppercase text-dark">Contact</h1>
                        <div class="breadcrumbs">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="contact-us padding-large">
        <div class="container">
            <div class="row">
                <div class="contact-info col-lg-6 pb-3">
                    <h2 class="display-7 text-uppercase text-dark">Contact info</h2>
                    <p>Contact us</p>
                    <div class="page-content d-flex flex-wrap">
                        <div class="col-lg-6 col-sm-12">
                            <div class="content-box text-dark pe-4 mb-5">
                                <h3 class="card-title text-uppercase text-decoration-underline">Office</h3>
                                <div class="contact-address pt-3">
                                    <p>730 Glenstone Ave 65802, Springfield, US</p>
                                </div>
                                <div class="contact-number">
                                    <p>
                                        <a href="#">+123 987 321</a>
                                    </p>
                                    <p>
                                        <a href="#">+123 123 654</a>
                                    </p>
                                </div>
                                <div class="email-address">
                                    <p>
                                        <a href="#">ministore@yourinfo.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="content-box">
                                <h3 class="card-title text-uppercase text-decoration-underline">Management</h3>
                                <div class="contact-address pt-3">
                                    <p>730 Glenstone Ave 65802, Springfield, US</p>
                                </div>
                                <div class="contact-number">
                                    <p>
                                        <a href="#">+123 987 321</a>
                                    </p>
                                    <p>
                                        <a href="#">+123 123 654</a>
                                    </p>
                                </div>
                                <div class="email-address">
                                    <p>
                                        <a href="#">ministore@yourinfo.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inquiry-item col-lg-6">
                    <h2 class="display-7 text-uppercase text-dark">Any questions?</h2>
                    <p>Use the form below to get in touch with us.</p>
                    <form id="form" name="contactForm" class="form-group flex-wrap" method="post" action="contact.php" onsubmit="return validateForm()">
                        <div class="form-input col-lg-12 d-flex mb-3">
                            <input type="text" name="name" placeholder="Write Your Name Here" class="form-control ps-3 me-3 mb-3">
                            <input type="text" name="email" placeholder="Write Your Email Here" class="form-control ps-3 mb-3">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <input type="text" name="number" placeholder="Phone Number" class="form-control ps-3">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <input type="text" name="subject" placeholder="Write Your Subject Here" class="form-control ps-3">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <textarea placeholder="Write Your Message Here" class="form-control ps-3" style="height:150px;" name="message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-medium text-uppercase btn-rounded-none" name='send'>Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <section id="our-store" class="padding-large no-padding-top">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-lg-6">
                    <div class="image-holder mb-5">
                        <img src="images/single-image2.jpg" alt="our-store" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="locations-wrap">
                        <div class="display-header">
                            <h2 class="display-7 text-uppercase text-dark">Our stores</h2>
                            <p>You can also directly buy products from our stores.</p>
                        </div>
                        <div class="location-content d-flex flex-wrap">
                            <div class="col-lg-6 col-sm-12">
                                <div class="content-box text-dark pe-4 mb-5">
                                    <h3 class="card-title text-uppercase text-decoration-underline">Office</h3>
                                    <div class="contact-address pt-3">
                                        <p>730 Glenstone Ave 65802, Springfield, US</p>
                                    </div>
                                    <div class="contact-number">
                                        <p>
                                            <a href="#">+123 987 321</a>
                                        </p>
                                        <p>
                                            <a href="#">+123 123 654</a>
                                        </p>
                                    </div>
                                    <div class="email-address">
                                        <p>
                                            <a href="#">ministore@yourinfo.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="content-box">
                                    <h3 class="card-title text-uppercase text-decoration-underline">USA</h3>
                                    <div class="contact-address pt-3">
                                        <p>730 Glenstone Ave 65802, Springfield, US</p>
                                    </div>
                                    <div class="contact-number">
                                        <p>
                                            <a href="#">+123 987 321</a>
                                        </p>
                                        <p>
                                            <a href="#">+123 123 654</a>
                                        </p>
                                    </div>
                                    <div class="email-address">
                                        <p>
                                            <a href="#">ministore@yourinfo.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <br>
    <?php include("includes/footer.php")?>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>
