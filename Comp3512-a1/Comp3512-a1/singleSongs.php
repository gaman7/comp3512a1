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

        <h1 class="h1-table"><?php echo ($request['title']);?><h1 class="h1-table">by <?php echo ($request['artist_name'])?></h1></h1>
        

  <div class="facts">
        <img class="image" src="Images/reet-talreja.jpg" alt="phone screen with music palying">
        <h2>Fast Facts:</h2>
        <h4>Artist Type: <?php echo ($request['type_name'])?></h4>
        <h4>Genre: <?php echo ($request['genre_name'])?></h4>
        <h4>Song Year: <?php echo ($request['year'])?></h4>
        <?php $songTime = $request['duration'];?>
        <h4>Song time: <?php echo gmdate("i:s", $songTime)?></h4>

    </div>


   
        <section>
<table>
<h3 class="center">Song Analytics</h3>

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

    <tr>
    <td>Beats Per Minute: <?php echo ($request['bpm'])?></td>
    </tr>

    </table>

    </section>

<?php include('H&S/footer.php');
