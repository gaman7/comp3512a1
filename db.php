 <?php
 //updated version
// Define the SQLite database file path
$databaseFile = 'data/music.db'; // Change the path to your SQLite database file

try {
    // Create a PDO connection to the SQLite database
    $pdo = new PDO("sqlite:$databaseFile");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set UTF-8 character set (optional)
    $pdo->exec("PRAGMA encoding = 'UTF-8'");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>




