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


//disconnect();

function connect()
{
    global $servername, $username, $password, $dbname, $conn;
    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        mysqli_query($conn, "SET NAMES 'utf8'");
    } catch (Exception $ex) {
        die("Unable to connect (" + $ex + ")");
    }
}

function disconnect()
{
    global $conn;
    mysqli_close($conn);
}

?>


<form action="">

</form>


</body>
</html>