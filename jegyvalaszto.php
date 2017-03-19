
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
    global $conn, $tableTantargy, $tableDiak, $tableEvfolyam, $tableTanev, $tableOsztaly, $tableSzak, $tableTantargySzak, $tableJegy;

    echo "<div id='jegyek'>";



    //Kapott érték
    $osztaly = $_GET["osztalyok"];
    $osztaly = mysqli_real_escape_string($conn, $osztaly); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev);
    $diak = $_GET["diakok"];
    $diak = mysqli_real_escape_string($conn, $diak); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
        


    //Kiválasztjuk a diák osztálya alapján a lehetséges tantárgyakat
    $sql = "SELECT ".$tableTantargy.".nev, ".$tableTantargy.".id
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
            
            for ($x = 9; $x <= 12; $x++) { //hónapok végigjárása 9 azaz szeptembertől kezdve
                
            //IDE JÖNNEK A JEGYEK//
            $sql2 = "SELECT jegy.evfolyamid, jegy.jegy, tantargy.nev, MONTH(jegy.datum) AS months
            FROM jegy INNER JOIN evfolyam ON jegy.evfolyamid = evfolyam.id
            INNER JOIN osztaly ON evfolyam.osztalyid = osztaly.id
            INNER JOIN diak ON evfolyam.diakid = diak.id
            INNER JOIN tanev ON evfolyam.tanevid = tanev.id
            INNER JOIN tantargy ON jegy.tantargyid = tantargy.id
            WHERE ".$tableDiak.".id = ".$diak." AND ".$tableOsztaly.".id = ".$osztaly." AND ".$tableTanev.".id = ".$tanev." "
            ."AND ".$tableTantargy.".id = ".$row["id"]." AND MONTH(".$tableJegy.".datum) = ".$x."
            ORDER BY ".$tableJegy.".datum";
            
            $jegyek = ""; //itt lesznek eltárolva a jegyek az adott hónaphoz
            $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                          $jegyek .=$row2["jegy"].", ";
                    }
                }
                $jegyek = substr($jegyek, 0, -2); //utolsó vessző nem kell
                echo "<td class='month' >$jegyek</td>";
                
                if ($x == 12) {//ha elértük decembert akkor előről azaz 1
                    $x = 0;
                }
                if ($x == 6) {//ha június akkor vége
                     break; 
                }
            }
            //
            
                
            echo "</tr>";
            } 
        }
    }

  
    echo "</tbody>";
    echo "</table>";
    echo "<!-- DivTable.com -->";
    
    echo "</div>";


?>