<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'dbCommands.php';

connect();


global $conn;

//TANÉV
$sql = "SELECT tanev.id, tanev.tanev, tanev.kezdet, tanev.veg
FROM tanev
ORDER BY tanev.id DESC LIMIT 1";

$result = $conn->query($sql);
$tanev;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tanev = $row;
    }
}



//KIK BUKTAK
$sql = "SELECT evfolyam.id, tantargy.nev, AVG(jegy.jegy) AS atlag, osztaly.szam, osztaly.betu
  FROM jegy
  INNER JOIN evfolyam ON jegy.evfolyamid = evfolyam.id
  INNER JOIN diak ON evfolyam.diakid = diak.id
  INNER JOIN tantargy ON jegy.tantargyid = tantargy.id
  INNER JOIN osztaly ON evfolyam.osztalyid = osztaly.id
  WHERE evfolyam.tanevid = " . $tanev['id'] . "
  GROUP BY diak.nev, tantargy.nev";

$result = $conn->query($sql);

$buko = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["atlag"] < 1.75) {
            array_push($buko, $row["id"]);
        }
    }
}



//ÚJ TANÉV
$sql = "INSERT INTO tanev (tanev, kezdet, veg) 
VALUES ('" . ($tanev['kezdet'] + 1) . '/' . ($tanev['veg'] + 1) . "', " . ($tanev['kezdet'] + 1) . ",  " . ($tanev['veg'] + 1) . ")";
$conn->query($sql);



//ÚJ TANÉV ID
$sql = "SELECT tanev.id, tanev.tanev, tanev.kezdet, tanev.veg
FROM tanev
ORDER BY tanev.id DESC LIMIT 1";

$result = $conn->query($sql);
$tanevuj;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tanevuj = $row;
    }
}



//OSZTÁLYLÉPTETÉS AHOL A TANÉVKEZDÉS KISEBB MINT AZ OSZTÁLY BEFEJEZÉSE
$sql = "SELECT osztaly.szam, osztaly.befejezes, osztaly.betu, osztaly.kezdes, osztaly.szakid, evfolyam.diakid FROM osztaly INNER JOIN evfolyam ON osztaly.id = evfolyam.osztalyid "
        . "WHERE evfolyam.tanevid = " . $tanev['id'] . "";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['befejezes'] >= $tanevuj['kezdet']) {
            $sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) "
                    . "VALUES (" . ($row['szam'] + 1) . ", '" . ($row['betu']) . "',"
                    . "" . ($row['szakid']) . ", " . ($row['kezdes']) . ", " . ($row['befejezes']) . ")";
            
            $result2 = $conn->query($sql);
            var_dump($result2);
            
        }
    }
}




//ÚJ OSZTÁLY
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'A', 1, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
$conn->query($sql);
var_dump($sql);
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'B', 1, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
$conn->query($sql);
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'C', 2, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
$conn->query($sql);
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'D', 2, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
$conn->query($sql);




/*//DIÁKOK LÉPTETÉSE (csak azzal kell foglalkozni, aki megbukott)
$sql = "SELECT evfolyam.id, evfolyam.osztalyid, evfolyam.diakid FROM enaplov2.evfolyam"
        . " WHERE tanevid = " . $tanev['id'] . " ;";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (in_array($row["id"], $buko)) {
            //bukó
        } else {
            $sql = "INSERT INTO evfolyam(tanevid, osztalyid, diakid) VALUES(" . $tanevuj['id'] . ", " . $row['osztalyid'] . ", " . $row['diakid'] . ")";
            $conn->query($sql);
            var_dump($sql);
        }
    }
}*/


disconnect();
?>

