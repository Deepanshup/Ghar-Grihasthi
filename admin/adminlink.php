<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <title>Lavina | Reset Password</title>
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
    $uname=$_GET["username"];
    try 
    {
        if(isset($_POST["register"])){
            $password=$_POST["passwordsignup"];
            $repassword=$_POST["passwordsignup_confirm"];
            if($password==$repassword)
            {
                $servernames = DB_HOST;
                $usernames = DB_USER;
                $passwords = DB_PASSWORD;
                $dbnames = DB_NAME;
                $conn = new mysqli($servernames, $usernames, $passwords,$dbnames);
                $sql="select * from admin_login where user_name='$uname'";
                $result = mysqli_query($conn,$sql) or die(mysql_error());
                if(mysqli_num_rows($result) > 0)
                {
                    $sql = "UPDATE `admin_login` SET `password`='$password' where user_name='$uname'";
                    if ($conn->query($sql)) {
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
                            <form  action="" method="post" autocomplete="on"> 
                                <h1> Change Password </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u" >Admin Email address:-</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="<?=$uname?>" value="<?=$uname?>" readonly/>
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
									<input type="submit" name="register" value="Done"/> 
								</p>
								<p class="uname">
                                    <?=$message?>
                                </p>
                                <p class="change_link">  
									Remember password ?
									<a href="http://jobmafiaa.com/products/lavina/admin/adminLogin.php" class="to_register"> Log in </a>
								</p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
