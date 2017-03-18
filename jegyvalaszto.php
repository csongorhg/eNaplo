
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
    global $conn, $tableTantargy, $tableDiak, $tableEvfolyam, $tableTanev, $tableOsztaly, $tableSzak, $tableTantargySzak;

    echo "<div id='jegyek'>";



    //Kapott érték
    $osztaly = $_GET["osztalyok"];
    $osztaly = mysqli_real_escape_string($conn, $osztaly); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev);
    $diak = $_GET["diakok"];
    $diak = mysqli_real_escape_string($conn, $diak); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
        


    //Kiválasztjuk a diák osztálya alapján a lehetséges tantárgyakat
    $sql = "SELECT ".$tableTantargy.".nev
            FROM ".$tableDiak."   
            INNER JOIN ".$tableEvfolyam." ON ".$tableDiak.".id = ".$tableEvfolyam.".diakid
            INNER JOIN ".$tableTanev." ON ".$tableEvfolyam.".tanevid = ".$tableTanev.".id
            INNER JOIN ".$tableOsztaly." ON ".$tableEvfolyam.".osztalyid = ".$tableOsztaly.".id
            INNER JOIN ".$tableSzak." ON ".$tableOsztaly.".szakid = ".$tableSzak.".id
            INNER JOIN ".$tableTantargySzak." ON ".$tableSzak.".id = ".$tableTantargySzak.".szakid
            INNER JOIN ".$tableTantargy." ON ".$tableTantargySzak.".tantargyid = ".$tableTantargy.".id
            WHERE ".$tableDiak.".id = ".$diak." AND ".$tableOsztaly.".id = ".$osztaly." AND ".$tableTanev.".id = ".$tanev.""
            . " ORDER BY ".$tableTantargy.".nev ";
    echo "Jegyek...<br>";
    $result = $conn->query($sql);

    
    
    //hónapok kiirása
    $months = array("Szeptember", "Október", "November", "December",
        "Január", "Február", "Március", "Április", "Május", "Június");
    
    echo "<table style='width: 100%; table-layout: fixed;' border='1' cellpadding='1'>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td class='month'></td>";
    
    foreach ($months as $value) {
        echo "<td class='month'>$value</td>";
    }
    
    echo "</tr>";
    
    //Kiirjuk az összes lehetséges tárgyát ebben a tanévben ehez az osztályhoz
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["nev"];
            echo "<tr>";
            echo "<td class='month' >$str</td>";
            
            //IDE JÖNNEK MAJD A JEGYEK//
            $sql = "SELECT DISTINCT jegy.jegy, MONTH(jegy.datum) AS month, tantargy.nev
            FROM diak
            INNER JOIN evfolyam ON diak.id = evfolyam.diakid
            INNER JOIN tanev ON evfolyam.tanevid = tanev.id
            INNER JOIN osztaly ON evfolyam.osztalyid = osztaly.id
            INNER JOIN szak ON osztaly.szakid = szak.id
            INNER JOIN tantargyszak ON szak.id = tantargyszak.szakid
            INNER JOIN jegy ON evfolyam.id = jegy.evfolyamid
            INNER JOIN tantargy ON jegy.tantargyid = tantargy.id
            WHERE diak.id = 3 AND osztaly.id = 1 AND tanev.id = 1
            ORDER BY tantargy.nev, honap";
            
            $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                          
                    }
                }
            }
            //
            
            echo "</tr>";

        }
    }

  
    echo "</tbody>";
    echo "</table>";
    echo "<!-- DivTable.com -->";
    
    echo "</div>";


?>