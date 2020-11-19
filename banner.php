<?php
function create_banner($name, $description, $icon, $splash)
{
    echo '<div class="card bg-dark text-white">';
    echo '<img src=';
    echo '"'.$splash.'"';
    echo ' style="object-fit: cover; height: 400px; filter: blur(10px); opacity: 50%" class="card-img" alt="Banner image">';
    echo ' <div class="card-img-overlay row">
        <div class="card text-center w-50 mx-auto" style="max-width: 540px; max-height: 200px; background-color: dimgray">
            <div class="row no-gutters" >
                <div class="col-md-4">
                    <img src="'.$icon.'" style="height: 150px; width: 150px; margin 50px"  class="card-img align-self-center" alt="...">
                </div>
                <div class="col-md-8 card-body" style="background-color:dimgray">
                        <h5 class="card-title">'.$name.'</h5>
                        <p class="card-text">'.$description.'</p>
                </div>
            </div>
        </div>
    </div>
</div>';
}
?>
<!-- todo: restyle this to be more responsive and visually appealing
<head>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
          crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>

    <title>Factor Store</title>
</head>

<div class="card bg-dark text-white">
<img src="resources/1.jpg" style="object-fit: cover; height: 400px; filter: blur(10px); opacity: 50%" class="card-img" alt="...">
<div class="card-img-overlay row">
        <div class="card text-center w-50 mx-auto" style="max-width: 540px; max-height: 200px; background-color: dimgray">
            <div class="row no-gutters" >
                <div class="col-md-4">
                    <img src="resources/user.png" style="height: 150px; width: 150px; margin 50px"  class="card-img align-self-center" alt="...">
                </div>
                <div class="col-md-8 card-body" style="background-color:dimgray">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
    </div>
</div>
-->



