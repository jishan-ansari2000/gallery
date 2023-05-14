<nav class="navbar navbar-light bg-light" style="padding: 20px 50px;">

    <a class="navbar-brand" href="/">Gallery</a>
    <div>
        
        <button class="btn btn-primary" data-bs-target="#loginModalToggle" data-bs-toggle="modal">Login</button>
        <button class="btn btn-primary" data-bs-target="#signupModalToggle" data-bs-toggle="modal">Sign Up</button>
        
          <form action="controllers/auth.php" method="POST" style="display: inline-block">
            <button type="submit" class="btn btn-primary" name="logout" value="logout">logout</button>
          </form>

    </div>

</nav>

<!-- ************ Login Modal -->

<div class="modal fade" id="loginModalToggle" aria-labelledby="loginModalToggleLabel" tabindex="-1"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalToggleLabel">Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php
                $auth_status = isset($_SESSION['status']) && isset($_GET['auth']) && $_GET['auth'] == "login";

                if ($auth_status || isset($_SESSION["not_loggedIn"])) {
                  ?>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey! </strong>
                            <?php  
                              if($auth_status) echo $_SESSION['status'];
                              else echo $_SESSION["not_loggedIn"];
                             ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                        unset($_SESSION['not_loggedIn']);
                        unset($_SESSION['status']);
                } 
                ?>

                <form action="controllers/auth.php" method="POST">
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="login_email" aria-describedby="emailHelp"
                            name="login_email">
                    </div>
                    <div class="mb-3">
                        <label for="login_assword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="login_password" name="login_password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="login" value="login">Login</button>
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#signupModalToggle" data-bs-toggle="modal">New User Sign
                    Up</button>
            </div>
        </div>
    </div>
</div>

<!-- *************************Logout Modal*********** -->

<div class="modal fade" id="signupModalToggle" aria-labelledby="signupModalToggleLabel" tabindex="-1"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signupModalToggleLabel">Sign Up</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php

                if (isset($_SESSION['status']) && isset($_GET['auth']) && $_GET['auth'] == "signup") {
                  ?>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey! </strong>
                            <?php echo $_SESSION['status'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php
                  unset($_SESSION['status']);
                }
                ?>

                <form action="controllers/auth.php" method="POST">
                    <div class="mb-3">
                        <label for="signup_username" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="signup_username" aria-describedby="emailHelp"
                            name="signup_username">
                    </div>
                    <div class="mb-3">
                        <label for="signup_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="signup_email" aria-describedby="emailHelp"
                            name="signup_email">
                    </div>
                    <div class="mb-3">
                        <label for="signup_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signup_password" name="signup_password">
                    </div>
                    <div class="mb-3">
                        <label for="signup_cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="signup_cpassword" name="signup_cpassword">
                    </div>
                    <button type="submit" class="btn btn-primary" name="signup" value="signup">Sign Up</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#loginModalToggle" data-bs-toggle="modal">Back to
                    Login</button>
            </div>
        </div>
    </div>
</div>


<!-- This code is working for when and what modal is going to open -->
<?php
if (!isset($_SESSION['email']) && $_SESSION["current_url"] != "/"):
  ?>

<script>
$(document).ready(function() {
    // Show the modal

    <?php if (isset($_GET['auth']) && $_GET['auth'] == "signup") { ?>
    $('#signupModalToggle').modal('show');
    <?php } else { ?>
    $('#loginModalToggle').modal('show');
    <?php } ?>

    $('#loginModalToggle').on('hidden.bs.modal', function() {

        if (<?php echo !isset($_SESSION['email']) ?> && !$('#signupModalToggle').is(':visible')) {
            $('#loginModalToggle').modal('show');
        }
    });

    $('#signupModalToggle').on('hidden.bs.modal', function() {

        if (<?php echo !isset($_SESSION['email']) ?>) {
            $('#loginModalToggle').modal('show');
        }
    });
});
</script>
<?php endif;
?>