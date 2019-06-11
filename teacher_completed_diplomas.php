<?php
include('connect.php'); 
include("teachercheck.php");



   $email = $_SESSION['email'];
    $role = $_SESSION['role'];
    
    
    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_assoc($result);
    
    $teacher_id = $row['id'];
    
    $name = $row['name'];
    $surname = $row['surname'];
    
    $teacher = ucfirst($name)." ".ucfirst($surname);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Teacher: <?php echo ucfirst($name)." ".ucfirst($surname); ?></title>

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
            background-image: url("images/img6.jpg");
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
        table
        {
            color:white;
        }
     </style>
  </head>
    <body>

 
<!--################################ NAVIGATION BAR ############################################## -->

<nav class="navbar navbar-default" style="background:#3C579D !important">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        
      </button>
        <a class="navbar-brand" href="teacher.php">Thesis Management System</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      
      <ul class="nav navbar-nav navbar-right">
          
          <li><a href="teacher_newdiploma.php">New thesis</a></li>
              <li><a href="teacher_pending_diplomas.php">Pending diplomas</a></li>
              <li><a href="teacher_completed_diplomas.php">Grade diplomas</a></li>
            
            <li><a href="teacher_statistics.php">Statistics</a></li>
          
            <li> <a href="logout.php">Sign out</a></li>

      </ul>
        
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
        
<!--################################ NAVIGATION BAR ############################################## -->

<div class="container">  
    

    
    <div class="jumbotron" style="background:#1CB186 !important">
        <h1 style="color:white;">Teacher: <?php echo ucfirst($name)." ".ucfirst($surname); ?></h1>
        <p style="color:white;">Below you can see the diplomas that you need to grade.</p>
    </div>

    
    <?php
    
    
          if(isset($_POST['submit']))
         {
              $grade = $_POST['grade'];
                
               $approve_sql1 = "UPDATE student_diploma SET s_completed='1' WHERE diploma_id='$_GET[submit_id]'";
                $run_sql1 = mysqli_query($conn,$approve_sql1);


                 if ($conn->query($approve_sql1) === TRUE) {

                                

                            } 

                            else
                            {
                                echo "Error: " . $approve_sql1 . "<br>" . $conn->error;
                            }
                

                $approve_sql = "UPDATE diploma SET grade='$grade',completed='1' WHERE id='$_GET[submit_id]'";
                $run_sql = mysqli_query($conn,$approve_sql);


                 if ($conn->query($approve_sql) === TRUE) {

                                echo "<div class=\"alert alert-success\" role=\"alert\">Grade inserted successfully</div>";

                            } 

                            else
                            {
                                echo "Error: " . $approve_sql . "<br>" . $conn->error;
                            }




                            $conn->close();
    } 
        
       
        $i=0;
        
        
        
        $sql1 = "SELECT * FROM student_diploma WHERE s_active='1' AND teacher_id='$teacher_id' AND s_reviewed='1' AND s_completed='0'";
        $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
        
         if(mysqli_num_rows($result1)==0){
             echo "<div class=\"alert alert-danger\" role=\"alert\">There are not any diplomas to grade yet.</div>";
                       
        }
        
        for($i=0;$i<mysqli_num_rows($result1);$i++){
            
            $row1 = mysqli_fetch_assoc($result1);
            
            $user_id = $row1['user_id'];
            $diploma_id = $row1['diploma_id'];
            
            
            
            $sql2 = "SELECT * FROM auth_users WHERE id='$user_id'";
            $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            $row2 = mysqli_fetch_assoc($result2);
            
            $s_id = $row2['id'];
            $student_name = $row2['name'];
            $student_surname = $row2['surname'];
            
            $fullname = ucfirst($student_name)." ".ucfirst($student_surname);
            
            $student_file = $fullname." ".$s_id;
            
            if ($handle = opendir('uploads/'))
                {
                 while (false !== ($entry = readdir($handle)))
                    {

                        if ($entry != "." && $entry != ".." && $entry==$student_file) {
                            
                          echo " <br>";
                          $student_f = "<a href=\"http://localhost:8888/PhpProjectWebProgramming/uploads/$entry\" target=\"_blank\">CLICK HERE TO SEE DIPLOMA FILES.</a>";

                        }
                    }
                    closedir($handle);
               } 
            
               $sql3 = "SELECT * FROM diploma WHERE id='$diploma_id' AND teacher_id='$teacher_id' AND reviewed='1' AND completed='0'";
            $result3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
            $row3 = mysqli_fetch_assoc($result3);
            
            $diploma_id = $row3['id'];
            $diploma_title = $row3['title'];
            
            echo "<table class=\"table table-bordered\">\n";
            echo "<tr style=\"color:red;\"><td>Student's Fullname</td>"."<td>Diploma Files</td>"."<td>Diploma Title</td>"."<td>Diploma ID</td>"."</tr>";
            echo "<tr><td>".$fullname."</td>"."<td>".$student_f."</td>"."<td>".$diploma_title."</td>"."<td>".$diploma_id."</td>"."</tr>";
            echo "</table>";
            
            
            echo "<form method=\"post\" action=\"teacher_completed_diplomas.php?submit_id=$diploma_id\">\n";
            
            echo "<div class=\"form-group\">\n";
            echo "    <label for=\"text\">Enter Grade For Diploma ".$diploma_id."</label>\n";
            echo "    <input type=\"text\" class=\"form-control\" id=\"grade\" name=\"grade\" placeholder=\"Enter Grade For Diploma ".$diploma_id."\">\n";
            echo "  </div>";

            echo "<input type=\"submit\" name=\"submit\" class=\"btn btn-success btn-lg btn-block\" value=\"Submit Grade in diploma\" >";
            
            echo "</form>";
            
            
   
        }
           
    ?>
    

   


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>


