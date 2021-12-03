<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Lego Search</title>
	<link rel="stylesheet" href="style.css">
	<script src="legoscript.js"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=M+PLUS+1+Code&family=Quantico&family=Rajdhani:wght@600&display=swap" rel="stylesheet">
	<link rel="icon" type="image/png" href="legohead.png">
</head>

<body>
	<div class="header">
		<a href="index.html"><img src="logo.svg" alt="logo" id="logo"></a>
	</div>
	<div class="wrapper">
		
		<div id="search">
			<h1>Lego Search</h1>
			<form method="get" action="results.php">
				<input id="searchbar" name="search" type="text" autofocus placeholder="Search for LEGO sets here...">
				<button type="submit">Search</button>
			</form>
		</div>
		
		<div id="help">
			<h3 id="helpbutton" onClick="showhelp()"><a>Help</a></h3>
			<div id="helpcontent">
				<img src="legoman.png" alt="legoman" id="legoman">
				<p>-According to all known laws of aviation, there is no way a bee should be able to fly. Its wings are too small to get its fat little body off the ground. The bee, of course, flies anyway because bees don't care what humans think is impossible.</p>
			</div>
		</div>
			
		<div id="about">
			<h3 id="aboutbutton" onClick="showabout()"><a>About us</a></h3>
			<div id="aboutcontent">
				<p>-According to all known laws of aviation, there is no way a bee should be able to fly. Its wings are too small to get its fat little body off the ground. The bee, of course, flies anyway because bees don't care what humans think is impossible.</p>
			</div>
		</div>
			
	</div>
</body>
</html>