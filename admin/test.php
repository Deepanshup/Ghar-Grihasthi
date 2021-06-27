<?php
    $url=$_SERVER['REQUEST_URI'];
    header("Refresh: 1; URL=$url");
    include("../wp-config.php");
    $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME);
    if(isset($_REQUEST["live_one_app"])){
        $email=$_GET["email"];
        $response['results']=array();
        $sql="SELECT `lat`, `lon` FROM `salesperson_distributers` WHERE email='$email'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["lat"]=urldecode($row[0]);
                $product["lon"]=urldecode($row[1]);
                array_push($response["results"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $product=array();
            $product["success"] = 0;
            $product["message"] = "No Sales person found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
    }
?>