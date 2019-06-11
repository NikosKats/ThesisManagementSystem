<?php
    session_start();
    //Database connection
    include('connect.php'); 
    
    
    $email = "";
    $password = "";
    $error_array = array(); //Holds error messages
    
    if(isset($_POST['login']))
    {
        
        
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //sanitize email
	$password = $_POST['password']; //Get password

        $password = md5($password);
        
        

        if(strlen(strlen($password) < 1)) 
            {
                array_push($error_array, "Password is required<br>");
                
            }
            if(strlen(strlen($email) < 1)) 
            {
                array_push($error_array, "Email is required<br>");
            }
       
         
    $sql = "SELECT email, password, role FROM auth_users WHERE email='$email' and password='$password' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        
        
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $_POST['email'];
        
        
    } else {
        array_push($error_array, "Email or password was incorrect<br>");
    }

    
    switch ($_SESSION['role']) {
        case 1: //admin
            
            
            header("Location: student.php");
            exit();
            break;
        case 2: //user
            
            header("Location: teacher.php");
            exit();
            break;
    }
            
           
        
    
        
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login Form</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body{
            background-image: url("images/img3.jpg");
        }
        label{
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
        
        .jumbotron
        {
            margin-top: 100px;
            
        }
        
    </style>
  </head>
    <body>

      <div  class="container">
          
          <div class="jumbotron">
      <h1 style="margin-left:150px;">Thesis Management System </h1>
      <p style="margin-left:150px;">A web application for managing Diploma Theses, created by University of the Aegean students.</p>
      <p style="margin-left:150px;"><a class="btn btn-primary btn-lg" href="http://localhost:8888/PhpProjectWebProgramming/startbootstrap-new-age-gh-pages/learn_more.html" target="_blank" role="button">Learn more</a></p>
    </div>
          
          
        <form style="margin-top: 50px;" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
         
            
                <div class="form-group row">
                      <label for="formGroupExampleInput">Email:</label>
                        <input type="text" name="email" value="" class="form-control" id="formGroupExampleInput2" placeholder="Type your email"/></br>
                        <?php if(in_array("Email is required<br>", $error_array)) echo  "<p style=\"color:red;\">Email is required.</p>"; ?>
                   </div> 
            
            <div class="form-group row">
                <label for="formGroupExampleInput">Password:</label>
                <input type="password" name="password" class="form-control" id="formGroupExampleInput2" placeholder="Type your password"/></br>
                <?php if(in_array("Email or password was incorrect<br>", $error_array)) echo  "<p style=\"color:red;\">Email or password was incorrect<br>or you need to activate your account.</p>"; ?>
            
                <?php if(in_array("Password is required<br>", $error_array)) echo  "<p style=\"color:red;\">Password is required.</p>"; ?>
                <br>
             </div>
            
            <div class="form-group row">
             <input type="submit" class="btn btn-primary" name="login" value="login"/>   
             <a style="float:right;" href="registerform.php">Register here!</a>
                
           </div>  
                    
            
        </form>
        

      </div>
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>

>