<?php
/**
 * Created by PhpStorm.
 * User: 13-085
 * Date: 2017. 02. 17.
 * Time: 9:08
 */

global $servername, $username, $password, $dbname, $conn;

$servername = "localhost";
$username = "csongi";
$password = "";
$dbname = "enaplo";

function connect()
{
    global $servername, $username, $password, $dbname, $conn;
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_query($conn, "SET NAMES 'utf8'") or die("adf");
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