
<?php
        include('H&S/header.php'); // Include the common header
        require("db.php");

        ?>

    <h2>Search for Songs</h2>
    <form action="search.php" method="POST">
       
        
        <label>Search By:</label><br>
        <input type="radio" name="search_type" value="title" checked> Title
        <input type="text" id="search_term" name="search_term" >
        <br>

        <input type="radio" name="search_type" value="artist"> 
        <label for="search_artist">Artist:</label>
        <select id="search_artist" name="search_artist">
            <option value="">Select an Artist</option>
            
           
            
            
            
            
        </select>
        <br>
        <input type="radio" name="search_type" value="genre"> 
        <label for="search_genre">Genre:</label>
        <select id="search_genre" name="search_genre">
            <option value="">Select a Genre</option>

            
        </select>
        <br>
        <input type="radio" name="search_type" value="year"> Year <br>
        <label for="search_year">Less:</label>
        <input type="number" id="search_year_less" name="search_year" min="2016" max="2019">
        <label for="search_year">Greater: </label>
        <input type="number" id="search_year_great" name="search_year" min="2016" max="2019">
        <br>
        
        
        <br>
        
        
        
        
        
        <input type="submit" value="Search">
    </form>
    <?php include('H&S/footer.php');
