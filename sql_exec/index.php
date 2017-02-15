<html>
<head>

    <meta charset="UTF-8">

    <title>eNaplo</title>

    <style>
        body {
            margin-left: 20%;
            margin-right: 20%;
            padding: 0px;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 2ch;
        }

        #connects {
            background-color: lightblue;
            margin-top: 1%;
            text-align: center;
            font-size: 5ch;
        }

        #connects:hover {
            background-color: black;
            color: lightblue;
        }

        #questionmark {
            float: right;
            color: lightcoral;
            background-color: burlywood;
        }

        #questionmark:hover {
            color: red;
            cursor: pointer;
        }

        #variables {
            color: black;
            font-style: italic;
            font-weight: normal;
        }

        #variables2 {
            color: gray;
            float: right;
            margin-right: 10%;
        }

        #variables3 {
            float: left;
            margin-left: 10%;
        }

        #variables4 {
            color: gray;
            float: left;
            margin-left: 20%;
        }

        fieldset {
            background-color: aliceblue;
        }

        fieldset:hover {
            box-shadow: 5px 5px 2px #888888;
        }
    </style>



    <script>
        function showSQL(str) {
            alert(str);
        }
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
$servername = "localhost";
$username = "csongi";
$password = "";
$dbname = "nobeldij";
$conn;

//main
connect();
exercises();
disconnect();

function connect()
{
    global $servername, $username, $password, $dbname, $conn;
    echo "<div id='connects'>";
    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        mysqli_query($conn, "SET NAMES 'utf8'");
        echo "Connected<br>";
    } catch (Exception $ex) {
        die("Unable to connect (" + $ex + ")");
    }
    echo "</div>";
}

function disconnect()
{
    global $conn;
    echo "<div id='connects'>";
    mysqli_close($conn);
    echo "Disconnected";
    echo "</div>";
}

?>




</body>
</html>