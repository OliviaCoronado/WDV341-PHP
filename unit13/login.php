<?php 
session_start();        //allow access to the application session
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
    //try & Catch structure
    //connect to database
    //create the SQL statement
    //prepare the SQL statement
    //bind parametters into the prepared statement
    //execute the prepared statement
        //LOGIN -
            //How do we tell that we have a valid user?
            //  if the SELECT returns at least one recored - assume valid user
            //  if the SELECT returns 0 records - assume invalid user

            //if you have a valid username/pw then display admin info
            //else display "Invalid username/pw" and display form again!

    $validUser = false; // assume invalid user until sign on
    $errMsg = "";

if( isset($_POST['submit']) ){
    echo "Form had been submitted!";

    $loginName = $_POST{'loginName'};
    $loginPW = $_POST{'loginPassword'};

    //echo $loginUserName; //Test - Works
    //echo $loginPW;    //Test - Works

    try{
        //connect to database    
            require 'dbConnect.php'; 
        //create the SQL statement
            $sql = "SELECT event_user_name, event_user_password FROM event_user WHERE event_user_name=:userName AND event_user_password=:userPW";
        //prepare the SQL statement   
            $stmt = $conn->prepare($sql);
            
        //bind parametters into the prepared statement       
            $stmt->bindParam(':userName' ,$loginName);
            $stmt->bindParam(':userPW' ,$loginPW);
           
        //execute the prepared statement
            $stmt->execute();
/*
        // How do we know that we have a valid users????
            $count = $stmt->fetchColumn();
            //echo "Found $count rows in event_user table!! "; //checking to see if there is valid account
            if($count == ""){
                echo " INVALID username/password. display error & form";
            }
            else{
                echo " Welcome Back $count!";
            }
*/
        // How do we know that we have a valid users???? -Useing fedchAll() 
           $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

           $numRows = count($resultArray);
            echo " Number of rows found: $numRows ";
             if($numRows == 1){
                    $_SESSION['validUser'] = true; //set session variable for this user
                    $validUser = true; //valid User
                    //Display Admin Option
             }
             else{
                    //Invalid User
                    //Display Form and Error message "invalid username/password"
                    $errMsg = "Invalid username/password. Please try again!";
             }



            echo " Works so far!!"; //testing
    
    
        }
    
        catch(PDOException $e)
        {
            $message = "There has been a problem. The system administrator has been contacted. Please try again later!";
    
            error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
            error_log(var_dump(debug_backtrace()));
        
            //Clean up any variables or connections that have been left hanging by this error.		
        
            //header('Location: files/505_error_response_page.php');	//sends control to a User friendly page					
        }
    
}//end if

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name=viewpoint content="width=device=width, initial-scale=1.0">
        <title> Document</title>


    </head>

    <body>
    <h1>My Company Sign On Page</h1>
    <?php 
        /*
        if you have a vlaid user diplay Block 1 (admin)
        else display Block 2(form)
        */
        if($validUser){
    ?>  
        <div> <!--Block 1 Display this to a valid user AFTER signing on -->
            <h3>Welcome to the Admin Area for Valid Users </h3>
            <p>You have the following options available as an administrator for this application. </p>
                <ol>
                    <li><a href="demo_inputEvent.php">Input new products</a></li>
                    <li>Delete products from the datebase</li>
                    <li>Select products to update</li>
                    <li><a href="logout.php">Log off of admin system</a></li>
                </ol>
        </div> 

    <?php 
        }
        else{
            echo "<h3> $errMsg </h3>";
    ?>
    <div><!--Block 2 Display this block when you link to this page -->
        <form method="POST" action="login.php">
            <div>
                <label for="loginName">Username:</label>
                <input type="text" name="loginName" id="loginName">
            </div>
            <div>
                <label for="loginPassword">Password: </label>
                <input type="password" name="loginPassword" id="loginPassword">
            </div>

            <div>
                <input type="submit"  name="submit" value="Sign On">
                <input type="reset">
            </div>
        </form>  
    </div>

    <?php
        } //End of (validUser) if/else
    ?>
    
    </body>
</html>
