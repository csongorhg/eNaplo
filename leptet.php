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
echo "<br><br>";

$result = $conn->query($sql);
$tanev;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tanev = $row;
    }
}



//NEM HASZNÁLT OSZTÁLYOK TÖRLÉSE
$sql = "DELETE FROM osztaly WHERE NOT EXISTS (SELECT 1 FROM evfolyam WHERE evfolyam.osztalyid = osztaly.id)";
$conn->query($sql);



//KIK BUKTAK
$sql = "SELECT diak.id, tantargy.nev, AVG(jegy.jegy) AS atlag, osztaly.szam, osztaly.betu
  FROM jegy
  INNER JOIN evfolyam ON jegy.evfolyamid = evfolyam.id
  INNER JOIN diak ON evfolyam.diakid = diak.id
  INNER JOIN tantargy ON jegy.tantargyid = tantargy.id
  INNER JOIN osztaly ON evfolyam.osztalyid = osztaly.id
  WHERE evfolyam.tanevid = " . $tanev['id'] . "
  GROUP BY diak.nev, tantargy.nev";
echo "<br><br>";
$result = $conn->query($sql);

$buko = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["atlag"] < 1.75 && $row["atlag"] != 0) {
            array_push($buko, $row["id"]);
        }
    }
}



//ÚJ TANÉV
$sql = "INSERT INTO tanev (tanev, kezdet, veg) 
VALUES ('" . ($tanev['kezdet'] + 1) . '/' . ($tanev['veg'] + 1) . "', " . ($tanev['kezdet'] + 1) . ",  " . ($tanev['veg'] + 1) . ")";
$conn->query($sql);
echo "<br><br>";



//ÚJ TANÉV ID
$sql = "SELECT tanev.id, tanev.tanev, tanev.kezdet, tanev.veg
FROM tanev
ORDER BY tanev.id DESC LIMIT 1";
echo "<br><br>";

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
echo "<br><br>";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['befejezes'] >= $tanevuj['kezdet']) {
            $sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) "
                    . "VALUES (" . ($row['szam'] + 1) . ", '" . ($row['betu']) . "',"
                    . "" . ($row['szakid']) . ", " . ($row['kezdes']) . ", " . ($row['befejezes']) . ")";
            echo "<br><br>";
            $result2 = $conn->query($sql);
        }
    }
}



//DIÁKOK ÁTHELYEZÉSE OSZTÁLYOKBA (AKI BUKIK [VALAMELY TÁRGYBÓL AVG<1.75] NEM KERÜL FELJEBB
//AKINEK NINCS JEGYE TOVÁBBMEGY   )
$sql = "SELECT evfolyam.diakid, osztaly.szam, osztaly.betu, evfolyam.osztalyid,
osztaly.szakid, osztaly.kezdes, osztaly.befejezes FROM osztaly
INNER JOIN evfolyam ON osztaly.id = evfolyam.osztalyid INNER JOIN tanev ON evfolyam.tanevid = tanev.id 
INNER JOIN diak ON evfolyam.diakid = diak.id
WHERE tanev.id = " . $tanev['id'] . "";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        if ($row['szam'] != 12) {
            var_dump($row["diakid"]);
            echo "<br>";
            var_dump($buko);
            if (!(in_array($row["diakid"], $buko))) {//ha nem bukott
                $sql = "SELECT osztaly.id FROM osztaly "
                        . "WHERE osztaly.szam = " . ($row['szam'] + 1) . " AND osztaly.betu LIKE('" . $row['betu'] . "')
            ORDER BY osztaly.id DESC LIMIT 1";

                $result2 = $conn->query($sql);

                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $sql = "INSERT INTO evfolyam(tanevid, osztalyid, diakid)"
                                . " VALUES (" . $tanevuj['id'] . ", " . $row2['id'] . ", " . $row['diakid'] . " )";
                        $conn->query($sql);
                    }
                }
            } else {//buko
                $sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) "
                        . "VALUES(" . $row['szam'] . ", " . $row['betu'] . ", " . $row['szakid'] .
                        ", " . ($row['kezdes'] + 1) . ", " . ($row['befejezes'] + 1) . ")";
                $conn->query($sql);

                $sql = "SELECT osztaly.id FROM osztaly "
                        . "WHERE osztaly.szam = " . ($row['szam']) . " AND osztaly.betu LIKE('" . $row['betu'] . "')
                        ORDER BY osztaly.id DESC LIMIT 1";
                $result2 = $conn->query($sql);

                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $sql = "INSERT INTO evfolyam(tanevid, osztalyid, diakid)"
                                . " VALUES (" . $tanevuj['id'] . ", " . $row2['id'] . ", " . $row['diakid'] . " )";
                        var_dump($sql);
                        echo "<br>";
                        $conn->query($sql);
                    }
                }
            }
        }
    }
}



//ÚJ OSZTÁLY (9-esek)
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'A', 1, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
echo "<br><br>";
$conn->query($sql);
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'B', 1, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
echo "<br><br>";
$conn->query($sql);
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'C', 2, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
echo "<br><br>";
$conn->query($sql);
$sql = "INSERT INTO osztaly(szam, betu, szakid, kezdes, befejezes) VALUES (9, 'D', 2, " . $tanevuj['kezdet'] . ", " . ($tanevuj['kezdet'] + 4) . ")";
echo "<br><br>";
$conn->query($sql);



disconnect();

header('Location: tanevvalaszto.php');
exit;

?>

