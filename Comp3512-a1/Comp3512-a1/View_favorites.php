<?php

include("H&S/header.php");
require('db.php');

include("H&S/header.php");
require("db.php");

session_start();

// Check if there's a request to add a song to favorites
if (isset($_GET['add_to_favorites'])) {
    $song_id = $_GET['add_to_favorites'];

    // Check if the user's favorites array exists in the session
    if (isset($_SESSION['favorite_songs'])) {
        // Add the song to the favorites array in the session
        $_SESSION['favorite_songs'][] = $song_id;
    } else {
        // Create a new favorites array in the session
        $_SESSION['favorite_songs'] = [$song_id];
    }
}

// Display the user's favorite songs
if (isset($_SESSION['favorite_songs']) && !empty($_SESSION['favorite_songs'])) {
    $favorite_songs = $_SESSION['favorite_songs'];

    // Fetch and display details of favorite songs
    echo "<h1>My Favorite Songs</h1>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Artist</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    foreach ($favorite_songs as $song_id) {
        // Fetch song details from the database using $song_id
        $sql = "SELECT title, artist_name FROM songs
                LEFT JOIN artists ON songs.artist_id = artists.artist_id
                WHERE song_id = :song_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':song_id', $song_id, PDO::PARAM_INT);
        $stmt->execute();
        $song = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($song) {
            echo "<tr>";
            echo "<td>" . $song['title'] . "</td>";
            echo "<td>" . $song['artist_name'] . "</td>";
            echo '<td><a href="view_favorites.php?remove_from_favorites=' . $song_id . '">Remove</a></td>';
            echo "</tr>";
        }
    }

    echo "</table>";
} else {
    echo "<h1>No favorite songs found</h1>";
}

include("H&S/footer.php");

?>