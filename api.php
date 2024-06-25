<?php
header("Content-Type:application/json");
if (isset($_GET['count'])) {
	include('db.php');
	$count = $_GET['count'];
	
	$result = mysqli_query(
	$con,
	"SELECT * FROM `count`");
	if(mysqli_num_rows($result)>0){
	    $results = array();
            while($row = $result->fetch_assoc()) {
                  $results[] = array(
                                      
                                      'Token'.$row['id'] => str_pad($row['current_count'], 5, '0', STR_PAD_LEFT) ,
                                      
                                   );
              }
              mysqli_close($con);
            $response = array(
                'status' => true,
                'message' => 'Success',
                'data' => ($results)
            );
       echo $json = json_encode($response);
       
    	
	}else{
		response(NULL);
		}
}else{
	response(NULL);
	}

function response($count){
	
	$json_response = $count;
	echo $json_response;
}
?>