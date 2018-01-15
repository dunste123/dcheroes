<?php
function myDump($var)
{
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
	
}

$heroId = rand(1,8);
?>
<html>
	<head>
		<title>Rating Widget, to be used for DC-heroes..</title>
		<link href="css/stars.css" rel="stylesheet" type="text/css" />
		<meta name="author" content="Peter Nocker"/>
		<meta name="author" content="Benjamin Porobic"/>
		<meta name="keywords" content="css, html, forms, radiobuttons"/>
	</head>
	<body>
		<?php
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			myDump($_POST);
		}
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="frmRate">
			<fieldset>
				<div class="rate">
					<input type="radio" id="rating10" name="rating" value="10" /><label class="lblRating" for="rating10" title="5 stars"></label>
				    <input type="radio" id="rating9" name="rating" value="9" /><label class="lblRating half" for="rating9" title="4 1/2 stars"></label>
				    <input type="radio" id="rating8" name="rating" value="8" /><label class="lblRating" for="rating8" title="4 stars"></label>
				    <input type="radio" id="rating7" name="rating" value="7" /><label class="lblRating half" for="rating7" title="3 1/2 stars"></label>
				    <input type="radio" id="rating6" name="rating" value="6" /><label class="lblRating" for="rating6" title="3 stars"></label>
				    <input type="radio" id="rating5" name="rating" value="5" /><label class="lblRating half" for="rating5" title="2 1/2 stars"></label>
				    <input type="radio" id="rating4" name="rating" value="4" /><label class="lblRating" for="rating4" title="2 stars"></label>
				    <input type="radio" id="rating3" name="rating" value="3" /><label class="lblRating half" for="rating3" title="1 1/2 stars"></label>
				    <input type="radio" id="rating2" name="rating" value="2" /><label class="lblRating" for="rating2" title="1 star"></label>
				    <input type="radio" id="rating1" name="rating" value="1" /><label class="lblRating half" for="rating1" title="1/2 star"></label>
				    <input type="radio" id="rating0" name="rating" value="0" /><label class="lblRating" for="rating0" title="No star"></label>
				</div>
				<div class="divSubmit">
					<input type="submit" name="submitRating" value="Rate Hero"/>
					<input type="hidden" name="heroId" value="<?php echo $heroId; ?>"/>
				</div>
			</fieldset>
		</form>
	</body>
</html>