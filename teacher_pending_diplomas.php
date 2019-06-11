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
        <p style="color:white;">Below you can see the diplomas that need approval.</p>
    </div>

    
    <?php
    
       if(isset($_GET['approve_id']))
    {
        
        $date = date("y/m/d");
           
        $approve_sql = "UPDATE student_diploma SET s_active='1' WHERE user_id='$_GET[stud_id]' AND  diploma_id='$_GET[approve_id]'";
        $run_sql = mysqli_query($conn,$approve_sql);

        
         if ($conn->query($approve_sql) === TRUE) {
                        
                        
                        
                        
                        echo "<div class=\"alert alert-success\" role=\"alert\">This diploma is now approved</div>";
                        
                    } 
                    else
                    {
                        echo "Error: " . $approve_sql . "<br>" . $conn->error;
                    }
                    
                    
                    
                    $approve_sql1 = "UPDATE diploma SET active='1',student_id='$_GET[stud_id]',date_of_approval='$date' WHERE id='$_GET[approve_id]'";
                    $run_sq1l = mysqli_query($conn,$approve_sql1);
        
                    if ($conn->query($approve_sql1) === TRUE) {
                        
                        
                        
                        
                        
                    } 
                    else
                    {
                        echo "Error: " . $approve_sql1 . "<br>" . $conn->error;
                    }


                    $conn->close();
    }
    
   else if(isset($_GET['reject_id']))
    {
        $reject_sql = "UPDATE student_diploma SET s_active='2' WHERE diploma_id='$_GET[reject_id]' AND user_id='$_GET[stud_id]'";
        $run_sql = mysqli_query($conn,$reject_sql);
        
         if ($conn->query($reject_sql) === TRUE) {
                        
                        
                       
                        echo "<div class=\"alert alert-danger\" role=\"alert\">This diploma was rejected </div>";
                        
                    } 
                    else
                    {
                        echo "Error: " . $reject_sql . "<br>" . $conn->error;
                    }
                    
                     $reject_sql1 = "UPDATE diploma SET active='2' WHERE id='$_GET[reject_id]'";
        $run_sql1 = mysqli_query($conn,$reject_sql1);
        
         if ($conn->query($reject_sql1) === TRUE) {
                        
                        
                       
                        
                    } 
                    else
                    {
                        echo "Error: " . $reject_sql1 . "<br>" . $conn->error;
                    }

                    $conn->close();
    }
    
    
        $i=0;
        
        
        
        $sql1 = "SELECT * FROM student_diploma WHERE s_active='0' AND teacher_id='$teacher_id'";
        $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
        
        if(mysqli_num_rows($result1)==0){
             echo "<div class=\"alert alert-danger\" role=\"alert\">There are not any pending diplomas to display yet.</div>";
                       
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
            
            $sql3 = "SELECT * FROM diploma WHERE id='$diploma_id' AND teacher_id='$teacher_id'";
            $result3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
            $row3 = mysqli_fetch_assoc($result3);
            
            $diploma_id = $row3['id'];
            $diploma_title = $row3['title'];
            
           
            
            
            
            echo "<table class=\"table table-bordered\">\n";
            
            
            echo "<tr style=\"color:red;\"><td>Student's Fullname</td>"."<td>Student's ID</td>"."<td>Diploma Title</td>"."<td>Diploma ID</td>"."</tr>";
            echo "<tr><td>".$fullname."</td>"."<td>".$s_id."</td>"."<td>".$diploma_title."</td>"."<td>".$diploma_id."</td>"."</tr>";
            
            
            echo "</table>";
            echo "<a href=\"teacher_pending_diplomas.php?approve_id=$diploma_id&stud_id=$s_id\" style=\"text-decoration:none\"><button type=\"button\" class=\"btn btn-success btn-lg btn-block\">Approve Diploma ".$diploma_id." for ".$fullname."</button></a><br>";
            echo "<a href=\"teacher_pending_diplomas.php?reject_id=$diploma_id&stud_id=$s_id\" style=\"text-decoration:none\"><button type=\"button\" class=\"btn btn-danger btn-lg btn-block\">Reject Diploma ".$diploma_id." for ".$fullname."</button></a><br>";
            
            
            
        }
        
     
          


        
        
    ?>
    
    




            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>


