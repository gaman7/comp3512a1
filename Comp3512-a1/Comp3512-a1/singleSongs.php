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

<section>
        <h1><?php echo ($request['title']);?></h1>
        <h2>Fast Facts:</h2>
        <h3>Artist: <?php echo ($request['artist_name'])?></h3>
        <h3>Artist Type: <?php echo ($request['type_name'])?></h3>
        <h3>Genre: <?php echo ($request['genre_name'])?></h3>
        <h3>Song Year: <?php echo ($request['year'])?></h3>
        <?php $songTime = $request['duration'];?>
        <h3>Song time: <?php echo gmdate("i:s", $songTime)?></h3>
   
<section>

<table>
<caption>Song Analytics</caption>

    <tr>
    <td>BPM: <?php echo ($request['bpm'])?></td>
    </tr>

    <tr>
    <td>Energy:</td>
    <?php $energy = $request['energy'];
    echo '<td><progress value= ' .$energy. ' max="100"></progress></td>' ?>
    </tr>

    <tr>
    <td>Danceability:</td>
    <?php $danceability = $request['danceability'];
    echo '<td><progress value= ' .$danceability. ' max="100"></progress></td>' ?>
    </tr>

    <tr>
    <td>Liveness:</td>
    <?php $liveness = $request['liveness'];
    echo '<td><progress value= ' .$liveness. ' max="100"></progress></td>' ?>
    </tr>

    <tr>
    <td>Valence:</td>
    <?php $valence = $request['valence'];
    echo '<td><progress value= ' .$valence. ' max="100"></progress></td>' ?>
    </tr>

    <tr>
    <td>Acousticness:</td>
    <?php $acousticness = $request['acousticness'];
    echo '<td><progress value= ' .$acousticness. ' max="100"></progress></td>' ?>
    </tr>

    <tr>
    <td>Speechiness:</td>
    <?php $speechiness = $request['speechiness'];
    echo '<td><progress value= ' .$speechiness. ' max="100"></progress></td>' ?>
    </tr>

    <tr>
    <td>Popularity:</td>
    <?php $popularity = $request['popularity'];
    echo '<td><progress value= ' .$popularity. ' max="100"></progress></td>' ?>
    </tr>

    </table>

   


<!-- <ul>Analysis Data:
    <li>BPM: <?php echo ($request['bpm'])?></li>
    <li>Energy: <?php echo ($request['energy'])?></li>
    <li>Danceability: <?php echo ($request['danceability'])?></li>
    <li>Liveness: <?php echo ($request['liveness'])?></li>
    <li>Valence: <?php echo ($request['valence'])?></li>
    <li>Acousticness: <?php echo ($request['acousticness'])?></li>
    <li>Speechiness: <?php echo ($request['speechiness'])?></li>
    <li>Popularity: <?php echo ($request['popularity'])?></li>

</ul>  -->
<?php include('H&S/footer.php');
