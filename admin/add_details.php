<?php
session_start();
?>
<!DOCTYPE html>
<head>
<title>Lavina | Dashboard</title>
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

	<section class="wrapper scrollable">
		<div class="main-grid">
			<div class="agile-grids">	
				<!-- tables -->
				
				<div class="table-heading">
					<h2>Lavina Admin Panel</h2>
				</div>
				<div class="agile-tables">
				<div class="w3l-table-info">
			        <h3><u><b>Dashboard</b></u></h3>
					<table id="addBook">
						<thead>
						  <tr>
							<th>S. No.</th>
							<th>Item</th>
							<th>Modify</th>
						  </tr>
						</thead>
						<tbody>
						    <?php
						        include("../wp-config.php");
						        $a=1;
                                $servernames1 = DB_HOST;
                                $usernames1 = DB_USER;
                                $passwords1 = DB_PASSWORD;
                                $dbnames1 = DB_NAME;
                                try {
                                    $conn1 = new mysqli($servernames1, $usernames1, $passwords1,$dbnames1);
                                    $results1 = mysqli_query($conn1,"SELECT * FROM dashboard");
                                    while($row1=mysqli_fetch_row($results1)){
                                        $name=urldecode($row1[0]);
                                        $link=urldecode($row1[1]);
                                        echo "
                                        <tr>
                                            <td>$a."."</td>
                                            <td>$name</td>
                                            <td>
                                                    <a href='$link'><button>Click here</button></a>
    								        </td>
    								    </tr>
    								    ";
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
				</div>
			</div>
		</div>
	</section>
	<script src="js/bootstrap.js"></script>
	<script src="js/proton.js"></script>
</body>
</html>
