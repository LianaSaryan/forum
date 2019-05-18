<?php 
    require('config/config.php');
    require('config/db.php');
    session_start();

    mysqli_query($conn, 'SET foreign_key_checks = 0');

    if (isset($_SESSION['SUCCESS_MESSAGE'])) 
    {
        echo '<div><strong>'.$_SESSION['SUCCESS_MESSAGE'].'</strong></div></br>';
        unset($_SESSION['SUCCESS_MESSAGE']);
    }
    if (isset($_SESSION['ERROR'])) 
    {
        echo '<div><strong>'.$_SESSION['ERROR'].'</strong></div></br>';
        unset($_SESSION['ERROR']);
    }
    if (isset($_SESSION['ADD_POST'])) 
    {
        echo '<div><strong>'.$_SESSION['ADD_POST'].'</strong></div></br>';

        // update user_posts table
        $post_num = "SELECT post_id FROM posts ORDER BY post_id DESC LIMIT 1";
        $result = mysqli_query($conn, $post_num);
        $row = mysqli_fetch_assoc($result);
        $post = $row['post_id'];

        $current_user = $_SESSION['CURRENT_USER'];

        $query1 = "INSERT INTO user_posts(user_id, post_id) VALUES('$current_user', '$post')";

        if(!mysqli_query($conn, $query1))
        {
            $_SESSION['ERROR'] = 'Error: Failed to fetch query.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        unset($_SESSION['ADD_POST']);
    }
    if (isset($_SESSION['ADD_COMMENT'])) 
    {
        // update post_comments table
        $comment_num = "SELECT comment_id FROM comments ORDER BY comment_id DESC LIMIT 1";
        $result = mysqli_query($conn, $comment_num);
        $row = mysqli_fetch_assoc($result);
        $comment = $row['comment_id'];

        $current_post = $_SESSION['CURRENT_POST'];

        $query2 = "INSERT INTO post_comments(post_id, comment_id) VALUES('$current_post', '$comment')";

        if(!mysqli_query($conn, $query2))
        {
            $_SESSION['ERROR'] = 'Error: Failed to fetch query.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update user_comments table
        $comment_num = "SELECT comment_id FROM comments ORDER BY comment_id DESC LIMIT 1";
        $result = mysqli_query($conn, $comment_num);
        $row = mysqli_fetch_assoc($result);
        $comment = $row['comment_id'];
        $current_user = $_SESSION['CURRENT_USER'];

        $query3 = "INSERT INTO user_comments(user_id, comment_id) VALUES('$current_user', '$comment')";

        if(!mysqli_query($conn, $query3))
        {
            $_SESSION['ERROR'] = 'Error: Failed to fetch query.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        echo '<div><strong>'.$_SESSION['ADD_COMMENT'].'</strong></div></br>';
        unset($_SESSION['ADD_COMMENT']);
    }

    if (isset($_SESSION['DELETE_COMMENT']))
    {
        echo '<div><strong>'.$_SESSION['DELETE_COMMENT'].'</strong></div></br>';
        unset($_SESSION['DELETE_COMMENT']);
    }

    if (isset($_SESSION['DELETE_POST'])) 
    {
        echo '<div><strong>'.$_SESSION['DELETE_POST'].'</strong></div></br>';
        unset($_SESSION['DELETE_POST']);
    }

    // Create query of all posts
    $query4 = 'SELECT * FROM posts ORDER BY created_at DESC';

    $result = mysqli_query($conn, $query4);

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);


    $current_user = $_SESSION['CURRENT_USER'];

    // Create query of current user's posts
    $query5 = "SELECT * FROM posts 
                WHERE post_id 
                    IN (SELECT post_id FROM user_posts WHERE user_id = $current_user)";

    $result = mysqli_query($conn, $query5);

    $user_posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    // Check for Delete Post Button
    if(isset($_POST['delete']))
    {
        // Get form data
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        
        // update user_comments table
        $query6 = "DELETE FROM user_comments
                    WHERE comment_id = ANY(SELECT comment_id FROM comments WHERE comment_belongs_to = $delete_id)";

        if(!mysqli_query($conn, $query6))
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update user_posts table
        $query7 = "DELETE FROM user_posts WHERE post_id = $delete_id";

        if(!mysqli_query($conn, $query7))
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update post_comments table
        $query8 = "DELETE FROM post_comments WHERE post_id = $delete_id";

        if(!mysqli_query($conn, $query8))
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update posts table
        $query9 = "DELETE FROM posts WHERE post_id = $delete_id";

        if(!mysqli_query($conn, $query9))
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update comments table
        $query10 = "DELETE FROM comments WHERE comment_belongs_to = $delete_id";

        if(mysqli_query($conn, $query10))
        {
            $_SESSION['DELETE_POST'] = 'Post Deleted!';
            
            header('Location: '.ROOT_URL.'/landing.php');
        } 
        else
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }
    }

?>

<?php include('inc/header.php');?>
    <div class= "container">
        <h1>Posts</h1>
            <?php foreach($posts as $post) :?>
            <div class = "well">
                <h1><?php echo $post['title']; ?></h1>
                <small>By  
                    <?php 
                        $user_id = $post['created_by'];
                        $user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$post[created_by]' ");
                        $user= mysqli_fetch_assoc($user);
                        echo $user['userName'];
                     ?>
                     <?php 
                         echo date('\o\n g:ia l\,\ F jS Y', strtotime("$post[created_at]"));
                     ?>
                    </small>
                <p><?php echo $post['body']; ?></p><br>
                <a class = "btn btn-primary" href="<?php echo ROOT_URL?>post.php?id=<?php echo $post['post_id']; ?>">Read More</a>
                <?php foreach($user_posts as $user_post) :?>
                    <?php if($user_post['post_id'] == $post['post_id']) : ?>
                        <form class="pull-right" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="delete_id" value ="<?php echo $post['post_id']; ?>">
                            <input type="submit" name="delete" value="Delete Post" class="btn btn-danger">
                        </form>
                    <?php  endif; ?>
                </form>
                <?php endforeach; ?>

            </div>   
        <?php endforeach; ?>
        <br>
    </div>
<?php include('inc/footer.php'); ?>