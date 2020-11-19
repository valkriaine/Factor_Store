<?php
if ( basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]) )
{
    exit();
}

?>
<html lang="en">
<div class="sticky-top">
    <nav style="margin: 0 200px"
         class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand"
           href="#">Factor Store</a>
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse"
             id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        Home
                        <span class="sr-only">
                            (current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Productivity</a>
                        <a class="dropdown-item" href="#">Entertainment</a>
                        <a class="dropdown-item" href="#">Utility</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Quick Apps</a>
                    </div>
            </ul>

            <div class="btn-group align-items-center">
                <div class="btn-group dropdown">
                    <img src="resources/user.png"
                         class="align-self-center"
                         data-toggle="dropdown"
                         style="height: 30px; width: 30px"
                         alt="User Portal">
                    <p id="username-nav"  data-toggle="dropdown" class="align-self-center" style="margin: 0 0 0 15px"></p>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" id="dropdown-sign-in" href="#sign-in-modal" data-toggle="modal">Sign In</a>
                        <a class="dropdown-item" id="dropdown-register" href="#register-modal" data-toggle="modal">Register</a>
                        <a class="dropdown-item" id="dropdown-settings" href="#settings-modal" data-toggle="modal">Settings</a>
                        <a class="dropdown-item" id="dropdown-upload" href="#upload-modal" data-toggle="modal">Upload</a>
                        <a class="dropdown-item" id="dropdown-my-cart" href="#" data-toggle="modal">My Cart</a>
                        <a class="dropdown-item" id="dropdown-wishlist" href="#" data-toggle="modal">Wishlist</a>
                        <a class="dropdown-item" id="dropdown-favorites" href="#" data-toggle="modal">Favorites</a>
                        <a class="dropdown-item" id="dropdown-sign-out" href="#" data-toggle="modal">Sign Out</a>
                    </div>
                </div>

                <!--search bar-->
            <form class="form-inline my-2 my-lg-0" style="margin-left: 15px">
                <div class="input-group">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
            </div>
        </div>
    </nav>
</div>




<!--Sign-in Modal -->
<div class="modal fade" id="sign-in-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="username-sign-in">Username:</label>
                        <input type="text" class="form-control" id="username-sign-in" name="username" required>
                        <p id="username-sign-in-error"></p>
                    </div>
                    <div class="form-group">
                        <label for="password-sign-in">Password:</label>
                        <input type="password" class="form-control" id="password-sign-in" name="password" required>
                        <label id="password-sign-in-error"></label>
                    </div>
                    <button type="button" id="sign-in-button" class="btn btn-secondary">Submit</button>
                    <input type="reset" class="btn btn-secondary"/>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!--Register Modal -->
<div class="modal fade" id="register-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="username-register">Username:</label>
                        <input type="text" class="form-control" id="username-register" name="username" required>
                        <p id="username-register-error"></p>
                    </div>
                    <div class="form-group">
                        <label for="password-register">Password:</label>
                        <input type="password" class="form-control" id="password-register" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="button" id="register-button" class="btn btn-secondary" data-dismiss="modal">Submit</button>
                    <input type="reset" class="btn btn-secondary"/>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!--Settings Modal -->
<div class="modal fade" id="settings-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update My Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="username-settings">Username:</label>
                        <input type="text" class="form-control" id="username-settings" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password-settings">New Password:</label>
                        <input type="password" class="form-control" id="password-settings" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-settings-confirm">Confirm New Password:</label>
                        <input type="password" class="form-control" id="password-settings-confirm" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="email-settings">Email:</label>
                        <input type="text" class="form-control" id="email-settings" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>I am a: </label>
                    <div class="btn-group btn-group-toggle" role="group" data-toggle="buttons">
                        <label class="btn btn-secondary btn-light active">
                            <input type="radio" name="options" id="type-user-toggle">User
                        </label>
                        <label class="btn btn-secondary btn-light">
                            <input type="radio" name="options" id="type-designer-toggle">Designer
                        </label>
                    </div>
                    </div>

                    <div class="form-group" role="group" >
                        <button type="button" id="settings-button" class="btn btn-secondary text-left" data-dismiss="modal">Update</button>
                        <input type="reset" class="btn btn-secondary text-left"/>
                        <button type="button" class="btn btn-danger text-left" data-dismiss="modal">Cancel</button>
                        <button type="button" id="settings-delete" class="btn btn-warning text-right" data-dismiss="modal">Delete My Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>







<!--Upload modal-->
<div class="modal fade" id="upload-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload my design</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label id="author-id">Author ID: </label>
                    </div>
                    <div class="form-group">
                        <label for="factor-name">Name of your design: </label>
                        <input type="text" class="form-control" id="factor-name" name="name" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Categories: </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="productivity-checkbox">
                        <label class="form-check-label" for="productivity-checkbox">
                            Productivity
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="entertainment-checkbox">
                        <label class="form-check-label" for="entertainment-checkbox">
                            Entertainment
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="utility-checkbox">
                        <label class="form-check-label" for="utility-checkbox">
                            Utility
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="quick-app-checkbox">
                        <label class="form-check-label" for="quick-app-checkbox">
                            Quick App
                        </label>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="description">Description: </label>
                        <textarea class="form-control" id="description" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Upload your package: </label>
                        <input type="file" class="form-control-file" data-icon="true">
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="upload-price">Price: </label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="number" class="form-control" id="upload-price" placeholder="0.00">
                        </div>
                    </div>


                    <div class="form-group" role="group">
                        <br>
                        <button type="button" id="upload-button" class="btn btn-secondary text-left" data-dismiss="modal">Upload</button>
                        <input type="reset" class="btn btn-secondary text-left"/>
                        <button type="button" class="btn btn-danger text-left" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</html>


<script>

    let global_type = 0;


    $(document).ready(function()
    {
        checkSignedIn();
        $('#register-button').click(function()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {page: 'header', command: 'Join', username: $('#username-register').val(), password: $('#password-register').val(), email: $('#email').val()},
                    success: function(data)
                    {
                        const message = JSON.parse(data);
                        if (message === -1)
                        {
                            alert("user already exists, please log in");
                        }
                        else if (message === 0)
                        {
                            checkSignedIn();
                            alert("registered successfully, you are now automatically signed in.");

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        });

        $("#sign-in-button").click(function()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {page: 'header', command: 'SignIn', username: $('#username-sign-in').val(), password: $('#password-sign-in').val()},
                    success: function(data)
                    {
                        const message = JSON.parse(data);
                        if (message === 1)
                        {
                            alert("wrong password");
                            $("#sign-in-modal").modal('show');
                            $("#register-modal").modal('hide');
                        }
                        else if (message === -1)
                        {
                            alert("username does not exist");
                            $("#sign-in-modal").modal('show');
                            $("#register-modal").modal('hide');
                        }
                        else
                        {
                            checkSignedIn();
                            $("#sign-in-modal").modal('hide');
                            $("#register-modal").modal('hide');

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        });

        $("#settings-button").click(function()
        {
            const password = $('#password-settings').val();
            if (password !== $('#password-settings-confirm').val())
            {
                alert("Passwords do not match, please confirm again");
            }
            else
            {
                $.ajax(
                    {
                        url : 'ajax.php',
                        type: "POST",
                        data : {page: 'header', command: 'Update',
                            username: $('#username-settings').val(),
                            password: password,
                            email_settings: $('#email-settings').val(),
                            type: global_type
                        },
                        success: function(data)
                        {
                            const message = JSON.parse(data);
                            if (message === 0)
                            {
                                checkSignedIn();
                            }
                            else
                                alert(message);

                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert("Error: " + errorThrown);
                        }
                    });
            }

        });

        $('#dropdown-sign-out').click(function()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {page: 'header', command: 'SignOut'},
                    success: function(data)
                    {
                        const code = JSON.parse(data);
                        if (code === true)
                        {
                            checkSignedIn();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        });

        $('#type-user-toggle').click(function ()
        {
            global_type = 0;
        })

        $('#type-designer-toggle').click(function ()
        {
            global_type = 1;
        })

        $('#settings-delete').click(function ()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {page: 'header', command: 'Delete'},
                    success: function(data)
                    {
                        const code = JSON.parse(data);
                        if (code === true)
                        {
                            checkSignedIn();
                            alert("Account deleted. You are now logged off.");
                        }
                        else
                            alert("an error occurred");
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })

        $('#upload-button').click(function ()
        {
            let productivity,
                entertainment,
                utility,
                quick_app,
                price;

            if($('#productivity-checkbox').is(":checked"))
                productivity = 1;
            else
                productivity = 0;

            if($('#entertainment-checkbox').is(":checked"))
                entertainment = 1;
            else
                entertainment = 0;

            if($('#utility-checkbox').is(":checked"))
                utility = 1;
            else
                utility = 0;

            if($('#quick-app-checkbox').is(":checked"))
                quick_app = 1;
            else
                quick_app = 0;

            price = $('#upload-price').val();
            if (price.length < 1)
                price = 0;


            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {page: 'header',
                        command: 'Upload',
                        description: $('#description').val(),
                        name: $('#factor-name').val(),
                        price: price,
                        productivity: productivity,
                        entertainment: entertainment,
                        utility: utility,
                        quick_app: quick_app
                    },
                    success: function(data)
                    {
                        const code = JSON.parse(data);
                        if (code === 0)
                            alert('Uploaded successfully');
                        else
                            alert('An error occurred, code: ' + code);

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert("Error: " + errorThrown);
                    }
                });
        })

    })

    function checkSignedIn()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {page: 'header', command: 'Get_Name'},
                success: function(data)
                {
                    const name = JSON.parse(data);
                    if (name === 1) //not signed in
                    {
                        $('#username-nav').text('');
                        $('#dropdown-sign-in').show();
                        $('#dropdown-register').show();
                        $('#dropdown-upload').hide();
                        $('#dropdown-settings').hide();
                        $('#dropdown-favorites').hide();
                        $('#dropdown-my-cart').hide();
                        $('#dropdown-wishlist').hide();
                        $('#dropdown-sign-out').hide();
                    }
                    else //signed in
                    {
                        $('#username-nav').text(name);
                        $('#dropdown-sign-in').hide();
                        $('#dropdown-register').hide();
                        $('#dropdown-settings').show();
                        $('#dropdown-favorites').show();
                        $('#dropdown-my-cart').show();
                        $('#dropdown-wishlist').show();
                        $('#dropdown-sign-out').show();
                        getUserType();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

    function getUserType()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {page: 'header', command: 'Get_Type'},
                success: function(data)
                {
                    const type = JSON.parse(data);
                    if (type === '0') //normal user
                    {
                        $('#type-user-toggle').click();
                        $('#dropdown-upload').hide();
                    }
                    else if (type === '1') //designer
                    {
                        $('#type-designer-toggle').click();
                        $('#dropdown-upload').show();
                        getCreatorID()
                    }
                    else
                    {
                        alert(type);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

    function getCreatorID()
    {
        $.ajax(
            {
                url : 'ajax.php',
                type: "POST",
                data : {page: 'header', command: 'Get_Author_ID'},
                success: function(data)
                {
                    const id = JSON.parse(data);
                    $('#author-id').text("Author ID: " + id);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert("Error: " + errorThrown);
                }
            });
    }

</script>