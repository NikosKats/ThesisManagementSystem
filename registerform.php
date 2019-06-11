<?php
//Database connection
include('connect.php'); 
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Register Form</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

          <style>
        body{
            background-image: url("images/img3.jpg");
        }
        label{
            color:white;
        }
        p{
            color:white;
        }
        a
        {
            color:white;
            font-family: verdana;
            font-size: 20px;
        }
        a:hover
        {
            color:green;
        }
        
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>

<?php
	// init variables
	$min_number = 1;
	$max_number = 15;

	// generating random numbers
	$random_number1 = mt_rand($min_number, $max_number);
	$random_number2 = mt_rand($min_number, $max_number);
?>

    <div class="container">

        <form style="margin-top: 50px;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            
                       <?php
                            $captchaResult = $_POST["captchaResult"];
                            $firstNumber = $_POST["firstNumber"];
                            $secondNumber = $_POST["secondNumber"];

                            $checkTotal = $firstNumber + $secondNumber;
                            
                                //Declaring variables to prevent errors
                                $name = "";
                                $surname = "";
                                $email = "";
                                $password = "";
                                $confirm_password = "";
                                $role = "";
                                $error_array = array(); //Holds error messages
                            
                            if(isset($_POST['register']))
                            {
                                //First name
                                $name = strip_tags($_POST['name']); //Remove html tags
                                $name = str_replace(' ', '', $name); //remove spaces
                                $name = ucfirst(strtolower($name)); //Uppercase first letter
                                $_SESSION['name'] = $name; //Stores first name into session variable
                                
                                //Last name
                                $surname = strip_tags($_POST['surname']); //Remove html tags
                                $surname = str_replace(' ', '', $surname); //remove spaces
                                $surname = ucfirst(strtolower($surname)); //Uppercase first letter
                                $_SESSION['surname'] = $surname; //Stores last name into session variable
                                
                                //email
                                $email = strip_tags($_POST['email']); //Remove html tags
                                $email = str_replace(' ', '', $email); //remove spaces
                                $email = ucfirst(strtolower($email)); //Uppercase first letter
                                $_SESSION['email'] = $email; //Stores email into session variable
                                
                                //Password
                                $password = strip_tags($_POST['password']); //Remove html tags
                                $confirm_password = strip_tags($_POST['confirm_password']); //Remove html tags
                                
                                //Role
                                $role = strip_tags($_POST['role']); //Remove html tags
                                $_SESSION['role'] = $role; //Stores role into session variable
                                
                                
                                
                               //Check if email is in valid format 
                                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

                                        //Check if email already exists 
                                        $e_check = mysqli_query($conn, "SELECT email FROM auth_users WHERE email='$email'");

                                        //Count the number of rows returned
                                        $num_rows = mysqli_num_rows($e_check);

                                        if($num_rows > 0) {
                                                array_push($error_array, "Email already in use<br>");
                                        }

                                }
                                else {
                                        array_push($error_array, "Invalid email format<br>");
                                }   
                                
                                if(strlen($name) > 25 || strlen($name) < 2) {
                                        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
                                }

                                if(strlen($surname) > 25 || strlen($surname) < 2) {
                                        array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
                                }

                                if($password != $confirm_password) {
                                        array_push($error_array,  "Your passwords do not match<br>");
                                }
                                else {
                                        if(preg_match('/[^A-Za-z0-9]/', $password)) {
                                                array_push($error_array, "Your password can only contain english characters or numbers<br>");
                                        }
                                }

                                if(strlen($password > 30 || strlen($password) < 5)) {
                                        array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
                                }
                                
                                
                                
                                if(!is_numeric($role))
                                {
                                    array_push($error_array, "Role must be 1 for student or 2 for teacher<br>"); 
                                }
                                elseif($role != "1" && $role != "2")
                                {
                                    array_push($error_array, "Role must be 1 for student or 2 for teacher<br>"); 
                                }
                                
                                
                                if ($captchaResult == $checkTotal && empty($error_array))
                                {
                                    
                                        
                                        
                                        $name = ucfirst($_POST['name']);
                                        $surname = ucfirst($_POST['surname']);
                                        $email = $_POST['email'];
                                        $password = $_POST['password'];
                                        $confirm_password = $_POST['confirm_password'];
                                        $role = $_POST['role'];
                                        
                                        $e_password = $password;
                                        
                                        $hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
                                        $password = md5($password);
                                        $confirm_password = md5($confirm_password);
                                        //sql query for inserting users into table auth_users
                                        $sql = "INSERT INTO auth_users (name,surname,email,password,confirm_password,role,hash) VALUES('$name','$surname','$email','$password','$confirm_password','$role','$hash')";
                                        
                                          /*
                                             *****************************
                                             ****** php mail start********
                                             *****************************
                                             */

                                            $to      = $email; // Send email to our user
                                            $subject = 'Signup | Verification'; // Give the email a subject 
                                            $message = '

                                            Thanks for signing up '.$name.' '.$surname.'!
                                            Your account has been created, you can login with the following credentials
                                            after you have activated your account by pressing the url below.

                                            ------------------------
                                            Email: '.$email.'
                                            Password: '.$e_password.'
                                            ------------------------

                                            Please click this link to activate your account:
                                            http://localhost:8888/PhpProjectWebProgramming/verify.php?email='.$email.'&hash='.$hash.'
                                                
                                            
                                            '; // Our message above including the link

                                            $headers = 'From:noreply@yourwebsite.com' . "\r\n".'X-Mailer: PHP/' . phpversion(); // Set from headers
                                            mail($to, $subject, $message, $headers); // Send our email

                                            /*
                                             *****************************
                                             ****** php mail end**********
                                             *****************************
                                             */
                                        
                                        
                                        if ($conn->query($sql) === TRUE) {
                                            echo "<h2 style=\"color:green;\">Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.</h2>";
                                            
                                        
                                            

                                            
                                        } 
                                        else {
                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                        }
                                        
                                     
                                }
                                elseif($captchaResult == $checkTotal && !empty($error_array))
                                {
                                    echo "<h2>Captcha OK but fields have errors.</h2>";
                                }
                                
                                 else 
                                {
                                    echo "<h2 style=\"color:red;\">Wrong Captcha. Try Again</h2>";
                                }
                                
                               
                                
                            } 
                            
                        ?>
            

            
                <div class="form-group row">
                <label for="formGroupExampleInput">Name:*</label>
                <input type="text" name="name" value="<?php 
					if(isset($_SESSION['name'])) {
						echo $_SESSION['name'];
					} 
					?>" class="form-control" id="formGroupExampleInput2" />
                     <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)){
                            echo "<p style=\"color:red;\">Your first name must be between 2 and 25 characters</p>";
                    }
                    ?>
                </div>
                
                <div class="form-group row">
                    <label for="formGroupExampleInput">Surname:*</label>
                <input type="text" name="surname" value="<?php 
					if(isset($_SESSION['surname'])) {
						echo $_SESSION['surname'];
					} 
					?>" class="form-control" id="formGroupExampleInput2"/>
                      <?php
                     if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array))
                     {
                            echo "<p style=\"color:red;\">Your last name must be between 2 and 25 characters</p>"; 
                     }
                     ?>
                </div>
                
                <div class="form-group row">
                    <label for="formGroupExampleInput">Email:*</label>
                    <input type="text" name="email" value="<?php 
					if(isset($_SESSION['email'])) {
						echo $_SESSION['email'];
					} 
					?>"  class="form-control" id="formGroupExampleInput2"/>
                    <?php
                    if(in_array("Email already in use<br>", $error_array))
                    {
                        echo "<p style=\"color:red;\">Email already in use</p>"; 
                    }
                        else if(in_array("Invalid email format<br>", $error_array)) {
                            echo "<p style=\"color:red;\">Invalid email format</p>";
                        }
                    ?>
                </div>
                
                <div class="form-group row">
                    <label for="formGroupExampleInput">Password:*</label>
                    <input type="password" name="password" class="form-control" id="formGroupExampleInput2"/>
                 </div>  
                
                <div class="form-group row">
                    <label for="formGroupExampleInput">Confirm Password:*</label>
                    <input type="password" name="confirm_password" class="form-control" id="formGroupExampleInput2"/>
                    <?php
                    if(in_array("Your passwords do not match<br>", $error_array))
                    {
                        echo "<p style=\"color:red;\">Your passwords do not match</p>";
                    }
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array))
                                 { 
                                            echo "<p style=\"color:red;\">Your password can only contain english characters or numbers</p>";
                                 }
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array))
                                        {
                                                echo "<p style=\"color:red;\">Your password must be betwen 5 and 30 characters</p>"; 
                                        }
                                        ?>
                    </div>
                
                <div class="form-group row">
                    <label for="formGroupExampleInput">Choose role: (type 1 for Student or 2 for Teacher)*</label>
                    <input type="text" name="role" value="<?php 
					if(isset($_SESSION['role'])) {
						echo $_SESSION['role'];
					} 
					?>"  class="form-control" id="formGroupExampleInput2"/>
		<?php
                             if(in_array("Role must be 1 for student or 2 for teacher<br>", $error_array))
                                       {
                                        echo "<p style=\"color:red;\">Role must be 1 for student or 2 for teacher</p>"; 
                                       }          
                    ?>	
                    </div>
                
                <div class="form-group row">
                    <p>Resolve the simple captcha below:*</p> <br />
                    <p>
			<?php
				echo $random_number1 . ' + ' . $random_number2 . ' = ';
			?>
                    </p>
			<input name="captchaResult" type="text" size="2" />
                    
			<input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
			<input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
	</div>	
            
            <div class="form-group row">
            <input type="submit" class="btn btn-primary" value="signup" name="register"/>
              <a style="float:right;" href="loginform.php">Already a member? Login here!</a>
              
         </div>
            <p>Fields with * are required.</p>
	</form>
        
  
    </div>  

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>