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

                <p id="username-nav"></p>

                <div class="btn-group dropdown">
                    <img src="resources/user.png"
                         class="align-self-center"
                         data-toggle="dropdown"
                         style="margin-right: 20px; height: 30px; width: 30px"
                         alt="User Portal">
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#sign-in-modal" data-toggle="modal">Sign In</a>
                        <a class="dropdown-item" href="#register-modal" data-toggle="modal">Register</a>
                    </div>
                </div>




            <form class="form-inline my-2 my-lg-0">
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
                <h5 class="modal-title" id="modal-header-sign-in">Sign In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-sign-in" method="POST" action='controller.php'>
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
                <h5 class="modal-title" id="modal-header-register">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-join" method="POST" action='ajax.php'>
                    <input type='hidden' name='page' value='StartPage'>
                    <input type='hidden' name='command' value='Join'>
                    <div class="form-group">
                        <label for="username-register">Username:</label>
                        <input type="text" class="form-control" id="username-register" name="username" required>
                        <?php
                        if(!empty($error_join))
                        {
                            echo $error_join;
                        }
                        ?>
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
</html>


<script>
    $(document).ready(function()
    {
        $('#register-button').click(function()
        {
            $.ajax(
                {
                    url : 'ajax.php',
                    type: "POST",
                    data : {page: 'StartPage', command: 'Join', username: $('#username-register').val(), password: $('#password-register').val(), email: $('#email').val()},
                    success: function(data)
                    {
                        const message = JSON.parse(data);
                        if (message === -1)
                        {
                            alert("user already exists, please log in");
                        }
                        else if (message === 0)
                        {
                            alert("registered successfully");
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
                    data : {page: 'StartPage', command: 'SignIn', username: $('#username-sign-in').val(), password: $('#password-sign-in').val()},
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
                        else if (message === 0)
                        {
                            $("#username-nav").text("test");
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
    })
</script>