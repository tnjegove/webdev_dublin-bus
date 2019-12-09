<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="css/stylesheet.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

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
								$(select).append('<p>The bus is due in: '+data[i]+' minutes.</p>');
								
							}
							//$(select).append('<option value=' + data[i] + '>' + data[i] + '</option>');
												
							
						}
						
						
						}});
				
				
			});
			
			
		});
	
	</script>
  </head>
  <body>
	<header>
		<div class="container">
			<h1>Welcome to our Irish Transport Application</h1>
			<p>We hope to make people's commuting lives easier with the introduction of our app</p>
		</div>
	</header>
	<div class="container">
		<nav class="navbar navbar-expand-xl navbar-light bg-light"> <!-- navigation, which is fixed to the top at all times --> 
			<div class="navbar-brand"> <!-- left side of navigation bar containing the brand and logo -->
				<!--<h2 class="navbar-brand">Tadija's E-shop</h2>-->
				<img class="logo" src="images/logo_dublinbus.jpg" alt="company logo Rathmines">
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent"> <!-- the right hand side of navigation bar that is collapsible depending on the screen size  -->
				<ul class="navbar-nav mr-auto"> <!-- links in navigation bar  -->
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#">About</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Tutorials</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link disabled" title="Not implemented" href="#">Forum</a>
					</li>
				</ul>
				<ul class="navbar-nav navbar-right">
					<li class="nav-item"><a title="Not implemented" class="nav-link" href="#"><i class="fas fa-user" ></i> Sign in</a></li>
					<li class="nav-item"><a title="Not implemented" class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Cart</a></li>
					<li class="nav-item">
						<form class="form-inline my-2 my-lg-0">
							<input title="Not implemented" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
							<button title="Not implemented" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
						</form>
					</li>
				</ul>
			</div>
		</nav></div>
	
	
    <main class="minimum-height"><div class="container">
	<div class="row">
		<br>
	
		<p class="waste-some-space">some text here...</p>
		
		<br>
	
	</div>
	
	
	
	<div class="row">
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
	<div class="col-sm">
	<h2>Choose your starting stop</h2>
	<select id="stopnames" name="stopnames">
	
	<?php for ($i=0;$i<count($result_fullnames);$i++) {
		echo '<option value="'.$result_id[$i].'">'.$result_fullnames[$i].'</option>';
		
		
	} 
	?>
	</select></div>
	<div class="col-sm">
	<select id="routes" name="routes"></select>
	<button type="submit" id="submit">Search!</button></div>
	
	<div class="col-sm" id="bus-data"></div>
	</div>
	<div class="row">
		<br>
	
		<p class="waste-some-space">some text here...</p>
		
		<br>
	
	</div>
	
	</div></main>
	<footer>
		<div class="container">
			<nav class="navbar navbar-expand-lg bg-light">
	
		<ul class="navbar-nav mr-auto"> <!-- links for social media implemented using font awesome -->
			<li class="navbar-brand">Copyright &copy; 2019 Tadija @ NCI</li> 
			<li ><a class="nav-link" href="#"><i class="fab fa-facebook-f"></i></a></li>
			<li ><a class="nav-link" href="#"><i class="fab fa-google"></i></a></li>
			<li ><a class="nav-link" href="#"><i class="fab fa-twitter"></i></a></li>
			
		</ul>
		<ul class="navbar-nav navbar-right">
			<li><a id="result" class="nav-link"> </a></li>
			<li ><a class="nav-link" href="#">Contact us</a></li>
			<li ><a class="nav-link" href="#">Site map</a></li>
			<li ><a class="nav-link" href="#">Terms &amp; Conditions</a></li>
			
		</ul>
	
</nav>
		</div>
	
	</footer>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
