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
                /*$itemtypeID = $row['ItemtypeID'];
                $colorID = $row['ColorID'];
                $suffix = " ";
                $check = $row['has_gif'];
                if ($check > 0) {
                    $suffix = ".gif";
                } 
                else {
                    $suffix = ".jpg";
                }*/
                
                
                print("<div>");
                print("<p>$setID</p>");
                print("<p>$setName $year</p>");
                //print("<p>$year</p>");
                /*print("<p>$colorID</p>");
                print("<p>$itemtypeID</p>");*/
                print("</div>\n");
                
            }
           
            ?>
        </div>
    </div>
    
</body>
</html>
