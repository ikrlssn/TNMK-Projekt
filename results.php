<!DOCTYPE html>
<html lang="en">
<head>
    <<meta charset="utf-8">
	<title>Search Results</title>
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
		<a href="index.html"><img src="logo.svg" alt="logo" id="logo"></a>
	</div>
    <div class="wrapper">
        <div id="searchresult">
            <form method="get" >
                <input type="text" name="search" placeholder="Search lego-set">
                <input type="submit" value="Search">
            </form>
        </div>
        <ul id="allresults">
            <?php
            $connection	= mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
            $searchword = $_GET['search'];

            
            $query = "SELECT sets.SetID, sets.Setname, sets.Year FROM sets 
            WHERE sets.Setname LIKE '%$searchword%' OR sets.SetID LIKE '%$searchword%'";
 
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {

                $setID = $row['SetID'];
                $setName = $row['Setname'];
                $year = $row['Year'];
                
                //ny fråga här
                $queryimg = "SELECT DISTINCT * 
                    FROM images
                    WHERE ItemID = '$setID' AND ItemtypeID = 'S'";
                
                $resultimg = mysqli_query($connection, $queryimg);
                $rowimg = mysqli_fetch_array($resultimg);

                //$itemtypeID = $rowimg['ItemtypeID'];
                $suffix = "jpg";
                $has_gif = $rowimg['has_gif'];
                $has_jpg = $rowimg['has_jpg'];
                $has_largegif = $rowimg['has_largegif'];
                $has_largejpg = $rowimg['has_largejpg'];
                $large = "";
		
                if ($rowimg['has_largegif']){
                    $suffix = "gif";
                    $large = "L";
                }
                else if ($rowimg['has_largejpg']){
                    $suffix = "jpg";
                    $large = "L";
                }
                else if ($rowimg['has_jpg']){
                    $suffix = "jpg";
                            
                }
                else if ($rowimg['has_gif']){
                    $suffix = "gif";
                }
                else {
                    echo "fel";
                }                
                    
                $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/S$large/$setID.$suffix";

                print("<li><a style='display:block' href='legosets.php?set=$setID'><div class='result'>");
                print("<img src=$imglink><p2>$setID</p2><p>$setName <br> $year</p>");
                
                print("</div></a></li>\n");
                
            }
           
            ?>
        </ul>
    </div>
    
</body>
</html>
