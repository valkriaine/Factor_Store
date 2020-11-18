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
            else if($validity == 0) //username matches password in database, move to mainpage
            {
                $ID = get_id($username);
                $_SESSION['SignIn'] = 'YES';
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $ID;
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
        case 'SignOut': //sign out and clear the session
            echo json_encode(session_unset());
            session_destroy();
            break;
    }
    exit;
}

