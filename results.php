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
                $queryimg = "SELECT inventory.ItemtypeID, images.has_gif 
                    FROM inventory, images
                    WHERE inventory.ItemID = $setID AND images.ColorID = inventory.ColorID AND images.ItemID = inventory.ItemID 
                    AND images.ItemtypeID = inventory.ItemtypeID";
                
                $resultimg = mysqli_query($connection, $queryimg);
                $rowimg = mysqli_fetch_array($resultimg);

                $itemtypeID = $rowimg['ItemtypeID'];
                $suffix = " ";
                $check = $rowimg['has_gif'];
                if ($check > 0) {
                    $suffix = "gif";
                } 
                else {
                    $suffix = "jpg";
                }
                
                $imglink = "https://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtypeID/$setID.$suffix";

                print("<a style='display:block' href='legosets.php?set=<?php echo $setID ?>'><div>");
                print("<img href=$imglink><p>$setID $setName $year</p>");
                
                print("</div></a>\n");
                
            }
           
            ?>
        </div>
    </div>
    
</body>
</html>
