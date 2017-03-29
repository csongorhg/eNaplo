<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'dbCommands.php';

//main
connect();

delete();

disconnect();

function delete() {
    
    global $conn, $tableJegy;
    
    //$del = json_decode($_POST["torol"]);
    //echo "asd: ".$del[0];
    $sql = "DELETE FROM ".$tableJegy." WHERE ".$tableJegy.".id = 7";
        $conn->query($sql);
       
}

?>