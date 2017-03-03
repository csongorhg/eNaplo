
<head>
    <link rel="stylesheet" href="komplexCSS.css">
</head>

<?php
/**
 * Created by PhpStorm.
 * User: mordes
 * Date: 2017.02.18.
 * Time: 10:05
 */

include 'dbCommands.php';

//main
connect();

selectYears();

disconnect();

function selectYears()
{
    global $conn, $tableDiak, $tableOsztaly, $tableTantargySzak, $tableTantargy;

    echo "<div id='jegyek'>";



    //Kapott érték
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést



    //Kiválasztjuk a diák osztálya alapján a lehetséges tantárgyakat
    $sql = "SELECT DISTINCT ".$tableTantargy.".nev 
    FROM ".$tableDiak."
    INNER JOIN ".$tableOsztaly." ON ".$tableDiak.".osztalyID = ".$tableOsztaly.".id
    INNER JOIN ".$tableTantargySzak." ON ".$tableOsztaly.".szak = ".$tableTantargySzak.".kategoriaszak
    INNER JOIN ".$tableTantargy." ON ".$tableTantargySzak.".tantargyid = ".$tableTantargy.".id
    WHERE ".$tableDiak.".id = 1";
    echo "Jegyek...<br>";
    $result = $conn->query($sql);



    //DivTable.com
    echo "<div class='divTable'>";
    echo "<div class='divTableBody'>";



    //Kiirjuk az összes hónapot
    echo " <select size = '1' name = 'tanevek'> ";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["tanev"];
            echo "<option value = '{$row["id"]}'>$str</option>";

            echo "<div class='divTableRow'>";
            echo "<div class='divTableCell'>&nbsp;</div>";
            echo "<div class='divTableCell'>&nbsp;</div>";
            echo "</div>";

        }
    }
    echo "</select > ";



    echo "</div>";
    echo "</div>";


    //elküld gomb
    /**/

    echo "</div > ";
}

?>