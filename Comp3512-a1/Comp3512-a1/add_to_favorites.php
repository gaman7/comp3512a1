<?php
// Start or resume the session
session_start();

// Check if the song_id parameter is present in the query string
if (isset($_GET['song_id'])) {
    $songID = $_GET['song_id'];

    // Check if the user has a favorites list in the session
    if (!isset($_SESSION['favorite_songs'])) {
        // If the favorites list doesn't exist, create an empty array
        $_SESSION['favorite_songs'] = array();
    }

    // Add the song to the favorites list (if it's not already there)
    if (!in_array($songID, $_SESSION['favorite_songs'])) {
        $_SESSION['favorite_songs'][] = $songID;
    }
    // Redirect back to the previous page (the Browse/Search Results Page)
    header("Location: search.php");
    exit();
} else {
    // Handle the case where no song_id parameter is provided
    echo "Error: Song ID not specified.";
}
?>
