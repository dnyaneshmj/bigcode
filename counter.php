<?php
    
//   // Check user login or not
// if(!isset($_SESSION['uname'])){
//     header('Location: index.php');
// }

// // logout
// if(isset($_POST['but_logout'])){
//     session_destroy();
//     header('Location: index.php');
// }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


  
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <title>Hello, world!</title>
  </head>
  <body>
      
      
<?php

    
if (isset($_POST['count']) && $_POST['count']!="") {
	
	var_dump($_POST);
	 $counter_id = $_POST['counter_id'];
	$count = $_POST['count'][0] ;
	//print_r($count);
  	include('db.php');
 	$sql = "UPDATE count SET current_count = $count where id = ($counter_id)";

            $result = mysqli_query( $con, $sql);
        	
            if (mysqli_query($con, $sql)) {
                    
              // echo "<script>alert('Updated Succesfully')</script>";
                    
            } else {
                
                 echo "Error updating record: " . mysqli_error($con);
                 
            }
    
 
 	  
	

    	mysqli_close($con);
 	
//  	foreach($count as $key => $value ){
//  	  //  echo $key;
//  	  //  echo $value;
//  	        $sql = "UPDATE count SET current_count = $value where id = ($key + 1)";

//             $result = mysqli_query( $con, $sql);
        	
//             // if (mysqli_query($con, $sql)) {
            
//             // } else {
//             //   echo "Error updating record: " . mysqli_error($con);
//             // }
    
//  	}
//  	  echo "Record updated successfully";
	

//     	mysqli_close($con);
}
    
?>

        <div class="container">
          <div class="row my-2 text-center"> <h3>Counter</h3>  </div>
        </div>
      <div class="container">
          <div class="row">
                <?php 
                    for ($i = 0; $i <= 19; $i++){
                        	include('db.php');
                         	
                   	        $result = mysqli_query( $con, "SELECT * FROM `count` WHERE id =". intval ($i+1) );
                            $row = $result->fetch_assoc();
                            $current_count = $row['current_count'];
                            mysqli_close($con);
    	
 	
                        ?>
                          <div class="col-md-4 my-3  p-3">
                                <form  action="" method="POST" class="counter-form border p-3">
                                      <div class="mb-3">
                                        <label for="" class="form-label">Token  <?php echo $i+1 ?> ( Current Count: <?php echo $current_count ?>)</label>
                                        
                                        <button class="btn btn-danger reset-count float-end mb-2" ><i class="bi bi-arrow-repeat"></i></button>
                                        
                                        <input type="number" name=count[] class="counter form-control"min="0" max="99999" required>
                                        
                                      </div>
                                        <input type="hidden" name="counter_id" value=" <?php echo $i+1 ?>">
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                      
                                </form>
                          </div>
                        <?php 
                    }
                ?>
          </div>


      </div>
      



    <?php 
        // for ($i = 0; $i <= 19; $i++){
        //     ?>
        <!--//         <label>Enter Count <?php echo $i+1 ?>:</label><br />-->
        <!--//             <input type="text" name="count[]" placeholder="Enter Count <?php echo $i+1 ?>" value="<?php echo (isset($_POST['count']) && $_POST['count']!="")? $_POST['count'][$i]:''  ?>"required/>-->
        <!--//         <br /><br />-->
                    <?php //echo (isset($_POST['count1']) && $_POST['count1']!="")? $_POST['count1']:''  ?>
                    
        <!--//         <br />-->
           <?php 
        // }
    ?>
    
    
    <!--<button type="submit" name="submit">Submit</button>-->



    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
      jQuery(document).ready(function(){
         jQuery('.reset-count').on('click', function(){
            
            jQuery(this).closest('.counter-form').find('.counter').val(0);     
            
         });
         
         
      });
      
  </script>
  
  </body>
</html>