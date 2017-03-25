
<head>
    <link rel="stylesheet" href="komplexCSS.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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

function selectYears() {
    global $conn, $tableTantargy, $tableDiak, $tableEvfolyam, $tableTanev, $tableOsztaly, $tableSzak, $tableTantargySzak, $tableJegy;

    echo '<script type="text/javascript">',
    'jegyvalto();',
    '</script>'
    ;

    echo "<div id='jegyek'>";



    //Kapott érték
    $osztaly = $_GET["osztalyok"];
    $osztaly = mysqli_real_escape_string($conn, $osztaly); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
    $tanev = $_GET["tanevek"];
    $tanev = mysqli_real_escape_string($conn, $tanev);
    $diak = $_GET["diakok"];
    $diak = mysqli_real_escape_string($conn, $diak); //ellenőrzi az átadott adat hitelességér -> nem lehet módositani a lekérdezést
    //Kiválasztjuk a diák osztálya alapján a lehetséges tantárgyakat
    $sql = "SELECT " . $tableTantargy . ".nev, " . $tableTantargy . ".id
            FROM " . $tableDiak . "   
            INNER JOIN " . $tableEvfolyam . " ON " . $tableDiak . ".id = " . $tableEvfolyam . ".diakid
            INNER JOIN " . $tableTanev . " ON " . $tableEvfolyam . ".tanevid = " . $tableTanev . ".id
            INNER JOIN " . $tableOsztaly . " ON " . $tableEvfolyam . ".osztalyid = " . $tableOsztaly . ".id
            INNER JOIN " . $tableSzak . " ON " . $tableOsztaly . ".szakid = " . $tableSzak . ".id
            INNER JOIN " . $tableTantargySzak . " ON " . $tableSzak . ".id = " . $tableTantargySzak . ".szakid
            INNER JOIN " . $tableTantargy . " ON " . $tableTantargySzak . ".tantargyid = " . $tableTantargy . ".id
            WHERE " . $tableDiak . ".id = " . $diak . " AND " . $tableOsztaly . ".id = " . $osztaly . " AND " . $tableTanev . ".id = " . $tanev . ""
            . " ORDER BY " . $tableTantargy . ".nev ";
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
            echo "<td class='month'>$str</td>";

            for ($x = 9; $x <= 12; $x++) { //hónapok végigjárása 9 azaz szeptembertől kezdve
                //IDE JÖNNEK A JEGYEK//
                $sql2 = "SELECT jegy.id, jegy.evfolyamid, jegy.jegy, DAY(jegy.datum) AS days, tanar.nev
            FROM jegy INNER JOIN evfolyam ON jegy.evfolyamid = evfolyam.id
            INNER JOIN osztaly ON evfolyam.osztalyid = osztaly.id
            INNER JOIN diak ON evfolyam.diakid = diak.id
            INNER JOIN tanev ON evfolyam.tanevid = tanev.id
            INNER JOIN tantargy ON jegy.tantargyid = tantargy.id
            INNER JOIN tanar ON jegy.tanarid = tanar.id 
            WHERE " . $tableDiak . ".id = " . $diak . " AND " . $tableOsztaly . ".id = " . $osztaly . " AND " . $tableTanev . ".id = " . $tanev . " "
                        . "AND " . $tableTantargy . ".id = " . $row["id"] . " AND MONTH(" . $tableJegy . ".datum) = " . $x . "
            ORDER BY " . $tableJegy . ".datum";

                $jegyek = NULL; //itt lesznek eltárolva a jegyek az adott hónaphoz
                $jegyid = NULL; //jegy id-k
                $tanarnev = NULL;
                $jegynap = NULL;

                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $jegyek .= $row2["jegy"] . ", ";
                        $jegyid .= $row2["id"] . ", "; 
                        $tanarnev .= $row2["nev"] . ", ";
                        var_dump($tanarnev);
                        $jegynap .= $row2["days"] . ", ";
                        var_dump($jegynap);
                    }
                }
                $jegyek = substr($jegyek, 0, -2); //utolsó vessző nem kell
                echo "<td class='jegyek' onclick='jegyvalto(this, [" . $jegyid . "]);'>$jegyek</td>";
                if ($x == 12) {//ha elértük decembert akkor előről azaz 0
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

echo "<!-- The Modal -->";
echo "<div id='myModal' class='modal'>";

echo "<!-- Modal content -->";
echo "<div class='modal-content'>";
echo "<div class='modal-header'>";
echo "<span class='close'>&times;</span>";
echo "<h2>Jegyek</h2>";
echo "</div>";
echo "<div class='modal-body'>";
/* echo "<p>Some text in the Modal Body</p>";
  echo "<p>Some other text...</p>"; */
echo "</div>";
echo "<div class='modal-footer'>";
echo "<div id = 'felv' >Új jegy</div>";
echo "<div id = 'felvtorl' >Törlés</div>";
echo "</div>";
echo "</div>";

echo "</div>";

echo "</tbody>";
echo "</table>";

echo "</div>";
?>

<body>
    <script type="text/javascript">

        function jegyvalto(jegyek, jegyid) {
            (jegyek.innerHTML).replace(" ", "");
            //(jegyek.innerHTML).split(",");
            //alert(jegyid[1]);
            //alert(tanar[0]);
            $modal = $('#myModal');
            $modalBody = $(".modal-body");

            var htmlString = "";
            $modalBody.empty();

            $modalBody.append("<div class='container'>");
            for (var i = 0; i < (jegyek.innerHTML.split(",")).length; i++) {
                //jegyid[i]
                htmlString = (jegyek.innerHTML).split(",")[i];
                if (htmlString)
                    $modalBody.append("<input type='checkbox' /> " + htmlString + " <br />");
            }
            $modalBody.append("</div>");

            $span = $(".close")[0];

            $modal.css("display", "block");

            $span.onclick = function () {
                $modal.css("display", "none");
            }

            window.onclick = function (event) {
                if (event.target === document.getElementById('myModal')) { //itt valamiért nem müködött a $(#..)
                    $modal.css("display", "none");
                }
            }
        }

    </script>
</body>

