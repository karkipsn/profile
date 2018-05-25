<?php
    $hostname = "localhost";
    $user = "root";
    $password = "";
    $database = "userprofile";
    $prefix = "";
    $db=mysqli_connect($hostname,$user,$password,$database);




    session_start();
    
    if(isset($_REQUEST['signup_button'])){
        $user_email=$_REQUEST['user_email'];
        $user_firstname=$_REQUEST['user_firstname'];
        $user_lastname=$_REQUEST['user_lastname'];
        $user_username=$_REQUEST['user_username'];
        $user_password=$_REQUEST['user_password'];
        $sql="INSERT INTO profile(user_firstname,user_lastname,user_email,user_username,user_password,user_joindate,user_avatar) VALUES('$user_firstname','$user_lastname','$user_email','$user_username','$user_password',CURRENT_TIMESTAMP,'default.jpg')";
        mysqli_query($db,$sql) or die(mysqli_error($db));
        $_SESSION['user_username'] = $user_username;
        header('Location: ../update-profile-after-registration.php?user_username='.$user_username);
    }
//LOGIN PROCESS

     if(isset($_REQUEST['login_button'])||$_REQUEST['auto']==1){
       
        $errmsg_arr = array();
        $errflag = false;
        $username=  mysqli_real_escape_string($database,$_REQUEST['username']);
        $password=  mysqli_real_escape_string($database,$_REQUEST['password']);
        if($username == '') {
            $errmsg_arr[] = 'Username missing';
            $errflag = true;
        }
        if($password == '') {
            $errmsg_arr[] = 'Password missing';
            $errflag = true;
        }
        if($errflag) {
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            session_write_close();
            header("location: authentication-check.php");
            exit();
        }
        $sql="SELECT user_username,user_password FROM profile WHERE user_username='$username'AND user_password='$password'";
        $result=  mysqli_query($db,$sql) or die(mysqli_errno());
        $trws= mysqli_num_rows($result);
        if($trws==1){
            $rws=  mysqli_fetch_array($result);
            $_SESSION['user_username']=$rws['user_username'];
            $_SESSION['user_password']=$rws['user_password'];
            header("location:../home.php?user_username=$username&request=login&status=success");    
        }
        else {
            $errmsg_arr[] = 'user name and password not found';
            $errflag = true;
            if($errflag) {
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
                header("location: ../components/authentication-check.php");
                exit();
            }
        }
    }

?>
