<?php
include('connect.php'); 
include("studentcheck.php");
?>

    <?php
    
        $email = $_SESSION['email'];
        $role = $_SESSION['role'];


        $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $row = mysqli_fetch_assoc($result);

        $student_id = $row['id'];
        $name = $row['name'];
        $surname = $row['surname'];

        $student = ucfirst($name)." ".ucfirst($surname);
     
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Student: <?php echo ucfirst($name)." ".ucfirst($surname); ?></title>

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
            background-image: url("images/img2.jpg");
        }
        label{
            color:white;
        }
        a
        {
            font-family: verdana;
            font-size: 20px;
            color:white !important;
        }
        a:hover
        {
            color:black !important;
        }
        form
        {
        margin-bottom: 50px;    
        }
     </style>
  </head>
    <body>
<!--################################ NAVIGATION BAR ############################################## -->

<nav class="navbar navbar-default" style="background:#1CB186 !important">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        
      </button>
        <a class="navbar-brand" href="student.php">Thesis Management System</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     
        <form class="navbar-form navbar-left" method="POST" action="search_results.php">
            
          
        <div class="form-group">
          <input type="text" name="search" class="form-control" placeholder="Search">
        </div>
        
        <input type="submit" value="Search" class="btn btn-default">
        
      </form>
      <ul class="nav navbar-nav navbar-right">
          
          
          <li><a href="student_requests.php">Requests</a></li>
          <li><a href="student_statistics.php">Statistics</a></li>
        
        
          
          <li> <a href="logout.php">Sign out</a></li>
         
       
      </ul>
        
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
        
<!--################################ NAVIGATION BAR ############################################## -->
    <?php
    
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];

    
    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_assoc($result);
    
    $diploma_id = $row['id'];
    $name = $row['name'];
    $surname = $row['surname'];
     
    ?>

<div class="container">
    
        
        <div class="jumbotron" style="background:#3C579D !important">
            <h1 style="color:white">Student: <?php echo ucfirst($name)." ".ucfirst($surname); ?></h1>
            <p style="color:white;">Below you can see your search results.</p>
        </div>
    

    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        
  <?php
        
  
        if(isset($_POST['search']))
        {
  
            $search_query = $_POST['search'];
            
            
        $sql2 = "SELECT * FROM student_diploma WHERE active='0' AND user_id='$student' ORDER BY id DESC";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result);
        
        $student_diploma = $row2['diploma_id'];
        
        $sql = "SELECT * FROM diploma WHERE active='0' AND (title LIKE '$search_query%' OR teacher LIKE '$search_query%') ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        
         if(mysqli_num_rows($result)==0){
             echo "<div class=\"alert alert-danger\" role=\"alert\">Your search query didn't produce any results.</div>";
                       
        }
        
        echo "<div class=\"row\">\n";
        echo "        \n";
        
        
        
        do{
             echo "        <div class=\"col-sm-6 col-md-4\">\n";
             echo "            \n";
            
             if(isset($_GET['r_id']))
                {
                 
                 if(empty($_GET['r_id']))
                 {
                      echo "<div class=\"alert alert-danger\" role=\"alert\">Error</div>";
                       
                 }
                 else
                 {
                    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                    
                    
                    $row = mysqli_fetch_assoc($result);
                    
                    
                    $student_id = $row['id'];
                    
                    //Check if diploma already exists 
                    $d_check = mysqli_query($conn, "SELECT diploma_id FROM student_diploma WHERE diploma_id='$_GET[r_id]' AND user_id='$student_id'");

                    //Count the number of rows returned
                    $num_rows = mysqli_num_rows($d_check);

                    if($num_rows > 0)
                    {
                        
                        echo "<div class=\"alert alert-danger\" role=\"alert\">You have already requested this diploma</div>";
                        
                    }
                    
                    else 
                    {
                        
                        $sql1 = "INSERT INTO student_diploma(teacher_id,user_id,diploma_id) VALUES ('$_GET[teacher_id]','$student_id','$_GET[r_id]')";
                        if (mysqli_query($conn, $sql1))
                        {
                            
                             echo "<div class=\"alert alert-success\" role=\"alert\">Your diploma is requested</div>";
                             
                        } 
                        else 
                        {
                            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                        }
                        
                       
                        
                        
                    }
 
                 }
                
                    
                }
            else
            {
                
                
                $row = mysqli_fetch_assoc($result);
                $diploma_id = $row['id'];
                $teacher_id = $row['teacher_id'];
                $title = $row['title'];
                $teacher = $row['teacher'];
                $student_number = $row['student_number'];
                $goal = $row['goal'];
                $description = $row['description'];
                $prerequisite_courses = $row['prerequisite_courses'];
                $prerequisite_knowledge = $row['prerequisite_knowledge'];

               
                echo "              <div class=\"thumbnail\">\n";
                echo "                    <div class=\"caption\">\n";
                echo "                        <h3><b>Title:</b> ".ucfirst($title)."</h3>\n";
                echo "                        <p><b>Teacher ID:</b> ".$teacher_id."</p>\n";
                echo "                        <p><b>Teacher:</b> ".ucfirst($teacher)."</p>\n";
                echo "                        <p><b>Diploma id:</b> ".$diploma_id."</p>\n";
                echo "                        <p><b>Student number:</b> ".ucfirst($student_number)."</p>\n";
                echo "                        <p><b>Goal:</b> ".ucfirst($goal)."</p>\n";
                echo "                        <p><b>Description:</b> ".ucfirst($description)."</p>\n";
                echo "                        <p><b>Prerequisite courses:</b> ".$prerequisite_courses."</p>\n";
                echo "                        <p><b>Prerequisite knowledge:</b> ".ucfirst($prerequisite_knowledge)."</p>\n";
                echo "                        <a href=\"student.php?r_id=$diploma_id&stu_id=$student_id&teacher_id=$teacher_id\"><button type=\"button\" class=\"btn btn-primary\">Request this diploma</button></a>";
                echo "                    </div>\n";
                echo "              </div>\n";
                echo "            \n";
                
                
             
            } 
  
           
           echo "        </div>\n"; 
           
           $i++;
           
        }while($i<mysqli_num_rows($result));
        
        echo "</div>";


        }   
        
    ?>
    
</form>


    
</div> 


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>

