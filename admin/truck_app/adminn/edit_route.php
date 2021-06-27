<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <style>
            p.poi {
               height: 100;
            }
        </style>
        <meta charset="UTF-8" />
        <title>Login Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
    </head>
    <body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "nadaa93i_gaurav";
    $password = "root@123";
    $dbname = "nadaa93i_Jrarron";
    try 
    {   $message="";
        $conn = new mysqli($servername, $username, $password,$dbname);
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="adminLogin.php";
                </script>';
        }
        $pl=$_SESSION['place'] ;
        $cat=$_SESSION['category'];
        $imgn=$_SESSION['image_name'];
        $abt=$_SESSION['about'] ;
        $poi=$_SESSION['poi'];
        $ID=$_SESSION['ID'];
        $source=$_SESSION['source'];
        $destination=$_SESSION['destination'];
        $poii=explode('|', $poi);

        if(isset($_POST["register"])){
            $route_name=$_POST["passwordsignup"];
            $sourceNew=$_POST["source"];
            $destinationNew=$_POST["destination"];
            $about_route=$_POST["passwordsignup_confirm"];
            $poi=$_POST["poi"];
            for ($num = 1; $num <= 9; $num ++) { 
                $temp='poi'.$num;
                if($_POST[$temp]!=""){
                    $poi=$poi.'|'.$_POST[$temp];
                }
            }
		    if(isset($_FILES['imageUpload']) && !empty($_FILES['imageUpload']['name'])){
		        $target_dir = "uploads/";
                $target_file = $target_dir . $cat.$route_name.basename($_FILES["imageUpload"]["name"]);
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		        if(isset($_FILES['poiAudio']) && !empty($_FILES['poiAudio']['name'])){
		            $target_dirPOI = "poi/";
                    $target_filePOI = $target_dirPOI . $cat.$route_name. basename($_FILES["poiAudio"]["name"]);
                    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["poiAudio"]["tmp_name"], $target_filePOI)) {
                        $images= $cat.$route_name.basename( $_FILES["imageUpload"]["name"],".jpg"); 
                        $actualpath = "https://bazar4you.online/gaurav/Jrarron/admin/web/uploads/$images";
                        $imagesPOI=$cat.$route_name.basename( $_FILES["poiAudio"]["name"],".jpg"); 
                        $actualpathPOI = "https://bazar4you.online/gaurav/Jrarron/admin/web/poi/$imagesPOI";
                                try {
                                    $con = new mysqli($servername, $username, $password,$dbname);
                                    $sql = "UPDATE `admin` SET place='$route_name' `rating`='0',`img_name`='$images',`img_url`='$actualpath',
                                            `about_route`='$about_route',`point_of_interest`='$poi',`poi_audio_file`='$target_filePOI',`source`='$sourceNew',`destination`='$destinationNew' WHERE category='$cat' and route_id='$ID' ";
                                    $_SESSION["end"]="true";
                                    if ($conn->query($sql)) {
                                        $message="Route successfully Updated.";
                                    } 
                                    else 
                                    {
                                        $message="Error while Updating1";
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    $message="Error in Network";
                                    $_SESSION["end"]="false";

                                }
                    } 
                    else {
                        $message="Sorry, there was an error uploading your file.";
                    }
		        }
                else{
                    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file) ) {
                        $images= $cat.$route_name.basename( $_FILES["imageUpload"]["name"],".jpg"); 
                        $actualpath = "https://bazar4you.online/gaurav/Jrarron/admin/web/uploads/$images";
                                try {
                                    $con = new mysqli($servername, $username, $password,$dbname);
                                    $sql = "UPDATE `admin` SET place='$route_name' `rating`='0',`img_name`='$images',`img_url`='$actualpath',
                                            `about_route`='$about_route',`point_of_interest`='$poi',`source`='$sourceNew',`destination`='$destinationNew' WHERE category='$cat' and route_id='$ID' ";
                                    $_SESSION["end"]="true";
                                    if ($conn->query($sql)) {
                                        $message="Route successfully Updated.";
                                    } 
                                    else 
                                    {
                                        $message="Error while Updating2";
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    $message="Error in Network";
                                    $_SESSION["end"]="false";
                                }
                    } 
                    else {
                        $message="Sorry, there was an error uploading your file.";
                    }
                }
		    }
            else{
                try {
                        $con = new mysqli($servername, $username, $password,$dbname);
                        $sql = "UPDATE `admin` SET place='$route_name' ,`rating`='0',
                                    `about_route`='$about_route',`point_of_interest`='$poi',`source`='$sourceNew',`destination`='$destinationNew' WHERE category='$cat' and route_id='$ID' ";
                        $_SESSION["end"]="true";
                        if ($conn->query($sql)) {
                               $message="Route successfully Updated.";
                        } 
                        else 
                        {
                                $message="Error while Updating3";
                        }
                    }
                    catch(PDOException $e)
                    {
                        $message="Error in Network";
                        $_SESSION["end"]="false";
                    }
            }
        }
        }
        catch(PDOException $e)
        {
        }
    ?>
        <div class="container">
            <header>
				<nav class="codrops-demos">
				</nav>
            </header>
            <section>				
                <div id="container_demo" >
                    <div id="wrapper">

                        <div id="login" class="animate form">
                            <form  action="" method="post" autocomplete="on" enctype="multipart/form-data"> 
                                <h1> Add New Route </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname"  > Category </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="text" value="<?=$cat?>" placeholder="<?=$cat?>" readonly/>
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" >Route Name</label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="text" value="<?=$pl?>" placeholder="<?=$pl?>" />
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Source</label>
                                    <input id="source" name="source" required="required" type="text" maxlength="100" placeholder="eg. Berclona"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Destination</label>
                                    <input id="destination" name="destination" required="required" type="text" maxlength="100" placeholder="eg. Berclona"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >About Route</label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="text" value="<?=$abt?>" placeholder="<?=$abt?>"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest</label>
                                    <label for="passwordsignup_confirm" class="youpasswd" onclick="myFunction('poi')" style="  margin-left: 280px;font-size: 10px;">+Add</label>
                                    <input id="poi" name="poi"  type="text" value="<?=$poii[0]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b" onclick="myFunctionn('b','poi')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi1" name="poi1"  type="text" value="<?=$poii[1]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b1" onclick="myFunctionn('b1','poi1')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi2" name="poi2"  type="text" value="<?=$poii[2]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b2" onclick="myFunctionn('b2','poi2')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi3" name="poi3"  type="text" value="<?=$poii[3]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b3" onclick="myFunctionn('b3','poi3')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi4" name="poi4"  type="text" value="<?=$poii[4]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b4" onclick="myFunctionn('b4','poi4')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi5" name="poi5"  type="text" value="<?=$poii[5]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b5" onclick="myFunctionn('b5','poi5')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi6" name="poi6"  type="text" value="<?=$poii[6]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b6" onclick="myFunctionn('b6','poi6')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi7" name="poi7" type="text" value="<?=$poii[7]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b7" onclick="myFunctionn('b7','poi7')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi8" name="poi8"  type="text" value="<?=$poii[8]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b8" onclick="myFunctionn('b8','poi8')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    <input id="poi9" name="poi9" type="text" value="<?=$poii[9]?>" placeholder="eg.Sagrada Famili "/>
                                    <label id="b9" onclick="myFunctionn('b9','poi9')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
