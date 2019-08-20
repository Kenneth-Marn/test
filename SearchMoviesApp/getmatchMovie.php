<?php
	$config = include("./config.php");
	$error = false;
	$message = '';
    $colorArray = array ('red','green','blue','yellow');
	if($_SERVER['REQUEST_METHOD'] =='GET' && !empty($_GET) && isset($_GET['movietitle'])) {
		$movietitle = trim($_GET['movietitle']);
		$movietitle =  urlencode($movietitle);
		$apikey = $config['apikey'];
		$url = "http://www.omdbapi.com/?t=".$movietitle."&r=json&apikey=".$apikey; //Searching a match movie
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
				if(strpos(strtolower($response['Title']), $query, 0) !== false) {
					$response['Color'] = $query;
					break;
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
		
		<?php if(!$error && $response['Response']) { ?>
			<div class="container">
				<table class="movielist">
        		<thead>
            		<tr>
                		<th>Title</th>
                		<th>Year</th>
                		<th>Runtime</th>
            		</tr>
        		</thead>
       	 		<tbody>
            		<tr style="background:<?php echo  $response['Color'] ?>;">
               			<td><?php echo $response['Title'] ?></td>
                		<td><?php echo $response['Year'] ?></td>
                		<td><?php echo $response['Runtime'] ?></td>
					</tr>
				
        		</tbody>
			</div>
		<?php } ?>

	</body>

</html>