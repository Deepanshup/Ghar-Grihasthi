<?php
session_start();
include("../wp-config.php");
require "../phpmail/PHPMailerAutoload.php";
include("./configg.php");
$unique=$_SESSION['email'] ;
?>
<!DOCTYPE html>
<head>
<title>Lavina | Sales Person Assignment</title>
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
        <div class="container">
            <header>
				<nav class="codrops-demos">
				</nav>
            </header>
            <section>				
                <div id="container_demo" >
                    <div id="wrapper">
                        <form  action="" method="post" autocomplete="on" enctype="multipart/form-data"> 
                            <h1> Allocate delivery details to Sales Person:- </h1> 
                            <h3>Sales Person Email:- <? echo $unique;?></h3>
        					<table id="addBook">
        						<thead>
        						  <tr>
        							<th>S. No.</th>
        							<th>Distributor's Name</th>
        							<th>Distributer's Address</th>
        							<th>Modify</th>
        						  </tr>
        						</thead>
        						<tbody>
        						    <?php
                                        $servername = DB_HOST;
                                        $username = DB_USER;
                                        $password = DB_PASSWORD;
                                        $dbname = DB_NAME;
                                        function assign($em,$cn,$ad,$nm) {
                                            $uniques=$_SESSION['email'] ;
                                            $servernamesd = DB_HOST;
                                            $usernamesd = DB_USER;
                                            $passwordsd = DB_PASSWORD;
                                            $dbnamesd = DB_NAME;
                                            $connfunction = new mysqli($servernamesd, $usernamesd, $passwordsd,$dbnamesd);
                                            try {
                                                $sq = "UPDATE `salesperson_distributers` SET `distributor_email`='$em',`distributor_cn`='$cn',`distributor_address`='$ad' WHERE `email`='$unique'";
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
                                                    $mail->addAddress($uniques);     // Add a recipient
                                                    $mail->isHTML(true);                                  // Set email format to HTML
                                                    $mail->Subject = 'By Laveena Admin Panel ';
                                                    $mail->Body    = 'Delivery Details :- <brDistributor\'s Name:-'.$nm.'<br>Distributor\'s Email:- '.$em.'<br>Distributor\'s Contact no.:- '.$cn.'<br>Delivery Address:-'.$ad.'';
                                                    if(!$mail->send()) {
                                                        echo "<script>alert('Error occured, try again later..!!')</script>";
                                                    } else {
                                                        echo "<script>alert('Assigned  successfully..!! ')</script>";
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
                                                        $mail->Body    = 'Sales Person\'s Email:- '.$em.'<br>Sales Person\'s Contact no.:- '.$cn.'';
                                                        if(!$mail->send()) {
                                                            echo "<script>alert('Error occured, try again later..!!')</script>";
                                                        } else {
                                                            echo "<script>alert('Assigned  successfully..!! ')</script>";
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
                                        try {
                                            $a=1;
                                            $conn = new mysqli($servername, $username, $password,$dbname);
                                            $results = mysqli_query($conn,"SELECT * FROM `wp_users` where user_status=1");
                                            while($row=mysqli_fetch_row($results)){
                                                $one=urldecode($row[9]);
                                                $two=urldecode($row[4]);
                                                $three=urldecode($row[5]);
                                                $product = array();
                                                $sqls = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$row[4]' && user_id!=''";
                                                $results = mysqli_query($con,$sqls);
                                                if (mysqli_num_rows($results) > 0) {
                                                    while ($rows = mysqli_fetch_array($results)) {
                                                        $sqll = "SELECT `order_id` FROM `wp_wc_order_stats` WHERE customer_id='$rows[0]' ";
                                                        $resultl = mysqli_query($con,$sqll);
                                                        if (mysqli_num_rows($resultl) > 0) {
                                        			        while ($rowl = mysqli_fetch_array($resultl)) {
                                        			            $sqlt = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$rowl[0]'";
                                        			            $resultt = mysqli_query($con,$sqlt);
                                        			            if (mysqli_num_rows($resultt) > 0) {
                                        				            while ($rowt = mysqli_fetch_array($resultt)) {
                                        				                if($rowt[0]=='_billing_address_1'||$rowt[0]=='_billing_city'||$rowt[0]=='_billing_state'||$rowt[0]=='_billing_postcode'||$rowt[0]=='_billing_country'){
                                                                                $product[$rowt[0]] =$rowt[1];
                                                                      }
                                        				            }
                                        			            }
                                        		            }
                                                        }
                                                    }
                                                }
                                                $address=$product['_billing_address_1'].$product['_billing_postcode'].$product['_billing_city'].$product['_billing_state'].$product['_billing_country'];
                                                $s=$two.'*'.$three.'*'.$address.'*'.$one;
                                                if($address!=null){
                                                    echo "
                                                        <tr>
                                                            <td>$a."."</td>
                                                            <td>$one</td>
                                                            <td>$address</td>
                                                            <td>
                                                                <form action='' method='post'>
                                                                    <input type='hidden' name='sub' value='1'>
                                                                    <button id='assign' name ='assign' value = '$s' style='margin:5px;' >assign</button>
                    								            <form>
                    								        </td>
                    								    </tr>
                    								    ";
                                                }
            								    if(isset($_POST["assign"]))
            								    {              
            								        $onee=explode('*', $_POST["assign"]);
            								        assign($onee[0],$onee[1],$onee[2],$onee[3]);
            								        
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
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </body>
