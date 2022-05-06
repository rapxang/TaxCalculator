<?php 
session_start();
require "connection.php";
$email = "";
$name = "";
$errors = array();

//if user signup button
if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    

    if($password !== $cpassword){
        $errors['password'] = "The passwords do not match.Please recheck your passwords!";
    }
    if(!empty($_POST)) {
    // check length of $_POST['username']

    if (strlen($_POST['name']) <5){
                    $errors['name']= "Username need to be 5 characters or longer!Please Try Again!";           
    }

    // check length of $_POST['password']
    if (strlen($_POST['password']) <8){
           $errors['password']="The Minimum Character for password should be 8!Please Try Again!"; 
    }}




    $check_email= "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($con, $check_email);
    if(mysqli_num_rows($result) > 0){
    
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "Email that you have entered is already exist!Please Use different email address!";
    }
    if(count($errors) === 0){
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO usertable (name, email, password, code, status)
                        values('$name', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($con, $insert_data);
        if($data_check){
            $email=$_POST['email'];
            $subject = "Email Verification Code";
            $message = "Your verification code is $code";
            $sender = "From: taxcalculatingsystem@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }   
    }else{
        $errors['email'] = "Sorry! Only verified admins are allowed to sign up!";
    }
}
/* During a Sign-Up process, $_POST command helps to input the user’s name, email, password to the database. Password (password) and Confirmation (cpassword) password are checked. If these two does not match then the user is notified that the passwords do not match. Moreover, the entered email address for the sign-up process is also checked in the database. If the entered email is present in the database, then the user is notified for using existing email address.
If there is no error during signup process, which means that the user has user non existing email address in the database and the passwords matches, the data are stored in the table in the database. Password is stored in encrypted format with the help of hash function along with a random code which is used as the OTP code for email verification and the status is set to “notverified”.  When the user clicks on the signup button with no error present, the user is directed to the “user-otp.php” file for email verification using OTP code.
*/






    //if user click verification code submit button
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'verified';
            $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_res = mysqli_query($con, $update_otp);
            if($update_res){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header('location: login-user.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }
/*After the OTP code has been sent to the user email address, and the OTP code from the database and the user email address is checked. User are notified if the entered code is incorrect. If the code matches then the user is directed to the “login-user.php” through which the user can login using email address and the password.
*/





    //if user click login button
    if(isset($_POST['login'])){
        $time=time()-60;
        $ip_address=getIpAddr();
        $check_login_row=mysqli_fetch_assoc(mysqli_query($con,"SELECT count(*) as total_count from login_log WHERE try_time>$time and ip_address='$ip_address'"));
        $total_count=$check_login_row['total_count'];
        if ($total_count==3) {
            $errors['email']  = "Too many failed Login attempts!Try again in 1 minute!";
        }


        else{ 
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $check_email = "SELECT * FROM usertable WHERE email = '$email'";
        $res = mysqli_query($con, $check_email);
        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['password'];
            if(password_verify($password, $fetch_pass)){
                $_SESSION['email'] = $email;
                $status = $fetch['status'];
                if($status == 'verified'){
                  $_SESSION['email'] = $email;
                  $_SESSION['password'] = $password;
                    header('location: AdminPage/AdminPage.php');

                    mysqli_query($con,"DELETE FROM login_log WHERE ip_address='$ip_address'");
                }else{
                    $info = "It looks like you still have not verified your email address. - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                }
            }else{
                $total_count++;
                $rem_attm=3-$total_count;

                if ($rem_attm==0) {
                    $errors['email'] = "Too many failed Login attempts! Try again in 1 minute!";
                }else{
                    $errors['email'] = "Incorrect email or password! $rem_attm attempts remaining!";
                }
                $try_time=time();
                mysqli_query($con,"INSERT INTO login_log(ip_address,try_time) VALUES ('$ip_address','$try_time') ");
                // when ever  auser enters wrong password, it is stored in the database table login_log
                
            }
        }else{
            $errors['email'] = "It looks like you're not a member yet! Click on the link at the  bottom  to signup.";
        }

        }  
    }

/*When the user clicks on the login button, $email variable stores the email value of user input and $password stores the password value of the user input. $check_email variable checks whether the input email is present in the database table or not. If the email is present in the database table, its status is checked whether it is verified or not. If the email present in the database table is verified then the password is checked whether it matches with the one in the database table or not. The user is notified stating that the email needs to be verified if the status is notverified. If an unauthorized user tries to login, they are requested for sign up in order to access login feature. When the email and password match with the ones in the database after verification, the user is directed to the admin panel.*/
 function getIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARD_FOR'])) {
        $ipAddr=$_SERVER['HTTP_X_FORWARD_FOR'];
    }else{
        $ipAddr=$_SERVER['REMOTE_ADDR'];
    }
    return $ipAddr;
 }





    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM usertable WHERE email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: taxcalculator123@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a password reset otp code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending the otp code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "The provided email address does not exist!";
        }
    }

/*When a user forgets their password and hits the "forgot password" link, they are taken to the "forgot-password.php" file, which asks for the user's email address. An OTP code is sent to the user's email address for authentication whether the user enters a legitimate email address that is already in the database. If a user enters an incorrect email address, the user is informed that the email address given does not exist in the database. Furthermore, users are alerted when the OTP code sending process fails, stating that the sending code process failed.*/





    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

/*When a user is led to the “reset-code.php” file, it prompts them to enter the OPT code they received by email. The OTP code entered by the user is compared to the code contained in the database. If the codes do not match with the chosen row from the database, the user is alerted that they entered an inaccurate code; however, if the code the user entered matches the one in the database, the user is not informed. If the code entered by the user matches the code stored in the database, the user is led to the “new-password.php” file, where they can reset their password.*/







    //if user click change password button
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; //getting this email using session
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['db-error'] = "Failed to change your password!";
            }
        }
    }

    /*In the change password panel, when user enters unmatched password, they are notified stating that the password does not match. When the passwords match, the chosen row's password in the database is replaced with the new password, and the user is informed that their password has been successfully changed. The user is then led to the “password-changed.php” file, where he or she can re-enter their credentials.*/



    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }
    /*The user is led to the login panel when they press the "login-now" tab.*/
?>