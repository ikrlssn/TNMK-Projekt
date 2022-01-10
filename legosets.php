<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
		<a href="index.php"><img src="logo.svg" alt="logo" id="logo"></a>
	</div>
    <div class="wrapper">
        
        <?php
        $setID = $_GET['set'];
        $connection	= mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
        $count = 50;
        $querycount = "SELECT COUNT(inventory.ItemID)
            FROM inventory
            WHERE inventory.SetID = '$setID'";
        $resultcount = mysqli_query($connection, $querycount);
        $rowcount = mysqli_fetch_array($resultcount);
        $count = $rowcount['COUNT(inventory.ItemID)'];
        
        if (isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }
        else{
            $page = 0;
        }
        

        $queryset = "SELECT has_gif, has_jpg, has_largegif, has_largejpg, sets.Setname, sets.Year 
            FROM images, sets
            WHERE images.ItemID = '$setID' AND images.ItemtypeID = 'S' AND sets.SetID = '$setID'";
        $resultset = mysqli_query($connection, $queryset);
        $rowset = mysqli_fetch_array($resultset);
        $setName = $rowset['Setname'];
        $year = $rowset['Year'];
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

        print("<div id='activeset'>");
        print("<img src=$imglink><p2> <br>Set ID: $setID <br>Year: $year</p2><h3>$setName </h3>");
        print("</div>\n");

        $limit = 24;

        $query = "SELECT inventory.ItemID, inventory.Quantity, inventory.ItemtypeID, colors.Colorname 
            FROM inventory, colors
            WHERE inventory.SetID = '$setID' AND colors.ColorID = inventory.ColorID LIMIT $page,$limit";
        $result = mysqli_query($connection, $query);
        $startnr = $page+1;
        $endnr = $page+$limit;
        if($page+$limit <= $count){
            print("<p>Showing result $startnr - $endnr</p>");
        }
        else{
            print("<p>Showing result $startnr - $count</p>");
        }
        ?>
        
        <div id="pagination">
            <a href='legosets.php?set=<?php echo $setID ?>&page=
            <?php 
            if($page-$limit>0){
                echo $page-$limit;
            }
            else{
                echo 0;
            }
            ?>'>&laquo;</a>
            <a href='legosets.php?set=<?php echo $setID ?>&page=
            <?php
            if($page+$limit<$count){
                echo $page+$limit;
            }
            else{
                echo $page;
            }
            ?>'>&raquo;</a>
        </div>


        <table id="parts">
            <tr>
                <th>
                    <p>Image</p>
                </th>
                <th>
                    <p>Part ID</p>
                </th>
                <th>
                    <p>Part Name</p>
                </th>
                <th>
                    <p>Quantity</p>
                </th>
                <th>
                    <p>Color</p>
                </th>
            </tr>

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

                print("<tr>");
                if($itemtypeID == "P"){
                    $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/$itemtypeID/$colorID/$itemID.$suffix";
                    print("<td><img src=$imglink alt='Image could not be found'> </td> <td> <p>$itemID </td>");
                    print("<td>$partname</td>");
                }
                else{
                    $imglink = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/$itemtypeID/$itemID.$suffix";
                    print("<td><img src=$imglink alt='Image could not be found'> </td> <td> <p>$itemID </td>");
                    print("<td>$minifigname</td>");
                }
                print("<td> $quantity </td> <td> $colorname</p> </td>");
                print("</tr>\n");
            }
            ?>
        </table>
    </div>
</body>
</html>
