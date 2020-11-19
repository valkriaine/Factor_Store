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
             '$quick_app')";

        $result =  mysqli_query($conn, $sql);
        if ($result == true)
        {
            //update file paths
            $result_update = update_paths($name);
            if ($result_update == true)
                return 0;
            else
                return 56;
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
    $path = "downloads/".$id.".html";
    $icon_path = "download_resources/".$id."_icon.jpg";
    $splash_path = "download_resources/".$id."_splash.jpg";

    $sql = "UPDATE `FACTOR` SET 
    `PATH` = '$path', 
    `ICON_PATH` = '$icon_path', 
    `SPLASH_PATH` = '$splash_path'
    where `ID` = '$id' ";

    return mysqli_query($conn, $sql);


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
