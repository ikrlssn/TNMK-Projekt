<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
    <!-- header and searchbar -->
    <div class="header">
		<a href="index.html"><img src="logo.svg" alt="logo" id="logo"></a>
	</div>
    <div class="wrapper">
        <div id="searchresult">
            <form id="searchagain" method="get" >
                <input type="text" name="search" placeholder="Search lego-set">
                <button type="submit" value="Search">Search</button>
            </form>
        </div>
        
            <?php
            //defining variables and sql-connection
            $connection	= mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
            $searchword = $_GET['search'];
            $invalid = "<p id='invalid'>No results found.<br>Please try a different searchword.</p>";
            $valid = TRUE;
            $limit = 24;
            //get page
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = 0;
            }
            //check bad search
            if(trim($searchword)==""){
                $valid = FALSE;
            }
            else{
                //question for amount of sets
                $querycount = "SELECT COUNT(sets.SetID)
                    FROM sets
                    WHERE sets.Setname LIKE '%$searchword%' OR sets.SetID LIKE '%$searchword%'";
                $resultcount = mysqli_query($connection, $querycount);
                $rowcount = mysqli_fetch_array($resultcount);
                $count = $rowcount['COUNT(sets.SetID)'];
                //sql question for all sets
                $query = "SELECT sets.SetID, sets.Setname, sets.Year FROM sets 
                    WHERE sets.Setname LIKE '%$searchword%' OR sets.SetID LIKE '%$searchword%' LIMIT $page,$limit";
            }
            $result = mysqli_query($connection, $query);
            //print message for nothing found
            if($count==0){
                $valid = FALSE;
            }
            //print pagination
            if($valid){
                $startnr = $page+1;
                $endnr = $page+$limit;
                if($page+$limit <= $count){
                    print("<p class='showcount'>Showing result $startnr - $endnr out of $count for '$searchword'</p>");
                }
                else{
                    print("<p class='showcount'>Showing result $startnr - $count out of $count for '$searchword'</p>");
                }
                ?>
                <div id="pagination">
                    <!-- link to previous results -->
                    <a href='results.php?search=<?php echo $searchword ?>&page=<?php 
                    if($page-$limit>0){
                        echo $page-$limit;
                    }
                    else{
                        echo 0;
                    }
                    ?>'><span class="arrows">&laquo;</span>Previous</a>
                    <!-- link to next results -->
                    <a href='results.php?search=<?php echo $searchword ?>&page=<?php
                    if($page+$limit<$count){
                        echo $page+$limit;
                    }
                    else{
                        echo $page;
                    }
                    ?>'>Next<span class="arrows">&raquo;</span></a>
                </div>
		<ul id="allresults">
                <?php
            }
            //print error message
            else{
                print($invalid);
            }
            //print all results

            while ($row = mysqli_fetch_array($result)) {
                $setID = $row['SetID'];
                $setName = $row['Setname'];
                $year = $row['Year'];
                //img question and assigning variables
                $queryimg = "SELECT DISTINCT * 
                    FROM images
                    WHERE ItemID = '$setID' AND ItemtypeID = 'S'";
                $resultimg = mysqli_query($connection, $queryimg);
                $rowimg = mysqli_fetch_array($resultimg);
                $suffix = "jpg";
                $has_gif = $rowimg['has_gif'];
                $has_jpg = $rowimg['has_jpg'];
                $has_largegif = $rowimg['has_largegif'];
                $has_largejpg = $rowimg['has_largejpg'];
                $large = "";
                //build img link
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
                //print info
                print("<li><a style='display:block' href='setinfo.php?set=$setID'><div class='result'>");
                print("<img src=$imglink alt='no image found'><p class='p2'>$setID</p><p>$setName <br>Year: $year</p>");
                print("</div></a></li>\n");
            }
            ?>
        </ul>
    </div>
</body>
</html>
