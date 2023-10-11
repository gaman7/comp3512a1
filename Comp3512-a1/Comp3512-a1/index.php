
        
<?php
        include('H&S/header.php'); // Include the common header
        require('db.php');

        
        // List 1: Top Genres based on the number of songs
        $query1 = "SELECT genres.genre_name, COUNT(songs.song_id) AS song_count
                   FROM genres
                   INNER JOIN songs ON genres.genre_id = songs.genre_id
                   GROUP BY genres.genre_id
                   ORDER BY song_count DESC
                   LIMIT 10";
        // Execute query1 and fetch results

        // List 2: Top Artists based on the number of songs
        $query2 = "SELECT artists.artist_name, COUNT(songs.song_id) AS song_count
                   FROM artists
                   INNER JOIN songs ON artists.artist_id = songs.artist_id
                   GROUP BY artists.artist_id
                   ORDER BY song_count DESC
                   LIMIT 10";
        // Execute query2 and fetch results

        // List 3: Most Popular Songs (song title and artist name)
        $query3 = "SELECT songs.title, artists.artist_name
                   FROM songs
                   INNER JOIN artists ON songs.artist_id = artists.artist_id
                   GROUP BY songs.song_id, artists.artist_name
                   ORDER BY MAX(songs.popularity) DESC
                   LIMIT 10";
        // Execute query3 and fetch results

        // List 4: One-hit wonders (most popular songs by artists with only one song)
        $query4 = "SELECT songs.title, artists.artist_name
                   FROM songs
                   INNER JOIN artists ON songs.artist_id = artists.artist_id
                   WHERE artists.artist_id IN (
                       SELECT artist_id FROM songs
                       GROUP BY artist_id
                       HAVING COUNT(song_id) = 1
                   )
                   ORDER BY songs.popularity DESC
                   LIMIT 10";
        // Execute query4 and fetch results

        // List 5: Longest Acoustic Song (acousticness > 40, sorted by duration)
        $query5 = "SELECT songs.title, artists.artist_name, songs.duration
                   FROM songs
                   INNER JOIN artists ON songs.artist_id = artists.artist_id
                   WHERE songs.acousticness > 40
                   ORDER BY songs.duration DESC
                   LIMIT 10";
        // Execute query5 and fetch results

        // List 6: At the Club (danceability*1.6 + energy*1.4 > 80, sorted by calculation)
        $query6 = "SELECT songs.title, artists.artist_name, (songs.danceability*1.6 + songs.energy*1.4) AS club_score
                   FROM songs
                   INNER JOIN artists ON songs.artist_id = artists.artist_id
                   WHERE (songs.danceability*1.6 + songs.energy*1.4) > 80
                   ORDER BY club_score DESC
                   LIMIT 10";

        // List 7: Running Songs (bpm between 120-125, sorted by calculation)
        $query7 = "SELECT songs.title, artists.artist_name, (songs.energy*1.3 + songs.valence*1.6) AS running_score
                   FROM songs
                   INNER JOIN artists ON songs.artist_id = artists.artist_id
                   WHERE songs.bpm BETWEEN 120 AND 125
                   ORDER BY running_score DESC
                   LIMIT 10";
        // Execute query7 and fetch results

        // List 8: Studying Songs (bpm between 100-115, speechiness between 1-20, sorted by calculation)
        $query8 = "SELECT songs.title, artists.artist_name,
                          (songs.acousticness*0.8)+(100-songs.speechiness)+(100-songs.valence) AS studying_score
                   FROM songs
                   INNER JOIN artists ON songs.artist_id = artists.artist_id
                   WHERE songs.bpm BETWEEN 100 AND 115 AND songs.speechiness BETWEEN 1 AND 20
                   ORDER BY studying_score DESC
                   LIMIT 10";
        // Execute query8 and fetch results
    ?>

<main>
    <h2 class="center">Home</h2>
     <div class="card-grid">
    <!-- List 1: Top Genres based on the number of songs -->
    <section>
        <h3>Top Genres</h3>
        <ul>
              <!-- ... PHP HERE ... -->
        </ul>
    </section>

    <!-- List 2: Top Artists based on the number of songs -->
    <section>
        <h3>Top Artists</h3>
        <ul>
             <!-- ... PHP HERE ... -->
        </ul>
    </section>

    <!-- List 3: Most Popular Songs (song title and artist name) -->
    <section>
        <h3>Most Popular Songs</h3>
        <ul>
            <!-- ... PHP HERE ... -->
        </ul>
    </section>

    <!-- List 4: One-hit wonders (most popular songs by artists with only one song) -->
    <section>
        <h3>One-hit wonders</h3>
        <ul>
              <!-- ... PHP HERE ... -->
        </ul>
    </section>

    <!-- List 5: Longest Acoustic Song (acousticness > 40, sorted by duration) -->
    <section>
        <h3>Longest Acoustic Song</h3>
        <ul>
             <!-- ... PHP HERE ... -->
        </ul>
    </section>

    <!-- List 6: At the Club (danceability*1.6 + energy*1.4 > 80, sorted by calculation) -->
    <section>
        <h3>At the Club</h3>
        <ul>
              <!-- ... PHP HERE ... -->
        </ul>
    </section>

    <!-- List 7: Running Songs (bpm between 120-125) -->
    <section>
        <h3>Running Songs</h3>
        <ul>
             <!-- ... PHP HERE ... --> 
        </ul>
    </section>

    <!-- List 8: Studying Songs (bpm between 100-115 and speechiness between 1-20) -->
    <section>
        <h3>Studying Songs</h3>
        <ul>
             <!-- ... PHP HERE ... -->
        </ul>
    </section>
        </div>

 
</main>


    <?php include('H&S/footer.php'); // Include the common footer ?>
