<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <title>Lavina | Login Form</title>
        <link rel="icon" sizes="72x72" href="./images/logo.png">
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
    include("../wp-config.php");
    require "../phpmail/PHPMailerAutoload.php";
    $_SESSION["end"] = "false";
    $servername = DB_HOST;
    $username = DB_USER;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;
    try 
    {
        $conn = new mysqli($servername, $username, $password,$dbname);

        if(isset($_POST["forget_password"])){
            $mail = new PHPMailer;
            $mail->SMTPDebug = 0;     //give all detail while sending mail                         
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
            $mail->SMTPAuth = true;                           
            $mail->Username = 'lavinapvt@gmail.com';         // SMTP username
            $mail->Password = 'lavina@1234';          // SMTP password
            $mail->SMTPSecure = 'tls';                           
            $mail->Port = 587;                                    
            $mail->setFrom('lavinapvt@gmail.com','OfficeToolByDeepanshu');
            $mail->addAddress('lavinapvt@gmail.com');     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'By Laveena Admin Panel ';
            $mail->Body    = 'Visit link for reset your password :- <a>http://jobmafiaa.com/products/lavina/admin/adminlink.php?username=lavinapvt@gmail.com</a>';
            if(!$mail->send()) {
                $message= "Error occured, try again later..!!";
                //echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                $message= 'Check your email for Reset Link..!!';
            }
        }
        if(isset($_POST["login"])){
            $uname=$_POST["username"];
            $password=$_POST["password"];
            $sql = "select * from admin_login where user_name='$uname'";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
    
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if($row["password"]==$password)
                    {         $_SESSION["end"] = "true";
    
                            echo '<script>
                                window.location="tables.php";
                            </script>';
                            $message= "Successfully Logged In";
                    }
                    else
                    {
                        $message="Password doesn't match";
                    }
            }
            } 
            else {
                $message="No user found";
            }
        }
            
    }
    catch(PDOException $e)
    {
    }
?>
        <div class="container">
                        <header>
                <h1>Login Form</h1>
				<nav class="codrops-demos">
				</nav>
            </header>
            <section>				
                <div id="container_demo" >
                    <a class="hiddenanchor" id="tochange"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="" method="post" autocomplete="on"> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Admin email </label>
                                    <input id="username" name="username" type="text" placeholder="myusername or mymail@mail.com"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                
                                <p class="login button"> 
                                    <input type="submit" name="login" value="Login" /> 
								</p>
								<p class="uname">
                                    <?=$message?>
                                </p>
                                <p class="change_link">
									Forget Password ?
                                    <input style="width:60px;height:10px;text-align:center;background-color:#E1EAEB;" type="submit" name="forget_password" value="Click-Here"/>
								</p>
								
                            </form>
                        </div>

                        <div id="register" class="animate form">
                            <form  action="" method="post" autocomplete="on"> 
                                <h1> Change Password </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u" > Your email or username </label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="myusername or mymail@mail.com"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your new password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your new password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p class="signin button"> 
									<input type="submit" name="forget_password" value="Done"/> 
								</p>
								<p class="uname">
                                    <?=$message?>
                                </p>
                                <p class="change_link">  
									Remember password ?
									<a href="#tologin" class="to_register"> Log in </a>
								</p>
							
                            </form>
                        </div>

                        </div>
                    </div>
                </div>  
            </section>
        </div>
    </body>
