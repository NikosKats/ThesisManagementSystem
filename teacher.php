<?php
include('connect.php'); 
include("teachercheck.php");


 if(isset($_GET['del_id']))
    {
        $del_sql = "DELETE FROM diploma WHERE id='$_GET[del_id]'";
        $run_sql = mysqli_query($conn,$del_sql);
        
        $del_sql1 = "DELETE FROM student_diploma WHERE diploma_id='$_GET[del_id]'";
        $run_sql1 = mysqli_query($conn,$del_sql1);
    }


    
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];
    
    
    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_assoc($result);
    
    
    $t_id = $row['id'];
    
    $name = $row['name'];
    $surname = $row['surname'];
    
    $teacher = ucfirst($name)." ".ucfirst($surname);
    
    $teacher_username = $name.$surname.$t_id;
     
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
        <p style="color:white;">Below you can see the diplomas that you manage.</p>
    </div>

    
    <?php
        $i=0;
        
        
        
        echo $full;
        
        $sql = "SELECT * FROM diploma WHERE teacher_id='$t_id' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        
         if(mysqli_num_rows($result)==0){
             echo "<div class=\"alert alert-danger\" role=\"alert\">There are not any diplomas to display yet.</div>";
                       
        }
        
        
        
        echo "<div class=\"row\">\n";
        echo "        \n";
        
        for($i=0;$i<mysqli_num_rows($result);$i++){
            
                $row = mysqli_fetch_assoc($result);
                
                $user_id = $row['student_id'];
                $diploma_id = $row['id'];
            
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
                          $student_f = "<a href=\"http://localhost:8888/PhpProjectWebProgramming/uploads/$entry\" target=\"_blank\">Download Files</a>";

                        }
                    }
                    closedir($handle);
               } 
                

                $grade = $row['grade'];
                $diploma_id=$row['id'];
                $title = $row['title'];     
                $student_number = $row['student_number'];
                $goal = $row['goal'];
                $description = $row['description'];
                $prerequisite_courses = $row['prerequisite_courses'];
                $prerequisite_knowledge = $row['prerequisite_knowledge'];
                $completed = $row['completed'];
                
                $doc = $row['date_of_creation'];
                $doa = $row['date_of_approval'];
                $doco = $row['date_of_completion'];
            

                echo "        <div class=\"col-sm-6 col-md-4\">\n";
                echo "            \n";
                echo "              <div class=\"thumbnail\" style=\"background:#EAF4FE !important\">\n";
                
                echo "                    <div class=\"caption\">\n";
                
                if($completed=='1')
                {
                    echo "               <h3 style=\"color:lightgreen;\">Completed</h3>\n";
                }
                else
                {
                    echo "               <h3 style=\"color:lightblue;\">Not graded yet</h3>\n";
                }
                
                echo "                        <h3><b>Title:</b> ".ucfirst($title)."</h3>\n";
                echo "                        <p><b>Diploma ID:</b> ".$diploma_id."</p>\n";
                echo "                        <p><b>Teacher:</b> ".ucfirst($teacher)."</p>\n";
                echo "                        <p><b>Student number:</b> ".ucfirst($student_number)."</p>\n";
                echo "                        <p><b>Goal:</b> ".ucfirst($goal)."</p>\n";
                echo "                        <p><b>Description:</b> ".ucfirst($description)."</p>\n";
                echo "                        <p><b>Prerequisite courses:</b> ".$prerequisite_courses."</p>\n";
                echo "                        <p><b>Prerequisite knowledge:</b> ".ucfirst($prerequisite_knowledge)."</p>\n";
                echo "                        <p><b>Grade:</b> ".$grade."/10</p>\n";
                
                if($doc!="0000-00-00 00:00:00")
                {
                     echo "                        <p><b>Date of creation:</b> ".$doc."</p>\n";
                }
                if($doa!="0000-00-00 00:00:00")
                {
                     echo "                        <p><b>Date of approval:</b> ".$doa."</p>\n";
                }
                if($doco!="0000-00-00 00:00:00")
                {
                     echo "                        <p><b>Date of completion:</b> ".$doco."</p>\n";
                }
                
                echo "                        <p><b>Diploma files:</b> ".$student_f."</p>\n";
                
                echo "                        <p><a href=\"http://localhost:8888/PhpProjectWebProgramming/AJAX-Chat-0.8.8-standalone/chat/?username=$teacher_username&teacher_id=$t_id\" target=\"_blank\"><button type=\"button\" class=\"btn btn-success\">Chat</button></a>  <a href=\"teacher_edit_diploma.php?edit_id=$diploma_id\"><button type=\"button\" class=\"btn btn-primary\">Edit Diploma</button></a> <a href=\"teacher.php?del_id=$diploma_id\"><button type=\"button\" class=\"btn btn-danger\">Delete Diploma</button></a>  </p>";
                
                echo "                    </div>\n";
                echo "              </div>\n";
                echo "            \n";
                echo "        </div>\n";

                
            
            
        }
        echo "</div>";

        
        
    ?>
    
    




            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>


