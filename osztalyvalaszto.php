<head>
    <link href="valasztoCSS.css" rel="stylesheet" type="text/css"/>
</head>

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
    global $conn, $tableOsztaly, $tableSzak, $tableEvfolyam;

    echo "<div id='osztalyok'>";
    echo "<div class='kiscim'>Válassza ki az osztályt</div>";
    echo "<form action='diakvalaszto.php' method='get' class='valaszto'>";



    //Kapott érték
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést




    //Kiválasztjuk a kapott osztály alapján az abba tartozó diákokat
    $sql = "SELECT ".$tableOsztaly.".id, ".$tableOsztaly.".szam, ".$tableOsztaly.".betu, ".$tableSzak.".szak
    FROM ".$tableOsztaly." INNER JOIN ".$tableEvfolyam." ON ".$tableOsztaly.".id = ".$tableEvfolyam.".osztalyid 
    INNER JOIN ".$tableSzak." ON ".$tableOsztaly.".szakid = ".$tableSzak.".id
    WHERE ".$tableEvfolyam.".tanevid = ".$tanev;
    $result = $conn->query($sql);

    //Kiirjuk az összes osztályt
    echo " <select size = '1' name = 'osztalyok'> ";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["szam"] . "." . $row["betu"] . " (" . $row["szak"] . ")";
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select ><br>";



    //elküld gomb
    echo "<input type = 'submit' class='gomb'/>";
    echo "<input type = 'hidden' name='tanevek' value='$tanev' />";

    echo "</form > ";
    echo "</div > ";
}

?>