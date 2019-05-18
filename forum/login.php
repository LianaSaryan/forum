<?php
    require('config/config.php');
    require('config/db.php');

    // Check for Submit Button
    if(!empty($_POST)){
        session_start();

        if(empty($_POST['login_email']) || empty($_POST['login_password']))
        {
            $_SESSION['ERROR'] = 'Please fill in all fields';

            header('Location: '.ROOT_URL.'/pathfinder.php');
        }
        else
        {   
            // Validate user ID
            $login_email = mysqli_real_escape_string($conn, $_POST['login_email']);
            $login_pass = md5($_POST['login_password']);

            $sql = mysqli_query($conn, "SELECT * FROM users WHERE (email ='$login_email')");
            $count=mysqli_num_rows($sql);

            if($count == 1)
            {
                $user = mysqli_fetch_assoc($sql);

                if ($login_pass == $user['password'])
                {
                    $_SESSION['SUCCESS_MESSAGE'] = 'Welcome back, '.$user['firstName'].'.';

                    $_SESSION['CURRENT_USER'] = $user['user_id'];

                    header('Location: '.ROOT_URL.'/landing.php');
                }
                else
                {
                    $_SESSION['ERROR'] = 'Invalid username or password';

                    header('Location: '.ROOT_URL.'/pathfinder.php');
                }         
            }
            else 
            {
                $_SESSION['ERROR'] = 'Invalid username or password';

                header('Location: '.ROOT_URL.'/pathfinder.php');
            }

        }   
    }
?>