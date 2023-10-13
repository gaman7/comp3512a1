<?php
include('H&S/header.php');
require('db.php'); // Include the database connection code


// List 1: Top Genres based on the number of songs
$query1 = "SELECT genres.genre_name, COUNT(songs.song_id) AS song_count
           FROM genres
           INNER JOIN songs ON genres.genre_id = songs.genre_id
           GROUP BY genres.genre_id
           ORDER BY song_count DESC
           LIMIT 10";

$result1 = $pdo->query($query1);

// List 2: Top Artists based on the number of songs
$query2 = "SELECT artists.artist_name, COUNT(songs.song_id) AS song_count
           FROM artists
           INNER JOIN songs ON artists.artist_id = songs.artist_id
           GROUP BY artists.artist_id
           ORDER BY song_count DESC
           LIMIT 10";

$result2 = $pdo->query($query2);

// List 3: Most Popular Songs (song title and artist name)
$query3 = "SELECT songs.title, artists.artist_name, songs.song_id
           FROM songs
           INNER JOIN artists ON songs.artist_id = artists.artist_id
           GROUP BY songs.song_id, artists.artist_name
           ORDER BY MAX(songs.popularity) DESC
           LIMIT 10";           

$result3 = $pdo->query($query3);


// List 4: One-hit wonders (most popular songs by artists with only one song)
$query4 = "SELECT songs.title, artists.artist_name, songs.song_id
           FROM songs
           INNER JOIN artists ON songs.artist_id = artists.artist_id
           WHERE artists.artist_id IN (
               SELECT artist_id FROM songs
               GROUP BY artist_id
               HAVING COUNT(song_id) = 1
           )
           ORDER BY songs.popularity DESC
           LIMIT 10";

$result4 = $pdo->query($query4);

// List 5: Longest Acoustic Song (acousticness > 40, sorted by duration)
$query5 = "SELECT songs.title, artists.artist_name, songs.duration, songs.song_id
           FROM songs
           INNER JOIN artists ON songs.artist_id = artists.artist_id
           WHERE songs.acousticness > 40
           ORDER BY songs.duration DESC
           LIMIT 10";

$result5 = $pdo->query($query5);

// List 6: At the Club (danceability*1.6 + energy*1.4 > 80, sorted by calculation)
$query6 = "SELECT songs.title, artists.artist_name, songs.song_id, (songs.danceability*1.6 + songs.energy*1.4) AS club_score
           FROM songs
           INNER JOIN artists ON songs.artist_id = artists.artist_id
           WHERE (songs.danceability*1.6 + songs.energy*1.4) > 80
           ORDER BY club_score DESC
           LIMIT 10";

$result6 = $pdo->query($query6);

// List 7: Running Songs (bpm between 120-125, sorted by calculation)
$query7 = "SELECT songs.title, artists.artist_name, songs.song_id, (songs.energy*1.3 + songs.valence*1.6) AS running_score
           FROM songs
           INNER JOIN artists ON songs.artist_id = artists.artist_id
           WHERE songs.bpm BETWEEN 120 AND 125
           ORDER BY running_score DESC
           LIMIT 10";

$result7 = $pdo->query($query7);

// List 8: Studying Songs (bpm between 100-115 and speechiness between 1-20, sorted by calculation)
$query8 = "SELECT songs.title, artists.artist_name, songs.song_id,
                      (songs.acousticness*0.8)+(100-songs.speechiness)+(100-songs.valence) AS studying_score
           FROM songs
           INNER JOIN artists ON songs.artist_id = artists.artist_id
           WHERE songs.bpm BETWEEN 100 AND 115 AND songs.speechiness BETWEEN 1 AND 20
           ORDER BY studying_score DESC
           LIMIT 10";

$result8 = $pdo->query($query8);
?>

<main>
    <h2 class="center">Home</h2>
    <div class="card-grid">
        
        <section class="hoverable">
            <h3>Top Genres</h3>
            <ul>
                <?php
                while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li>' . $row1['genre_name'] . ' (' . $row1['song_count'] . ' songs)</li>';
                }
                ?>
            </ul>
        </section>

        <!-- List 2: Top Artists based on the number of songs -->
        <section class="hoverable">
            <h3>Top Artists</h3>
            <ul>
                <?php
                while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li>' . $row2['artist_name'] . ' (' . $row2['song_count'] . ' songs)</li>';
                }
                ?>
            </ul>
        </section>

        <!-- List 3: Most Popular Songs (song title and artist name) -->
        <section class="hoverable">
            <h3>Most Popular Songs</h3>
            <ul>
                <?php
                while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
                    // echo '<li>' . $row3['title'] . ' by ' . $row3['artist_name'] . '</li>';
                    echo '<li><a href="singleSongs.php?song_id=' . $row3['song_id'] . '">' . $row3['title'] . ' by ' . $row3['artist_name'] . '</a></li>';
                }
                ?>
            </ul>
        </section>

        <!-- List 4: One-hit wonders (most popular songs by artists with only one song) -->
        <section class="hoverable">
            <h3>One-hit wonders</h3>
            <ul>
                <?php
                while ($row4 = $result4->fetch(PDO::FETCH_ASSOC)) {
                   // echo '<li>' . $row4['title'] . ' by ' . $row4['artist_name'] . '</li>';
                    echo '<li><a href="singleSongs.php?song_id=' . $row4['song_id'] . '">' . $row4['title'] . ' by ' . $row4['artist_name'] . '</a></li>';

                }
                ?>
            </ul>
        </section>

        <!-- List 5: Longest Acoustic Song (acousticness > 40, sorted by duration) -->
        <section class="hoverable">
            <h3>Longest Acoustic Song</h3>
            <ul>
                <?php
                while ($row5 = $result5->fetch(PDO::FETCH_ASSOC)) {
                   echo '<li><a href="singleSongs.php?song_id=' . $row5['song_id'] . '">' . $row5['title'] . ' by ' . $row5['artist_name'] . ' (Duration: ' . $row5['duration'] . ' seconds)</a></li>';
                }
                ?>
            </ul>
        </section>

        <!-- List 6: At the Club (danceability*1.6 + energy*1.4 > 80, sorted by calculation) -->
        <section class="hoverable">
            <h3>At the Club</h3>
            <ul>
                <?php
                while ($row6 = $result6->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li><a href="singleSongs.php?song_id=' . $row6['song_id'] . '">' . $row6['title'] . ' by ' . $row6['artist_name'] . '</a></li>';
                }
                ?>
            </ul>
        </section>

                <!-- List 7: Running Songs (bpm between 120-125) -->
                <section class="hoverable">
            <h3>Running Songs</h3>
            <ul>
                <?php
                while ($row7 = $result7->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li><a href="singleSongs.php?song_id=' . $row7['song_id'] . '">' . $row7['title'] . ' by ' . $row7['artist_name'] . '</a></li>';

                }
                ?>
            </ul>
        </section>

        <!-- List 8: Studying Songs (bpm between 100-115 and speechiness between 1-20) -->
        <section class="hoverable">
            <h3>Studying Songs</h3>
            <ul>
                <?php
                while ($row8 = $result8->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li><a href="singleSongs.php?song_id=' . $row8['song_id'] . '">' . $row8['title'] . ' by ' . $row8['artist_name'] . '</a></li>';

                }
                ?>
            </ul>
        </section>
    </div>
</main>

<?php include('H&S/footer.php'); // Include the common footer ?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./Css/styles.css">
    
</head>

</body>
</html>


