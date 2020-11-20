<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) )
{
    die();
}
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
        create_banner($row['ID'], $row['NAME'], $row['DESCRIPTION'], $row['ICON_PATH'], $row['SPLASH_PATH']);
        echo $item_tail;
    }
    echo "</div>";
}

?>
<html lang="en">
<body style="background: #eee">

<div id="carousel"
     style="margin: 0 200px; height: 400px"
     class="carousel slide"
     data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>

    <?php create_banners($data); ?>

    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container mt-5">
    <div class="row" id="factor-list">
    </div>
</div>



<!-- Factor Modal -->
<div class="modal fade" id="factor-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div>
                    <img src="" alt="Widget banner" id="splash-image" style="object-fit: cover; max-height: 20%; filter:brightness(50%); max-width:100%">
                    <div style="background-color: whitesmoke; position: relative; left: 20px; bottom: 50px; text-align:left; width: fit-content">
                        <img src="" alt="Widget icon" id="icon-image"  style="height: 100px; width:100px; margin: 2px 2px 0 2px">
                        <h5 class="modal-title" id="factor-title" style="margin: 2px 2px 2px 2px"></h5>
                    </div>

                </div>
                <div>
                    <p id="factor-author-name"></p>
                    <p id="factor-description"></p>
                </div>


                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="factor-productivity-checkbox" disabled>
                    <label class="form-check-label" for="factor-productivity-checkbox">
                        Productivity
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="factor-entertainment-checkbox" disabled>
                    <label class="form-check-label" for="factor-entertainment-checkbox">
                        Entertainment
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="factor-utility-checkbox" disabled>
                    <label class="form-check-label" for="factor-utility-checkbox">
                        Utility
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="factor-quick-app-checkbox" disabled>
                    <label class="form-check-label" for="factor-quick-app-checkbox">
                        Quick App
                    </label>
                </div>

                <div class="form-group">
                    <label class="control-label" for="factor-price">Price: </label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">$</div>
                        </div>
                        <input type="number" class="form-control" id="factor-price" placeholder="0.00" disabled>
                    </div>
                </div>

                <button type="button" class="btn btn-warning" id="show-comments-button" data-toggle="modal" data-target="#comments-modal">Show Comments</button>

            </div>
            <div class="modal-footer sticky-bottom">
                <div class="btn-group">
                    <a type="button" class="btn btn-primary" id="download-link" onclick="updateDownloads()">Download</a>
                    <button type="button" class="btn btn-info" id="add-cart-button">Add to Cart</button>
                    <button type="button" class="btn btn-secondary" id="add-favorite-button">Add to Favorites</button>
                    <button type="button" class="btn btn-secondary" id="add-wishlist-button">Add to Wishlist</button>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Comments Modal -->
<div class="modal fade " id="comments-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="comment-section"></div>
            </div>
            <div class="modal-footer">
                <div class="form-group" style="width: 100%">
                    <div class="input-group" >
                        <div class="input-group-prepend">
                            <button class="input-group-text" id="comment-button">Comment</button>
                        </div>
                        <label for="comment-input"></label>
                        <input type="text" class="form-control" id="comment-input" placeholder="add a comment" >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>

