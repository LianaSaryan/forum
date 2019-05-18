<?php 
    session_start();
    require('config/config.php');   
    require('config/db.php');

	// Check for Submit Button
    if(!empty($_POST))
    {
		// Get form data
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$body = mysqli_real_escape_string($conn, $_POST['body']);

		$current_user = $_SESSION['CURRENT_USER'];

		$query = "INSERT INTO posts(title, body, created_by) VALUES('$title', '$body', '$current_user')";

		if(mysqli_query($conn, $query))
        {

            $_SESSION['ADD_POST'] = 'Post Created!';

            header('Location: '.ROOT_URL.'landing.php');

        } 
        else 
        {
            $_SESSION['ERROR'] = 'Error: Failed to add a new post.';

            header('Location: '.ROOT_URL.'pathfinder.php');
        }
	}

?>

<?php include('inc/header.php') ?>
    <div class = 'container'>
    <h1>Add Post</h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class ="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class ="form-group">
                <label>Body</label>
                <textarea name ="body" class="form-control"></textarea>
            </div>
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
<?php include('inc/footer.php') ?>