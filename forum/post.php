<?php 
    require('config/config.php');
    require('config/db.php');
    session_start();
    mysqli_query($conn, 'SET foreign_key_checks = 0');
    
    // Get current post ID
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Create query for current post
    $query1 = 'SELECT * FROM posts WHERE post_id = '.$id;

    $result = mysqli_query($conn, $query1);

    $post = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    //Create query for all comments in post
    $query2 = "SELECT * FROM comments 
                WHERE comment_id 
                    IN (SELECT comment_id FROM post_comments WHERE post_id = $id)";

    $result2 = mysqli_query($conn, $query2);

    $comments = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    $current_user = $_SESSION['CURRENT_USER'];

    // Create query for user comments 
    $query3 = "SELECT * FROM comments 
                WHERE comment_id 
                    IN (SELECT comment_id FROM user_comments WHERE user_id = $current_user)";

    $result3 = mysqli_query($conn, $query3);

    $user_comments = mysqli_fetch_all($result3, MYSQLI_ASSOC);

    // Check for Delete Comment Button 
    if(isset($_POST['delete']))
    {
        // Get form data
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

        // update user_comments table
        $query4 = "DELETE FROM user_comments WHERE comment_id = $delete_id";

        if(!mysqli_query($conn, $query4))
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: http://localhost:8888/forum/landing.php');
        }

        // update post_comments table
        $query5 = "DELETE FROM post_comments WHERE comment_id = $delete_id";

        if(!mysqli_query($conn, $query5))
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete comment.';

            header('Location: http://localhost:8888/forum/landing.php');
        }

        // update comments table
        $query6 = "DELETE FROM comments WHERE comment_id = $delete_id";

        if(mysqli_query($conn, $query6))
        {
            
            $_SESSION['DELETE_COMMENT'] = 'Comment Deleted!';
            header('Location: http://localhost:8888/forum/landing.php');
        } 
        else
        {
            $_SESSION['ERROR'] = 'Error: Failed to delete post.';

            header('Location: http://localhost:8888/forum/landing.php');
        }
    }
?>

<?php include('inc/header.php');?>
    <div class = 'container'>
        <h1><?php echo $post['title']; ?></h1>
            <small><?php echo date('g:ia l\,\ F jS Y', strtotime("$post[created_at]")); ?> by 
                <?php 
                    $user_id = $post['created_by'];
                    $user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id' ");
                    $user= mysqli_fetch_assoc($user);
                    echo $user['userName']; 
                 ?>
                </small>
        <p><br><?php echo $post['body']; ?></p>
            <br>
            <h4>Comments</h4>
            <?php foreach($comments as $comment) :?>
                <?php 
                    $user_id = $comment['comment_created_by'];
                    $user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id' ");
                    $user= mysqli_fetch_assoc($user); 
                 ?>
                 <h6><?php echo $user['userName']; ?></h6>
                <small><?php echo $comment['comment_text']; ?></small><br>
                <?php foreach($user_comments as $user_comment) :?>
                    <?php if($user_comment['comment_id'] ==  $comment['comment_id']) : ?>
                            <form class="pull-right" action="<?php echo ROOT_URL?>post.php?id=<?php echo $post['post_id']; ?>" method="POST">
                            <input type="hidden" name="delete_id" value ="<?php echo $comment['comment_id']; ?>">
                            <input type="submit" name="delete" value="Delete Comment" class="btn btn-danger btn-xs">
                        </form>
                    <?php  endif; ?>
                </form>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <hr>
        <a href="<?php echo ROOT_URL; ?>add_comment.php?id=<?php echo $post['post_id']; ?>" class = "btn btn-primary">Add Comment</a>
    </div>
<?php include('inc/footer.php') ?>

        