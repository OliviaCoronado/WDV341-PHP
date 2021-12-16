<?php 
    include 'dbConnect.php';

try{
    $sql = "SELECT * FROM wdv341_events" ; //saying - select (*ALL) the Columns from wdv341_event table   
                                          //best not to use the * - to much memory used       
    $stmt = $conn->prepare($sql);   //prepare the statement
                                    //connect to prepare(make in to sql)???
    $stmt->execute();           //the result Object is sitll in database format
}


catch(PDOException $e){ //catch block
    echo "Errors: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="example of meta">
    <meta name=viewpoint content="width=device=width, initial-scale=1.0">
    <title> WDV321 Intro Javascript</title>
        
    </head>

    <body>
    <h1> All Events for the Events Table</h1>
    
<?php

foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){ 
    echo "<p>";
    echo $row['events_id'];
    echo "<br>";
    echo $row['events_name'];
    echo "<br>";
    echo $row['events_description'];
    echo "<p>";
    echo "<p><a href='updateEvent.php?eventsId=". $row["events_id"] . "'>Update</p>";
    echo "<p><a href='deleteEvent.php?eventsId=". $row["events_id"] . "'> Delete </a></p>"; 
}


?>
    </body>
   
</html>