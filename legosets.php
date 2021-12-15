<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Legosets</title>
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
        <a href='legosets.php?set=<?php echo $setID ?>&page=<?php echo $page+24 ?>'>next</a>");

        
        
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
