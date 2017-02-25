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
    global $conn;

    echo "<div id='jegyek'>";



    //Kapott érték
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést



    //Kiválasztjuk a diák osztálya alapján a lehetséges tantárgyakat
    $sql = "SELECT DISTINCT tantargy.nev
FROM diak
INNER JOIN osztaly ON diak.osztalyID = osztaly.id
INNER JOIN tantargyszak ON osztaly.szak = tantargyszak.kategoriaszak
INNER JOIN tantargy ON tantargyszak.tantargyid = tantargy.id
WHERE diak.id = 1";
    echo "Jegyek...<br>";
    $result = $conn->query($sql);



    //Kiirjuk az összes tanévet
    /*echo " <select size = '1' name = 'tanevek'> ";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["tanev"];
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select > ";*/


    /*
     <div class="divTable">
<div class="divTableBody">
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
<div class="divTableRow">
<div class="divTableCell">&nbsp;</div>
<div class="divTableCell">&nbsp;</div>
</div>
</div>
</div>
<!-- DivTable.com -->

     * */



    //elküld gomb

    echo "</div > ";
}

?>