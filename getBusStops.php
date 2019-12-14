<?php 
	$selectedOperator = $_POST['operator'];
	$busStopLink = "https://data.smartdublin.ie/cgi-bin/rtpi/busstopinformation?stopid=&operator=".$selectedOperator;
	$jsondata=file_get_contents($busStopLink);
	$json=json_decode($jsondata,true);
	$result_array = array("","");
	
	for ($i=0;$i<count($json["results"]);$i++) {
		$result_array[$i][0]=$json["results"][$i]["fullname"];
		$result_array[$i][1]=$json["results"][$i]["stopid"];
		
	}
	
	for ($i=0;$i<count($json["results"]);$i++) {
		echo '<option value="'.$result_array[$i][1].'">'.$result_array[$i][0].' '.$result_array[$i][1].'</option>';	
	}
	
	
	
	
?>