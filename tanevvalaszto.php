<html>
    <head>

        <meta charset="UTF-8">

        <title>eNaplo</title>

        <style>
            @import "valasztoCSS.css";
        </style>


        <script>

        </script>

    </head>


    <body>


        <form action='leptet.php' >
            <input type = 'submit' />
        </form>

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

        function selectClass() {
            global $conn, $tableTanev, $tableSzak;

            echo "<div id='tanevek'>";
            echo "<div class='kiscim'>Tanév kiválasztása</div>";
            echo "<form action='osztalyvalaszto.php' method='get' class='valaszto'>";



            //Kiválasztjuk az összes évfolyamot, eltároljuk
            $sql = "SELECT * FROM " . $tableTanev . ";";
            $result = $conn->query($sql);



            //Kiirjuk az összes tanévet
            echo "<select size='1' name = 'tanevek'>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $str = $row["tanev"];
                    echo "<option value = '{$row["id"]}'>$str</option>";
                }
            }
            echo "</select><br>";



            //elküld gomb
            echo "<input type = 'submit' class='gomb'/><br>";

            echo "</div>";
        }

        
        ?>


    </body>
</html>