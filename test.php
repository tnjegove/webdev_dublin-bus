<?php 
	
	
	$results2_fullnames = array("");
	$results2_id = array("");
	$selected_val = $_POST['stopid'];
	$selected_operator = $_POST['operatorid'];
	$link = "https://data.smartdublin.ie/cgi-bin/rtpi/busstopinformation?stopid=".$selected_val."&operator=".$selected_operator;
	$get_json_with_busid = file_get_contents($link);
		$busids_decoded = json_decode($get_json_with_busid,true);
		
		
		
		for ($i=0;$i<count($busids_decoded["results"][0]["operators"][0]["routes"]);$i++) {
			$results2_fullnames[$i]=$busids_decoded["results"][0]["operators"][0]["routes"][$i];			
			
		}
	echo json_encode($results2_fullnames);
?>