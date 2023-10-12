<?php
include("H&S/header.php");
require("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission and construct SQL query based on user input
    $searchType = $_POST['search_type'];
    $searchTerm = $_POST['search_term'];
    $searchYearLess = $_POST['search_year_less'];
    $searchYearGreat = $_POST['search_year_great'];
    $searchArtist = $_POST['search_artist'];
    $searchGenre = $_POST['search_genre'];

    // Construct SQL query based on selected search type and user input
    $sql = "SELECT songs.song_id, songs.title, artists.artist_name, genres.genre_name, songs.year, songs.bpm, songs.energy, songs.danceability, songs.loudness, songs.liveness, songs.valence, songs.duration, songs.acousticness, songs.speechiness, songs.popularity
            FROM songs
            LEFT JOIN artists ON songs.artist_id = artists.artist_id
            LEFT JOIN genres ON songs.genre_id = genres.genre_id
            WHERE ";

    if ($searchType == 'title') {
        $sql .= "songs.title LIKE :searchTerm";
    } elseif ($searchType == 'artist') {
        $sql .= "songs.artist_id = :searchArtist";
    } elseif ($searchType == 'genre') {
        $sql .= "songs.genre_id = :searchGenre";
    } elseif ($searchType == 'year') {
        $sql .= "songs.year >= :searchYearLess AND songs.year <= :searchYearGreat";
    }else {
        // If searchType is null or not set, include all records
        $sql .= "1"; // A true condition to include all records
    }

    // Prepare the SQL query
    $stmt = $pdo->prepare($sql);

    if ($searchType == 'title') {
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    } elseif ($searchType == 'artist') {
        $stmt->bindValue(':searchArtist', $searchArtist, PDO::PARAM_INT);
    } elseif ($searchType == 'genre') {
        $stmt->bindValue(':searchGenre', $searchGenre, PDO::PARAM_INT);
    } elseif ($searchType == 'year') {
        $stmt->bindValue(':searchYearLess', $searchYearLess, PDO::PARAM_INT);
        $stmt->bindValue(':searchYearGreat', $searchYearGreat, PDO::PARAM_INT);
    }

    // Execute the prepared statement
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any results were found
    if (count($results) === 0) {
        echo "<h1>No records found</h1>";
    } else {
        // Display the results in a table
        echo "<h1>Search Results</h1>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Artist</th>";
        echo "<th>Genre</th>";
        echo "<th>Year</th>";
        echo "<th>Popularity</th>";
        echo "<th>Action</th>";
        echo "</tr>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['artist_name'] . "</td>";
            echo "<td>" . $row['genre_name'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['popularity'] . "</td>";
            echo '<td><a href="single_song.php?song_id=' . $row['song_id'] . '">View</a>';
            echo '<a href="add_to_favorites.php?song_id=' . $row['song_id'] . '">Add to Favorites</a></td>';
            echo "</tr>";
        }

        echo "</table>";
    }
} else {
    // If no form submission, display all songs
    $sql = "SELECT songs.song_id, songs.title, artists.artist_name, genres.genre_name, songs.year, songs.bpm, songs.energy, songs.danceability, songs.loudness, songs.liveness, songs.valence, songs.duration, songs.acousticness, songs.speechiness, songs.popularity
            FROM songs
            LEFT JOIN artists ON songs.artist_id = artists.artist_id
            LEFT JOIN genres ON songs.genre_id = genres.genre_id";
    
    $stmt = $pdo->query($sql);

    // Fetch all songs
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display all songs in a table
    echo "<h1>All Songs</h1>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Artist</th>";
    echo "<th>Genre</th>";
    echo "<th>Year</th>";
    echo "<th>Popularity</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['artist_name'] . "</td>";
        echo "<td>" . $row['genre_name'] . "</td>";
        echo "<td>" . $row['year'] . "</td>";
        echo "<td>" . $row['popularity'] . "</td>";
        echo '<td><a href="single_song.php?song_id=' . $row['song_id'] . '">View</a>';
        echo '<a href="add_to_favorites.php?song_id=' . $row['song_id'] . '">Add to Favorites</a></td>';
        echo "</tr>";
    }

    echo "</table>";
}

include("H&S/footer.php");
?>
