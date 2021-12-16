<?php 
//pass the selecte event id as a GET parameter on the url


//Access the GET parameter from the name/value pair eventsId=?
echo $_GET['eventsId'];
$deleteId = $_GET['eventsId'];

//How to connect to database
    //-connect to the db
    //-write the SQL stmt
    //-prepare the statement
    //-bind prarmeters(if any)
    //-excute statement
    //confirm/error check...
try{
    require 'dbConnect.php';

        $sql = "DELETE FROM wdv341_events WHERE events_id=:eventsId"; 
        $stmt = $conn->prepare($sql);  
        $stmt->bindParam(':eventsId' ,$deleteId);
        $stmt->execute();
}
        catch(PDOException $e)
        {
            $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
    
            error_log($e->getMessage());
            error_log(var_dump(debug_backtrace()));				
        }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name=viewpoint content="width=device=width, initial-scale=1.0">
        <title> Delete</title>

    </head>

    <body>
    <h1>Delete Event Page</h1>



        
    </body>
</html>