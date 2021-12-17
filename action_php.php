<?php
 if(isset($_POST['submit'])){
 echo $Email =$_POST['Email'];
 echo $Password =$_POST['Password'];
}
 if(!empty($Email) || !empty($Password)){
     $host = "localhost";
     $dbUsername = "root";
     $dbPassword = "";
     $dbname = "userlogin";
 }
  else{
     echo "All fields are required";
     die();
 }

 $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
 if(mysqli_connect_error()){
     die('Connection Failed : '.mysqli_connect_errno().')'.mysqli_connect_error());
    }
 else{
     $SELECT = "SELECT Email from userdata Where Email = ? Limit 1";
     $INSERT = "INSERT Into userdata (Email, Password) values (?, ?)";
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $Email);
     $stmt->execute();
     $stmt->bind_result($Email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     if ($rnum==0) {
         $stmt->close();

         $stmt = $conn->prepare($INSERT);
         $stmt->bind_param("sss", $Email, $Password);
         $stmt->execute();
         echo "New record inserted successfully";            
     } else{
         echo "Someone already registered this email";
     }
     $stmt->close();
     $conn->close();
    }
    ?>