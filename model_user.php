<?php
$conn = mysqli_connect('localhost', 'ywangf20', 'valkriaine', 'C354_ywangf20');

//check if the username exists in database
function check_existence($user)
{
    global $conn;
    $sql = "SELECT * FROM FACTOR_USERS WHERE NAME = '$user'";
    $result = mysqli_query($conn, $sql);
    return (mysqli_num_rows($result) > 0);
}


//register new user
//performs check if the username already exists
function register($user, $password, $email)
{
    global $conn;
    if (!check_existence($user))
    {
        $current_date = date("Ymd");
        $sql = "INSERT INTO FACTOR_USERS VALUES (NULL, '$user', '$email', '$password', '$current_date', 0)";
        mysqli_query($conn, $sql);
        return 0;
    }
    else
    {
        //user already exists
        return -1;
    }
}


//check if the credentials are correct
//return different codes based on the result
function check_validity($user, $password)
{
    global $conn;
    if (check_existence($user))
    {
        $sql = "SELECT NAME, PASSWORD FROM FACTOR_USERS WHERE NAME = '".$user."' AND  PASSWORD = '".$password."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0 )
        {
            //valid
            return 0;
        }
        else
        {
            //wrong password
            return 1;
        }
    }
    else
    {
        //user does not exist (wrong username)
        return -1;
    }
}


//return name given id
function get_name($user_id)
{
    global $conn;
    $sql = "SELECT * FROM FACTOR_USERS WHERE ID = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        return $row['NAME'];
    }
    else
    {
        return -1;
    }
}

//return name given id
function get_user_type($user_id)
{
    global $conn;
    $sql = "SELECT * FROM FACTOR_USERS WHERE ID = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        return $row['TYPE'];
        //return 0 for normal user
        //return 1 for designer
    }
    else
    {
        return -1;
    }
}


//return id given name
function get_id($username)
{
    global $conn;
    $sql = "SELECT * FROM FACTOR_USERS WHERE NAME = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        return $row['ID'];
    }
    else
    {
        return -1;
    }
}

function update_user($name, $email, $password, $type)
{
    global $conn;
    $id = $_SESSION['id'];

    $sql = "UPDATE `FACTOR_USERS` SET 
    `NAME` = '$name', 
    `EMAIL` = '$email', 
    `PASSWORD` = '$password', 
    `TYPE` = '$type'
    where `ID` = '$id' ";

    if (mysqli_query($conn, $sql))
    {
        $_SESSION['SignIn'] = 'YES';
        $_SESSION['factor_username'] = $name;
        $_SESSION['id'] = $id;
        $_SESSION['type'] = get_user_type($id);
        return 0; //updated successfully
    }
    else
        return mysqli_error($conn); //sql error

}

function delete_user($id)
{
    global $conn;

    $sql = "DELETE FROM `FACTOR_USERS` where `ID` = '$id' ";

    if (mysqli_query($conn, $sql))
    {
        $result =  session_unset();  //deleted successfully
        session_destroy();

        //if the account is of type designer, delete all the widgets that this user has created
        $delete_sql = "DELETE FROM FACTOR where CREATOR = $id";
        $delete_result = mysqli_query($conn, $delete_sql);
        if ($delete_result == true)
            return $result;
        else
            return mysqli_error($conn);
    }
    else
        return mysqli_error($conn); //sql error

}
