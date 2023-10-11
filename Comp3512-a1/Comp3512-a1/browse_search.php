<?php
include("H&S/header.php");
// Include database connection code here
require("db.php");

// Check if query string parameters are present
if (isset($_GET['search_type'])) {
    // Retrieve and sanitize query string parameters
    $searchType = $_GET['search_type'];
    $searchTerm = $_GET['search_term'];

    if($searchType == 'artists') {
    $sql = "SELECT song_id, SUBSTR(title, 1, 25) AS truncated_title, artist_name, year, genre_name, popularity FROM songs
    JOIN artists ON songs.artist_id = artists.artist_id
    JOIN genres ON songs.genre_id = genres.genre_id
    WHERE year < :searchYear";
    }
    if($searchType == 'artists') {
        $sql = "SELECT song_id, SUBSTR(title, 1, 25) AS truncated_title, artist_name, year, genre_name, popularity FROM songs
        JOIN artists ON songs.artist_id = artists.artist_id
        JOIN genres ON songs.genre_id = genres.genre_id
        WHERE year < :searchYear";
        }

    // Check if the user selected "Year Less Than" or "Year Greater Than"
    if ($searchType === 'year_less') {
        $sql = "SELECT song_id, SUBSTR(title, 1, 25) AS truncated_title, artist_name, year, genre_name, popularity FROM songs
                JOIN artists ON songs.artist_id = artists.artist_id
                JOIN genres ON songs.genre_id = genres.genre_id
                WHERE year < :searchYear";
    } elseif ($searchType === 'year_greater') {
        $sql = "SELECT song_id, SUBSTR(title, 1, 25) AS truncated_title, artist_name, year, genre_name, popularity FROM songs
                JOIN artists ON songs.artist_id = artists.artist_id
                JOIN genres ON songs.genre_id = genres.genre_id
                WHERE year > :searchYear";
    } else {
        // Handle other search types (e.g., title, artist, genre)
        $sql = "SELECT song_id, SUBSTR(title, 1, 25) AS truncated_title, artist_name, year, genre_name, popularity FROM songs
                JOIN artists ON songs.artist_id = artists.artist_id
                JOIN genres ON songs.genre_id = genres.genre_id
                WHERE $searchType LIKE :searchTerm";
    }

    // Prepare and execute the SQL query
    if ($searchType === 'year_less' || $searchType === 'year_greater') {
        $searchYear = $_GET['search_year'];
        $statement = $database->prepare($sql);
        $statement->bindValue(':searchYear', $searchYear, PDO::PARAM_INT);
    } else {
        // Handle other search types (e.g., title, artist, genre)
        $statement = $database->prepare($sql);
        $statement->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
    }
    
    $statement->execute();
} else {
    // If no query string parameters are present, retrieve all songs
    $sql = "SELECT song_id, SUBSTR(title, 1, 25) AS truncated_title, artist_name, year, genre_name, popularity FROM songs
            JOIN artists ON songs.artist_id = artists.artist_id
            JOIN genres ON songs.genre_id = genres.genre_id";
    
    // Prepare and execute the SQL query
    $statement = $database->prepare($sql);
    $statement->execute();
}

// Display the table headers
echo "<table>";
echo "<tr><th>Title</th><th>Artist</th><th>Year</th><th>Genre</th><th>Popularity</th><th>Action</th></tr>";


// Fetch and display the search results in a table row
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $songID = $row['song_id'];
    $truncatedTitle = $row['truncated_title'];
    $artist = $row['artist_name'];
    $year = $row['year'];
    $genre = $row['genre_name'];
    $popularity = $row['popularity'];
    
    // Display each result as a table row
    echo "<tr>";
    echo "<td><a href='single_song.php?song_id=$songID'>$truncatedTitle</a></td>";
    echo "<td>$artist</td>";
    echo "<td>$year</td>";
    echo "<td>$genre</td>";
    echo "<td>$popularity</td>";
    echo "<td><a href='single_song.php?song_id=$songID'>View</a>";
    echo "<a href='add_to_favorites.php?song_id=$songID'>Add to Favorites</a></td>";
    echo "</tr>";
}

// Close the table
echo "</table>";

// Close the database connection
$database = null;
include("H&S/footer.php");
?>