
<?php
// Define the path to the database file
$databasePath = 'data/music.db';

try {
    $database = new PDO("sqlite:$databasePath");
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query= "SELECT COUNT(*) as row_count FROM Songs";
$result=$database->query($query);
$row=$result->fetch(PDO::FETCH_ASSOC);
echo"Number of rows in 'songs' table: " .$row['row_count'];
} catch (PDOException $e) {
    // Handle database connection error
    die("Database connection failed: " . $e->getMessage());
}


?>




