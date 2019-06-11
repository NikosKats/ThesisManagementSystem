<?php
//Database connection
include('connect.php'); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Error 404</title>

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
        h1{
            
        }
        
        .jumbotron
        {
            margin-top: 250px;
            background-color: #460862;
        }
        
    </style>
  </head>
    <body>

      <div  class="container">
          
        <div class="jumbotron">
      
            <h1 style="margin-left:250px; color:white;">ERROR 404 PAGE NOT FOUND.</h1>
            
            <p style="margin-left:250px;">
             OOOPS!!! Looks Like you are a little bit lost.
            </p>
            
        </div>
       
        

      </div>
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
