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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<div class="header">
		<a href="index.php"><img src="logo.svg" alt="logo" id="logo"></a>
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
				<p>
					Search for LEGO sets, either by name, keyword or ID number. <br> 
					Then, click one of the search results to get a better view of a set, <br> 
					along with all its cointaining parts.<br> 
				</p>
			</div>
		</div>
			
		<div id="about">
			<h3 id="aboutbutton" onClick="showabout()"><a>About us</a></h3>
			<div id="aboutcontent">
				<p>
					Armen Abedi <span class="liuid">		- armab790@ad.liu.se</span> <br>
					Oscar Fyrk <span class="liuid">			- oscfy612@ad.liu.se</span> <br>
					Simon Henriksson <span class="liuid">	- simhe960@ad.liu.se</span> <br>
					Isak Karlsson <span class="liuid">		- isaka326@ad.liu.se</span> <br>
					Emil Larsgärde <span class="liuid">		- emila490@ad.liu.se</span> <br>
				</p>
			</div>
		</div>
			
	</div>
</body>
</html>