<?php
    $data = get_first_three_widgets();

//display prompted widgets in the carousel
function create_banners($data = array())
{
    echo "<div class='carousel-inner'>";
    $item_forehead = "<div class='carousel-item'>";
    $item_forehead_active = "<div class='carousel-item active'>";
    $item_tail = "</div>";
    foreach ($data as $key => $row)
    {
        if ($key == 0)
        {
            echo $item_forehead_active;
        }
        else
            echo $item_forehead;
        create_banner($row['NAME'], $row['DESCRIPTION'], $row['ICON_PATH'], $row['SPLASH_PATH']);
        echo $item_tail;
    }
    echo "</div>";
}



?>
<div id="carouselExampleIndicators"
     style="margin: 0 200px; height: 400px"
     class="carousel slide"
     data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>



        <?php create_banners($data); ?>



    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
