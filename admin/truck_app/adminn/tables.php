<!DOCTYPE html>
<head>
<title>Admin Panel Tables</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Colored Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link rel="stylesheet" href="css/bootstrap.css">
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
<script src="js/jquery2.0.3.min.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/screenfull.js"></script>
<script>
	$(function () {
		$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

		if (!screenfull.enabled) {
			return false;
		}

		$('#toggle').click(function () {
			screenfull.toggle($('#container')[0]);
		});	
	});
</script>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();

      $('#table-breakpoint').basictable({
        breakpoint: 768
      });

      $('#table-swap-axis').basictable({
        swapAxis: true
      });

      $('#table-force-off').basictable({
        forceResponsive: false
      });

      $('#table-no-resize').basictable({
        noResize: true
      });

      $('#table-two-axis').basictable();

      $('#table-max-height').basictable({
        tableWrapper: true
      });
    });
</script>
</head>
<body class="dashboard-page">
<?php
session_start();
$servername = "localhost";
$username = "nadaa93i_gaurav";
$password = "root@123";
$dbname = "nadaa93i_Jrarron";
try 
{
        $conn = new mysqli($servername, $username, $password,$dbname);
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="adminLogin.php";
                </script>';
        }
        if(isset($_POST["reset"])){
            $uname=$_POST["usernamesignup"];
            $password=$_POST["passwordsignup"];
            $repassword=$_POST["passwordsignup_confirm"];
            if($password==$repassword)
            {
                $sql="select * from admin_login where user_name='$uname'";
                $result = mysqli_query($conn,$sql) or die(mysql_error());
                if(mysqli_num_rows($result) > 0)
                {
                    $sql = "UPDATE `admin_login` SET `password`='$password'  user_name='$uname'";
                    if ($conn->query($sql)) {
                        $_SESSION["end"]="true";
                        echo '<script>
                            window.location="tables.php";
                        </script>';
                        $message= "Password successfully Updated.";
                    } 
                    else 
                    {
                        $message= "Oops! An error occurred.";
                    }
                }
                else
                {
                    
                        $message= "User name or Email  not exist.";
                }
            
            }
            else
            {
                        $message= "Password Doesn't match";
            }
            
        }
        if(isset($_POST["logout"]))
        {
            $_SESSION["end"]="false";
            session_destroy(); 
            echo '<script>
                    window.location="adminLogin.php";
                    </script>';
        }
        if(isset($_POST["resets"]))
        {
            $_SESSION["end"]="true";
            echo '<script>
                    window.location="changepassword.php";
                    </script>';
        }
        if(isset($_POST["add"]))
        {
            $_SESSION["end"]="true";
            echo '<script>
                    window.location="add_new.php";
                    </script>';
        }
}
catch(PDOException $e)
{
}
?>
	<section class="wrapper scrollable">
		<div class="main-grid">
			<div class="agile-grids">	
				<!-- tables -->
				
				<div class="table-heading">
					<h2>Jrarron</h2>
				</div>
				<div>
				    <form action="" method="post" >
				        <p class="login button" > 
                            <input type="submit" name="resets" value="Reset Password" /> 
					    </p>
					</form>
					<form action="" method="post" >
				        <p class="login button" > 
                            <input type="submit" name="logout" value="Logout" /> 
					    </p>
					</form>
					<form action="" method="post" >
				        <p class="login button" > 
                            <input type="submit" id="add" name="add" value="Add New Route" /> 
					    </p>
					</form>
				</div>
				<div class="agile-tables">
				<div class="w3l-table-info">
			<h3><u><b>Routes Tables</b></u></h3>
			<h3>Driving</h3>
					    <table id="addBook">
					          <col width="60">
					          <col width="60">
					          <col width="150">
					          <col width="150">
					          <col width="100">

						<thead>
						  <tr>
							<th>Route Name</th>
							<th>Image</th>
							<th>About Route</th>
							<th>Point of interest separated by '|'</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
						    $servername = "localhost";
                            $username = "nadaa93i_gaurav";
                            $password = "root@123";
                            $dbname = "nadaa93i_Jrarron";
                          function accept($pl,$rt,$cat,$imgn,$abt,$poi,$ID) {
                                $_SESSION['place'] = $pl;
                                $_SESSION['rating'] = $rt;
                                $_SESSION['category'] = $cat;
                                $_SESSION['image_name'] = $imgn;
                                $_SESSION['about'] = $abt;
                                $_SESSION['poi'] = $poi;
                                $_SESSION['ID'] = $ID;
                                $_SESSION["end"]="true";
                                echo '<script>
                                    window.location="edit_route.php";
                                </script>';
                            }
                                 
                        function reject($un,$bn) {
                            $serverna = "localhost";
                            $userna = "nadaa93i_gaurav";
                            $passwo = "root@123";
                            $dbne = "nadaa93i_Jrarron";
                            try {
                                    $co = new mysqli($serverna, $userna, $passwo,$dbne);
                                    $sq = "DELETE FROM admin WHERE place='$un' and category='$bn'";
                                    $co->query($sq);
                                    $_SESSION["end"]="true";
                                                  
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            }
                                  try {
                                    $conn = new mysqli($servername, $username, $password,$dbname);
                                    $results = mysqli_query($conn,"SELECT * FROM `admin` where category='Driving'");
                                    while($row=mysqli_fetch_row($results)){
                                        $one=urldecode($row[0]);
                                        $two=urldecode($row[1]);
                                        $three=urldecode($row[4]);
                                        $four=urldecode($row[5]);
                                        $five=urldecode($row[6]);
                                        $six=urldecode($row[2]);
                                        $s=$one.'*'.$six.'*'.$row[3].'*'.$two.'*'.$four.'*'.$five.'*'.$row[8];
                                    echo "
                                    <tr>
                                        <td>$one</td>
                                        <td><img src='$three' height='50px' width='50px'></td>
                                        <td>$four</td>
                                        <td>$five</td>
                                        <td>
                                            <form action='' method='post'>
                                                <input type='hidden' name='sub' value='1'>
                                                <button id='accept' name ='accept' value = '$s' style='margin:5px;' >Edit</button>
								                <button id='reject' name ='reject' value = '$s' style='margin:5px;'>Delete</button>
								            <form>
								        </td>
								    </tr>
								    ";
								    if(isset($_POST["accept"]))
								    {              
								        $onee=explode('*', $_POST["accept"]);
								        accept($onee[0],$onee[3],$onee[1],$onee[2],$onee[4],$onee[5],$onee[6]);
								        
								    }
								    if(isset($_POST["reject"]))
								    {
								        $onee=explode('*', $_POST["reject"]);
								        reject($onee[0],$onee[1]);

								    }
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
				<h3>Bike</h3>
					    <table id="addBook">
					        <col width="60">
					          <col width="60">
					          <col width="150">
					          <col width="150">
					          <col width="100">
						<thead>
						  <tr>
							<th>Route Name</th>
							<th>Image</th>
							<th>About Route</th>
							<th>Point of interest separated by '|'</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
						    $servername = "localhost";
                            $username = "nadaa93i_gaurav";
                            $password = "root@123";
                            $dbname = "nadaa93i_Jrarron";
                          function acceptBike($pl,$rt,$cat,$imgn,$abt,$poi,$ID) {
                                $_SESSION['place'] = $pl;
                                $_SESSION['rating'] = $rt;
                                $_SESSION['category'] = $cat;
                                $_SESSION['image_name'] = $imgn;
                                $_SESSION['about'] = $abt;
                                $_SESSION['poi'] = $poi;
                                $_SESSION['ID'] = $ID;
                                $_SESSION["end"]="true";
                                echo '<script>
                                    window.location="edit_route.php";
                                </script>';
                            }
                                 
                        function rejectBike($un,$bn) {
                            $serverna = "localhost";
                            $userna = "nadaa93i_gaurav";
                            $passwo = "root@123";
                            $dbne = "nadaa93i_Jrarron";
                            try {
                                    $co = new mysqli($serverna, $userna, $passwo,$dbne);
                                    $sq = "DELETE FROM admin WHERE place='$un' and category='$bn'";
                                    $co->query($sq);
                                    $_SESSION["end"]="true";
                                                  
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            }
                                  try {
                                    $conn = new mysqli($servername, $username, $password,$dbname);
                                    $results = mysqli_query($conn,"SELECT * FROM `admin` where category='Bike'");
                                    while($row=mysqli_fetch_row($results)){
                                        $one=urldecode($row[0]);
                                        $two=urldecode($row[1]);
                                        $three=urldecode($row[4]);
                                        $four=urldecode($row[5]);
                                        $five=urldecode($row[6]);
                                        $six=urldecode($row[2]);
                                        $s=$one.'*'.$six.'*'.$row[3].'*'.$two.'*'.$four.'*'.$five.'*'.$row[8];
                                    echo "
                                    <tr>
                                        <td>$one</td>
                                        <td><img src='$three' height='50px' width='50px'></td>
                                        <td>$four</td>
                                        <td>$five</td>
                                        <td>
                                            <form action='' method='post'>
                                                <input type='hidden' name='sub' value='1'>
                                                <button id='accept' name ='accept' value = '$s' style='margin:5px;' >Edit</button>
								                <button id='reject' name ='reject' value = '$s' style='margin:5px;'>Delete</button>
								            <form>
								        </td>
								    </tr>
								    ";
								    if(isset($_POST["accept"]))
								    {              
								        $onee=explode('*', $_POST["accept"]);
								        acceptBike($onee[0],$onee[3],$onee[1],$onee[2],$onee[4],$onee[5],$onee[6]);
								        
								    }
								    if(isset($_POST["reject"]))
								    {
								        $onee=explode('*', $_POST["reject"]);
								        rejectBike($onee[0],$onee[1]);

								    }
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
            <h3>Walking</h3>
					    <table id="addBook">
					        <col width="60">
					          <col width="60">
					          <col width="150">
					          <col width="150">
					          <col width="100">
						<thead>
						  <tr>
							<th>Route Name</th>
							<th>Image</th>
							<th>About Route</th>
							<th>Point of interest separated by '|'</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
						    $servername = "localhost";
                            $username = "nadaa93i_gaurav";
                            $password = "root@123";
                            $dbname = "nadaa93i_Jrarron";
                          function acceptWalking($pl,$rt,$cat,$imgn,$abt,$poi,$ID) {
                                $_SESSION['place'] = $pl;
                                $_SESSION['rating'] = $rt;
                                $_SESSION['category'] = $cat;
                                $_SESSION['image_name'] = $imgn;
                                $_SESSION['about'] = $abt;
                                $_SESSION['poi'] = $poi;
                                $_SESSION['ID'] = $ID;
                                $_SESSION["end"]="true";
                                echo '<script>
                                    window.location="edit_route.php";
                                </script>';
                            }
                                 
                        function rejectWalking($un,$bn) {
                            $serverna = "localhost";
                            $userna = "nadaa93i_gaurav";
                            $passwo = "root@123";
                            $dbne = "nadaa93i_Jrarron";
                            try {
                                    $co = new mysqli($serverna, $userna, $passwo,$dbne);
                                    $sq = "DELETE FROM admin WHERE place='$un' and category='$bn'";
                                    $co->query($sq);
                                    $_SESSION["end"]="true";
                                                  
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            }
                                  try {
                                    $conn = new mysqli($servername, $username, $password,$dbname);
                                    $results = mysqli_query($conn,"SELECT * FROM `admin` where category='Walking'");
                                    while($row=mysqli_fetch_row($results)){
                                        $one=urldecode($row[0]);
                                        $two=urldecode($row[1]);
                                        $three=urldecode($row[4]);
                                        $four=urldecode($row[5]);
                                        $five=urldecode($row[6]);
                                        $six=urldecode($row[2]);
                                        $s=$one.'*'.$six.'*'.$row[3].'*'.$two.'*'.$four.'*'.$five.'*'.$row[8];
                                    echo "
                                    <tr>
                                        <td>$one</td>
                                        <td><img src='$three' height='50px' width='50px'></td>
                                        <td>$four</td>
                                        <td>$five</td>
                                        <td>
                                            <form action='' method='post'>
                                                <input type='hidden' name='sub' value='1'>
                                                <button id='accept' name ='accept' value = '$s' style='margin:5px;' >Edit</button>
								                <button id='reject' name ='reject' value = '$s' style='margin:5px;'>Delete</button>
								            <form>
								        </td>
								    </tr>
								    ";
								    if(isset($_POST["accept"]))
								    {              
								        $onee=explode('*', $_POST["accept"]);
								        acceptWalking($onee[0],$onee[3],$onee[1],$onee[2],$onee[4],$onee[5],$onee[6]);
								        
								    }
								    if(isset($_POST["reject"]))
								    {
								        $onee=explode('*', $_POST["reject"]);
								        rejectWalking($onee[0],$onee[1]);

								    }
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
				<h3>Scooter</h3>
					    <table id="addBook">
					        <col width="60">
					          <col width="60">
					          <col width="150">
					          <col width="150">
					          <col width="100">
						<thead>
						  <tr>
							<th>Route Name</th>
							<th>Image</th>
							<th>About Route</th>
							<th>Point of interest separated by '|'</th>
							<th>Modify</th>

						  </tr>
						</thead>
						<tbody>
						    <?php
						    $servername = "localhost";
                            $username = "nadaa93i_gaurav";
                            $password = "root@123";
                            $dbname = "nadaa93i_Jrarron";
                          function acceptScooter($pl,$rt,$cat,$imgn,$abt,$poi,$ID) {
                                $_SESSION['place'] = $pl;
                                $_SESSION['rating'] = $rt;
                                $_SESSION['category'] = $cat;
                                $_SESSION['image_name'] = $imgn;
                                $_SESSION['about'] = $abt;
                                $_SESSION['poi'] = $poi;
                                $_SESSION['ID'] = $ID;
                                $_SESSION["end"]="true";
                                echo '<script>
                                    window.location="edit_route.php";
                                </script>';
                            }
                                 
                        function rejectScooter($un,$bn) {
                            $serverna = "localhost";
                            $userna = "nadaa93i_gaurav";
                            $passwo = "root@123";
                            $dbne = "nadaa93i_Jrarron";
                            try {
                                    $co = new mysqli($serverna, $userna, $passwo,$dbne);
                                    $sq = "DELETE FROM admin WHERE place='$un' and category='$bn'";
                                    $co->query($sq);
                                    $_SESSION["end"]="true";
                                                  
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            }
                                  try {
                                    $conn = new mysqli($servername, $username, $password,$dbname);
                                    $results = mysqli_query($conn,"SELECT * FROM `admin` where category='Scooter'");
                                    while($row=mysqli_fetch_row($results)){
                                        $one=urldecode($row[0]);
                                        $two=urldecode($row[1]);
                                        $three=urldecode($row[4]);
                                        $four=urldecode($row[5]);
                                        $five=urldecode($row[6]);
                                        $six=urldecode($row[2]);
                                        $s=$one.'*'.$six.'*'.$row[3].'*'.$two.'*'.$four.'*'.$five.'*'.$row[8];
                                    echo "
                                    <tr>
                                        <td>$one</td>
                                        <td><img src='$three' height='50px' width='50px'></td>
                                        <td>$four</td>
                                        <td>$five</td>
                                        <td>
                                            <form action='' method='post'>
                                                <input type='hidden' name='sub' value='1'>
                                                <button id='accept' name ='accept' value = '$s' style='margin:5px;' >Edit</button>
								                <button id='reject' name ='reject' value = '$s' style='margin:5px;'>Delete</button>
								            <form>
								        </td>
								    </tr>
								    ";
								    if(isset($_POST["accept"]))
								    {              
								        $onee=explode('*', $_POST["accept"]);
								        acceptScooter($onee[0],$onee[3],$onee[1],$onee[2],$onee[4],$onee[5],$onee[6]);
								        
								    }
								    if(isset($_POST["reject"]))
								    {
								        $onee=explode('*', $_POST["reject"]);
								        rejectScooter($onee[0],$onee[1]);

								    }
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table>
					</div></br></br>
			<h3><u><b>Feedbacks Tables</b></u></h3>
				 <table id="acceptUser" class="max-height">
					<thead>
					  <tr>
						<th>Category</th>
						<th>User Name</th>
						<th>User Email</th>
						<th>Route Name</th>
						<th>Feedback</th>
						<th>Rating</th>
						<th>Delete</th>
					
					  </tr>
					</thead>
					<tbody>
					  <?php
						    $servername = "localhost";
                            $username = "nadaa93i_gaurav";
                            $password = "root@123";
                            $dbname = "nadaa93i_book_app";

                          function delete($em,$cat,$pl,$feed) {
                            $servernam = "localhost";
                            $usernam = "nadaa93i_gaurav";
                            $passwor = "root@123";
                            $dbnam = "nadaa93i_Jrarron";
                            try {
                            $con = new mysqli($servernam, $usernam, $passwor,$dbnam);
                                    $sq = "DELETE FROM feedback WHERE email = '$em' and place = '$pl' and category = '$cat' and feedback = '$feed'";
                                    $con->query($sq);
                                    $_SESSION["end"]="true";
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            }
                                
                            try {
                                    $conn = new mysqli($servername, $username, $password,$dbname);
                                    $results = mysqli_query($conn,"SELECT * FROM `feedback`");
                                    while($row=mysqli_fetch_row($results)){
                                        $s=$row[1].'*'.$row[2].'*'.$row[3].'*'.$row[4];
                                        echo "
                                        <tr>
                                            <td>$row[2]</td>
                                            <td>$row[0]</td>
                                            <td>$row[1]</td>
                                            <td>$row[3]</td>
                                            <td>$row[4]</td>
                                            <td>$row[5]</td>
                                            <td>
                                                <form action='' method='post'>
                                                    <input type='hidden' name='sub' value='1'>
                                                    <button id='delete' name ='delete' value = '$s' style='margin:5px;' >Delete</button>
								                </form>
								            </td>
								        </tr>
								        "; 
								        if(isset($_POST["delete"]))
								        {            
								            $onee=explode('*', $_POST["reject"]);
								            delete($onee[0],$onee[1],$onee[2],$onee[3]);
								        }
								  }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
					</tbody>
				  </table>
				</div>
			</div>
		</div>
	</section>
	<script src="js/bootstrap.js"></script>
	<script src="js/proton.js"></script>
</body>
</html>
