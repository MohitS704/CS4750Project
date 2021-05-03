<?php 
        require("./db-connect.php");
        global $pdo;
        if (isset($_SESSION['firstName'])) {
            echo('<h2>Welcome ' . $_SESSION["firstName"]. '!</h2>');
        }
        
        if (isset($_GET['searchCuisine'])) {
            $cuis = $_GET['searchCuisine'];
            if ($cuis != '') {
                $res = $pdo->prepare("SELECT * FROM Restaurants NATURAL JOIN Cuisines WHERE cuisine LIKE '%{$cuis}%';");
                $res->bindParam(":cuisine",$_GET['searchCuisine']);
                $res->execute();
            } else {
                $res = $pdo->prepare("SELECT * FROM Restaurants;");
                $res->execute();
            }
        } else {
            $res = $pdo->prepare("SELECT * FROM Restaurants;");
            $res->execute();
        }
        // SELECT * FROM Restaurants NATURAL JOIN Cuisines WHERE cuisine LIKE :cuisine 
        // Get the list of all restaurants to render in the front-end
        echo "<h1 class='text-center'> List of Restaurants: </h1>";
        echo "<br>";
        echo "<table class='table table-condensed table-hover' style='table-layout: fixed; border-collapse:collapse;'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'> Detail </th>";
                    echo "<th scope='col'>Address </th>";
                    echo "<th scope='col'>Restaurant Name </th>";
                    echo "<th scope='col'>Rating </th>";
                    echo "<th scope='col'>Price </th>";
                    echo "<th scope='col'>Cuisine </th>";
                echo "</tr>";
            echo "</thead>";
    
            while ($row = $res->fetch()) {
                $r_id = $row["r_ID"];
                $address = $row["r_address"];
                echo "<tr>";
                    echo "<th scope='row'><a class='btn btn-outline-secondary btn-sm' href='menu.php?r_id=",$r_id,"&address=",$address,"'> Click here to view menu </a></th>";
                    echo('<td> ' .  $row["r_address"]. '</td>');
                    echo('<td> ' .  $row["r_name"]. '</td>');
                    echo('<td> ' .  $row["r_rating"]. '</td>');
                    echo('<td> ' .  $row["r_price"]. '</td>');
                    echo('<td> ' .  $row["r_cuisine"]. '</td>');
                echo "</tr>";    
            }
    
        echo "</table>";

?>