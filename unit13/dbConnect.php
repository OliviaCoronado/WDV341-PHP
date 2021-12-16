<?php 
//This file creates a 'connection object' to our database.
$database = "wdv341";             //name of database
$serverName= "localhost";   //name of server ---most default to localhost
$username= "root";          //username for the database ---NOT your Account -make different
$password="";              //password for the database --NOT your Acount -make different

try{    //try block --in

    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password); //can call whatever($conn)- the connection object/variable
   //variable = new PDO object("connect to mysql: host name(usually localhost); database", pass in the user and pw);

        //set the PDO error mode to exception

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected Successfully";      //if it breaks, then do this ERROR message instead of breaking completely.

}

//catch(datatype $variable) variable can be call whatever
catch(PDOException $e){        //catch block  --out

    echo "Connection Failed: " . $e->getMessage();       //the (->) arrow basically means- $e.getMessage() --object.notation - b/c ( . ) is concatenation in PHP

                                                    //only works for PDO exception, it something is wrong somewhere else - Will NOT do anything.
}

?>