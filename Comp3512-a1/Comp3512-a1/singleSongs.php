<?php
        include('H&S/header.php'); // Include the common header
        require("db.php");

        //$song_id = $_GET['song_id'];

        //SONG MAY NEED TO BE SONG_ID
        if ( isset($_GET['song']) ) { 
            $songs = getSongs($database, $_GET['song']); 
         }
         $database = null;

        function getSongs($database, $song_id) {
            $sql = "SELECT title, year, duration FROM songs WHERE song_id=?"; 
            $sql = "SELECT genre_name FROM genre WHERE song_id=?";  
            $sql = "SELECT artist_name FROM artists WHERE song_id=?"; 
            $sql = "SELECT type_name FROM types WHERE song_id=?"; 
            
            // $result = $database->query($sql);
            // return $result->fetchAll(PDO::FETCH_ASSOC); 
            $statement = $databse->prepare($sql);
            $statement->bindValue(1, $song_id); 
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
         }

         function outputSongHeader($songs) {
            echo "<h3>Song Informtation</h3>";
            echo "<table class='table'>";
          //  foreach ($songs as $row) {
               echo "<tr>";
               echo "<td>" . $row['title'] . "</td>";
               echo "<td>" . $row['year'] . "</td>";
               echo "<td>" . $row['duration'] . "</td>";
               echo "<td>" . $row['genre_name'] . "</td>";
               echo "<td>" . $row['artist_name'] . "</td>";
               echo "<td>" . $row['type_name'] . "</td>";
               echo "</tr>";
          //   }
            echo "</table>";
         }
        ?>

<h2>  Song Information</h2>

<br>

<section>
    <?php
         outputSongHeader($songs);
         ?>
<section>

<h3>title, artist name, artist type, genre, year, duration</h3>

<ul>Analysis Data:
    <li>bpm</li>
    <li>energy</li>
    <li>danceability</li>
    <li>liveness</li>
    <li>valence</li>
    <li>acousticness</li>
    <li>speechiness</li>
    <li>popularity</li>

</ul>

<?php include('H&S/footer.php');