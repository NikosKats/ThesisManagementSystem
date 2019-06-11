<?php

    session_start();

    $role = $_SESSION['role'];
    
    if($_SESSION['email'])
    {
        
        if($role != '2')
        {
            header("Location: 404.php");
           exit();
        }
        
    }
    
    else
    {
        header("Location: loginform.php");
        exit();
    }

?>
