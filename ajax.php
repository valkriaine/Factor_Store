<?php

if (empty($_POST['page']))
{
    include_once('controller.php');
    exit();
}
else
{
    require ("model_user.php");
    require ("model_factor.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $command = $_POST['command'];

    switch ($command)
    {
        case 'SignIn': //sign in request
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
                $_SESSION['signedin'] = 'YES';
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $ID;
                echo json_encode($validity);
            }
            break;
        case 'Join': //register for new user
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
    }
    exit;
}

