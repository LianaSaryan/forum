<?php 
    session_start();
    require('config/config.php');
    require('config/db.php');

	// Check for Submit Button
    if(!empty($_POST))
    {
        // Get form data
	    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        
        $current_user = $_SESSION['CURRENT_USER'];

        $current_post = mysqli_real_escape_string($conn, $_GET['id']);

        $_SESSION['CURRENT_POST'] = $current_post;
        
        $query = "INSERT INTO comments(comment_text, comment_created_by, comment_belongs_to) VALUES('$comment', '$current_user', '$current_post')";

        if(mysqli_query($conn, $query))
        {
            $_SESSION['ADD_COMMENT'] = 'Comment Created!';

            header('Location: '.ROOT_URL.'/landing.php');

        } 
        else 
        {
            $_SESSION['ERROR'] = 'Error: Failed to add a new comment.';

            header('Location: '.ROOT_URL.'/landing.php');
        }
	}
?>

<?php include('inc/header.php') ?>
    <div class = 'container'>
    <h1>Add Comment</h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class ="form-group">
                <label>Comment</label>
                <textarea name ="comment" class="form-control"></textarea>
            </div>
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
<?php include('inc/footer.php') ?>