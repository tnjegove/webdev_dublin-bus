<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Dublin bus app</title>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
	<script>
		$(document).ready(function(){
			$("#routes").hide();
			$("#submit").hide();
			$("#stopnames").change(function() {
				$("#routes").show();
				$("#submit").show();
				$("#bus-data").html('');
				var stop_data=$(this).val();
				//alert(stop_data);
				$.ajax({type: "POST",
					url: 'test.php',
					data: {stopid: stop_data},
					dataType: 'json',
					
					success: function(data){
						console.log(data);
						var select = document.getElementById('routes');
						$(select).html('');
						for (var i in data) {
							$(select).append('<option value=' + data[i] + '>' + data[i] + '</option>');
												
							
						}
						
						}});
				
				
			});
			
			$("#submit").click(function() {
				var stop_data = $("#stopnames").val();
				var route_data = $("#routes").val();
				console.log("button clicked!"+route_data+" "+stop_data);
				$.ajax({type: "POST",
					url: 'getrealtimedata.php',
					data: {stopid: stop_data, routeid: route_data},
					dataType: 'json',
					error: function (request, status, error) { alert(request.responseText);},
					success: function(data){
						console.log(data);
						var select = document.getElementById('bus-data');
						$(select).html('');
						for (var i in data) {
							
							if (data[i]=="") {
								console.log("no bus data");
								$(select).append('<p>No buses at this time!</p>');
								}
							else {
								$(select).append('<div>'+data[i]+'</div>');
								
							}
							//$(select).append('<option value=' + data[i] + '>' + data[i] + '</option>');
												
							
						}
						
						
						}});
				
				
			});
			
			
		});
	
	</script>
  </head>
  <body>
    <div class="container">
		<?php
	$jsondata=file_get_contents("https://data.smartdublin.ie/cgi-bin/rtpi/busstopinformation?stopid=&operator=bac");
	$json=json_decode($jsondata,true);
	$result_fullnames = array("");
	$result_id = array("");
	for ($i=0;$i<count($json["results"]);$i++) {
		$result_fullnames[$i]=$json["results"][$i]["fullname"];
		$result_id[$i]=$json["results"][$i]["stopid"];
		
	}
	
	?>
	<select id="stopnames" name="stopnames">
	<?php for ($i=0;$i<count($result_fullnames);$i++) {
		echo '<option value="'.$result_id[$i].'">'.$result_fullnames[$i].'</option>';
		
		
	} 
	?>
	</select>
	
	<select id="routes" name="routes"></select>
	<button type="submit" id="submit">Search!</button>
	
	<div id="bus-data"></div>
	</div>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>