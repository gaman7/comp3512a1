<?php
        include('H&S/header.php'); // Include the common header
        require("db.php");
  
        try{
            $sql = "SELECT title, year, bpm, energy, danceability, liveness,
            valence, duration, acousticness, speechiness, popularity, 
            genre_name, artist_name, type_name
            FROM songs 
            INNER JOIN genres ON songs.genre_id = genres.genre_id
            INNER JOIN artists ON songs.artist_id = artists.artist_id
            INNER JOIN types ON artists.artist_type_id = types.type_id
            WHERE song_id=:songId";


            $statement = $pdo->prepare($sql);

            $id = filter_input(INPUT_GET, 'song_id');
            $statement->bindValue(':songId', $id, PDO::PARAM_INT);
            
            $statement->execute();

            $request = $statement->fetch();
            $pdo = null;

            if(!$request){
                echo "No song found :(";
                exit();
            }
        }
        catch (PDOException $error){
            print "Error: " . $error->getMessage() . "br/>";
            die();
        }
        ?>


        <h1> Song Information</h1>
        <h3><?php echo ($request['title'])?></h3>
        <h3><?php echo ($request['artist_name'])?></h3>
        <h3><?php echo ($request['type_name'])?></h3>
        <h3><?php echo ($request['genre_name'])?></h3>
        <h3><?php echo ($request['year'])?></h3>
        <h3><?php echo ($request['duration'])?></h3>

        <ul>Analysis Data:
    <li>bpm<?php echo ($request['bpm'])?></li>
    <li><?php echo ($request['energy'])?></li>
    <li><?php echo ($request['danceability'])?></li>
    <li><?php echo ($request['liveness'])?></li>
    <li><?php echo ($request['valence'])?></li>
    <li><?php echo ($request['acousticness'])?></li>
    <li><?php echo ($request['speechiness'])?></li>
    <li><?php echo ($request['popularity'])?></li>

</ul> 

<?php include('H&S/footer.php');
