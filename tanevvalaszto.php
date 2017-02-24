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
    global $conn;

    echo "<div id='tanevek'>";
    echo "<form action='jegyvalaszto.php' method='get'>";



    //Kapott érték
    $diak = $_GET["diakok"];
    $diak = mysqli_real_escape_string($conn, $diak); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést



    //Kiválasztjuk a kapott osztály alapján az abba tartozó diákokat
    $sql = "SELECT *
            FROM tanev INNER JOIN tanevdiak ON tanev.ID = tanevdiak.tanevID
            INNER JOIN diak ON tanevdiak.diakID = diak.ID 
            WHERE diak.ID = ".$diak;
    echo "Tanévei<br>";
    $result = $conn->query($sql);



    //Kiirjuk az összes tanévet
    echo " <select size = '1' name = 'tanevek'> ";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["tanev"];
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select > ";



    //elküld gomb
    echo "<input type = 'submit' />";

    echo "</form > ";
    echo "</div > ";
}

?>