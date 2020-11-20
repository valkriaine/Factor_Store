<?php
require_once("model_user.php");
require_once("model_factor.php");
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


        case 'Get_Author_ID': //retrieve designer ID
            if(isset($_SESSION['SignIn']))
            {
                $type = $_SESSION['type'];
                if ($type == 1)
                    echo json_encode($_SESSION['id']);
                else
                    echo json_encode("You are not a designer.");
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

        case 'Upload': //upload a new widget
            if(isset($_SESSION['SignIn']))
            {
                $description = $_POST['description'];
                $creator = $_SESSION['id'];
                $name  = $_POST['name'];
                $path = "";
                $icon_path = "";
                $splash_path = "";
                $price = $_POST['price'];
                $productivity = $_POST['productivity'];
                $entertainment = $_POST['entertainment'];
                $utility = $_POST['utility'];
                $quick_app = $_POST['quick_app'];

                $result =
                    upload($description,
                            $creator,
                            $name,
                            $path,
                            $icon_path,
                            $splash_path,
                            $price,
                            $productivity,
                            $entertainment,
                            $utility,
                            $quick_app);

                if ($result == 0)
                {
                    $result_update = update_paths($name);
                    if ($result_update == true)
                    {
                        echo json_encode(0);
                        unset($_SESSION['widget_name']);
                        unset($_SESSION['package_path']);
                        unset($_SESSION['package_uploaded']);
                        unset($_SESSION['splash_image_path']);
                        unset($_SESSION['splash_uploaded']);
                        unset($_SESSION['icon_image_path']);
                        unset($_SESSION['icon_uploaded']);
                    }

                    else
                        echo json_encode('error updating paths');
                }
                else
                    echo json_encode($result);
            }
            else
            {
                //user not signed in
                echo json_encode("You are not signed in.");
            }
            break;

        case 'Search': //search for widgets
            $term = $_POST['term'];
            $result = search_factor($term);
            echo json_encode(createList($result));
            break;

        case 'Filter': //show widgets based on category selected
            $category = $_POST['category'];
            $result = filter_factor($category);
            echo json_encode(createList($result));
            break;



        case 'Get_Widget': //retrieve widget info
            $id = $_POST['get_id'];
            $result = get_factor($id);
            $array = array();
            foreach ($result as $key => $row)
            {
                $array[$key] =
                    array($row['NAME'],
                        $row['DESCRIPTION'],
                        $row['CREATOR'],
                        $row['DOWNLOADS'],
                        $row['PATH'],
                        $row['ICON_PATH'],
                        $row['SPLASH_PATH'],
                        $row['PRICE'],
                        $row['PRODUCTIVITY'],
                        $row['ENTERTAINMENT'],
                        $row['UTILITY'],
                        $row['QUICK_APP'],
                        );
            }
            echo json_encode($array);
            break;

        case 'Get_Author_Name': //retrieve author name for this widget
            $id = $_POST['author_id'];
            $result = get_name($id);
            echo json_encode($result);
            break;

        case 'Show_Comments': //retrieve list of comments under this widget
            $id = $_POST['item_id'];
            $result = get_comments($id);
            echo json_encode(generateComments($result));
            break;

        case 'Add_Comment': //add a new comment under the current widget
            $item_id = $_POST['item_id'];
            $comment = $_POST['comment'];
            $user_id = $_SESSION['id'];
            $result = add_comment($item_id, $user_id, $comment);
            if ($result == true)
                echo json_encode(generateComments(get_comments($item_id)));
            else
                echo json_encode("Error");
            break;

        case 'SignOut': //sign out and clear the session
            echo json_encode(session_unset());
            session_destroy();
            break;
    }
    exit;
}


function createList($data = array())
{
    $list = '';
    foreach ($data as $row)
    {
        $list = $list.' <div class="col-md-4" style="margin-top: 27px" data-toggle="modal" data-target="#factor-modal" id="'.$row['ID'].'">
                    <div class="card p-3">
                    <div class="d-flex flex-row mb-3">';
        $list = $list.'<img src="'.$row['ICON_PATH'].'" width="70" alt="">';
        $list = $list.'<div class="d-flex flex-column ml-2"><span>'.$row['NAME'].'</span>';
        $list = $list.'<span class="text-black-50" id="factor-id">ID: '.$row['ID'].'</span><span class="ratings">
                            <i class="fa fa-star" style="color: green"></i>
                            <i class="fa fa-star" style="color: green"></i>
                            <i class="fa fa-star" style="color: green"></i>
                            <i class="fa fa-star" style="color: green"></i></span></div>
                </div>
                <h6>'.$row['DESCRIPTION'].'</h6>
                <div class="d-flex justify-content-between install mt-3">
                <span style=" font-size: 12px">'.$row['DOWNLOADS'].' downloads</span>
                <span class="text-primary">&nbsp;
                <i class="fa fa-angle-right"></i>
                </span>
                </div>
               </div>
             </div> ';
    }
    return $list;
}



function generateComments($data = array())
{
    if (sizeof($data) < 1)
        return "No comments available.";
    $list = '';
    $forehead_question = '<td>';
    $forehead_other = '<td style="text-align:center">';
    $tail = '</td>';
    foreach ($data as $row)
    {
        $list = $list.'<tr>';
        $list = $list.$forehead_question.get_name($row['USER_ID']) . $tail;
        $list = $list. $forehead_other.$row['DATE'] . $tail;
        $list = $list. $forehead_other . $row['COMMENT'] . $tail;
        $list = $list.'</tr>';
    }
    return $list;
}

