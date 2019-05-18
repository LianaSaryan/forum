<?php
    require('config/config.php');
    require('config/db.php');

    // Check for Submit Button
    if(!empty($_POST))
    {
        session_start();

        if(empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['userName']) || empty($_POST['email']) || empty($_POST['password']))
        {
            $_SESSION['ERROR'] = 'Please fill in all fields';

            header('Location: '.ROOT_URL.'/pathfinder.php');
        }
        else{
            // Get form data
            $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
            $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $userName = mysqli_real_escape_string($conn, $_POST['userName']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $hash = md5($_POST['password']);

            // Validate user information
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                $query_email = mysqli_query($conn, "SELECT email FROM users WHERE (email = '$email')");
                $query_user_name = mysqli_query($conn, "SELECT userName FROM users WHERE (userName = '$userName')");

                if($query_email -> num_rows == 0)
                {
                    if($query_user_name -> num_rows == 0)
                    {
                        $query = "INSERT INTO users(firstName, lastName, email, userName, password) VALUES('$firstName', '$lastName', '$email', '$userName', '$hash')";

                        if(mysqli_query($conn, $query))
                        {
                            $_SESSION['SUCCESS_MESSAGE'] = 'Congratulations, '.$_POST['firstName'].'. You have successfully created a new account.';

                            $sql = mysqli_query($conn, "SELECT * FROM users WHERE ((email ='$email') AND (password ='$hash'))");

                            $user = mysqli_fetch_assoc($sql);

                            $_SESSION['CURRENT_USER'] = $user['user_id'];

                            header('Location: '.ROOT_URL.'/landing.php');
                        }
                        else 
                        {
                            $_SESSION['ERROR'] = 'Failed to create a new account!';

                            header('Location: '.ROOT_URL.'/pathfinder.php');
                        }
                    }
                    else
                    {
                        $_SESSION['ERROR'] = 'Failed to create a new account! Username already exists. ';

                        header('Location: '.ROOT_URL.'/pathfinder.php');
                    }
        
                }
                else 
                {
                    $_SESSION['ERROR'] = 'Failed to create a new account! Email already exists. ';

                    header('Location: '.ROOT_URL.'/pathfinder.php');
                }
            }
            else
            {
                $_SESSION['ERROR'] = 'Failed to create a new account! Please enter a valid email. ';

                header('Location: '.ROOT_URL.'/pathfinder.php');
            }

        }   
    }
?>