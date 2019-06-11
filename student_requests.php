<?php
include('connect.php'); 
include("studentcheck.php");

 if(isset($_GET['del_id']))
    {
        $del_sql = "DELETE FROM student_diploma WHERE id='$_GET[del_id]'";
        $run_sql = mysqli_query($conn,$del_sql);
    }
    
    if(isset($_GET['submit_for_review_id']))
    {
        
            $review_sql1 = "UPDATE student_diploma SET s_reviewed='1' WHERE diploma_id='$_GET[submit_for_review_id]'";
        $run_sql1 = mysqli_query($conn,$review_sql1);
    
    
    if ($conn->query($review_sql1) === TRUE) {
                        
                       
                        
                    } 
                    else
                    {
                        echo "Error: " . $review_sql1 . "<br>" . $conn->error;
                    }
        
                  $date = date("y/m/d");

                    
        $review_sql = "UPDATE diploma SET date_of_completion='$date',reviewed='1' WHERE id='$_GET[submit_for_review_id]'";
        $run_sql = mysqli_query($conn,$review_sql);
    
    
    if ($conn->query($review_sql) === TRUE) {
                        
                     $review_result = "<div class=\"alert alert-success\" role=\"alert\">Submitted for review.</div>"; 
                       
                        
                    } 
                    else
                    {
                        echo "Error: " . $review_sql . "<br>" . $conn->error;
                    }

                    
    
     }
     
$student = $_FILES['file']['name'];
                    $tmp_name = $_FILES['file']['tmp_name'];
                    

?>
    <?php
    
        $email = $_SESSION['email'];
        $role = $_SESSION['role'];


        $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $row = mysqli_fetch_assoc($result);

        $name = $row['name'];
        $surname = $row['surname'];
        $id = $row['id'];
        
        $student = ucfirst($name)." ".ucfirst($surname)." ".$id;
        
        $student_username = $name.$surname.$id;

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
    
    $stu_id = $row['id'];
    $name = $row['name'];
    
    
    
     
    ?>

<div class="container">
    
   
    
        
        <div class="jumbotron" style="background:#3C579D !important">
            <h1 style="color:white">Student: <?php echo ucfirst($name)." ".ucfirst($surname); ?></h1>
            <p style="color:white;">Below you can manage your diplomas.</p>
        </div>
    
