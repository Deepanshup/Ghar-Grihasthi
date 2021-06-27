<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <style>
            p.poi {
               height: 100;
            }
        </style>
        <meta charset="UTF-8" />
        <title>Lavina | Edit Distributor's Discount</title>
        <link rel="icon" sizes="72x72" href="./images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdFvXTNcn2V80lPvfSMEl1FuLegxJJNos&libraries=places" type="text/javascript"></script>
		<script type="text/javascript">
               function initialize() {
                    var input = document.getElementById('source');
                    var autocompletess = new google.maps.places.Autocomplete(input);
                    var inputs = document.getElementById('destination');
                    var autocompletes = new google.maps.places.Autocomplete(inputs);
               }
               google.maps.event.addDomListener(window, 'load', initialize);
       </script>
    </head>
    <body>
    <?php
        include("../wp-config.php");
        require "../phpmail/PHPMailerAutoload.php";
        include("./configg.php");
        try 
        {   $message="";
            $end=$_SESSION["end"];
            if($end!="true"){
                echo '<script>
                        window.location="adminLogin.php";
                    </script>';
            }
            $em=$_SESSION['email'] ;
            $dc=$_SESSION['discount'] ;
            if(isset($_POST["register"])){
                $disc=$_POST["passwordsignup_confirm"];
                $servernamesd = DB_HOST;
                $usernamesd = DB_USER;
                $passwordsd = DB_PASSWORD;
                $dbnamesd = DB_NAME;
                $connfunction = new mysqli($servernamesd, $usernamesd, $passwordsd,$dbnamesd);
                try {
                    $sq = "UPDATE `discount_distributers` SET `discount`='$disc' WHERE email='$em'";
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
                        $mail->Body    = 'Your discount percentage has been changed to '.$disc.' by Lavina. Visit our website :- <br><a>http://jobmafiaa.com/products/lavina/</a>';
                        if(!$mail->send()) {
                            echo "<script>alert('Error occured, try again later..!!')</script>";
                        } else {
                            echo "<script>alert('Successfully changed')</script>";
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
                                <h1> Edit Discount: </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname"  > Email: </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="text" value="<?=$em?>" placeholder="<?=$em?>" readonly/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Discount Alloted :-</label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="text" value="<?=$dc?>" placeholder="<?=$dc?>"/>
                                </p>
                                <p class="signin button"> 
									<input type="submit" name="register" value="Done"/> 
								</p>
								<p class="uname">
                                    <?=$message?>
                                </p>
                                <p class="change_link">  
									Don't want to edit?
									<a href="tables.php" class="to_register"> Go to Tables view </a>
								</p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
