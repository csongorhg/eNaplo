<html>
<head>
    <meta charset="UTF-8">
    <title>eNaplo</title>


    <style>

    </style>

    <script>

    </script>
</head>
<body>
<?php
$servername = "localhost";
$username = "csongi";
$password = "";
$dbname = "enaplo";
$conn;


//main
connect();
disconnect();

function connect() {
    global $servername, $username, $password, $dbname, $conn;
    echo "<div id='connects'>";
    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        mysqli_query($conn, "SET NAMES 'utf8'");
        echo "Connected<br>";
        echo "LÓFASZ";
    } catch (Exception $ex) {
        die("Unable to connect (" + $ex + ")");
    }
    echo "</div>";
}

function disconnect() {
    global $conn;
    echo "<div id='connects'>";
    mysqli_close($conn);
    echo "Disconnected";
    echo "</div>";
}

?>

</body>
</html>
