<?php 
session_start();
/*algorithm
    Display avaibale information to update
        use the selectEvent.php page -DONE
    Make a way to select a specific item to be updated - attabeck a recored id
        create a update link with the recored id passed  as GET parameter - DONE

    Display the information of selected item on the update form - same as ADD/input form
        if(form has been submitted){
            process form data
            do database UPDATED stuff
        }
        else{
            get the selected record from the database
            populate the fields
            display the form to the user so they can make changes
        }

    Allow the user to make Changes
    Update the database with the information when the user clicks Save/Update
*/
    
/*
        if(form has been submitted){
            process form data
            do database UPDATED stuff
        }
        else{
            get the selected record from the database
            populate the fields
            display the form to the user so they can make changes
        }
*/
$newEventId = $_GET['eventsId'];    //Problem is here. neither eventsId or eventId work.
//echo  $_GET['eventsId']


if(isset($_POST['submit'])){
    echo "FORM HAS BEEN SUBMITTED!";

    $eventName= $_POST['events_name'];
    $eventDesc = $_POST['events_description'];
    $eventPres = $_POST['events_presenter'];

    try{
        require 'dbConnect.php'; 
    //Need to do an UPDATE
        $sql = "UPDATE wdv341_events SET events_name=eventName, events_description=:eventDesc, events_presenter=:eventsPresenter WHERE events_id=:newEventId"; 
        $stmt = $conn->prepare($sql); 

        $stmt->bindParam(':eventName' ,$eventName);
        $stmt->bindParam(':eventDesc' ,$eventDesc);
        $stmt->bindParam(':eventPres' ,$eventPres);
        $stmt->bindParam(':newEventId', $newEventId);
        $stmt->execute();

        //echo "Works so far!!"; //basic confirmation message - NEEDS IMPROVED!!

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
    //get data and display it on the form

    try{
        require 'dbConnect.php'; 
            $sql = "SELECT * FROM wdv341_events WHERE events_id=:eventsId";
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':eventsId' ,$newEventId);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //Check for success- I should have at least 1 row. If no rows I have an error.
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
    <h2>Update Page </h2>

    <form method="POST" action="updateEvent.php?eventId=<?php echo $newEventId; ?>">

        <p>
            <label for="events_name"> Event Name: </label>
            <input type="text" name="events_name" id="events_name" value="<?php echo $result['events_name'];  ?>">
        
        </p>

        <p>
            <label for="events_description">Event Description</label>
            <input type="text" name="events_description" id="events_description" value="<?php echo $result['events_description'];  ?>">
        </p>

        <p>
            <label for="events_presenter">Event Presenter</label>
            <input type="text" name="events_presenter" id="events_presenter" value="<?php echo $result['events_presenter'];  ?>">
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