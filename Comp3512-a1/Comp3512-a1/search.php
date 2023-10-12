<?php
include('H&S/header.php'); // Include the common header
require("db.php");

$searchType = "";
$searchTerm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search_type'])) {
        $searchType = $_POST['search_type'];
    }

    if (isset($_POST['search_term'])) {
        $searchTerm = $_POST['search_term'];
    }
}

?>

<h2>Search for Songs</h2>
<form action="browse_search.php" method="POST">
    <label>Search By:</label><br>
    <input type="radio" name="search_type" value="title" <?= ($searchType === "title") ? "checked" : "" ?>> Title
    <input type="text" id="search_term" name="search_term" value="<?= $searchTerm ?>">
    <br>

    <input type="radio" name="search_type" value="artist" <?= ($searchType === "artist") ? "checked" : "" ?>>
    <label for="search_artist">Artist:</label>
    <select id="search_artist" name="search_artist">
        <option value="">Select an Artist</option>
        <?php
        // Query to retrieve artists from the database
        $artistQuery = "SELECT artist_id, artist_name FROM artists";

        $result = $pdo->query($artistQuery);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $artistID = $row['artist_id'];
                $artistName = $row['artist_name'];
                $selected = ($searchType === "artist" && $searchTerm == $artistID) ? "selected" : "";
                echo "<option value='$artistID' $selected>$artistName</option>";
            }
        }
        ?>
    </select>
    <br>

    <input type="radio" name="search_type" value="genre" <?= ($searchType === "genre") ? "checked" : "" ?>>
    <label for="search_genre">Genre:</label>
    <select id="search_genre" name="search_genre">
        <option value="">Select a Genre</option>
        <?php
        // Query to retrieve genres from the database
        $genreQuery = "SELECT genre_id, genre_name FROM genres";

        $result = $pdo->query($genreQuery);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $genreID = $row['genre_id'];
                $genreName = $row['genre_name'];
                $selected = ($searchType === "genre" && $searchTerm == $genreID) ? "selected" : "";
                echo "<option value='$genreID' $selected>$genreName</option>";
            }
        }
        ?>
    </select>
    <br>

    <input type="radio" name="search_type" value="year" <?= ($searchType === "year") ? "checked" : "" ?>> Year
    <label for="search_year_less">Less:</label>
    <input type="number" id="search_year_less" name="search_year_less" min="2016" max="2019">
    <label for="search_year">Greater: </label>
    <input type="number" id="search_year_great" name="search_year_great" min="2016" max="2019">
    <br>

    <br>

    <input type="submit" value="Search">
</form>
<?php include('H&S/footer.php'); ?>