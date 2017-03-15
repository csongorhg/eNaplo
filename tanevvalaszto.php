<html>
<head>

    <meta charset="UTF-8">

    <title>eNaplo</title>

    <style>

    </style>


    <script>

    </script>

</head>


<body>


<?php
/**
 * Created by PhpStorm.
 * User: mordes
 * Date: 2017.02.15.
 * Time: 17:54
 */

include 'dbCommands.php';

//main
connect();

selectClass();

disconnect();




function selectClass()
{
    global $conn, $tableTanev;

    echo "<div id='tanevek'>";
    echo "<form action='osztalyvalaszto.php' method='get'>";



    //Kiválasztjuk az összes évfolyamot, eltároljuk
    $sql = "SELECT * FROM ".$tableTanev.";";
    echo "Tanév<br>";
    $result = $conn->query($sql);



    //Kiirjuk az összes tanévet
    echo "<select size='1' name = 'tanevek'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str = $row["tanev"];
            echo "<option value = '{$row["id"]}'>$str</option>";
        }
    }
    echo "</select>";

    

    //elküld gomb
    echo "<input type = 'submit' />";

    echo "</form>";
    echo "</div>";

}


?>


</body>
</html>