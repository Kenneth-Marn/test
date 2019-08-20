<?php
	$config = include("./config.php");
	$error = false;
	$message = '';
    $colorArray = ['red','green','blue','yellow'];
	if($_SERVER['REQUEST_METHOD'] =='GET' && !empty($_GET) && isset($_GET['movietitle'])) {
		$movietitle = trim($_GET['movietitle']);
		$movietitle =  urlencode($movietitle);
		$apikey = $config['apikey'];
		$url="http://www.omdbapi.com/?s=".$movietitle."&apikey=".$apikey; // Seraching list of movies
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPGET, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($curl);
		curl_close($curl);
		$response=json_decode($response_json, true);
		if(isset($response['Error'])) {
			$error = true;
			$message= $response['Error'];
		}else{
			foreach($colorArray as $query) {
				for($i=0;$i<sizeof($response['Search']);$i++) {
					if(strpos(strtolower($response['Search'][$i]['Title']), $query, 0) !== false) {
						$response['Search'][$i]['Color'] = $query;
						continue;
					}
				}
			}	
		}
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Search Movies</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="index.css" />
	</head>

	<body>
		<h1 align="center">Search Movie</h1>
		<?php if($error) { ?>
			      <div class="error-msg">
				  	<i class="fa fa-times-circle"></i>
  				  	<?php echo $message ?>
				  </div>

		<?php } ?>
		
		<div class="wrap">
			<form action="index.php" method="GET">
   				<div class="search">
      				<input type="text" name="movietitle" class="searchTerm" placeholder="Movie name..." autocomplete="off">
      				<button type="submit" class="searchButton">
       					<i class="fa fa-search"></i>
     				</button>
				</div>
			</form>
		</div>
		
		<?php if(!$error && isset($response['Search'])  ) { ?>
			<div class="container">
				<table class="movielist">
        		<thead>
            		<tr>
                		<th>Title</th>
                		<th>Year</th>
                		<th>Type</th>
            		</tr>
        		</thead>
       	 		<tbody>
					<?php for($i=0;$i<sizeof($response['Search']);$i++) { ?>
            			<tr style="background:<?php echo  $response['Search'][$i]['Color'] ?>;" >
               				<td><?php echo $response['Search'][$i]['Title'] ?></td>
                			<td><?php echo $response['Search'][$i]['Year'] ?></td>
                			<td><?php echo $response['Search'][$i]['Type'] ?></td>
						</tr>
					<?php } ?>
        		</tbody>
			</div>
		<?php } ?>
		

	</body>

</html>