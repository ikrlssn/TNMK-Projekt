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
        <p> allt skit </p>
        <?php
        $setID = $_GET['set'];

        $query = "SELECT inventory.ItemID, inventory.Quantity, inventory.ItemtypeID, colors.Colorname 
            FROM inventory, colors
            WHERE inventory.SetID = $setID AND colors.ColorID = inventory.ColorID";
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {

            $itemID = $row['ItemID'];
            $quantity = $row['Quantity'];
            $colorname = $row['Colorname'];
            $itemtypeID = $row['ItemtypeID'];

            if($itemtypeID = "P"){
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


            $queryimg = "SELECT inventory.ColorID, images.has_gif 
                FROM inventory, images
                WHERE inventory.SetID = $setID AND images.ColorID = inventory.ColorID AND images.ItemID = inventory.ItemID 
                AND images.ItemtypeID = inventory.ItemtypeID";
            $resultimg = mysqli_query($connection, $queryimg);
            $rowimg = mysqli_fetch_array($resultimg);

            $colorID = $rowimg['ColorID'];
            $suffix = " ";
            $check = $rowimg['has_gif'];
            if ($check > 0) {
                $suffix = "gif";
            } 
            else {
                $suffix = "jpg";
            }
            $imglink = "https://weber.itn.liu.se/~stegu76/img.bricklink.com/$itemtypeID/$colorID/$setID.$suffix";

            print("<div>");
            print("<img href=$imglink><p>");
            if($itemtypeID = "P"){
                print("$partname");
            }
            else{
                print("$minifigname");
            }
            print(" $quantity $colorname</p>");
            print("</div>\n");
        }
        ?>
    </div>
</body>
</html>