<script>
var i='';
var j;
var y;
if(document.getElementById('poi')==''){
    y = document.getElementById('poi');
    y.style.display = "none";
    y = document.getElementById('b');
    y.style.display = "none";
    i=1;
}
for (j = 1; j < 10; j++) { 
      y = document.getElementById('poi'+j);
      var q = document.getElementById('b'+j);
      if(y.value==''){
      y.style.display = "none";
      q.style.display = "none";
      }
      else{
          i++;
      }
}
function myFunction(id) {
  var x = document.getElementById(id+i);
    x.style.display = "block";
    var z = document.getElementById('b'+i);
    z.style.display = "block";
  i++;

}
function myFunctionn(id,idd) {
  var x = document.getElementById(id);
    x.style.display = "none";
    var z = document.getElementById(idd);
            document.getElementById(idd).value = "";
    z.style.display = "none";
      var res = id.substring(1, 2);

    i='';
}
</script>                                    
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Image</label>
                                    <input  type="file" id="imageUpload" name="imageUpload" class="to_register"  />
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest Audio file</label>
                                    <input type="file" id="poiAudio" name="poiAudio" class="to_register"/>
                                </p>
                                <p class="signin button"> 
									<input type="submit" name="register" value="Done"/> 
								</p>
								<p class="uname">
                                    <?=$message?>
                                </p>
                                <p class="change_link">  
									Don't want to edit  route ?
									<a href="tables.php" class="to_register"> Go to Tables view </a>
								</p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
