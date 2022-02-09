<?php
//$servername = "localhost";
//$username = "root";
//$password = "";

//$servername = "localhost";
//$username = "c98l9GRLrq";
//$password = "usyd2f5kCr";

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);


try {
    $conn = new PDO("mysql:host=$cleardb_server;dbname=heroku_6daa70e44adaa77", $cleardb_username, $cleardb_password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
