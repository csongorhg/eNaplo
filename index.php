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
/**
 * Created by PhpStorm.
 * User: mordes
 * Date: 2017.02.15.
 * Time: 17:54
 */
$servername = "localhost";
$username = "csongi";
$password = "";
$dbname = "enaplo";
$conn;

//main
connect();

selectClass();

disconnect();

function connect()
{
    global $servername, $username, $password, $dbname, $conn;
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_query($conn, "SET NAMES 'utf8'");
    } catch (Exception $ex) {
        die("Unable to connect (" + $ex + ")");
    }
}

function selectClass()
{
    global $conn;

    echo "<div id='osztalyok'>";
    echo "<form action=''>";


    $sql = "SELECT EVFOLYAM, BETU, SZAK FROM osztaly";
    echo "Évfolyam, név, szak<br>";
    $result = $conn->query($sql);

    echo "<select size='5'>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["EVFOLYAM"] . " " . $row["BETU"] . " (" . $row["SZAK"] . ")";
            echo "<option >$str</option>";
        }
    } else {
        echo "0 results";
    }

    echo "</select>";
    echo "</form>";
    echo "</div>";


}

function disconnect()
{
    global $conn;
    mysqli_close($conn);
}

?>


</body>
</html>