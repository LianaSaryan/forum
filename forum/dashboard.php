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
    
    $current_user = $_SESSION['CURRENT_USER'];

    // Create query of current user's posts
    $query = "SELECT * FROM posts 
                WHERE post_id 
                    IN (SELECT post_id FROM user_posts WHERE user_id = $current_user)";

    $result = mysqli_query($conn, $query);

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Check for Delete Post Button
    if(isset($_POST['delete']))
    {
        // Get form data
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

        // update user_comments table
        $query1 = "DELETE FROM user_comments
                    WHERE comment_id = ANY(SELECT comment_id FROM comments WHERE comment_belongs_to = $delete_id)";

        if(mysqli_query($conn, $query1))
        {
            header('Location: '.ROOT_URL.'/landing.php');
        } 
        else
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update user_posts table
        $query2 = "DELETE FROM user_posts WHERE post_id = $delete_id";

        if(mysqli_query($conn, $query2))
        {
            header('Location: '.ROOT_URL.'/landing.php');
        } 
        else
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update post_comments table
        $query3 = "DELETE FROM post_comments WHERE post_id = $delete_id";

        if(mysqli_query($conn, $query3))
        {
            header('Location: '.ROOT_URL.'/landing.php');
        } 
        else
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }

        // update posts table
        $query4 = "DELETE FROM posts WHERE post_id = $delete_id";

        if(mysqli_query($conn, $query4))
        {
            header('Location: '.ROOT_URL.'/landing.php');
        } 
        else
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: '.ROOT_URL.'/landing.php');
        }
        // update comments table
        $query5 = "DELETE FROM comments WHERE comment_belongs_to = $delete_id";

        if(mysqli_query($conn, $query5))
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
        <?php  
            if (mysqli_num_rows($result)==0)
            {
                echo "You do not have any posts. To get started, click on the 'Add Posts' icon above!"; 
            }
        ?>
        <?php foreach($posts as $post) :?>
        <div class = "well">
            <h1><?php echo $post['title']; ?></h1>
            <small>Created on 
                <?php 
                     echo date('g:ia l\,\ F jS Y', strtotime("$post[created_at]"));
                 ?>
                </small>
            <p><?php echo $post['body']; ?></p><br>
            <a class = "btn btn-primary" href="<?php echo ROOT_URL?>post.php?id=<?php echo $post['post_id']; ?>">Read More</a>
                <form class="pull-right" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="delete_id" value ="<?php echo $post['post_id']; ?>">
                            <input type="submit" name="delete" value="Delete Post" class="btn btn-danger">
                </form>
        </div>
        <?php endforeach; ?>
        <br>

    </div>
<?php include('inc/footer.php'); ?>