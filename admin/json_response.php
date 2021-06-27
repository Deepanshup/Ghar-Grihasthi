<?php
include("../wp-config.php");
$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;
$dbname = DB_NAME;
try 
{
    $con = new mysqli($servername, $username, $password,$dbname);
    $response['results']=array();
    
    if(isset($_GET["live_one_web"])){
        $email=$_GET["email"];
        $sql="SELECT `lat`, `lon`,email,distributor_address FROM `salesperson_distributers` WHERE email='$email'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            header("Content-type: text/xml");
            echo "<?xml version='1.0' ?>";
            echo '<markers>';
            while ($row=mysqli_fetch_row($result)){
                echo '<marker ';
                echo 'lat="' . $row['0'] . '" ';
                echo 'lng="' . $row[1] . '" ';
                echo 'email="' . $row[2] . '" ';
                echo 'address="' . $row[3] . '" ';
                echo '/>';
            }
            echo '</markers>';
        }
        else
        {
            $product=array();
            $product["success"] = 0;
            $product["message"] = "No Sales person found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
        $url=$_SERVER['http://jobmafiaa.com/products/lavina/admin/json_response.php?email='+$email+'&live_one_web=Submit'];
        header("Refresh: 2; URL=$url");
    } 
    
    if(isset($_GET["live_one_app"])){
        $email=$_GET["email"];
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
        $url=$_SERVER['http://jobmafiaa.com/products/lavina/admin/json_response.php?email='+$email+'&live_one_app=Submit'];
        header("Refresh: 5; URL=$url");
    } 
    
    
    if(isset($_GET["update_live_location_app"])){
        $lat=$_GET["lat"];
        $lon=$_GET["lon"];
        $email=$_GET["email"];
        $sql="UPDATE `salesperson_distributers` SET `lat`='$lat',`lon`='$lon' WHERE email='$email'";
        if ($con->query($sql)) 
        {
            $product["success"] = 1;
            $product["message"] = "Updated Successfully";
            echo json_encode($response);
        }
        else
        {
            $product["success"] = 0;
            $product["message"] = "Oops! An error occurred.";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
    }
    
    function parseToXML($htmlStr)
    {
        $xmlStr=str_replace('<','&lt;',$htmlStr);
        $xmlStr=str_replace('>','&gt;',$xmlStr);
        $xmlStr=str_replace('"','&quot;',$xmlStr);
        $xmlStr=str_replace("'",'&#39;',$xmlStr);
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
        return $xmlStr;
    }
    
    if(isset($_GET["live_multiple_web"])){
        $sql="SELECT * FROM `salesperson_distributers`";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
                header("Content-type: text/xml");
                echo "<?xml version='1.0' ?>";
                echo '<markers>';
                while ($row=mysqli_fetch_row($result)){
                    echo '<marker ';
                    echo 'email="' . $row['0'] . '" ';
                    echo 'de="' . $row[1] . '" ';
                    echo 'dcn="' . parseToXML($row[2]) . '" ';
                    echo 'da="' . parseToXML($row['3']) . '" ';
                    echo 'lat="' . $row[4] . '" ';
                    echo 'lng="' . $row[5] . '" ';
                    echo '/>';
                }
                echo '</markers>';
        }
        else
        {
            $product=array();
            $product["success"] = 0;
            $product["message"] = "No driver found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
        $url=$_SERVER['http://jobmafiaa.com/products/lavina/admin/json_response.php?live_multiple_web=Submit'];
        header("Refresh: 1; URL=$url");
    }
    
    if(isset($_GET["live_multiple_app"])){
        $sql="SELECT * FROM `salesperson_distributers`";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["lat"]=urldecode($row[4]);
                $product["lon"]=urldecode($row[5]);
                $product["email"]=urldecode($row[0]);
                array_push($response["results"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $product=array();
            $product["message"] = "No driver found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
        $url=$_SERVER['http://jobmafiaa.com/products/lavina/admin/json_response.php?live_multiple_app=Submit'];
        header("Refresh: 5; URL=$url");
    }
}
catch(PDOException $e)
{
}
?>