<script>

    let current_id;

    $(document).ready(function()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {
                    page: 'store_page', command: 'Search',
                    term: ""
                },
                success: function(data)
                {
                    const list = JSON.parse(data);
                    $('#factor-list').html(list);

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });

        //click event to open widget modals
        $(document).on("click", "div.col-md-4" , function()
        {
            const id = $(this).attr('id');
            current_id = id;
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {
                        page: 'store_page',
                        command: 'Get_Widget',
                        get_id: id
                    },
                    success: function(data)
                    {
                        const details_array = JSON.parse(data);
                        const current_widget = details_array[0];

                        getAuthorName(current_widget[2]);

                        $('#factor-title').text(current_widget[0]);
                        $('#splash-image').attr('src', current_widget[6]);
                        $('#icon-image').attr('src', current_widget[5]);
                        $('#factor-description').text(current_widget[1]);

                        const price = current_widget[7];
                        $('#factor-price').val(price);

                        let link = $('#download-link');
                        link.attr('href', current_widget[4]);

                        if (price > 0)
                            link.text("Purchase");
                        else
                            link.text("Download");


                        let productivity = current_widget[8],
                            entertainment = current_widget[9],
                            utility = current_widget[10],
                            quick_app = current_widget[11];

                        if (productivity === '1')
                            $('#factor-productivity-checkbox').attr('checked', true);
                        else
                            $('#factor-productivity-checkbox').attr('checked', false);

                        if (entertainment === '1')
                            $('#factor-entertainment-checkbox').attr('checked', true);
                        else
                            $('#factor-entertainment-checkbox').attr('checked', false);

                        if (utility === '1')
                            $('#factor-utility-checkbox').attr('checked', true);
                        else
                            $('#factor-utility-checkbox').attr('checked', false);

                        if (quick_app === '1')
                            $('#factor-quick-app-checkbox').attr('checked', true);
                        else
                            $('#factor-quick-app-checkbox').attr('checked', false);


                        checkCart();
                        checkFavorite();
                        checkWishlist();


                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        });

        $('#show-comments-button').click(function ()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {
                        page: 'store_page',
                        command: 'Show_Comments',
                        item_id: current_id
                    },
                    success: function(data)
                    {
                        const list = JSON.parse(data);
                        $('#comment-section').html(list);

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })

        $('#comment-button').click(function ()
        {
            const comment = $('#comment-input').val();
            if (comment.length < 1)
                return
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {
                        page: 'store_page',
                        command: 'Add_Comment',
                        item_id: current_id,
                        comment: comment
                    },
                    success: function(data)
                    {
                        const list = JSON.parse(data);
                        if (list === -1 || list === '-1')
                            alert("You are not signed in")
                        else
                            $('#comment-section').html(list);

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })

        $('#add-cart-button').click(function ()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {
                        page: 'store_page',
                        command: 'Add_Cart',
                        item_id: current_id,
                    },
                    success: function(data)
                    {
                        const code = JSON.parse(data);
                        if (code === 1 || code ==='1')
                            alert("added to cart");
                        else if (code === 0 || code === '0')
                            alert ("removed from cart");
                        else
                            alert(code);
                        checkCart()

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })

        $('#add-wishlist-button').click(function ()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {
                        page: 'store_page',
                        command: 'Add_Wishlist',
                        item_id: current_id,
                    },
                    success: function(data)
                    {
                        const code = JSON.parse(data);
                        if (code === 1 || code ==='1')
                            alert("added to wishlist");
                        else if (code === 0 || code === '0')
                            alert ("removed from wishlist");
                        else
                            alert(code);
                        checkWishlist();

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })

        $('#add-favorite-button').click(function ()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {
                        page: 'store_page',
                        command: 'Add_Favorite',
                        item_id: current_id,
                    },
                    success: function(data)
                    {
                        const code = JSON.parse(data);
                        if (code === 1 || code ==='1')
                            alert("added to favorites");
                        else if (code === 0 || code === '0')
                            alert ("removed from favorites");
                        else
                            alert(code);
                        checkFavorite();

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })
    })

    function getAuthorName(id)
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {
                    page: 'store_page',
                    command: 'Get_Author_Name',
                    author_id: id
                },
                success: function(data)
                {
                    const name = JSON.parse(data);
                    $('#factor-author-name').text("Created by " + name);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

    function checkCart()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {
                    page: 'store_page',
                    command: 'Check_Cart',
                    item_id: current_id,
                },
                success: function(data)
                {
                    const code = JSON.parse(data);
                    if (code === true || code ==='true')
                        $('#add-cart-button').text("Remove From Cart");
                    else
                        $('#add-cart-button').text("Add to Cart");

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

    function checkWishlist()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {
                    page: 'store_page',
                    command: 'Check_Wishlist',
                    item_id: current_id,
                },
                success: function(data)
                {
                    const code = JSON.parse(data);
                    if (code === true || code ==='true')
                        $('#add-wishlist-button').text("Remove From Wishlist");
                    else
                        $('#add-wishlist-button').text("Add to Wishlist");

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

    function checkFavorite()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {
                    page: 'store_page',
                    command: 'Check_Favorites',
                    item_id: current_id,
                },
                success: function(data)
                {
                    const code = JSON.parse(data);
                    if (code === true || code ==='true')
                        $('#add-favorite-button').text("Remove From Favorites");
                    else
                        $('#add-favorite-button').text("Add to Favorites");

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

    function updateDownloads()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {
                    page: 'store_page',
                    command: 'Update_Downloads',
                    item_id: current_id,
                },
                success: function(data)
                {
                    const code = JSON.parse(data);
                    if (code === -1 || code ==='-1')
                        console.log("error updating downloads number");
                    else
                        $('#' + current_id + '-downloads').text(code + " downloads");


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

</script>
