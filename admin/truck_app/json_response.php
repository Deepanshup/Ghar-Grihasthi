<?php
$servername = "localhost";
$username = "nadaa93i_gaurav";
$password = "root@123";
$dbname = "nadaa93i_truck_app";
try 
{
    $con = new mysqli($servername, $username, $password,$dbname);
    if(isset($_GET["live"])){
        $lat=$_GET["lat"];
        $lon=$_GET["lon"];
        $name=$_GET["name"];
        $truck=$_GET["truck"];
        $manager_no=$_GET["manager_no"];
        $sql="UPDATE `live_location` SET `lat`='$lat',`lon`='$lon' WHERE name='$name' and manager_no='$manager_no' and truck='$truck'";
        if ($con->query($sql)) 
        {
            $response["success"] = 1;
            $response["message"] = "";
            echo json_encode($response);
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "Oops! An error occurred.";
            echo json_encode($response);
        }
    }
    if(isset($_GET["login"])){
        $name=$_GET["name"];
        $truck=$_GET["truck"];
        $manager_no=$_GET["manager_no"];
        $sql = "select * from driver where name='$name' and manager_no='$manager_no' and truck='$truck'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if (mysqli_num_rows($result) > 0) {
            $response["success"] = 1;
            $response["message"] = "Successfully Logged In";
            echo json_encode($response);
            $sql="SELECT * FROM `live_location`";
            $result = mysqli_query($con,$sql) or die(mysql_error());
            if(mysqli_num_rows($result) > 0)
            {
                // while($row=mysqli_fetch_row($result)){
                //     if($name==$row[2] && $truck==$row[3] && $manager_no==$row[4]){
                //         $sql="UPDATE `live_location` SET `lat`=0,`lon`=0 WHERE `id`='$row[5]'";
                //         $con->query($sql);
                //     }
                // }
            }
            else
            {
                $sql="INSERT INTO `live_location`(`lat`, `lon`, `name`, `truck`, `manager_no`) VALUES ('0','0','$name','$truck','$manager_no')";
                $con->query($sql);
            }
             
        } 
        else {
            $response["success"] = 0;
            $response["message"] = "No user found";
            echo json_encode($response);
        }
    }
    if(isset($_GET["login_manager"])){
        $name=$_GET["name"];
        $manager_no=$_GET["manager_no"];
        $sql = "select * from manager where name='$name' and manager_no='$manager_no'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if (mysqli_num_rows($result) > 0) {
                    $response["success"] = 1;
                    $response["message"] = "Successfully Logged In";
                     echo json_encode($response);
        } 
        else {
            $response["success"] = 0;
            $response["message"] = "No user found";
            echo json_encode($response);
        }
    }
    if(isset($_GET["live_one"])){
        $name=$_GET["name"];
        $truck=$_GET["truck"];
        $manager_no=$_GET["manager_no"];
        $sql="SELECT `lat`, `lon` FROM `live_location` WHERE name='$name' and manager_no='$manager_no' and truck='$truck'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            $response["success"] = 1;
            $response["message"] = "Successfull";
            while($row=mysqli_fetch_row($result)){
                $response["lat"]=urldecode($row[0]);
                $response["lon"]=urldecode($row[1]);
            }
            echo json_encode($response);
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
        $url=$_SERVER['http://rbtechsolution.com/truck_app/json_response.php?name='+$name+'&truck='+$truck+'&manager_no='+$manager_no+'live_one=Submit'];
        header("Refresh: 5; URL=$url");
    } 
    if(isset($_GET["live_one_latlon"])){
        $id=$_GET["id"];
        $sql="SELECT `lat`, `lon` FROM `live_location` WHERE id='$id'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            $response["success"] = 1;
            $response["message"] = "Successfull";
            while($row=mysqli_fetch_row($result)){
                $response["lat"]=urldecode($row[0]);
                $response["lon"]=urldecode($row[1]);
            }
            echo json_encode($response);

        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
    }
    
    if(isset($_GET["live_multiple"])){
        $manager_no=$_GET["manager_no"];
        $sql="SELECT * FROM `live_location` where manager_no='$manager_no' ORDER BY id";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            $response["success"] = 1;
            $response["message"] = "Successfull";
            $response["Drivers"]=array();
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["lat"]=urldecode($row[0]);
                $product["lon"]=urldecode($row[1]);
                $product["name"]=urldecode($row[2]);
                $product["truck"]=urldecode($row[3]);
                $product["manager_no"]=urldecode($row[4]);
                $product["id"]=urldecode($row[5]);
                array_push($response["Drivers"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
        $url=$_SERVER['http://rbtechsolution.com/truck_app/json_response.php?live_multiple=Submit'];
        header("Refresh: 5; URL=$url");
    }
    if(isset($_GET["driver_list"])){
        $manager_no=$_GET["manager_no"];
        $sql="SELECT * FROM `live_location` where manager_no='$manager_no' ORDER BY id";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            $response["success"] = 1;
            $response["message"] = "Successfull";
            $response["Drivers"]=array();
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["id"]=urldecode($row[5]);
                $product["lat"]=urldecode($row[0]);
                $product["lon"]=urldecode($row[1]);
                $product["name"]=urldecode($row[2]);
                $product["truck"]=urldecode($row[3]);
                $product["manager_no"]=urldecode($row[4]);
                array_push($response["Drivers"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
    }
    if(isset($_GET["manager_list"])){
        $sql="SELECT * FROM `manager` ORDER BY id";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            $response["success"] = 1;
            $response["message"] = "Successfull";
            $response["Managers"]=array();
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["name"]=urldecode($row[0]);
                $product["manager_no"]=urldecode($row[1]);
                $product["id"]=urldecode($row[2]);
                array_push($response["Managers"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
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
    if(isset($_GET["live_all_driver_api"])){
        $sql="SELECT * FROM `live_location` ORDER BY id";
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
                    echo 'name="' . parseToXML($row[2]) . '" ';
                    echo 'truck="' . parseToXML($row['3']) . '" ';
                    echo 'manager_no="' . $row[4] . '" ';
                    echo 'id="' . $row[5] . '" ';
                    echo '/>';
                }
                echo '</markers>';
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
        $url=$_SERVER['http://rbtechsolution.com/truck_app/json_response.php?live_multiple=Submit'];
        header("Refresh: 10; URL=$url");
    }
    if(isset($_GET["live_all_driver_once_api"])){
        $sql="SELECT * FROM `live_location` ORDER BY id";
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
                    echo 'name="' . parseToXML($row[2]) . '" ';
                    echo 'truck="' . parseToXML($row['3']) . '" ';
                    echo 'manager_no="' . $row[4] . '" ';
                    echo 'id="' . $row[5] . '" ';
                    echo '/>';
                }
                echo '</markers>';
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
    }
    if(isset($_GET["live_drive_under_mnager_api"])){
        $manager_no=$_GET["manager_no"];
        $sql="SELECT * FROM `live_location` where manager_no='$manager_no' ORDER BY id";
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
                    echo 'name="' . parseToXML($row[2]) . '" ';
                    echo 'truck="' . parseToXML($row['3']) . '" ';
                    echo 'manager_no="' . $row[4] . '" ';
                    echo 'id="' . $row[5] . '" ';
                    echo '/>';
                }
                echo '</markers>';
        }
        else
        {
            $response["success"] = 0;
            $response["message"] = "No driver found";
            echo json_encode($response);
        }
        $url=$_SERVER['http://rbtechsolution.com/truck_app/json_response.php?live_multiple=Submit'];
        header("Refresh: 10; URL=$url");
    }
}
catch(PDOException $e)
{
}
?>