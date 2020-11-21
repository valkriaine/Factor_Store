<?php

$conn = mysqli_connect('localhost', 'ywangf20', 'valkriaine', 'C354_ywangf20');

function upload($description,
                $creator,
                $name,
                $path,
                $icon_path,
                $splash_path,
                $price,
                $productivity,
                $entertainment,
                $utility,
                $quick_app)
{
    global $conn;
    if (!check_existence_factor($name))
    {
        $sql = "INSERT INTO FACTOR 
            VALUES (NULL, 
            '$description',
            '$creator',
             0,
             '$name',
             '$path',
             '$icon_path',
             '$splash_path',
             '$price',
             '$productivity',
             '$entertainment',
             '$utility',
             '$quick_app', 0)";

        $result =  mysqli_query($conn, $sql);
        if ($result == true)
        {
            $_SESSION['widget_name'] = $name;
            return 0;
        }
        else
            return mysqli_error($conn);
    }
    else
        return -1; //name already exists

}

function check_existence_factor($name)
{
    global $conn;
    $sql = "SELECT * FROM FACTOR WHERE NAME = '$name'";
    $result = mysqli_query($conn, $sql);
    return (mysqli_num_rows($result) > 0);
}


function search_factor($term)
{
    global $conn;
    $sql = "select * from FACTOR where NAME like '%$term%'";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}

//test method for setting up promoted widgets, in reality we will use a different list
function get_first_three_widgets()
{
    global $conn;
    $sql = "select * from FACTOR LIMIT 3";
    $result = mysqli_query($conn, $sql);
    echo mysqli_error($conn);
    $data = [];
    while($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}


function update_paths($name)
{
    global $conn;
    $id = get_id_factor($name);
    $path = $_SESSION['package_path'];
    $icon_path = $_SESSION['icon_image_path'];
    $splash_path = $_SESSION['splash_image_path'];

    $sql = "UPDATE `FACTOR` SET 
    `PATH` = '$path', 
    `ICON_PATH` = '$icon_path', 
    `SPLASH_PATH` = '$splash_path'
    where `ID` = '$id' ";

    $result = mysqli_query($conn, $sql);
    if ($result == true)
        return true;
    else
        return mysqli_error($conn);


}


//return id given name
function get_id_factor($name)
{
    global $conn;
    $sql = "SELECT * FROM FACTOR WHERE NAME = '$name'";
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


function get_factor($id)
{
    global $conn;

    $sql = "select * from FACTOR where ID = '$id'";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}

function filter_factor($category)
{
    global $conn;
    if ($category == 'PRODUCTIVITY')
    {
        $sql = "select * from FACTOR where PRODUCTIVITY = 1";
    }
    else if ($category == 'ENTERTAINMENT')
    {
        $sql = "select * from FACTOR where ENTERTAINMENT = 1";
    }
    else if ($category == 'UTILITY')
    {
        $sql = "select * from FACTOR where UTILITY = 1";
    }
    else if ($category == 'QUICK_APP')
    {
        $sql = "select * from FACTOR where QUICK_APP = 1";
    }
    else
        $sql = "select * from FACTOR";

    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}

function get_comments($item_id)
{
    global $conn;
    $sql = "select * from COMMENTS where FACTOR_ID = '$item_id'";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}

function add_comment($item_id, $user_id, $comment)
{
    global $conn;
    $current_date = date("Ymd");
    $sql = "INSERT INTO COMMENTS VALUES ('$item_id', '$user_id', '$current_date', '$comment')";
    $result = mysqli_query($conn, $sql);
    if ($result == true)
        return $result;
    else
        return -1;
}

function add_cart($item_id, $user_id)
{
    global $conn;

    if (check_cart($item_id, $user_id))
    {
        $sql = "DELETE FROM CART WHERE USER_ID = $user_id AND FACTOR_ID = $item_id";
        $result = mysqli_query($conn, $sql);
        if ($result == true)
            return 0; //deleted
        else
            return -1;
    }
    else
    {
        $sql = "INSERT INTO CART VALUES ('$user_id', '$item_id')";
        $result = mysqli_query($conn, $sql);
        if ($result == true)
            return 1; //added
        else
            return -1;
    }
}


function add_wishlist($item_id, $user_id)
{
    global $conn;

    if (check_wishlist($item_id, $user_id))
    {
        $sql = "DELETE FROM WISHLISTS WHERE USER_ID = $user_id AND FACTOR_ID = $item_id";
        $result = mysqli_query($conn, $sql);
        if ($result == true)
            return 0; //deleted
        else
            return -1;
    }
    else
    {
        $sql = "INSERT INTO WISHLISTS VALUES ('$user_id', '$item_id')";
        $result = mysqli_query($conn, $sql);
        if ($result == true)
            return 1; //added
        else
            return -1;
    }
}

function add_favorites($item_id, $user_id)
{
    global $conn;

    if (check_favorites($item_id, $user_id))
    {
        $sql = "DELETE FROM FAVORITES WHERE USER_ID = $user_id AND FACTOR_ID = $item_id";
        $result = mysqli_query($conn, $sql);
        if ($result == true)
            return 0; //deleted
        else
            return -1;
    }
    else
    {
        $sql = "INSERT INTO FAVORITES VALUES ('$user_id', '$item_id')";
        $result = mysqli_query($conn, $sql);
        if ($result == true)
            return 1; //added
        else
            return -1;
    }
}


function get_collection($collection, $user_id)
{
    global $conn;
    if ($collection == 'CART')
    {
        $sql = "select * from FACTOR f join CART c on f.ID = c.FACTOR_ID  where c.USER_ID = $user_id";
    }
    else if ($collection == 'WISHLIST')
    {
        $sql = "select * from FACTOR f join WISHLISTS c on f.ID = c.FACTOR_ID  where c.USER_ID = $user_id";
    }
    else if ($collection == 'FAVORITES')
    {
        $sql = "select * from FACTOR f join FAVORITES c on f.ID = c.FACTOR_ID  where c.USER_ID = $user_id";
    }
    else
        $sql = "select * from FACTOR";

    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}

function check_cart($item_id, $user_id)
{
    global $conn;
    $sql = "SELECT * FROM CART WHERE FACTOR_ID = $item_id AND USER_ID = $user_id";
    $result = mysqli_query($conn, $sql);
    return (mysqli_num_rows($result) > 0);
}

function check_wishlist($item_id, $user_id)
{
    global $conn;
    $sql = "SELECT * FROM WISHLISTS WHERE FACTOR_ID = $item_id AND USER_ID = $user_id";
    $result = mysqli_query($conn, $sql);
    return (mysqli_num_rows($result) > 0);
}

function check_favorites($item_id, $user_id)
{
    global $conn;
    $sql = "SELECT * FROM FAVORITES WHERE FACTOR_ID = $item_id AND USER_ID = $user_id";
    $result = mysqli_query($conn, $sql);
    return (mysqli_num_rows($result) > 0);
}

function update_downloads($item_id)
{
    global $conn;

    $sql = "UPDATE FACTOR SET 
    DOWNLOADS = DOWNLOADS + 1
    where ID = $item_id";

    if (mysqli_query($conn, $sql))
    {
        $sql = "SELECT DOWNLOADS FROM FACTOR where ID = $item_id";
        $result = mysqli_query($conn, $sql);
        $downloads = 0;
        while($row = mysqli_fetch_assoc($result))
            $downloads = $row['DOWNLOADS'];
        return $downloads;
    }
    else
        return -1; //sql error
}