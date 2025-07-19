<!--</*?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
         }

      }
   }

}

?>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
   <style>
 body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 50px;
        }
        .vk1{
width:100%;
position: absolute;
z-index: -2;
}

p{
font-color:blue;
}
    
        form {
            max-width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
        }

        .box {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .btn {
            background-color:  #205fd2; /* Blue register button */
            color:  #fff;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color:  #205fd2;
        }

        /* Style for file input */
        input[type="file"] {
            margin-bottom: 10px;
        }

        /* Style for error messages (optional) */
        .message {
            background-color: #ff9999; /* Light red background for messages */
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            color: #fff;
            display: inline-block;
        }

        .message i {
            cursor: pointer;
        }
/*   body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    text-align: center;
    margin-top: 50px;
}

form {
    max-width: 300px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h3 {
    color: #333;
}

.box {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.btn {
    background-color: #4caf50;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

a {
    text-decoration: none;
    color: #4caf50;
}

/* Style for file input */
input[type="file"] {
    margin-bottom: 10px;
}

/* Style for error messages (optional) */
.error-message {
    color: #ff0000;
    margin-top: 5px;
}*/

      </style>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"-->

   <!-- custom css file link  -->
   <!--link rel="stylesheet" href="css/components.css"-->



   <!---
</head>
<body>
<img class="vk1" src="home-bg1.jpg" alt=
"foodzone1">
</*?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<!--section class="form-container"-->

   <!--<form action="" enctype="multipart/form-data" method="POST">
      <h3>register now</h3>
      <input type="text" name="name" class="box" placeholder="enter your name" required>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

<!--/section-->

<!---
</body>
</html>-->


<?php
include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var(md5($_POST['pass']), FILTER_SANITIZE_STRING);
    $cpass = filter_var(md5($_POST['cpass']), FILTER_SANITIZE_STRING);

    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select->execute([$email]);

    if ($select->rowCount() > 0) {
        $message[] = 'User email already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Send OTP email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'arpitkukadiya10@gmail.com'; // Your email
                $mail->Password = 'crmscaebqyzqvist'; // Your email password (use app password for Gmail)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('arpitkukadiya10@gmail.com', 'Your Website');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'OTP Verification';
                $mail->Body = 'Your OTP for registration is <b>' . $otp . '</b>.';

                $mail->send();

                // Save user data and OTP temporarily in session
                session_start();
                $_SESSION['temp_user'] = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $pass,
                    'image' => $image,
                    'otp' => $otp
                ];

                move_uploaded_file($image_tmp_name, $image_folder);
                header('location:otp_verify.php');
                exit;
            } catch (Exception $e) {
                $message[] = 'Error: Unable to send OTP. ' . $mail->ErrorInfo;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 50px;
        }
        form {
            max-width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #333;
        }
        .box {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #205fd2;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        a {
            text-decoration: none;
            color: #205fd2;
        }
        .message {
            background-color: #ff9999;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            color: #fff;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message">' . $msg . '</div>';
        }
    }
    ?>

    <form action="" enctype="multipart/form-data" method="POST">
        <h3>Register Now</h3>
        <input type="text" name="name" class="box" placeholder="Enter your name" required>
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <input type="password" name="pass" class="box" placeholder="Enter your password" required>
        <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
        <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="Register Now" class="btn" name="submit">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</body>
</html>