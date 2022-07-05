<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="js/function.js"></script>
	<script src="js/animate.js"></script>
	<script src="js/index.js"></script>
	<link rel="stylesheet" href="index.css">
</head>
<body>
	<div class="img-container">
		<div class="wheel-box">
			<div class="img-box">
				<?php
				   		$string  = file_get_contents("./img/slideAdv/slideAdv.json");
				        $json_array = json_decode($string,true);

				        foreach ($json_array as $key => $value){
							 if(is_array($value)){
							 	foreach($value as $key1 => $value1){
									 if(is_array($value1)){
									 	foreach($value1 as $key2 => $value2){
									 		if($key2 == "name"){
									 			$name = $value2;
									 		} else if($key2 == "url"){
									 			$url = $value2;
									 		};

									 	};

								 		echo '<a href="'.$url.'">
								 				<img src=./img/slideAdv/'.$name.'?rnd='.rand(0,10000).' alt=""/>
											  </a>';
									 };
							 	};
							 };
				        };
				?>

			</div>
			<div class="left">&lt;</div>
			<div class="right">&gt;</div>
		</div>
		<div class="fixDiv">
			<?php
		   		$string  = file_get_contents("./img/fixedAdv/fixedAdv.json");
		        $json_array = json_decode($string,true);

		        foreach ($json_array as $key => $value){
					 if(is_array($value)){
					 	foreach($value as $key1 => $value1){
							 if(is_array($value1)){
							 	foreach($value1 as $key2 => $value2){
							 		if($key2 == "name"){
							 			$name = $value2;
							 		} else if($key2 == "url"){
							 			$url = $value2;
							 		};

							 	};

						 		echo '<a href="'.$url.'">
						 				<img src=./img/fixedAdv/'.$name.'?rnd='.rand(0,10000).' alt=""/>
									  </a>';
							 };
					 	};
					 };
		        };
			?>
		</div>
	</div>

</body>
</html>