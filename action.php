<?php
require_once("model_user.php");
require_once("model_factor.php");
if (!isset($_SESSION['started']))
{
    session_start();
    $_SESSION['started'] = 'started';
}

        $downloads_dir = "downloads/";
        $resources_dir = "download_resources/";

        $uploadOk_package = 1;
        $uploadOk_splash = 1;
        $uploadOk_icon = 1;

        $package_file = $downloads_dir . basename($_FILES["factor-upload"]["name"]);
        $splash_file = $resources_dir . basename($_FILES["splash-upload"]["name"]);
        $icon_file = $resources_dir . basename($_FILES["icon-upload"]["name"]);

        $fileType_package = strtolower(pathinfo($package_file,PATHINFO_EXTENSION));
        $fileType_splash = strtolower(pathinfo($splash_file,PATHINFO_EXTENSION));
        $fileType_icon = strtolower(pathinfo($icon_file,PATHINFO_EXTENSION));

        $temp_package = explode(".", $_FILES["factor-upload"]["name"]);
        $new_file_name_package = round(microtime(true)) . '.' . end($temp_package);

        $temp_splash = explode(".", $_FILES["splash-upload"]["name"]);
        $new_file_name_splash = round(microtime(true)) . '.' . end($temp_splash);

        $temp_icon = explode(".", $_FILES["icon-upload"]["name"]);
        $new_file_name_icon = round(microtime(true)) . '.' . end($temp_icon);

        $error_package = "";
        $error_splash = "";
        $error_icon = "";

//html
    if($fileType_package != "html")
    {
        $error_package = "Package: Sorry, please upload .html file.";
        $uploadOk_package = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk_splash == 0 || $uploadOk_package == 0 || $uploadOk_icon == 0)
    {
        $_SESSION['package_uploaded'] = false;
// if everything is ok, try to upload file
    }
    else {
        if (move_uploaded_file($_FILES["factor-upload"]["tmp_name"], $downloads_dir.$new_file_name_package))
        {
            $_SESSION['package_path'] = $downloads_dir.$new_file_name_package;
            $_SESSION['package_uploaded'] = true;
        }
        else
        {
            $error_package = "Package: Sorry, there was an error uploading your file.";
            $_SESSION['package_uploaded'] = false;
        }
    }





// splash
    if($fileType_splash != "jpg" && $fileType_splash != "png" && $fileType_splash != "jpeg" && $fileType_splash!= "gif" )
    {
        $error_splash = "Splash: Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk_splash = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk_splash == 0 || $uploadOk_package == 0 || $uploadOk_icon == 0)
    {
        $_SESSION['splash_uploaded'] = false;
// if everything is ok, try to upload file
    } else
    {
        if (move_uploaded_file($_FILES["splash-upload"]["tmp_name"], $resources_dir.$new_file_name_splash))
        {
            $_SESSION['splash_image_path'] = $resources_dir.$new_file_name_splash;
            $_SESSION['splash_uploaded'] = true;
        }
        else
        {
            $error_splash = "Splash: Sorry, there was an error uploading your file.";
            $_SESSION['splash_uploaded'] = false;
        }
    }



// icon
    if($fileType_icon != "jpg" && $fileType_icon != "png" && $fileType_icon != "jpeg" && $fileType_icon != "gif" )
    {
        $error_icon = "icon: Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk_icon = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk_splash == 0 || $uploadOk_package == 0 || $uploadOk_icon == 0)
    {
        $_SESSION['icon_uploaded'] = false;
// if everything is ok, try to upload file
    } else
    {
        if (move_uploaded_file($_FILES["icon-upload"]["tmp_name"], $resources_dir.$new_file_name_icon))
        {
            $_SESSION['icon_image_path'] = $resources_dir.$new_file_name_icon;
            $_SESSION['icon_uploaded'] = true;
        }
        else
        {
            $error_icon = "icon: Sorry, there was an error uploading your file.";
            $_SESSION['icon_uploaded'] = false;
        }
    }

    $ok = $_SESSION['icon_uploaded'] && $_SESSION['splash_uploaded'] && $_SESSION['package_uploaded'];
    if ($ok)
        echo json_encode(true);
    else
        echo json_encode($error_package."\n".$error_icon."\n".$error_splash);
exit();