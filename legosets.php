<!DOCTYPE html>
<html lang="en">
<head>
    <<meta charset="utf-8">
	<title>Set Info</title>
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
        <p>här kommer en meny</p>
    </div>
    <div class="wrapper">
        
        
        
        <?php
        $connection	= mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
        $count = 0;
        $querycount = "SELECT inventory.ItemID 
            FROM inventory
            WHERE inventory.SetID = '$setID'";
        $resultcount = mysqli_query($connection, $query);
        while ($rowcount = mysqli_fetch_array($resultcount)) {
            $count += 1;
        }

        if (isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }
        else{
            $page = 0;
        }
        $setID = $_GET['set'];

        $queryset = "SELECT has_gif, has_jpg, has_largegif, has_largejpg 
            FROM images
            WHERE ItemID = '$setID' AND ItemtypeID = 'S'";
        $resultset = mysqli_query($connection, $queryset);
        $rowset = mysqli_fetch_array($result);

        $suffixset = "jpg";
        $has_gifset = $rowset['has_gif'];
        $has_jpgset = $rowset['has_jpg'];
        $has_largegifset = $rowset['has_largegif'];
        $has_largejpgset = $rowset['has_largejpg'];
        $large = "";

        if ($rowset['has_largegif']){
            $suffixset = "gif";
            $large = "L";
        }
        else if ($rowset['has_largejpg']){
            $suffixset = "jpg";
            $large = "L";
        }
        else if ($rowset['has_jpg']){
            $suffixset = "jpg";
                    
        }
        else if ($rowset['has_gif']){
            $suffixset = "gif";
        }
        else {
            echo "fel";
        }                
            
        $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/S$large/$setID.$suffixset";

        print("<li><div class='result'>");
        print("<img src=$imglink><p2>$setID</p2><p>$setName <br> $year</p>");
        print("</div></li>\n");

        $query = "SELECT inventory.ItemID, inventory.Quantity, inventory.ItemtypeID, colors.Colorname 
            FROM inventory, colors
            WHERE inventory.SetID = '$setID' AND colors.ColorID = inventory.ColorID LIMIT $page,24";
        $result = mysqli_query($connection, $query);

        /*if($page+24 <= $count){
            print("<p>Showing result "$page+1" - "$page+24"</p>");
        }
        else{
            print("<p>Showing result "$page+1" - "$count"</p>");
        }*/
        ?>

        <a href='legosets.php?set=<?php echo $setID ?>&page=<?php echo $page-24 ?>'>previous </a>
        <a href='legosets.php?set=<?php echo $setID ?>&page=<?php echo $page+24 ?>'>next</a>

        
        
        <?php
        while ($row = mysqli_fetch_array($result)) {

            $itemID = $row['ItemID'];
            $quantity = $row['Quantity'];
            $colorname = $row['Colorname'];
            $itemtypeID = $row['ItemtypeID'];

            if($itemtypeID == "P"){
                $querypart = "SELECT parts.Partname
                    FROM parts, inventory
                    WHERE inventory.SetID = $setID AND parts.PartID = $itemID";
                $resultpart = mysqli_query($connection, $querypart);
                $rowpart = mysqli_fetch_array($resultpart);
                $partname = $rowpart['Partname'];
            }
            else{
                $queryminifig = "SELECT minifigs.Minifigname
                    FROM minifigs
                    WHERE minifigs.MinifigID = $itemID";
                $resultminifig = mysqli_query($connection, $queryminifig);
                $rowminifig = mysqli_fetch_array($resultminifig);
                $minifigname = $rowminifig['Minifigname'];
            }

            $queryimg = "SELECT inventory.ColorID, images.has_gif, images.has_jpg 
                FROM inventory, images
                WHERE inventory.SetID = '$setID' AND inventory.ItemID = '$itemID' AND images.ColorID = inventory.ColorID AND images.ItemID = inventory.ItemID 
                AND images.ItemtypeID = inventory.ItemtypeID";
            $resultimg = mysqli_query($connection, $queryimg);
            $rowimg = mysqli_fetch_array($resultimg);

            $colorID = $rowimg['ColorID'];
            $suffix = "jpg";
            //$check = $rowimg['has_gif'];
            if ($rowimg['has_gif']) {
                $suffix = "gif";
            } 
            else if($rowimg['has_jpg']){
                $suffix = "jpg";
            }

            print("<div>");
            if($itemtypeID == "P"){
                $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/$itemtypeID/$colorID/$itemID.$suffix";
                print("<img src=$imglink alt='Bild finns inte'><p>$itemID ");
                print("$partname");
            }
            else{
                $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/$itemtypeID/$itemID.$suffix";
                print("<img src=$imglink alt='Bild finns inte'><p>$itemID ");
                print("$minifigname");
            }
            print(" $quantity $colorname</p>");
            print("</div>\n");
        }
        ?>
    </div>
</body>
</html>
