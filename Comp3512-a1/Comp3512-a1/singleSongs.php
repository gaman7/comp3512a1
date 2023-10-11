<?php
        include('H&S/header.php'); // Include the common header
        require("db.php");

        $song_id = $_GET['song_id'];


        function getSongs($pdo) {
            $sql = "SELECT GalleryID, GalleryName FROM Galleries
                     ORDER BY GalleryName"; 
            $result = $pdo->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC); 
         }
        ?>

<h2>  Song Information</h2>

<br>

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