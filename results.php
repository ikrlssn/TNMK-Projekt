<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Result</title>
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
        <div>
            <?php
            $searchword = $_GET['search'];

            $connection	= mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
            $query = "SELECT sets.SetID, sets.Setname, sets.Year FROM sets 
            WHERE sets.Setname LIKE '%$searchword%' OR sets.SetID LIKE '%$searchword%'";
 
            $result = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($result)) {

                $setID = $row['SetID'];
                $setName = $row['Setname'];
                $year = $row['Year'];
                
                //ny fråga här
                $queryimg = "SELECT * 
                    FROM images
                    WHERE ItemID = $setID AND ItemtypeID = 'S'";
                
                $resultimg = mysqli_query($connection, $queryimg);
                $rowimg = mysqli_fetch_array($resultimg);

                //$itemtypeID = $rowimg['ItemtypeID'];
                $suffix = " ";
                $has_gif = $rowimg['has_gif'];
                $has_jpg = $rowimg['has_jpg'];
                $has_largegif = $rowimg['has_largegif'];
                $large = "";
                if ($has_gif != 0) {
                    $suffix = "gif";
                } 
                else if ($has_jpg != 0){
                    $suffix = "jpg";
                }
                elseif ($has_largegif != 0){
                    $suffix = "gif";
                    $large = "L";
                }
                else {
                    $suffix = "jpg";
                    $large = "L";
                }
                
                $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/S$large/$setID.$suffix";

                print("<a style='display:block' href='legosets.php?set=<?php echo $setID ?>'><div>");
                print("<img src=$imglink><p>$setID $setName $year</p>");
                
                print("</div></a>\n");
                
            }
           
            ?>
        </div>
    </div>
    
</body>
</html>
