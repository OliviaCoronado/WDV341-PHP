<?php 
//if you are a valid user then you can access this page else redirect to login page
session_start();

if(isset( $_SESSION['validUser']) && $_SESSION['validUser']){
    //allow access
}
else{
    //deny access, returen to login page/homepage
    header("Location: login.php");
}
/*The algorithm
    if(form is submitted){
        process form data
        do database stuff
    }
    else{
        display form
    }

    isset(_Post)
*/

//How to connect to a database!!
    //-connect to database
    //-create the SQL statement
    //-prepare the SQL statement
    //-bind parametters into the prepared statement
    //-execute the prepared statement
//extra stuff  
    //display a confirmation message
    //create honeyPot 

if(isset($_POST['presenter_message']) && $_POST['presenter_message'] !="")//https://www.youtube.com/watch?v=fdIsENbgBn8
        //Checking to see if honeyPot is filled out
    die(); 

/* --honey pot but I can't get it to work.
if(isset($_POST['submit'])){
    echo "FORM HAS BEEN SUBMITTED!";

    $presenterMessage = $_POST['presenter_message'];

    if(!empty($presenterMessage)){
        //invalid form - send error
        //stop process
        //return to homepage/form/etc....
        echo "try again";
    }
}
*/
if(isset($_POST['submit'])){
    echo "FORM HAS BEEN SUBMITTED!";

    $eventName = $_POST['events_name'];
    $eventDesc = $_POST['events_description'];
    $eventPres = $_POST['events_presenter'];


    try{
    //connect to database    
        require 'dbConnect.php'; 
    //create the SQL statement
        $sql = "INSERT INTO wdv341_events (events_name, events_description, events_presenter) 
        VALUES (:eventName,:eventDesc,:eventPres)"; //name placeholders
    //prepare the SQL statement   
        $stmt = $conn->prepare($sql);
        
    //bind parametters into the prepared statement       
        $stmt->bindParam(':eventName' ,$eventName);
        $stmt->bindParam(':eventDesc' ,$eventDesc);
        $stmt->bindParam(':eventPres' ,$eventPres);
    //execute the prepared statement
        $stmt->execute();


        echo "Works so far!!"; //basic confirmation message - NEEDS IMPROVED!!

    // echo $conn->lastInsertId(); // have to comment out the header first - check if it is working - WORKS
        $newEventId = $conn->lastInsertId();   //create a variable for it - put header back ON and concatinate the new variable into Header!

    //send to a 'response page' to display to customer that everthing worked
        //header('Location: eventResponsePage.php?eventId=1');      //hard code testing- just to check it works
        header('Location: eventResponsePage.php?eventId=' . $newEventId);

    }

    catch(PDOException $e)
    {
        $message = "There has been a problem. The system administrator has been contacted. Please try again later.";

        error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
        error_log(var_dump(debug_backtrace()));
    
        //Clean up any variables or connections that have been left hanging by this error.		
    
        //header('Location: files/505_error_response_page.php');	//sends control to a User friendly page					
    }

}
else{
    echo "FORM NOT SUBMITTED!";

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name=viewpoint content="width=device=width, initial-scale=1.0">
    <title> Event Input Form</title>
    <style>
            .formField{
        display: none;
    }</style>

    <script>
    </script>

</head>

<body>
    <h1>WDV341 Advance JavaScript</h1>
    <h2>11-1 Input Event Form </h2>

    <form method="POST" action="inputEvent.php">

        <p>
            <label for="event_name"> Event Name: </label>
            <input type="text" name="events_name" id="events_name">
        
        </p>
        <p>
            <label for="events_description">Event Description</label>
            <input type="text" name="events_description" id="events_description">
        </p>
        <p>
            <label for="events_presenter">Event Presenter</label>
            <input type="text" name="events_presenter" id="events_presenter">
        </p>

        <p class="formField">
			<label for="presenter_message">Message: </label>
			<input type="text" name="presenter_message" id="presenter_message">
		</p>

        <p>
            <input type="submit" value="submit" name="submit">
            <input type="reset" value="Try Again">
        </p>
</body>

</html>

<?php
} //end of else
?>