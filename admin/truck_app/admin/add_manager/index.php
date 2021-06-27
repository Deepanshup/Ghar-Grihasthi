<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="sasdWwoAAYoZi0sVHrtjsAvG5TIzH6ArKcrta2Vo">

    <title>22Ggroup</title>

    <link rel="icon" sizes="72x72" href="../public/images/favicon-96x96.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900%7COpen+Sans:300,400,600,700,800"
          rel="stylesheet">
    <link rel="stylesheet" href="../public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/magnific-popup.css">
    <link rel="stylesheet" href="../public/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/settings.css">
    <link rel="stylesheet" type="text/css" href="../public/css/layers.css">
    <link rel="stylesheet" type="text/css" href="../public/css/navigation.css">
    <link rel="stylesheet" href="../public/css/animate.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link data-style="color-style" rel="stylesheet" href="../public/css/color-blue.css">
    <script src="../public/js/modernizr-2.8.3.min.js"></script>

</head>
<body style="height: 100vh" >
<?php
session_start();
$servername = "localhost";
$username = "nadaa93i_gaurav";
$password = "root@123";
$dbname = "nadaa93i_truck_app";
try 
{
        $conn = new mysqli($servername, $username, $password,$dbname);
        $one="";
        $message="";
        $messages="";
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="../../admin/";
                </script>';
        }
        if(isset($_POST["register"])){
            $name=$_POST["name"];
            $manager_no=$_POST["manager_no"];
            $sql="select * from manager where name='$name' and manager_no='$manager_no'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0)
            {
                while($row=mysqli_fetch_row($result)){
                    $one=$row[2];
                    $messages= "Manager Already Exist.Want to update Driver??";
                }
            }
            else
            {
                $sql = "INSERT INTO `manager`(`name`, `manager_no`) VALUES ('$name','$manager_no')";
                if ($conn->query($sql)) {
                    $message="Manager successfully Added.";
                } 
                else 
                {
                     $message="Error while adding";
                }
            }
        }
}
catch(PDOException $e)
{
    $_SESSION["end"]="false";
}
?>
<div style="text-align: center"><img src="../public/logo.jpeg" style="width:20%"></div>
<div id="app">
    <main class="py-4">
    <div class="main-content section-padding">
        <div class="container">
            <div class="col-md-4 col-md-offset-4">
                <form class="contact-form" method="POST" action="">
                    <div class="row">
                        <div class="input-group">
                            <label for="name" class="col-form-label text-md-right"><h4>Manager's Name</h4></label>
                            <input type="text" name="name"  required autofocus placeholder="Name"  class="input-group__input form-control is-invalid"/>
                                <span class="invalid-feedback col-md-12" role="alert">
                                    <strong><?=$message?></strong>
                                    <a style="text-decoration:none" href="./update_manager.php?id=<?php echo $one; ?>"><strong><?=$messages?></strong></a>
                                </span>
                        </div>
                        <div class="input-group">
                            <label for="manager_no" class="col-form-label text-md-right"><h4>Manager's Number</h4></label>
                            <input type="number" name="manager_no" placeholder="Enter Mobile No." required  class="input-group__input form-control"/>
                        </div>
                        <button type="submit"  style="background-color: #D4AF37" name="register" class="btn base-bg">
                            Add Manager
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>
</div>


    <script src="../public/js/jquery-2.2.4.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
    <script src="../public/js/mixitup.min.js"></script>
    <script src="../public/js/select2.min.js"></script>
    <script src="../public/js/jquery.colorbox-min.js"></script>
    <script src="../public/js/jquery.waypoints.min.js"></script>
    <script src="../public/js/jquery.counterup.min.js"></script>
    <script src="../public/js/slick.min.js"></script>
    <script src="../public/js/jquery.plugin.js"></script>
    <script src="../public/js/jquery.countdown.min.js"></script>
    <script src="../public/js/wow.min.js"></script>
    <script src="../public/js/revolution/jquery.themepunch.tools.min.js"></script>
    <script src="../public/js/revolution/jquery.themepunch.revolution.min.js"></script>
    <script src="../public/js/revolution/extensions/revolution.extension.actions.min.js"></script>
    <script src="../public/js/revolution/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="../public/js/revolution/extensions/revolution.extension.navigation.min.js"></script>
    <script src="../public/js/revolution/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="../public/js/revolution-active.js"></script>
    <script src="../public/js/custom.js"></script>
</body>
</html>
