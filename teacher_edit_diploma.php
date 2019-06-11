<?php
include('connect.php'); 
include("teachercheck.php");

 $email = $_SESSION['email'];
    $role = $_SESSION['role'];
    
    
    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_assoc($result);
    
    
    
    
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
        
        #courses_1
        {
            float:left;  
            margin-top: 35px;
        }
        #courses_2
        {
            float:left;
            margin-top: 15px;
        }
        #courses_3
        {
            float:left;   
            
        }
     #bottom
     {
         margin-bottom: 100px;
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
              <li><a href="teacher_completed_diplomas.php">Completed diplomas</a></li>
            
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
        <p style="color:white;">Below you can edit your diploma.</p>
    </div>

    <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        
       
       <?php
             
            
       
            
            $email = $_SESSION['email'];
            $role = $_SESSION['role'];

            $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            $row = mysqli_fetch_assoc($result);

            $teacher_id = $row['id'];
            $name = $row['name'];
            $surname = $row['surname'];
            

            $teacher = ucfirst($name)." ".ucfirst($surname);
       
            $title="";
            $student_number="";
            $goal="";
            $description="";
            $prerequisite_courses="";
            $prerequisite_knowledge="";

            $error_array = array();
            
            if(isset($_POST['register']))
             {
            
                $title =  $_POST['title'];
                $_SESSION['title'] = $title;

                $teacher = ucfirst($name)." ".ucfirst($surname);
                $_SESSION['teacher'] = $teacher;
                
                $student_number = $_POST['student_number'];
                $_SESSION['student_number'] = $student_number;
                
                $goal = $_POST['goal'];
                $_SESSION['goal'] = $goal;
                
                $description = $_POST['description'];
                $_SESSION['description'] = $description;
                
                $grade=$_POST['grade'];
                

                $prerequisite_knowledge = $_POST['prerequisite_knowledge'];
                $_SESSION['prerequisite_knowledge'] = $prerequisite_knowledge;
                
                if(strlen($title) < 1)
                    {
                      array_push($error_array, "Title must not be empty<br>");
                    }

                if(strlen($teacher) < 1)
                    {
                      array_push($error_array, "Teacher must not be empty<br>");
                    }
                
                if(strlen($goal) < 1)
                    {
                      array_push($error_array, "Goal must not be empty<br>");
                    }
                
                if(strlen($description) < 1)
                    {
                      array_push($error_array, "Description must not be empty<br>");
                    }
                 
                if(strlen($prerequisite_knowledge) < 1)
                    {
                      array_push($error_array, "Prerequisite knowledge must not be empty<br>");
                    }
                    
                    if(strlen($grade) < 1)
                    {
                      array_push($error_array, "Grade must not be empty<br>");
                    }
                    
                
            
            if(!empty($_POST['option']))
            {
                // Counting number of checked checkboxes.
                $checked_count = count($_POST['option']);
                
                // Loop to store and display values of individual checked checkbox.
                foreach($_POST['option'] as $selected)
                {
                    echo "<p>".$selected ."</p>";
                }
            }
            else
            {
                
                array_push($error_array, "Please Select Atleast One Option<br>");
            }
                
                
                if(empty($error_array))
                {  
                    
                    $date = date("y/m/d");
                    
                    $sql = "UPDATE diploma SET title='$title',goal='$goal',description='$description',prerequisite_knowledge='$prerequisite_knowledge',grade='$grade' WHERE id='$_GET[edit_id]'";

                    
                    
                    if (mysqli_query($conn, $sql))
                    {
                       echo "<div class=\"alert alert-success\" role=\"alert\">New record created successfully</div>";
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    
                    
                    
                }
                else
                {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">Fields must not be empty</div>";
                }
                
                
             }
          
             
        ?>
        
        <?php 
            
        if(isset($_GET['edit_id']))
    {
        $sql = "SELECT * FROM diploma WHERE id='$_GET[edit_id]'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result) or die(mysqli_error($conn));

        $title = $row['title'];

        $goal = $row['goal'];

        $description = $row['description'];
        
        $prerequisite_knowledge = $row['prerequisite_knowledge'];
        
        $grade= $row['grade'];
        
        
    }
        
        ?>
        
        
     <div class="form-group">
       <label for="title">Title:</label>
       <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $title;  ?>">
       
       <?php
        if(in_array("Title must not be empty<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Title must not be empty</p>";
        }
        
       ?>
       
     </div>

     <div class="form-group">
       <label for="teacher">Teacher:</label>
       <input type="text" class="form-control" id="teacher" name="teacher" placeholder="<?php echo $teacher;  ?>" value="<?php echo $teacher;  ?>">
       <?php
        if(in_array("Teacher must not be empty<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Teacher must not be empty</p>";
        }
        
       ?>
     </div>

     <div class="form-group"> 
      <label for="student_number">Student number:</label>
      <select name="student_number" class="form-control">
       <option>1</option>
       <option>2</option>
       <option>3</option>
     </select>
      </div>
       
       <div class="form-group">
       <label for="goal">Goal:</label>
       <input type="text" class="form-control" id="goal" name="goal" placeholder="Goal" value="<?php echo $goal; ?>">
       <?php
        if(in_array("Goal must not be empty<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Goal must not be empty</p>";
        }
        
       ?>
       </div>
       
     <div class="form-group">
       <label for="description">Description:</label>
       <textarea name="description" id="description" class="form-control" rows="5"><?php echo $description;  ?></textarea>
       <?php
        if(in_array("Description must not be empty<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Description must not be empty</p>";
        }
        
       ?>
     </div>
       
       <div class="form-group" >
           
           <div id="courses_1">
               
               <label for="exampleInputPassword1" style="color:red;">1st Semester:</label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option1" name="option[]" value="English 1"> English 1
                </label><br>
               <label class="checkbox-inline">
                 <input type="checkbox" id="option2" name="option[]" value="Mathematical Calculus"> Mathematical Calculus
               </label><br>
               <label class="checkbox-inline">
                 <input type="checkbox" id="option3" name="option[]" value="Functional Programming"> Functional Programming
               </label><br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option4" name="option[]" value="Introduction to computer science & Communications"> Introduction to computer <br>science & Communications
               </label><br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option5" name="option[]" value="Discrete Mathematics 1"> Discrete Mathematics 1
               </label><br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option6" name="option[]" value="Logic Design"> Logic Design
               </label>
               <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option7" name="option[]" value="Physics">Physics
               </label>
               <br>
              
           
                <label for="exampleInputPassword1" style="color:red;">2nd Semester:</label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option8" name="option[]" value="English 2"> English 2
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option9" name="option[]" value="Object Oriented Programming 1"> Object Oriented Programming 1
              </label>
              <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option10" name="option[]" value="Probability and statistics"> Probability and statistics
              </label>
              <br>
               <label class="checkbox-inline">
                <input type="checkbox" id="option11" name="option[]" value="Discrete Mathematics 2"> Discrete Mathematics 2
              </label>
              <br>
               <label class="checkbox-inline">
                <input type="checkbox" id="option12" name="option[]" value="Circuit Theory"> Circuit Theory
              </label>
              <br>
              <label class="checkbox-inline">
                 <input type="checkbox" id="option13" name="option[]" value="Linear Algebra"> Linear Algebra
               </label>
              <br>
              <label class="checkbox-inline">
                 <input type="checkbox" id="option14" name="option[]" value="Operating Systems"> Operating Systems
               </label>
              <br>

               
            
                <label for="exampleInputPassword1" style="color:red;">3rd Semester:</label>
                <br>
                <label class="checkbox-inline">
                 <input type="checkbox" id="option15" name="option[]" value="English 3"> English 3
               </label>
                <br>

                <label class="checkbox-inline">
                 <input type="checkbox" id="option16" name="option[]" value="Data Structures"> Data Structures
               </label>
                <br>

                <label class="checkbox-inline">
                 <input type="checkbox" id="option17" name="option[]" value="Computer Architecture"> Computer Architecture
               </label>
                <br>

                <label class="checkbox-inline">
                    <input type="checkbox" id="option18" name="option[]" value="Object Oriented Programming 2"> Object Oriented Programming 2
                </label>
                <br>
               <label class="checkbox-inline">
                 <input type="checkbox" id="option19" name="option[]" value="Stochastic Analysis"> Stochastic Analysis
               </label>
                <br>
               <label class="checkbox-inline">
                 <input type="checkbox" id="option20" name="option[]" value="Signals and systems"> Signals and systems
               </label>
                <br>
               <label class="checkbox-inline">
                 <input type="checkbox" id="option21" name="option[]" value="IT Project Management"> IT Project Management
               </label>
           </div>
                <br>
           <div id="courses_2">
                <label for="exampleInputPassword1" style="color:red;">4th Semester:</label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option22" name="option[]" value="Differential Equations"> Differential Equations
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option23" name="option[]" value="Analysis and design of information systems"> Analysis and design <br>of information systems
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option24" name="option[]" value="Databases I"> Databases I
               </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option25" name="option[]" value="Computer Communications"> Computer Communications
              </label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option26" name="option[]" value="Advanced Topics In Programming Languages"> Advanced Topics<br> In Programming Languages
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option27" name="option[]" value="Algorithms and complexity"> Algorithms and complexity
              </label> 
            
           <br>
            
                <label for="exampleInputPassword1" style="color:red;">5th Semester:</label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option28" name="option[]" value="Business and information systems"> Business and information systems
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option29" name="option[]" value="Telecommunications"> Telecommunications
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option30" name="option[]" value="Databases 2"> Databases 2
               </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option31" name="option[]" value="Software Technology"> Software Technology
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option32" name="option[]" value="Computer Networks"> Computer Networks
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option33" name="option[]" value="Theory Of Computation"> Theory Of Computation
              </label> 
                
                <br>
                
                <label for="exampleInputPassword1" style="color:red;">6th Semester:</label>
                <br>
                 <label class="checkbox-inline">
                     <input type="checkbox" id="option34" name="option[]" value="Information and communication systems security"> Information and communication<br> systems security
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option35" name="option[]" value="Artificial Intelligence"> Artificial Intelligence
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option36" name="option[]" value="Legal framework for the information society"> Legal framework for <br>the information society
               </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option37" name="option[]" value="Information Systems Management"> Information Systems Management
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option38" name="option[]" value="Distributed Systems"> Distributed Systems
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option39" name="option[]" value="Programming on the Internet"> Programming on the Internet
              </label> 
            </div>
                <br>
                
           <div id="courses_3">
                <label for="exampleInputPassword1" style="color:red;">7th Semester:</label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option40" name="option[]" value="Privacy"> Privacy
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option41" name="option[]" value="Computer network security and Privacy Technologies"> Computer network security <br>and Privacy Technologies
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option42" name="option[]" value="Online Entrepreneurship"> Online Entrepreneurship
               </label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option43" name="option[]" value="Methodologies and tools for analysis and design of information systems"> Methodologies and tools for analysis<br> and design of information systems
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option44" name="option[]" value="Digital Communications"> Digital Communications
              </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option45" name="option[]" value="Design Of Digital Systems"> Design Of Digital Systems
              </label> 
                <br>
                 
            
                <label for="exampleInputPassword1" style="color:red;">8th Semester:</label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option46" name="option[]" value="Cryptography"> Cryptography
               </label>
                <br>
                 <label class="checkbox-inline">
                     <input type="checkbox" id="option47" name="option[]" value="Security of mobile and wireless communications networks"> Security of mobile and<br> wireless communications networks
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option48" name="option[]" value="Decision Support Systems"> Decision Support Systems
               </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option49" name="option[]" value="Systems Theory"> Systems Theory
              </label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option50" name="option[]" value="Technologies and E-Government Applications"> Technologies and<br> E-Government Applications
              </label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option51" name="option[]" value="Human-computer interaction with Web Applications"> Human-computer interaction<br> with Web Applications
              </label> 
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option52" name="option[]" value="Digital Image Processing"> Digital Image Processing
               </label>
                <br>
                <label class="checkbox-inline">
                 <input type="checkbox" id="option53" name="option[]" value="Introduction to VLSI"> Introduction to VLSI
               </label>
                <br>
                <label class="checkbox-inline">
                 <input type="checkbox" id="option54" name="option[]" value="Wireless Communications"> Wireless Communications
               </label>
                <br>
           </div>
            </div>
           <br>
           <div id="courses_3">
                <label for="exampleInputPassword1" style="color:red;">9th Semester:</label>
                <br>
                 <label class="checkbox-inline">
                     <input type="checkbox" id="option55" name="option[]" value="Regulatory and social dimensions of the information society"> Regulatory and social<br> dimensions of the information society
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option56" name="option[]" value="Strategy and Investments in information systems"> Strategy and Investments <br>in information systems
               </label>
                <br>
                 <label class="checkbox-inline">
                 <input type="checkbox" id="option57" name="option[]" value="Satellite Communications"> Satellite Communications
               </label>
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option58" name="option[]" value="Broadband Networks"> Broadband Networks
              </label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option59" name="option[]" value="Design and development of Mobile Computing Applications"> Design and development<br> of Mobile Computing Applications
              </label>
                <br>
                <label class="checkbox-inline">
                    <input type="checkbox" id="option60" name="option[]" value="Knowledge Engineering and knowledge systems"> Knowledge Engineering<br> and knowledge systems
              </label> 
                <br>
                <label class="checkbox-inline">
                <input type="checkbox" id="option61" name="option[]" value="Computational Vision"> Computational Vision
              </label> 
            </div>
           <br>
           
       </div>
        

     <div class="container" id="bottom">
         <?php
        if(in_array("Please Select Atleast One Option<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Please Select Atleast One Option</p>";
        }
        
       ?>
       <br>
       
     <div class="form-group">
         
       <label for="prerequisite_knowledge" id="know">Prerequisite knowledge:</label>
       <textarea name="prerequisite_knowledge" id="prerequisite_knowledge" class="form-control" rows="5"><?php echo $prerequisite_knowledge;  ?></textarea>
       <?php
        if(in_array("Prerequisite knowledge must not be empty<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Prerequisite knowledge must not be empty</p>";
        }
        
       ?>
     </div>

       <div class="form-group">
       <label for="teacher">Grade:</label>
       <input type="text" class="form-control" id="grade" name="grade" placeholder="Grade" value="<?php echo $grade;  ?>/10">
       <?php
        if(in_array("Grade must not be empty<br>",$error_array))
        {
            echo "<p style=\"color:red;\">Grade must not be empty</p>";
        }
        
       ?>
     </div>


        <input type="submit" class="btn btn-default" value="submit" name="register">
     
    
   </form>
    
    
    
    
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
