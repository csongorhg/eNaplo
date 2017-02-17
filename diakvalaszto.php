<?php
/**
 * Created by PhpStorm.
 * User: 13-085
 * Date: 2017. 02. 17.
 * Time: 9:07
 */

include 'dbCommands.php';

//main
connect();

selectStudent();

disconnect();


function selectStudent()
{
    global $conn;

    $osztaly = $_GET["osztalyok"];

    $osztaly = mysqli_real_escape_string($conn, $osztaly); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést

    //Osztályba tartozó diákok
    $sql = "SELECT diak.nev, diak.ID
            FROM diak 
            WHERE diak.osztalyID = ".$osztaly;

    echo "Név<br>";
    echo "<select size='1'>";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option>{$row["nev"]}</option>";
        }
    }
    echo "</select>";


    echo "</form>";
    echo "</div>";
}


?>