<?php
include('connect.php'); 
include("teachercheck.php");
?>
    <?php
    
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];
    
    
    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_assoc($result);
    
    $name = $row['name'];
    $surname = $row['surname'];
    
    $student = ucfirst($name)." ".ucfirst($surname);
    
    $sql1 = "SELECT * FROM diploma WHERE completed='1'";
    $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
    
    for($i=0;$i<mysqli_num_rows($result1);$i++)
    {
        $row1 = mysqli_fetch_assoc($result1);

        $grade += $row1['grade'];
        
        $j++;
    }
    
    $average = $grade/$j;
    
    $sql2 = "SELECT * FROM diploma WHERE active='0'";
    $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
    
    $available = mysqli_num_rows($result2);
    
    $sql3 = "SELECT * FROM diploma WHERE reviewed='0'";
    $result3= mysqli_query($conn, $sql3) or die(mysqli_error($conn));
    
    $pending = mysqli_num_rows($result3);
    
    $sql4 = "SELECT * FROM diploma WHERE completed='1'";
    $result4= mysqli_query($conn, $sql4) or die(mysqli_error($conn));
    
    $completed = mysqli_num_rows($result4);
    
    $sql5 = "SELECT * FROM diploma";
    $result5= mysqli_query($conn, $sql5) or die(mysqli_error($conn));
    
    $number_of_diplomas = mysqli_num_rows($result5);
    
     
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
     
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Title', 'Hours per Day'],
          <?php echo "['Total Diplomas Created',".$number_of_diplomas."],"; ?> 
          <?php echo "['Average Grade',".$average."],"; ?> 
          <?php echo "['Available Diplomas',".$available."],"; ?> 
          <?php echo "['Pending Diplomas',".$pending."],"; ?> 
          <?php echo "['Completed Diplomas',".$completed."]"; ?> 
           
        ]);

        var options = {
          title: 'Diploma Statistics'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
     
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
    <?php
    
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];

    
    $sql = "SELECT * FROM auth_users WHERE email='$email' and active='1'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    $row = mysqli_fetch_assoc($result);
    
    $name = $row['name'];
    $surname = $row['surname'];
     
    ?>

<div class="container">
        
    
    <div class="jumbotron" style="background:#1CB186 !important">
        <h1 style="color:white;">Teacher: <?php echo ucfirst($name)." ".ucfirst($surname); ?></h1>
        <p style="color:white;">Below you can see the diploma statistics.</p>
    </div>
    
    <div id="piechart" style="width: 1140px; height: 500px; margin-bottom:50px;"></div>

</div> 


            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>

