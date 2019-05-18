<?php 
    session_start();
    require('config/config.php');
    require('config/db.php');

    if (isset($_SESSION['ERROR'])) 
    {
        echo '<div>'.$_SESSION['ERROR'].'</div>';
        unset($_SESSION['ERROR']);
    }
    if (isset($_SESSION['LOG_OUT'])) 
    {
        echo '<div><strong>'.$_SESSION['LOG_OUT'].'</strong></div></br>';
        unset($_SESSION['LOG_OUT']);
    }
?>

<html>
    <head>
        <title>Meta+Labs Forum</title>
        <style type="text/css">
            label {
                display: inline-block;
                width:100px;
                text-align: right;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="https://bootswatch.com/3/cerulean/bootstrap.min.css">
    </head>
    <nav class="navbar navbar-default">
  <div class ="container">
    <div class ="navbar-header">
    </div>
  </div>
</nav>
    <body>
        <div class = "container">
            <p style="text-align:center;"><font size="8" style="color:black">META Labs Forum</font>
            <strong></strong><br><br>
            <div class = "well">
                <form action="./register.php" method="post">
                <p style="text-align:center;"><label>First Name:</label> <input type="text" name="firstName"><br><br></p>
                <p style="text-align:center;"><label>Last Name:</label> <input type="text" name="lastName"><br><br>
                <p style="text-align:center;"><label>E-mail:</label> <input type="text" name="email"><br><br>
                <p style="text-align:center;"><label>Username:</label> <input type="text" name="userName"><br><br></p>
                <p style="text-align:center;"><label>Password:</label> <input type="password" name="password"><br><br>
                <p style="text-align:center;"><label><button class = "btn btn-success" type="submit">Register</button></label><br><br>
            </form>
            </div>
        </div>
        <div class = "container">
            <div class = "well">
                <form action="./login.php" method="post">
                    <p style="text-align:center;"><p style="text-align:center;"><p style="text-align:center;"><label>E-mail:</label> <input type="text" name="login_email"><br><br>
                    <p style="text-align:center;"><p style="text-align:center;"><p style="text-align:center;"><label>Password:</label> <input type="password" name="login_password"><br><br>
                    <p style="text-align:center;"><label><button class = "btn btn-primary" type="submit">Log In</button></label><br><br>
                </form>
            </div>
        </div>
    </body>
</html>