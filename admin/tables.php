<?php
session_start();
?>
<!DOCTYPE html>
<head>
<title>Lavina | Distributors List</title>
<link rel="icon" sizes="72x72" href="./images/logo.png">
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
    include("../wp-config.php");
    include("./configg.php");
    require "../phpmail/PHPMailerAutoload.php";
    $servername = DB_HOST;
    $username = DB_USER;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;
    try 
    {
        $conn = new mysqli($servername, $username, $password,$dbname);
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="adminLogin.php";
                </script>';
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
					<h2>Lavina Admin Panel</h2>
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
				</div>
				<div class="agile-tables">
				<div class="w3l-table-info">
			        <h3><u><b>Distrubuters Tables</b></u></h3>
			        <h3>Verified Distributors</h3>
					<table id="addBook">
						<thead>
						  <tr>
							<th>S. No.</th>
							<th>Distributor's Name</th>
							<th>Distributor's Email</th>
							<th>Distributor's Contact No.</th>
							<th>Alloted Discount</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
                                $servername = DB_HOST;
                                $username = DB_USER;
                                $password = DB_PASSWORD;
                                $dbname = DB_NAME;
                                function accept($em,$dc) {
                                    $_SESSION['email'] = $em;
                                    $_SESSION['discount'] = $dc;
                                    echo '<script>
                                        window.location="edit_route.php";
                                    </script>';
                                }
                                function reject($em) {
                                    $servernamesd = DB_HOST;
                                    $usernamesd = DB_USER;
                                    $passwordsd = DB_PASSWORD;
                                    $dbnamesd = DB_NAME;
                                    $connfunction = new mysqli($servernamesd, $usernamesd, $passwordsd,$dbnamesd);
                                    try {
                                        $sq = "UPDATE `wp_users` SET `user_status`=-1 WHERE user_email='$em' and  user_status=1";
                                        if($connfunction->query($sq)){
                                            $_SESSION["end"]="true";
                                            $mail = new PHPMailer;
                                            $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                            $mail->isSMTP();                                      
                                            $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                            $mail->SMTPAuth = true;                           
                                            $mail->Username = EMAIL;         // SMTP username
                                            $mail->Password = PASSWORD;          // SMTP password
                                            $mail->SMTPSecure = 'tls';                           
                                            $mail->Port = 587;                                    
                                            $mail->setFrom(EMAIL,'By Lavina');
                                            $mail->addAddress($em);     // Add a recipient
                                            $mail->isHTML(true);                                  // Set email format to HTML
                                            $mail->Subject = 'By Laveena Admin Panel ';
                                            $mail->Body    = 'Your Distributor\'s account has been rejected by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                            if(!$mail->send()) {
                                                echo "<script>alert('Error occured, try again later..!!')</script>";
                                            } else {
                                                echo "<script>alert('User rejected  successfully..!! ')</script>";
                                                echo '<script>
                                                    window.location="tables.php";
                                                </script>';
                                            }
                                        }
                                        else{
                                            $_SESSION["end"]="false";
                                            echo '<script>
                                                window.location="adminLogin.php";
                                            </script>';
                                        }            
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo $sql . "<br>" . $e->getMessage();
                                    }
                                }
                                try {
                                    $a=1;
                                    $conn = new mysqli($servername, $username, $password,$dbname);
                                    $results = mysqli_query($conn,"SELECT * FROM `wp_users` where user_status=1");
                                    while($row=mysqli_fetch_row($results)){
                                        $one=urldecode($row[9]);
                                        $two=urldecode($row[4]);
                                        $three=urldecode($row[5]);
                                        $resultss = mysqli_query($conn,"SELECT * FROM `discount_distributers` where email='$two'");
                                        while($rows=mysqli_fetch_row($resultss)){
                                            $four=$rows[1];
                                        }
                                        $s=$two.'*'.$four;
                                            echo "
                                            <tr>
                                                <td>$a."."</td>
                                                <td>$one</td>
                                                <td>$two</td>
                                                <td>$three</td>
                                                <td>$four</td>
                                                <td>
                                                    <form action='' method='post'>
                                                        <input type='hidden' name='sub' value='1'>
                                                        <button id='accept' name ='accept' value = '$s' style='margin:5px;' >Edit</button>
        								                <button id='reject' name ='reject' value = '$s' style='margin:5px;'>De-active Now</button>
        								            <form>
        								        </td>
        								    </tr>
        								    ";
        								    if(isset($_POST["accept"]))
        								    {              
        								        $onee=explode('*', $_POST["accept"]);
        								        accept($onee[0],$onee[1]);
        								        
        								    }
        								    if(isset($_POST["reject"]))
        								    {
        								        $onee=explode('*', $_POST["reject"]);
        								        reject($onee[0]);
        
        								    }
        								    $a++;
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
					<h3>Verification Pending Distributors</h3>
					<table id="addBook">
						<thead>
						  <tr>
							<th>S. No.</th>
							<th>Distributor's Name</th>
							<th>Distributor's Email</th>
							<th>Distributor's Contact No.</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
                                $servernames = DB_HOST;
                                $usernames = DB_USER;
                                $passwords = DB_PASSWORD;
                                $dbnames = DB_NAME;
                                function accepts($em) {
                                    $servernamess = DB_HOST;
                                    $usernamess = DB_USER;
                                    $passwordss = DB_PASSWORD;
                                    $dbnamess = DB_NAME;
                                    $connfunctionss = new mysqli($servernamess, $usernamess, $passwordss,$dbnamess);
                                    try {
                                        $sq = "UPDATE `wp_users` SET `user_status`=1 WHERE user_email='$em' and  user_status=-1";
                                        if($connfunctionss->query($sq)){
                                            $sq = "INSERT INTO `discount_distributers`(`email`) VALUES ('$em')";
                                            if($connfunctionss->query($sq)){
                                                $_SESSION["end"]="true";
                                                $mail = new PHPMailer;
                                                $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                                $mail->isSMTP();                                      
                                                $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                                $mail->SMTPAuth = true;                           
                                                $mail->Username = EMAIL;         // SMTP username
                                                $mail->Password = PASSWORD;          // SMTP password
                                                $mail->SMTPSecure = 'tls';                           
                                                $mail->Port = 587;                                    
                                                $mail->setFrom(EMAIL,'By Lavina');
                                                $mail->addAddress($em);     // Add a recipient
                                                $mail->isHTML(true);                                  // Set email format to HTML
                                                $mail->Subject = 'By Laveena Admin Panel ';
                                                $mail->Body    = 'Your Distributor\'s account has been approved by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                                if(!$mail->send()) {
                                                    echo "<script>alert('Error occured, try again later..!!')</script>";
                                                } else {
                                                    echo "<script>alert('User Activated  successfully..!! ')</script>";
                                                    echo '<script>
                                                        window.location="tables.php";
                                                    </script>';
                                                }
                                            }
                                            else{
                                                $_SESSION["end"]="true";
                                                $mail = new PHPMailer;
                                                $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                                $mail->isSMTP();                                      
                                                $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                                $mail->SMTPAuth = true;                           
                                                $mail->Username = EMAIL;         // SMTP username
                                                $mail->Password = PASSWORD;          // SMTP password
                                                $mail->SMTPSecure = 'tls';                           
                                                $mail->Port = 587;                                    
                                                $mail->setFrom(EMAIL,'By Lavina');
                                                $mail->addAddress($em);     // Add a recipient
                                                $mail->isHTML(true);                                  // Set email format to HTML
                                                $mail->Subject = 'By Laveena Admin Panel ';
                                                $mail->Body    = 'Your Distributor\'s account has been approved by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                                if(!$mail->send()) {
                                                    echo "<script>alert('Error occured, try again later..!!')</script>";
                                                } else {
                                                    echo "<script>alert('User Activated  successfully..!! ')</script>";
                                                    echo '<script>
                                                        window.location="tables.php";
                                                    </script>';
                                                }
                                            }
                                        }
                                        else{
                                            $_SESSION["end"]="false";
                                            echo '<script>
                                                window.location="adminLogin.php";
                                            </script>';
                                        }            
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo $sql . "<br>" . $e->getMessage();
                                    }
                                }
                                function rejects($bn) {
                                    $servernamesss = DB_HOST;
                                    $usernamesss = DB_USER;
                                    $passwordsss = DB_PASSWORD;
                                    $dbnamesss = DB_NAME;
                                    $connfunctionsss = new mysqli($servernamesss, $usernamesss, $passwordsss,$dbnamesss);
                                    try {
                                        $sq = "DELETE FROM `wp_users` WHERE user_email='$em' and  user_status=-1";
                                        if($connfunctionsss->query($sq)){
                                            $_SESSION["end"]="true";
                                            $mail = new PHPMailer;
                                            $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                            $mail->isSMTP();                                      
                                            $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                            $mail->SMTPAuth = true;                           
                                            $mail->Username = EMAIL;         // SMTP username
                                            $mail->Password = PASSWORD;          // SMTP password
                                            $mail->SMTPSecure = 'tls';                           
                                            $mail->Port = 587;                                    
                                            $mail->setFrom(EMAIL,'By Lavina');
                                            $mail->addAddress($em);     // Add a recipient
                                            $mail->isHTML(true);                                  // Set email format to HTML
                                            $mail->Subject = 'By Laveena Admin Panel ';
                                            $mail->Body    = 'Your Distributor\'s account has been deleted by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                            if(!$mail->send()) {
                                                echo "<script>alert('Error occured, try again later..!!')</script>";
                                            } else {
                                                echo "<script>alert('User rejected successfully..!! ')</script>";
                                                echo '<script>
                                                    window.location="tables.php";
                                                </script>';
                                            }
                                        }
                                        else{
                                            $_SESSION["end"]="false";
                                            echo '<script>
                                                window.location="adminLogin.php";
                                            </script>';
                                        }            
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo $sql . "<br>" . $e->getMessage();
                                    }
                                }
                                try {
                                    $aa=1;
                                    $conn = new mysqli($servernames, $usernames, $passwords,$dbnames);
                                    $results = mysqli_query($conn,"SELECT * FROM `wp_users` where user_status=-1");
                                    while($row=mysqli_fetch_row($results)){
                                        $one=urldecode($row[9]);
                                        $two=urldecode($row[4]);
                                        $three=urldecode($row[5]);
                                        $s=$two;
                                        echo "
                                        <tr>
                                            <td>$aa."."</td>
                                            <td>$one</td>
                                            <td>$two</td>
                                            <td>$three</td>
                                            <td>
                                                <form action='' method='post'>
                                                    <input type='hidden' name='sub' value='1'>
                                                    <button id='accepts' name ='accepts' value = '$s' style='margin:5px;' >Active Now</button>
    								                <button id='rejects' name ='rejects' value = '$s' style='margin:5px;'>Reject Request</button>
    								            <form>
    								        </td>
    								    </tr>
    								    ";
    								    if(isset($_POST["accepts"]))
    								    {              
    								        $onee=explode('*', $_POST["accepts"]);
    								        accepts($onee[0]);
    								    }
    								    if(isset($_POST["rejects"]))
    								    {
    								        $onee=explode('*', $_POST["rejects"]);
    								        rejects($onee[0]);
    								    }
    								    $aa++;
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
					
					
					<h3><u><b>Sales Person's Tables</b></u></h3>
			        <h3>Verified Sales Person's</h3>
					<table id="addBook">
						<thead>
						  <tr>
							<th>S. No.</th>
							<th>Sales Person's Name</th>
							<th>Sales Person's Email</th>
							<th>Sales Person's Contact No.</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
                                $servername1 = DB_HOST;
                                $username1 = DB_USER;
                                $password1 = DB_PASSWORD;
                                $dbname1 = DB_NAME;
                                function accept1($em) {
                                    $_SESSION['email'] = $em;
                                    echo '<script>
                                        window.location="view_map.php";
                                    </script>';
                                }
                                function reject1($em) {
                                    $servernamesd1 = DB_HOST;
                                    $usernamesd1 = DB_USER;
                                    $passwordsd1 = DB_PASSWORD;
                                    $dbnamesd1 = DB_NAME;
                                    $connfunction = new mysqli($servernamesd1, $usernamesd1, $passwordsd1,$dbnamesd1);
                                    try {
                                        $sq = "UPDATE `wp_users` SET `user_status`=-2 WHERE user_email='$em' and  user_status=2";
                                        if($connfunction->query($sq)){
                                            $_SESSION["end"]="true";
                                            $mail = new PHPMailer;
                                            $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                            $mail->isSMTP();                                      
                                            $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                            $mail->SMTPAuth = true;                           
                                            $mail->Username = EMAIL;         // SMTP username
                                            $mail->Password = PASSWORD;          // SMTP password
                                            $mail->SMTPSecure = 'tls';                           
                                            $mail->Port = 587;                                    
                                            $mail->setFrom(EMAIL,'By Lavina');
                                            $mail->addAddress($em);     // Add a recipient
                                            $mail->isHTML(true);                                  // Set email format to HTML
                                            $mail->Subject = 'By Laveena Admin Panel ';
                                            $mail->Body    = 'Your Sales Person\'s account has been rejected by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                            if(!$mail->send()) {
                                                echo "<script>alert('Error occured, try again later..!!')</script>";
                                            } else {
                                                echo "<script>alert('User rejected  successfully..!! ')</script>";
                                                echo '<script>
                                                    window.location="tables.php";
                                                </script>';
                                            }
                                         }
                                        else{
                                            $_SESSION["end"]="false";
                                            echo '<script>
                                                window.location="adminLogin.php";
                                            </script>';
                                        }            
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo $sql . "<br>" . $e->getMessage();
                                    }
                                }
                                try {
                                    $a1=1;
                                    $conn1 = new mysqli($servername1, $username1, $password1,$dbname1);
                                    $results1 = mysqli_query($conn1,"SELECT * FROM `wp_users` where user_status=2");
                                    while($row1=mysqli_fetch_row($results1)){
                                        $one1=urldecode($row1[9]);
                                        $two1=urldecode($row1[4]);
                                        $three1=urldecode($row1[5]);
                                        $s1=$two1;
                                            echo "
                                            <tr>
                                                <td>$a1."."</td>
                                                <td>$one1</td>
                                                <td>$two1</td>
                                                <td>$three1</td>
                                                <td>
                                                    <form action='' method='post'>
                                                        <input type='hidden' name='sub' value='1'>
                                                        <button id='accept1' name ='accept1' value = '$s1' style='margin:5px;' >View</button>
        								                <button id='reject1' name ='reject1' value = '$s1' style='margin:5px;'>De-active Now</button>
        								            <form>
        								        </td>
        								    </tr>
        								    ";
        								    if(isset($_POST["accept1"]))
        								    {              
        								        $onee=explode('*', $_POST["accept1"]);
        								        accept1($onee[0]);
        								        
        								    }
        								    if(isset($_POST["reject1"]))
        								    {
        								        $onee=explode('*', $_POST["reject1"]);
        								        reject1($onee[0]);
        
        								    }
        								    $a++;
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
					<h3>Verification Pending Sales Person's</h3>
					<table id="addBook">
						<thead>
						  <tr>
							<th>S. No.</th>
							<th>Sales Person's Name</th>
							<th>Sales Person's Email</th>
							<th>Sales Person's Contact No.</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
                                $servernames1 = DB_HOST;
                                $usernames1 = DB_USER;
                                $passwords1 = DB_PASSWORD;
                                $dbnames1 = DB_NAME;
                                function accepts1($em) {
                                    $servernamess1 = DB_HOST;
                                    $usernamess1 = DB_USER;
                                    $passwordss1 = DB_PASSWORD;
                                    $dbnamess1 = DB_NAME;
                                    $connfunctionss1 = new mysqli($servernamess1, $usernamess1, $passwordss1,$dbnamess1);
                                    try {
                                        $sq = "UPDATE `wp_users` SET `user_status`=2 WHERE user_email='$em' and  user_status=-2";
                                        if($connfunctionss1->query($sq)){
                                            $sqss = "INSERT INTO `salesperson_distributers`(`email`) VALUES ('$em')";
                                            if($connfunctionss1->query($sqss)){
                                                $_SESSION["end"]="true";
                                                $mail = new PHPMailer;
                                                $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                                $mail->isSMTP();                                      
                                                $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                                $mail->SMTPAuth = true;                           
                                                $mail->Username = EMAIL;         // SMTP username
                                                $mail->Password = PASSWORD;          // SMTP password
                                                $mail->SMTPSecure = 'tls';                           
                                                $mail->Port = 587;                                    
                                                $mail->setFrom(EMAIL,'By Lavina');
                                                $mail->addAddress($em);     // Add a recipient
                                                $mail->isHTML(true);                                  // Set email format to HTML
                                                $mail->Subject = 'By Laveena Admin Panel ';
                                                $mail->Body    = 'Your Sales Person\'s account has been approved by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                                if(!$mail->send()) {
                                                    echo "<script>alert('Error occured, try again later..!!')</script>";
                                                } else {
                                                    echo "<script>alert('User Activated  successfully..!! ')</script>";
                                                    echo '<script>
                                                        window.location="tables.php";
                                                    </script>';
                                                }
                                            }
                                            else{
                                                $_SESSION["end"]="true";
                                                $mail = new PHPMailer;
                                                $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                                $mail->isSMTP();                                      
                                                $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                                $mail->SMTPAuth = true;                           
                                                $mail->Username = EMAIL;         // SMTP username
                                                $mail->Password = PASSWORD;          // SMTP password
                                                $mail->SMTPSecure = 'tls';                           
                                                $mail->Port = 587;                                    
                                                $mail->setFrom(EMAIL,'By Lavina');
                                                $mail->addAddress($em);     // Add a recipient
                                                $mail->isHTML(true);                                  // Set email format to HTML
                                                $mail->Subject = 'By Laveena Admin Panel ';
                                                $mail->Body    = 'Your Sales Person\'s account has been approved by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                                if(!$mail->send()) {
                                                    echo "<script>alert('Error occured, try again later..!!')</script>";
                                                } else {
                                                    echo "<script>alert('User Activated  successfully..!! ')</script>";
                                                    echo '<script>
                                                        window.location="tables.php";
                                                    </script>';
                                                }
                                            }
                                        }
                                        else{
                                            $_SESSION["end"]="false";
                                            echo '<script>
                                                window.location="adminLogin.php";
                                            </script>';
                                        }            
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo $sql . "<br>" . $e->getMessage();
                                    }
                                }
                                function rejects1($bn) {
                                    $servernamesss1 = DB_HOST;
                                    $usernamesss1 = DB_USER;
                                    $passwordsss1 = DB_PASSWORD;
                                    $dbnamesss1 = DB_NAME;
                                    $connfunctionsss1 = new mysqli($servernamesss1, $usernamesss1, $passwordsss1,$dbnamesss1);
                                    try {
                                        $sq = "DELETE FROM `wp_users` WHERE user_email='$em' and  user_status=-2";
                                        if($connfunctionsss1->query($sq)){
                                            $_SESSION["end"]="true";
                                            $mail = new PHPMailer;
                                            $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                                            $mail->isSMTP();                                      
                                            $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                                            $mail->SMTPAuth = true;                           
                                            $mail->Username = EMAIL;         // SMTP username
                                            $mail->Password = PASSWORD;          // SMTP password
                                            $mail->SMTPSecure = 'tls';                           
                                            $mail->Port = 587;                                    
                                            $mail->setFrom(EMAIL,'By Lavina');
                                            $mail->addAddress($em);     // Add a recipient
                                            $mail->isHTML(true);                                  // Set email format to HTML
                                            $mail->Subject = 'By Laveena Admin Panel ';
                                            $mail->Body    = 'Your Sales Person\'s account has been deleted by Lavina. Please visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                                            if(!$mail->send()) {
                                                echo "<script>alert('Error occured, try again later..!!')</script>";
                                            } else {
                                                echo "<script>alert('User rejected successfully..!! ')</script>";
                                                echo '<script>
                                                    window.location="tables.php";
                                                </script>';
                                            }
                                        }
                                        else{
                                            $_SESSION["end"]="false";
                                            echo '<script>
                                                window.location="adminLogin.php";
                                            </script>';
                                        }            
                                    }
                                    catch(PDOException $e)
                                    {
                                        echo $sql . "<br>" . $e->getMessage();
                                    }
                                }
                                try {
                                    $aa1=1;
                                    $conn1 = new mysqli($servernames1, $usernames1, $passwords1,$dbnames1);
                                    $results1 = mysqli_query($conn1,"SELECT * FROM `wp_users` where user_status=-2");
                                    while($row1=mysqli_fetch_row($results1)){
                                        $one1=urldecode($row1[9]);
                                        $two1=urldecode($row1[4]);
                                        $three1=urldecode($row1[5]);
                                        $s1=$two1;
                                        echo "
                                        <tr>
                                            <td>$aa1."."</td>
                                            <td>$one1</td>
                                            <td>$two1</td>
                                            <td>$three1</td>
                                            <td>
                                                <form action='' method='post'>
                                                    <input type='hidden' name='sub' value='1'>
                                                    <button id='accepts1' name ='accepts1' value = '$s1' style='margin:5px;' >Active Now</button>
    								                <button id='rejects1' name ='rejects1' value = '$s1' style='margin:5px;'>Reject Request</button>
    								            <form>
    								        </td>
    								    </tr>
    								    ";
    								    if(isset($_POST["accepts1"]))
    								    {              
    								        $onee=explode('*', $_POST["accepts1"]);
    								        accepts1($onee[0]);
    								    }
    								    if(isset($_POST["rejects1"]))
    								    {
    								        $onee=explode('*', $_POST["rejects1"]);
    								        rejects1($onee[0]);
    								    }
    								    $aa1++;
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo $sql . "<br>" . $e->getMessage();
                                }
                            ?>
						</tbody>
					  </table></br></br>
				</div>
			</div>
		</div>
	</section>
	<script src="js/bootstrap.js"></script>
	<script src="js/proton.js"></script>
</body>
</html>