<?php

    echo $review_result;
 
    $sql = "SELECT * FROM diploma,student_diploma WHERE diploma.id=student_diploma.diploma_id AND student_diploma.user_id='$stu_id'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
     if(mysqli_num_rows($result)==0){
             echo "<div class=\"alert alert-danger\" role=\"alert\">There are not any requested diplomas to display yet.</div>";
                       
        }
    
    
    echo "<div class=\"row\">\n";
        echo "        \n";
        
        
        
    for($i=0;$i<mysqli_num_rows($result);$i++)
    {
        $row = mysqli_fetch_assoc($result);
        
            $st_id = $row['user_id'];
            
            
            $grade = $row['grade'];
            
            $completed = $row['completed'];
            $diploma_id = $row['diploma_id'];
            $id = $row['id'];
            $title = $row['title'];
            $teacher = $row['teacher'];
            $student_number = $row['student_number'];
            $goal = $row['goal'];
            $description = $row['description'];
            $prerequisite_courses = $row['prerequisite_courses'];
            $prerequisite_knowledge = $row['prerequisite_knowledge'];
            $active = $row['s_active'];
            
            $doc = $row['date_of_creation'];
            $doa = $row['date_of_approval'];
            $doco = $row['date_of_completion'];
        
            echo "        <div class=\"col-sm-6 col-md-4\">\n";
            echo "            \n";
            echo "              <div class=\"thumbnail\" style=\"background:#EDF0F5 !important\">\n";
            
            echo "                    <div class=\"caption\">\n";
            
            
            
            if($active==0){
                echo "                        <h3 style=\"color:lightblue;\">Pending</h3>\n";
                
                echo "                        <h3><b>Title:</b> ".ucfirst($title)."</h3>\n";
                    echo "                        <p><b>Teacher:</b> ".ucfirst($teacher)."</p>\n";
                    echo "                        <p><b>Student number:</b> ".ucfirst($student_number)."</p>\n";
                    echo "                        <p><b>Goal:</b> ".ucfirst($goal)."</p>\n";
                    echo "                        <p><b>Description:</b> ".ucfirst($description)."</p>\n";
                    echo "                        <p><b>Prerequisite courses:</b> ".$prerequisite_courses."</p>\n";
                    echo "                        <p><b>Prerequisite knowledge:</b> ".ucfirst($prerequisite_knowledge)."</p>\n";
                    if($doc!="0000-00-00 00:00:00")
                {
                     echo "                        <p><b>Date of creation:</b> ".$doc."</p>\n";
                }
                    echo "                        <a href=\"student_requests.php?del_id=$id\"><button type=\"button\" class=\"btn btn-danger\">Delete this diploma</button></a>";
                    
                    echo "                    </div>\n";
                    echo "              </div>\n";
                    echo "        </div>\n";
                }
                else if($active==1 && $st_id==$stu_id)
                {
                    
                    
                    if(isset($student))
                    {
                        if(!empty($student))
                        {
                            $location = 'uploads/';

                            if(move_uploaded_file($tmp_name, $location.$student))
                            {
                                $result = "<h3 style=\"color:lightgreen;\" class=\"help-block\">".'Your file was uploaded successfully!'."</h3>";
                                $path = $location.$student;
                                
                                echo "<h3 style=\"color:lightgreen;\" class=\"help-block\">".'Your file was uploaded successfully!'."</h3>";

                            }

                        }
                        else
                        {
                            $result = "<h3 style=\"color:red;\" class=\"help-block\">".'Please choose a file!'."</h3>";
                            echo "<h3 style=\"color:red;\" class=\"help-block\">".'Please choose a file!'."</h3>";
                            
                        }


                    }
                    
                    $graded="";
                    if($completed == '1')
                    {
                        $graded = "and graded";
                    }
                    
                    echo "                        <h3 style=\"color:#2EC99A;\">Approved ".$graded."</h3>\n";
                    
                    echo "                        <h3><b>Title:</b> ".ucfirst($title)."</h3>\n";
                    echo "                        <p><b>Teacher:</b> ".ucfirst($teacher)."</p>\n";
                    echo "                        <p><b>Student number:</b> ".ucfirst($student_number)."</p>\n";
                    echo "                        <p><b>Goal:</b> ".ucfirst($goal)."</p>\n";
                    echo "                        <p><b>Description:</b> ".ucfirst($description)."</p>\n";
                    echo "                        <p><b>Prerequisite courses:</b> ".$prerequisite_courses."</p>\n";
                    echo "                        <p><b>Prerequisite knowledge:</b> ".ucfirst($prerequisite_knowledge)."</p>\n";
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
                    if($completed == '1')
                    {
                       echo "                        <p><b>Grade:</b> ".$grade."/10</p>\n";
                    }
                    else
                    {
                        echo "                        <p><b>Grade:</b> unmarked</p>\n";
                    }
                    
                    
                    echo "<hr>";
                    
                    echo '<h3>Chat with your teacher below.</h3>';
                    echo '<br>';
                    echo "                        <a href=\"http://localhost:8888/PhpProjectWebProgramming/AJAX-Chat-0.8.8-standalone/chat/?username=$student_username&student_id=$st_id\" target=\"_blank\"><button type=\"button\" class=\"btn btn-success\">Chat</button></a>";
                    
                    echo "<hr>";

                    echo '<h3>Upload your files below.</h3>';
                    
                    echo "<form method=\"post\" action=".$_SERVER['PHP_SELF']." enctype=\"multipart/form-data\">\n";
                    echo "                <div class=\"form-group\">\n";
                    echo "                    \n";
                    echo "                  <label for=\"exampleInputFile\">File input</label>\n";
                    echo "                  <input type=\"file\" name=\"file\" id=\"exampleInputFile\">\n";
                    echo "<p class=\"help-block\">".'If you upload a new file your previous file will be replaced with the new one !'."</p>";
                    echo "                </div>\n"; 
                    
                    
                    
                    echo "              <br>\n";
                    
                    echo "              <button type=\"submit\" value=\"Submit\" class=\"btn btn-primary\">Upload files</button>\n";
                    echo "\n";
                    echo "                  \n";
                    echo " <br>";
                    if ($handle = opendir('uploads/')) {
                        while (false !== ($entry = readdir($handle))) {

                            if ($entry != "." && $entry != ".." && $entry==$student) {


                              echo " <br>";
                              echo "<a style=\"color:blue;\" href=\"http://localhost:8888/PhpProjectWebProgramming/uploads/$entry\" target=\"_blank\"><u>Click here to view your file! </u></a>";
                              echo " <br>";



                            }
                        }
                        closedir($handle);
                    }
                    
                    echo "          </form>";

                    echo "<hr>";
                    echo '<h3>Submit your diploma for review below.</h3>';
                    echo '<br>';
                    echo "                        <a href=\"student_requests.php?submit_for_review_id=$diploma_id\"><button type=\"button\" class=\"btn btn-default\">Submit for review</button></a>";
                    
                    
                    
                    echo "                    </div>\n";
                    echo "              </div>\n";
                    echo "        </div>\n";
                    
                    
                    
                    
                }
                else if($active==2 && $st_id==$stu_id)
                {
                    echo "                        <h3 style=\"color:red;\">Rejected</h3>\n";
                

                    echo "                        <h3><b>Title:</b> ".ucfirst($title)."</h3>\n";
                    echo "                        <p><b>Teacher:</b> ".ucfirst($teacher)."</p>\n";
                    echo "                        <p><b>Student number:</b> ".ucfirst($student_number)."</p>\n";
                    echo "                        <p><b>Goal:</b> ".ucfirst($goal)."</p>\n";
                    echo "                        <p><b>Description:</b> ".ucfirst($description)."</p>\n";
                    echo "                        <p><b>Prerequisite courses:</b> ".$prerequisite_courses."</p>\n";
                    echo "                        <p><b>Prerequisite knowledge:</b> ".ucfirst($prerequisite_knowledge)."</p>\n";
                    if($doc!="0000-00-00 00:00:00")
                {
                     echo "                        <p><b>Date of creation:</b> ".$doc."</p>\n";
                }
                    echo "                        <a href=\"student_requests.php?del_id=$id\"><button type=\"button\" class=\"btn btn-danger\">Delete this diploma</button></a>";
                    echo "                    </div>\n";
                    echo "              </div>\n";
                    echo "        </div>\n";
                }
            }
            
    
    echo "</div>";
    
                       
    
    $sql_names= "SELECT * FROM auth_users,diploma,student_diploma WHERE auth_users.id=student_diploma.user_id AND diploma.id=student_diploma.diploma_id AND diploma.teacher_id = student_diploma.teacher_id AND s_active='1'";
    $run = mysqli_query($conn, $sql_names);
    
    for($i=0;$i<mysqli_num_rows($run);$i++)
    {
         
        
        $row = mysqli_fetch_assoc($run);
        
        $user = $row['user_id'];
        $s_name = $row['name'];
        $s_surname = $row['surname'];
        
        $full = $s_name." ".$s_surname;
        
        
        
        
    }

?>

    
</div> 


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>

