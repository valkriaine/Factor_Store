<?php
if (!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started'] = 'started';
}
if (empty($_POST['page']))
{
    include_once('controller.php');
    exit();
}
else
{
    require ("model_user.php");
    require ("model_factor.php");

    $command = $_POST['command'];

    switch ($command)
    {
        case 'SignIn': //sign in request
            $username = $_POST['username'];
            $password = $_POST['password'];
            $validity = check_validity($username, $password);
            if ($validity == 1) //username exists but password is incorrect
            {
                echo json_encode($validity);
            }
            else if($validity == -1) //username does not exist in database
            {
                echo json_encode($validity);
            }
            else if($validity == 0) //username matches password in database, successfully signed in
            {
                $ID = get_id($username);
                $_SESSION['SignIn'] = 'YES';
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $ID;
                $_SESSION['type'] = get_user_type($ID);
                echo json_encode($validity);
            }
            break;
        case 'Join': //register for new user
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $code = register($username, $password, $email);
            if($code == -1) //username already exists in database
            {
                $error_join = 'user already exists';
                echo json_encode($code);
            }
            else //registered successfully
            {
                $_SESSION['SignIn'] = 'YES';
                $_SESSION['username'] = $username;
                $_SESSION['id'] = get_id($username);
                $_SESSION['type'] = get_user_type(get_id($username));
                echo json_encode($code);
            }
            break;
        case 'Get_Name': //retrieve username after logging in
            if(isset($_SESSION['SignIn']))
            {
                $name = $_SESSION['username'];
                echo json_encode($name);
            }
            else
            {
                echo json_encode(1);
            }
            break;
        case 'Get_Type': //retrieve user type
            if(isset($_SESSION['SignIn']))
            {
                //return 0 for normal user
                //return 1 for designer
                $type = $_SESSION['type'];
                echo json_encode($type);
            }
            else
            {
                //user not signed in
                echo json_encode("You are not signed in.");
            }
            break;
        case 'Update': //update user info
            if(isset($_SESSION['SignIn']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email_settings'];
                $type = $_POST['type'];
                $result = update_user($username, $email, $password, $type);
                echo json_encode($result);
            }
            else
            {
                //user not signed in
                echo json_encode("You are not signed in.");
            }
            break;
        case 'Delete': //delete the user account
            if(isset($_SESSION['SignIn']))
            {
                $result = delete_user($_SESSION['id']);
                echo json_encode($result);
            }
            else
            {
                //user not signed in
                echo json_encode("You are not signed in.");
            }
            break;
        case 'SignOut': //sign out and clear the session
            echo json_encode(session_unset());
            session_destroy();
            break;
    }
    exit;
}

