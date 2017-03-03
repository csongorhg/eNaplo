<?php
/**
 * Created by PhpStorm.
 * User: mordes
 * Date: 2017.02.18.
 * Time: 10:03
 */

include 'dbCommands.php';

//main
connect();

selectYears();

disconnect();


function selectYears()
{
    global $conn, $tableTanev, $tableDiak, $tableTanevDiak;

    echo "<div id='tanevek'>";
    echo "<form action='jegyvalaszto.php' method='get'>";



    //Kapott érték
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést



    //Kiválasztjuk a kapott osztály alapján az abba tartozó diákokat
    $sql = "SELECT osztaly.evfolyam, osztaly.betu, osztaly.szak
    FROM osztaly
    WHERE osztaly.aktiv = 1";
    echo "Osztályok<br>";
    $result = $conn->query($sql);

    //Kiirjuk az összes osztályt
    echo " <select size = '1' name = 'osztalyok'> ";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["evfolyam"] . " " . $row["betu"] . " (" . $row["szak"] . ")";
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select > ";



    //elküld gomb
    echo "<input type = 'submit' />";
    echo "<input type = 'hidden' name='tanevek' value='$tanev' />";

    echo "</form > ";
    echo "</div > ";
}

?>