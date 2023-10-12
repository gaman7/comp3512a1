<?php
include("H&S/header.php");
require('db.php');

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


if (isset($_SESSION['favorite_songs']) && !empty($_SESSION['favorite_songs'])) {
    $favorite_songs = $_SESSION['favorite_songs'];
    echo "<h1>My Favorite Songs</h1>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Artist</th>";
    echo "<th>Genre</th>";
    echo "<th>Year</th>";
    echo "<th>Popularity</th>";
    echo "<th>Action</th>";
    echo"<th></th>";
    echo "</tr>";

?>
<!DOCTYPE html>
 <html>
 <form method="post" action="view_favorites.php"> 
     <button type="submit" name="remove_all" value="1">Remove All</button>
 </form>


<?php
 require("db.php");

if (isset($_POST['remove_all'])) {
    // Check if the user's favorites array exists in the session
    if (isset($_SESSION['favorite_songs'])) {
        $_SESSION['favorite_songs'] = array();
    }
    header('Location: view_favorites.php');
    exit();
}



 ?>
</html>
<?php

    foreach ($favorite_songs as $song_id) {
      
        $sql = "SELECT songs.title, artists.artist_name, genres.genre_name, songs.year, songs.popularity 
        FROM songs
        LEFT JOIN artists ON songs.artist_id = artists.artist_id
        LEFT JOIN genres ON songs.genre_id = genres.genre_id
        WHERE songs.song_id = :song_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':song_id', $song_id, PDO::PARAM_INT);
        $stmt->execute();
        $song = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($song) {
            echo "<tr>";
            echo "<td>" . $song['title'] . "</td>";
            echo "<td>" . $song['artist_name'] . "</td>";
            echo "<td>" . $song['genre_name'] . "</td>";
            echo "<td>" . $song['year'] . "</td>";
            echo "<td>" . $song['popularity'] . "</td>";
            echo '<td><a href="singleSongs.php?song_id=' . $song_id . '">View</a>';
            echo '<td><a href="view_favorites.php?remove_from_favorites=' . $song_id . '">Remove</a></td>';
            echo "</tr>";
        }
    }

    echo "</table>";
    
   
   
    
} else {
    echo "<h1>No favorite songs found</h1>";
}

if (isset($_GET['remove_from_favorites'])) {
    $song_id_to_remove = $_GET['remove_from_favorites'];


    if (isset($_SESSION['favorite_songs'])) {
        
        $key = array_search($song_id_to_remove, $_SESSION['favorite_songs']);
        if ($key !== false) {
            unset($_SESSION['favorite_songs'][$key]);
        }
    }
    

    header('Location: view_favorites.php');
    exit;
}
?>