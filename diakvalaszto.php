<head>
    <link href="valasztoCSS.css" rel="stylesheet" type="text/css"/>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</head>

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

function selectStudent() {
    global $conn, $tableDiak, $tableEvfolyam, $tableTanev, $tableOsztaly;

    echo "<div id='diakok'>";
    echo "<div class='kiscim'>Válasszon a diákok közül!</div>";
    echo "<form action='jegyvalaszto.php' method='get' class='valaszto'>";



    //Kapott érték
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev);
    $osztaly = $_GET["osztalyok"];
    $osztaly = mysqli_real_escape_string($conn, $osztaly); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
    //Kiválasztjuk a kapott évfolyam és osztály alapján az abba tartozó diákokat
    $sql = "SELECT " . $tableDiak . ".id, " . $tableDiak . ".nev, " . $tableDiak . ".szuletes 
            FROM " . $tableDiak . "
            INNER JOIN " . $tableEvfolyam . " ON " . $tableDiak . ".id = " . $tableEvfolyam . ".diakid
            INNER JOIN " . $tableTanev . " ON " . $tableEvfolyam . ".tanevid = " . $tableTanev . ".id
            INNER JOIN " . $tableOsztaly . " ON " . $tableEvfolyam . ".osztalyid = " . $tableOsztaly . ".id
            WHERE " . $tableOsztaly . ".id = " . $osztaly . " AND " . $tableTanev . ".id = " . $tanev . ";";
    //echo "Név<br>";
    $result = $conn->query($sql);



    //Kiirjuk az összes diákot
    echo "<select size='1' name ='diakok'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["nev"];
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select><br>";



    //elküld gomb
    echo "<input type = 'submit' class='gomb'/>";
    echo "<input type = 'hidden' name='osztalyok' value='$osztaly' />";
    echo "<input type = 'hidden' name='tanevek' value='$tanev' />";


    echo "</form>";
    
    echo "<button class='vissza' onclick='goBack()'>Go Back</button>";
    
    echo "</div>";
}
?>