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

    echo "<div id='diakok'>";
    echo "<form action='tanevvalaszto.php' method='get'>";



    //Kapott érték
    $osztaly = $_GET["osztalyok"];
    $osztaly = mysqli_real_escape_string($conn, $osztaly); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést



    //Kiválasztjuk a kapott osztály alapján az abba tartozó diákokat
    $sql = "SELECT nev, ID
            FROM diak 
            WHERE osztalyID = ".$osztaly;
    echo "Név<br>";
    $result = $conn->query($sql);



    //Kiirjuk az összes diákot
    echo "<select size='1' name ='diakok'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["nev"];
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select>";



    //elküld gomb
    echo "<input type = 'submit' />";

    echo "</form>";
    echo "</div>";
}


?>