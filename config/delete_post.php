<?php
session_start();
require_once 'db.php';

// Check if the user is logged in and has the 'user' role
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $postId = $_GET['id'];

        // Verify that the post belongs to the logged-in user
        $verifyQuery = "SELECT * FROM job_posts WHERE post_id = $postId AND user_id = {$_SESSION['id']}";
        $verifyResult = mysqli_query($conn, $verifyQuery);

        if ($verifyResult && mysqli_num_rows($verifyResult) > 0) {
            // Delete the post
            $deleteQuery = "DELETE FROM job_posts WHERE post_id = $postId";
            $deleteResult = mysqli_query($conn, $deleteQuery);

            if ($deleteResult) {
                // Display success message
                echo "<script>
                        alert('ลบโพสต์สำเร็จ');
                        window.location.href = '../user/profile.php';
                      </script>";
            } else {
                echo "Error deleting post: " . mysqli_error($conn);
            }
        } else {
            echo "Unauthorized access to delete this post.";
        }
    } else {
        echo "Invalid post ID.";
    }
} else {
    echo "Unauthorized access.";
}
?>
