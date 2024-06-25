<?php
// Start the session
if(!isset($_SESSION['uname'])){
    session_start();
}
//print_r($_SESSION);
?>
<html>
   
   <head>
      <title>BIG Counter</title>
          <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


  
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"></script>
  
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
<?php
include("db.php");

   // Check user login or not
    if(!isset($_SESSION['uname'])){
        ?>
                <script>
                          jQuery(document).ready(function(){
                                jQuery("#login-form").show();
                                jQuery("#count-container").hide();
                                //jQuery("#count-container").remove();
                          });
                   
                </script>
            <?php
    }else{
                ?>
                <script>
                          jQuery(document).ready(function(){
                                jQuery("#login-form").hide();
                                jQuery("#count-container").show();
                                //jQuery("#login-form").remove();
                          });
                   
                </script>
            <?php
    }

    if(isset($_POST['but_logout'])){
        session_destroy();
        ?>
                    <script>
                              jQuery(document).ready(function(){
                                    jQuery("#login-form").show();
                                    jQuery("#count-container").hide();
                                    //jQuery("#count-container").remove();
                                   
                              });
                       
                    </script>
                <?php
    }


   if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']) ) {
    
    $uname = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    if ($uname != "" && $password != ""){

        $sql_query = "select count(*) as cntUser from admin where username='".$uname."' and passcode='".$password."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            $_SESSION['uname'] = $uname;
            //echo "Logged in!";
            //header("Location: https://conscionable-appear.000webhostapp.com/counter.php");
            //exit();
            ?>
                <script>
                 jQuery(document).ready(function(){
                     jQuery("#login-form").hide();
                     
                    //jQuery("#login-form").remove();
                    jQuery("#count-container").show();
                    
                 });
                    
                </script>
            <?php
        }else{
            echo "Invalid username and password";
        }

    }
   }
   



?>

         
         <form action = "" method = "post" id="login-form" style="width: 50%;margin: 10% auto; display:none">
            <div class="container">
                <div class="row my-2 text-center"> <h3>Login</h3>  </div>
            </div>
        
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name = "password">
          </div>
          <button type="submit" value = "Submit" class="btn btn-primary">Submit</button>
        </form>
        <?php

    
        if (isset($_POST['count']) && $_POST['count']!="") {
        	
        	//var_dump($_POST);
        	 $counter_id = $_POST['counter_id'];
        	  $count = $_POST['count'][0] ;
        	  $reset_count = $_POST['reset_count'];
        	  
        	  
         	$sql = "UPDATE count SET current_count = $count where id = ($counter_id)";
         	 $result = mysqli_query( $con, $sql);
                	
                    if (mysqli_query($con, $sql)) {
                            
                      // echo "<script>alert('Updated Succesfully')</script>";
                      if($reset_count == 'true'){
                        
                        $sql = "UPDATE count SET total_count = 0 where id = ($counter_id)";
                        $result = mysqli_query( $con, $sql);      
                        
                      }else{
                        $sql = "UPDATE count SET total_count = ( SELECT total_count FROM count WHERE id = ($counter_id) ) + 1 where id = ($counter_id)";
                        $result = mysqli_query( $con, $sql);      
                      }

                     
                            
                    } else {
                        
                         echo "Error updating record: " . mysqli_error($con);
                         
                    }
            
         
         
        
            	mysqli_close($con);
         	
        
        }
    
?>
 <div id="count-container" class="container" style="display:none">
     
        <div class="container">
          <div class="row my-2 text-center"> <h3>Counter</h3>  </div>
               <form method='post' action="">
                    <input type="submit" value="Logout" name="but_logout">
                </form>
        </div>
        <div class="container">
          <div class="row">
                <?php 
                    for ($i = 0; $i <= 19; $i++){
                        	include('db.php');
                         	
                   	        $result = mysqli_query( $con, "SELECT * FROM `count` WHERE id =". intval ($i+1) );
                            $row = $result->fetch_assoc();
                            $current_count = $row['current_count'];
                            $total_count = $row['total_count'];
                            mysqli_close($con);
    	
 	
                        ?>
                          <div class="col-md-4 my-3  p-3">
                                <form  action="" method="POST" class="counter-form border p-3">
                                      <div class="mb-3">
                                        <label for="" class="form-label">Token  <?php echo $i+1 ?> ( Current Token: <?php echo $current_count ?>)</label>
                                        
                                        <button class="btn btn-danger reset-count float-end mb-2" ><i class="bi bi-arrow-repeat"></i></button>
                                        <label for="" class="form-label">Total Count <?php echo  $total_count ?></label>
                                        
                                        <input type="number" name=count[] class="counter form-control"min="0" max="99999" required>
                                        
                                      </div>
                                        <input type="hidden" name="counter_id" value=" <?php echo $i+1 ?>">
                                        <input type="hidden" class="reset_count" name="reset_count" value="false">
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                      
                                </form>
                          </div>
                        <?php 
                    }
                ?>
          </div>


      </div>
    </div>
      







  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
      <script>
          jQuery(document).ready(function(){
             jQuery('.reset-count').on('click', function(){
                jQuery(this).closest('.counter-form').find('.counter').val(0);   
                jQuery(this).closest('.counter-form').find('.reset_count').val(true);     
                
             });
             
             
          });
          
      </script>
  
   </body>
</html>