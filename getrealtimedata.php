<?php 
	
	$results = array("");
	$selected_route=$_POST['routeid'];
	$selected_stop=$_POST['stopid'];
	$selected_operator=$_POST['operatorid'];
	$realtime_link = "https://data.smartdublin.ie/cgi-bin/rtpi/realtimebusinformation?stopid=".$selected_stop."&".$selected_operator."&routeid=".$selected_route;
	$data = file_get_contents($realtime_link);
	$data_decode = json_decode($data,true);
	for ($i=0;$i<count($data_decode["results"]);$i++) {
		$results[$i] = $data_decode["results"][$i]["duetime"];
		
	}
	
	echo json_encode($results);

?>
