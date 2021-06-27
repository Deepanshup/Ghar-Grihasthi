<?php
include("../wp-config.php");
require "../phpmail/PHPMailerAutoload.php";
try {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME);
    
    if(isset($_REQUEST["user_register"])){
        $fname = $_GET['fname'];
        $lname = $_GET['lname'];
        $fullname = $_GET['fname'].' '.$_GET['lname'];
        $username = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $contact_no = $_GET['contact_no'];
        $user_status = $_GET['user_status'];
        if($user_status=='true'){
            $CheckSQL = "select * from wp_users where user_email='$email' and user_status=-1";
            $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
            if(isset($check)){
                $response = "Email already exists.";
                echo json_encode($response);
            }
            else{
                $CheckSQL = "select * from wp_users where user_email='$email' and user_status=1";
                $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
                if(isset($check)){
                    $response = "Email already exists.";
                    echo json_encode($response);
                }
                else{
                    $Sql_Query = "INSERT INTO `wp_users`(`user_login`,`user_pass`,`user_nicename`,`user_email`,`user_url`,`display_name`,`user_status`) VALUES
                            ('$username','$password','$fname','$email','$contact_no','$fullname',-1)";
                    if($con->query($Sql_Query)){
                        $response = "Registered Successfully.Wait for Verification Email..!!";
                        echo json_encode($response);
                    }
                    else{
                        $response= "Oops an error occured try again later..!!";
                        echo json_encode($response);
                    }
                }
            }
        }
        else{
            $CheckSQL = "select * from wp_users where user_email='$email' and user_status=0";
            $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
            if(isset($check)){
                $response = "Email already exists.";
                echo json_encode($response);
            }
            else{
                $Sql_Query = "INSERT INTO `wp_users`(`user_login`,`user_pass`,`user_nicename`,`user_email`,`user_url`,`display_name`,`user_status`) VALUES
                            ('$username','$password','$fname','$email','$contact_no','$fullname',0)";
                if($con->query($Sql_Query)){
                    $response = "Registered Successfully..!!";
                    echo json_encode($response);
                }
                else{
                    $response= "Oops an error occured try again later..!!";
                    echo json_encode($response);
                }
            }
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["Google_register"])){
        $fullname = $_GET['name'];
        $username = $_GET['name'];
        $email = $_GET['email'];
        $one=explode(" ",$fullname);
        $fname = $one[0];
        $lname = $one[1];
        $password = $_GET['password'];
        $contact_no = $_GET['contact_no'];
        $user_status = $_GET['user_status'];
        if($user_status=='true')
        {
            $user_status=-1;
            $CheckSQL = "select * from wp_users where user_email='$email' and user_status=-1";
            $check = mysqli_fetch_array($con->query($CheckSQL));
            if(isset($check)){
                $response = "Email already exists.";
                echo json_encode($response);
            }
            else{
                $CheckSQL = "select * from wp_users where user_email='$email' and user_status=1";
                $check = mysqli_fetch_array($con->query($CheckSQL));
                if(isset($check)){
                    $response = "Email already exists.";
                    echo json_encode($response);
                }
                else{
                    $Sql_Query = "INSERT INTO `wp_users`(`user_login`,`user_pass`,`user_nicename`,`user_email`,`user_url`,`display_name`,`user_status`) VALUES
                                ('$username','$password','$fname','$email','$contact_no','$fullname',-1)";
                    if($con->query($Sql_Query)){
                        $response = "User logged in successfully.";
                        echo json_encode($response);
                    }
                    else{
                        $response = "OOps an error occured try again later..!!";
                        echo json_encode($response);
                    }
                }
            }

        }
        else
        {
            $user_status=0;
            $CheckSQL = "select * from wp_users where user_email='$email' and user_status=0";
            $check = mysqli_fetch_array($con->query($CheckSQL));
            if(isset($check)){
                $response = "Email already exists.";
                echo json_encode($response);
            }
            else{
                $Sql_Query = "INSERT INTO `wp_users`(`user_login`,`user_pass`,`user_nicename`,`user_email`,`user_url`,`display_name`,`user_status`) VALUES
                            ('$username','$password','$fname','$email','$contact_no','$fullname',0)";
                if($con->query($Sql_Query)){
                    $response = "User logged in successfully.";
                    echo json_encode($response);
                }
                else{
                    $response = "OOps an error occured try again later..!!";
                    echo json_encode($response);
                }
            }
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["login"])){
        $email = $_GET['email'];
        $password = $_GET['password'];
        $user_status = $_GET['user_status'];
        if($user_status=='true')
        {
            $user_status=1;
        }
        else
        {
            $user_status=0;
        }
        $Sql_Query = "select * from wp_users where `user_email`='$email' and user_status=$user_status";
        $result = mysqli_query($con,$Sql_Query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if($password==$row[2])
                {   
                    $response = 'User successfully logged in.';
                }
                else
                {
                    $response = 'password is Incorrect..!!';
                }
            }
        }
        else{
            $response = 'User does not exist..!! or Wait for Verification and try again later..!!' ;
        }
        echo json_encode($response);
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["forget_password"])){
        $email = $_GET['email'];
        $status = $_GET['status'];
        if($status=='one')
        {
            $status=0;
        }
        else if($status=='two')
        {
            $status=2;
        }
        else if($status=='three')
        {
            $status=1;
        }
        $sql= "select user_email from wp_users where `user_email`='$email' and user_status=$status";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $mail = new PHPMailer;
                $mail->SMTPDebug = 0;     //give all detail while sending mail                         
                $mail->isSMTP();                                      
                $mail->Host = 'smtp.gmail.com';  // yhi likhna hai
                $mail->SMTPAuth = true;                           
                $mail->Username = 'lavinapvt@gmail.com';         // SMTP username
                $mail->Password = 'lavina@1234';          // SMTP password
                $mail->SMTPSecure = 'tls';                           
                $mail->Port = 587;                                    
                $mail->setFrom('lavinapvt@gmail.com','By Lavina');
                $mail->addAddress($email);     // Add a recipient
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'By Laveena Admin Panel ';
                $mail->Body    = 'Click on following link to reset your password<br><a href=http://jobmafiaa.com/products/lavina/admin/apppassword.php?email='.$row[0].'&status='.$status.'> Click Me</a>';
                if(!$mail->send()) {
                    $response= "An error occured. Plz try again later..!!";
                    echo json_encode($response);
                } else {
                    $response= "Check your Email box..!!";
                    echo json_encode($response);
                }
            }
        }
        else{
            $response= "Wrong Details..!!";
            echo json_encode($response);
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["user_fetch"])){
        $email = $_GET['email'];
        $user_status = $_GET['user_status'];
        if($user_status=='true')
        {
            $user_status=1;
        }
        else
        {
            $user_status=0;
        }
        $response["results"] = array();
        $sql= "select * from wp_users where `user_email`='$email' and user_status='$user_status'";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $product=array();
                $product['ID']=$row[0];
                $product['username']=$row[1];
                $product['user_pass']=$row[2];
                $product['user_firstname']=$row[3];
                $product['user_email']=$row[4];
                $product['contact_no']=$row[5];
                $product['display_name']=$row[9];
                array_push($response["results"], $product);
            }
            echo json_encode($response);
        }
        else{
            echo json_encode($response);
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["newest_home"])){
	    $off=$_GET["offset"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $response["results"] = array();
        $sql = "select post_id from `wp_postmeta`  WHERE `meta_key`='_regular_price' ORDER BY `post_id` DESC";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock' ){
				            $product["post_id"] = $row[0];
				            $product[$rowl[0]] =$rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
					                $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
							                $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!=""){
		                array_push($response["results"], $product);
                        $o=0;
                   }
		        }
                if($product["img_url"]!="" ){
		            $x++;$o=0;
                }
                else if($product["img_url"]=="" ){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["newest_high_to_low"])){
	    $off=$_GET["offset"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;

        $sql = "select meta_value from `wp_postmeta`  WHERE `meta_key`='_regular_price'";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            $products = array();
            $i=0;
            while ($row = mysqli_fetch_array($result)) {
				 $products[$i++] = $row[0];
            }
        rsort($products);
        $clength = count($products);


        $response["results"] = array();
        for($proLength = 0; $proLength < $clength; $proLength++) {
            $sql = "select post_id from `wp_postmeta`  WHERE  `meta_key`='_regular_price' and `meta_value`='$products[$proLength]'";

        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock'  ){
				            $product["post_id"] = $row[0];
				            $product[$rowl[0]] = $rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
						            $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
								            $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
                           
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!="" ){
		                array_push($response["results"], $product);
                        $o=0;
                   }
		        }
                if($product["img_url"]!=""  ){
		            $x++;$o=0;
                }
                else if($product["img_url"]==""  ){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }

        }
        }
        echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["newest_low_to_high"])){
	    $off=$_GET["offset"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;



        $sql = "select meta_value from `wp_postmeta`  WHERE `meta_key`='_regular_price'";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            $products = array();
            $i=0;
            while ($row = mysqli_fetch_array($result)) {
				 $products[$i++] = $row[0];
            }
        sort($products);
        $clength = count($products);



        $response["results"] = array();
        for($proLength = 0; $proLength < $clength; $proLength++) {
            $sql = "select post_id from `wp_postmeta`  WHERE  `meta_key`='_regular_price' and `meta_value`='$products[$proLength]'";



        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock' ){
				            $product["post_id"] = $row[0];
				            $product[$rowl[0]] = $rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
						            $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]' ";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
								            $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
                           
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!="" ){
		                array_push($response["results"], $product);
                        $o=0;
                   }
		        }
                if($product["img_url"]!="" ){
		            $x++;$o=0;
                }
                else if($product["img_url"]=="" ){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }

        }
        }
        echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["wishlist"])){
        $off=$_GET["offset"];
        $email=$_GET["email"];
        $count=$_GET["count"];
        $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $event=$_GET["event"];
        $post_id=$_GET["post_id"];
        if($event=="insert"){
            $response["results"]=array();
            $sql= "INSERT INTO `wishlist`(`post_id`,`email`,`count`) VALUES ('$post_id','$email','$count')";
            if(mysqli_query($con,$sql)){
                $response = "Article successfully added to the wishlist.";
                echo json_encode($response);
            }
            else{
                $response= "Oops! An error occurred.";
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if($event=="delete"){
            $response["results"]=array();
            $sql= "DELETE FROM `wishlist` WHERE `post_id`='$post_id' and `email`='$email'";
            if(mysqli_query($con,$sql)){
                $response = "Article successfully removed from wishlist";
                echo json_encode($response);
            }
            else{
                $response= "Oops! An error occurred.";
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if($event=="selectedItems"){
            $response["results"]=array();
            $product=array();
            $sql= "select post_id from wishlist where email='$email' ";
            $result = mysqli_query($con,$sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $product = $row[0];
                    array_push($response["results"], $product);
                }
                echo json_encode($response);
            }
            else
            {
                array_push($response["results"], $product);
                echo json_encode($response);
            }
            mysqli_close($con);
        }
    }
    
    if(isset($_REQUEST["cart"])){
        $off=$_GET["offset"];
        $email=$_GET["email"];
        $count=$_GET["count"];
        $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $event=$_GET["event"];
        $post_id=$_GET["post_id"];
        if($event=="insert"){
            $response["results"]=array();
            $sql= "INSERT INTO `cart`(`post_id`,`email`,`count`) VALUES ('$post_id','$email','$count')";
            if(mysqli_query($con,$sql)){
                $response = "Item successfully added to cart.";
                echo json_encode($response);
            }
            else{
                $response= "Oops! An error occurred.";
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if($event=="delete"){
            $response["results"]=array();
            $sql= "DELETE FROM `cart` WHERE `post_id`='$post_id' and `email`='$email'";
            if(mysqli_query($con,$sql)){
                $response = "Item successfully removed from cart.";
                echo json_encode($response);
            }
            else{
                $response= "Oops! An error occurred.";
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if($event=="selectedItems"){
            $response["results"]=array();
            $product=array();
            $sql= "select post_id from `cart` where email='$email' ";
            $result = mysqli_query($con,$sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $product = $row[0];
                    array_push($response["results"], $product);
                }
                echo json_encode($response);
            }
            else
            {
                array_push($response["results"], $product);
                echo json_encode($response);
            }
            mysqli_close($con);
        }
    }
    
    if(isset($_REQUEST["wishlistFetch"])){
	    $off=$_GET["offset"];
	    $email=$_GET["email"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $response["results"] = array();
        $sql= "select `post_id`,`count` from `wishlist` where `email`='$email'";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock'  || $rowl[0]== '_wpb_vc_js_status'){
				            $product["post_id"] = $row[0];
				            $product["count"] = $row[1];
				            $product[$rowl[0]] = $rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
						            $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
								            $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
				          
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!="" ){
		                array_push($response["results"], $product);
                        $o=0;
                   }
		        }
                if($product["img_url"]!=""){
		            $x++;$o=0;
                }
                else if($product["img_url"]=="" ){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["cartFetch"])){
	    $off=$_GET["offset"];
	    $email=$_GET["email"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $totalprice=0;
        $totalpriceWithCount=0;
        $response["results"] = array();
        $sql= "select `post_id`,`count` from `cart` where `email`='$email'";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock'  ){
				            $product["post_id"] = $row[0];
				            $product["count"] = $row[1];
				            $product[$rowl[0]] = $rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
						            $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
								            $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				              }
				            
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!=""){
		                array_push($response["results"], $product);
                        $o=0;
                   }
                   if($product["_price"]!="" ){
                       $totalprice=$totalprice+$product["_price"];
                       $totalpriceWithCount=$totalpriceWithCount+$product["_price"]*$product["count"] ;
                   }
		        }
                if($product["img_url"]!="" ){
		            $x++;$o=0;
                }
                else if($product["img_url"]==""){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }
            $response["totalPrice"] = $totalprice;
            $response["totalPriceWithCount"] = $totalpriceWithCount;
            echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["buy_now_sub_category_item_fetch"])){
	    $off=$_GET["offset"];
	    $catt=$_GET["category"];
	    $subcatt=$_GET["sub_category"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $response["results"] = array();
        $sql = "select post_id from `wp_postmeta`  WHERE `meta_key`='_regular_price' ORDER BY `post_id` DESC";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock'  ){
				            $product["post_id"] = $row[0];
				            $product[$rowl[0]] = $rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
						            $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
								            $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!="" && $product["category"]==$catt && $product["sub_category"]==$subcatt ){
		                array_push($response["results"], $product);
                        $o=0;
                    }
		        }
                if($product["img_url"]!="" && $product["category"]==$catt && $product["sub_category"]==$subcatt ){
		            $x++;$o=0;
                }
                else if($product["img_url"]=="" || $product["category"]!=$catt || $product["sub_category"]!=$subcatt ){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }

    if(isset($_REQUEST["categoryFetch"])){
       $response["results"]=array();
       $catt=$_GET["categorys"];
       $sql = "select `term_id` FROM `wp_terms` WHERE slug='$catt'";
       $result = mysqli_query($con,$sql) ;
       if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_array($result)) {
              $product = array();
              $sqlcc = "select `term_id` FROM `wp_term_taxonomy` where `parent`='$row[0]' ";
              $resultcc = mysqli_query($con,$sqlcc);
              if (mysqli_num_rows($resultcc) > 0) {
                 while ($rowcc = mysqli_fetch_array($resultcc)) {
                        $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                        $resultccc = mysqli_query($con,$sqlccc);
                        if (mysqli_num_rows($resultccc) > 0) {
                           while ($rowccc = mysqli_fetch_array($resultccc)) {
                           $product['sub_cat'] = $rowccc[0];
                           $product['slug'] = $rowccc[1];
                           array_push($response["results"], $product);
                       }
                   }
                }
             }
          }echo json_encode($response);
       }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["main_category"])){
        $response["results"]=array();
        $catt=$_GET["categorys"];
        $sql = "select `term_id` FROM `wp_term_taxonomy` WHERE taxonomy='product_cat'";
        $result = mysqli_query($con,$sql) ;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $product = array();
                $sqlcc = "select `name`,`slug` FROM `wp_terms` where `term_id`='$row[0]' ";
                $resultcc = mysqli_query($con,$sqlcc);
                if (mysqli_num_rows($resultcc) > 0) {
                    while ($rowcc = mysqli_fetch_array($resultcc)) {
                        if($rowcc[1]!=='uncategorized' && $rowcc[1]!=='all'){
                            $product['post_title'] = $rowcc[0];
                            $product['main_category_slug'] = $rowcc[1];
                            $sqlccc = "select `meta_value` FROM `wp_termmeta` where `term_id`='$row[0]' and meta_key='thumbnail_id'";
                            $resultccc = mysqli_query($con,$sqlccc);
                            if (mysqli_num_rows($resultccc) > 0) {
                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                    $sqlcccx = "select `guid` FROM `wp_posts` where `ID`='$rowccc[0]'";
                                    $resultcccx = mysqli_query($con,$sqlcccx);
                                    if (mysqli_num_rows($resultcccx) > 0) {
                                        while ($rowcccx = mysqli_fetch_array($resultcccx)) {
                                                $product[img_url] = $rowcccx[0];
                                                array_push($response["results"], $product);
                                       }
                                   }
                               }
                           }
                        }
                   }
               }
            }
            echo json_encode($response);
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["sub_category_item_fetch"])){
	    $off=$_GET["offset"];
	    $catt=$_GET["category"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $response["results"] = array();
        $sql = "select post_id from `wp_postmeta`  WHERE `meta_key`='_regular_price' ORDER BY `post_id` DESC";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock' ){
				            $product["post_id"] = $row[0];
				            $product[$rowl[0]] =$rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
					                $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
							                $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!="" && $product["sub_category"]==$catt){
		                array_push($response["results"], $product);
                        $o=0;
                   }
		        }
                if($product["img_url"]!="" && $product["sub_category"]==$catt){
		            $x++;$o=0;
                }
                else if($product["img_url"]=="" || $product["sub_category"]!=$catt){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["SearchItems"])){
        $word=$_GET["word"];
        $off=$_GET["offset"];
	    $x=0;
        $y=$off*10;
        $z=$y+9;
        $o=0;
        $response["results"] = array();
        $sql = "select post_id from `wp_postmeta`  WHERE `meta_key`='_regular_price' ORDER BY `post_id` DESC";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
                        if($rowl[0]=='_menu_item_type'||$rowl[0]=='_regular_price'||$rowl[0]=='total_sales'||$rowl[0]=='_tax_status'
                                  ||$rowl[0]=='_stock_status'||$rowl[0]=='_wc_average_rating'||$rowl[0]=='_price'||$rowl[0]=='_sale_price'||$rowl[0]=='_sku'
                                  ||$rowl[0]=='_stock' ){
				            $product["post_id"] = $row[0];
				            $product[$rowl[0]] =$rowl[1];
				            $sqlt = "select * FROM `wp_posts`  WHERE `ID`='$row[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
					                $productssss=strip_tags($rowt[5]);
						            $product["post_title"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productssss));
						            $productss=strip_tags($rowt[4]);
						            $product["long_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productss));
						            $productsss=strip_tags($rowt[6]);
						            $product["short_desc"] = utf8_encode(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $productsss));
                                    $sqli = "select `guid` FROM `wp_posts`  WHERE post_parent='$row[0]'";
                                    $resulti = mysqli_query($con,$sqli);
                                    if (mysqli_num_rows($resulti) > 0) {
							            while ($rowi = mysqli_fetch_array($resulti)) {
							                $product["img_url"]=$rowi[0];
                                            $sqld = "select `term_taxonomy_id` FROM `wp_term_relationships` WHERE object_id='$row[0]'";
                                            $resultd = mysqli_query($con,$sqld);
                                            if (mysqli_num_rows($resultd) > 0) {
                                                while ($rowd = mysqli_fetch_array($resultd)) {
                                                    $sqlcc = "select `term_id` FROM `wp_term_taxonomy`  WHERE term_taxonomy_id='$rowd[0]'";
                                                    $resultcc = mysqli_query($con,$sqlcc);
                                                    if (mysqli_num_rows($resultcc) > 0) {
                                                        while ($rowcc = mysqli_fetch_array($resultcc)) {
                                                            $sqlccc = "select `name`,`slug` FROM `wp_terms` WHERE term_id='$rowcc[0]'";
                                                            $resultccc = mysqli_query($con,$sqlccc);
                                                            if (mysqli_num_rows($resultccc) > 0) {
                                                                while ($rowccc = mysqli_fetch_array($resultccc)) {
                                                                    if($o==0){
                                                                        $product["Main"] = $rowccc[1];
                                                                    }
                                                                    else if($o==1){
                                                                        $product["category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==2){
                                                                        $product["sub_category"] = $rowccc[1];
                                                                    }
                                                                    else if($o==3){
                                                                        $product["sub_to_sub_category"] = $rowccc[1];
                                                                    }
                                                                    $o++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
							            }
						            }
					            }
				            }
			            }
		            }
               }
                if($x>=$y && $x<=$z){
                   if($product["img_url"]!="" && stripos($product["post_title"], $word) !== ''){
		                array_push($response["results"], $product);
                        $o=0;
                   }
		        }
                if($product["img_url"]!="" &&  stripos($product["post_title"], $word) !== ''){
		            $x++;$o=0;
                }
                else if($product["img_url"]=="" && stripos($product["post_title"], $word) === ''){
                    if($x>0 ){
                       if($x<9){
                          $x--;$o=0;
                       }
                    }
                    else{
                        $x=0;$o=0;
                    }
                }
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    //http://jobmafiaa.com/products/lavina/json_response/ex.php?email=deepanshu01pathak@gmail.com&stts=1&total_count=5&totalprice=100&fname=deepanshu&lname=pathak&street=palasia&city=indore&state=mp&country=INDIA&postcode=452001&b_email=avl.gauravpatidar@gmail.com&b_cn=7734826695&p_method=cod&place_order_2=Submit
    if(isset($_REQUEST["place_order"])){
        $email=$_GET['email'];
        $stts=$_GET['stts'];
        $count=$_GET['total_count'];
        $totalprice=$_GET['totalprice'];
        $fname=$_GET['fname'];
        $lname=$_GET['lname'];
        $street=$_GET['street'];
        $city=$_GET['city'];
        $state=$_GET['state'];
        $country=$_GET['country'];
        $postcode=$_GET['postcode'];
        $b_email=$_GET['b_email'];
        $b_cn=$_GET['b_cn'];
        $p_method=$_GET['p_method'];
        date_default_timezone_set("Asia/Kolkata");
        $date=date("Y-m-d")." ".date("H:i:s");
        $meta_value=array($fname,$lname,$street,$city,$state,$postcode,$country,$b_email,$b_cn,$p_method);
        $value=array('_billing_first_name','_billing_last_name','_billing_address_1','_billing_city','_billing_state','_billing_postcode','_billing_country','_billing_email','_billing_phone','_payment_method_title');
        if($stts=='true')
        {
            $stts=1;
        }
        else
        {
            $stts=0;
        }
        $i=0;
        $Sql_Query = "select ID,user_login,user_nicename from wp_users where `user_email`='$email' and user_status='$stts'";
        $result = mysqli_query($con,$Sql_Query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $sql = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$email' && user_id='$row[0]'";
                $result = mysqli_query($con,$sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $sql = "select MAX(ID) as max from `wp_posts`";
                        $result = mysqli_query($con,$sql);
                        $rows = mysqli_fetch_array( $result );
                        $largestNumber = $rows['max']+1;
                        $d1=date('F d,Y @ H:i A');
                        $d2=date('Y-F-d-Hi-a');
                        $sqll="INSERT INTO `wp_posts`(`ID`, `post_date`, `post_date_gmt`, `post_title`, `post_status`, `comment_status`, `ping_status`,`post_name`,`post_modified`, `post_modified_gmt`,`guid`,`post_type`) 
                            VALUES ('$largestNumber','$date','$date','Order &ndash; $d1','wp-processing','open','open','order-$d2','$date','$date','http://jobmafiaa.com/products/lavina/?post_type=shop_order&#038;p=$largestNumber','shop_order')";
        				if ($con->query($sqll)) {
        				    $sqll = "INSERT INTO `wp_wc_order_stats`(`order_id`,`date_created`, `date_created_gmt`, `num_items_sold`, `total_sales`, `net_total`, `status`, `customer_id`) 
                                VALUES ('$largestNumber','$date','$date','$count','$totalprice','$totalprice','wp-processing','$row[0]')";
                            if ($con->query($sqll)) {
                                $sql= "select `post_id`,`count` from `cart` where `email`='$email'";
                                $result = mysqli_query($con,$sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($rowss = mysqli_fetch_array($result)) {
                                        $sqlls = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$rowss[0]'";
                                        $resultl = mysqli_query($con,$sqlls);
                                        if (mysqli_num_rows($resultl) > 0) {
                        			        while ($rowl = mysqli_fetch_array($resultl)) {
                                                if($rowl[0]=='_price'){
                        				            $sqlt = "select post_title FROM `wp_posts`  WHERE `ID`=$rowss[0]";
                        				            $resultt = mysqli_query($con,$sqlt);
                        				            if (mysqli_num_rows($resultt) > 0) {
                        					            while ($rowt = mysqli_fetch_array($resultt)) {
                        						            $sqllk="INSERT INTO `wp_woocommerce_order_items`(`order_item_name`, `order_item_type`,`order_id`) VALUES ('$rowt[0]','line_item','$largestNumber')";
                                                            if ($con->query($sqllk)) {
                                                                $aeae="SELECT `order_item_id` FROM `wp_woocommerce_order_items` WHERE `order_item_name`='$rowt[0]' and `order_id`=$largestNumber";
                                                                $resultsssh = mysqli_query($con,$aeae);
                                                                $rowsf = mysqli_fetch_array( $resultsssh );
                                                                $nmj = $rowsf['order_item_id'];
                                                                $sqllm = "INSERT INTO `wp_wc_order_product_lookup`(`order_item_id`,`order_id`, `product_id`, `customer_id`, `date_created`, `product_qty`, `product_net_revenue`) 
                                                                        VALUES ('$nmj','$largestNumber','$rowss[0]','$row[0]','$date','$rowss[1]','$rowl[1]')";
                                                                if ($con->query($sqllm)) {
                                                                    $response="Success";
                                                                }
                                                            }
                        					            }
                        				            }
                        			            }
                        		            }
                                       }
                                    }
                                }
                                for($i=0;$i<sizeof($value);$i++){
                                    $sqlllk = "INSERT INTO `wp_postmeta`( `post_id`, `meta_key`, `meta_value`) VALUES ('$largestNumber','$value[$i]','$meta_value[$i]')";
                                    if ($con->query($sqlllk)) {
                                        $response="Success";
                                    }
                                }
                            }
        				}
                    }
                     echo json_encode($response);
                }
                else {
        	        $sql = "INSERT INTO `wp_wc_customer_lookup`(`user_id`, `username`, `first_name`, `last_name`, `email`,`date_registered`, `country`, `postcode`, `city`, `state`) 
        	                                            VALUES ($row[0],'$row[1]','$fname','$lname','$email','$date','$country','$postcode','$city','$state')";
                    if ($con->query($sql)) {
                        $sql = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$email' && user_id=$row[0]";
                        $result = mysqli_query($con,$sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $sql = "select MAX(ID) as max from `wp_posts`";
                                $result = mysqli_query($con,$sql);
                                $rows = mysqli_fetch_array( $result );
                                $largestNumber = $rows['max']+1;
                                $sqll="INSERT INTO `wp_posts`(`ID`, `post_date`, `post_date_gmt`, `post_title`, `post_status`, `comment_status`, `ping_status`,`post_name`,`post_modified`, `post_modified_gmt`,`guid`,`post_type`) 
                                    VALUES ('$largestNumber','$date','$date','Order &ndash; date('F d,Y @ H:i A')','wp-processing','open','open','order-date('Y-F-d-Hi-a')','$date','$date','http://jobmafiaa.com/products/lavina/?post_type=shop_order&#038;p=$largestNumber','shop_order')";
                				if ($con->query($sqll)) {
                				    $sqll = "INSERT INTO `wp_wc_order_stats`(`order_id`,`date_created`, `date_created_gmt`, `num_items_sold`, `total_sales`, `net_total`, `status`, `customer_id`) 
                                        VALUES ('$largestNumber','$date','$date','$count','$totalprice','$totalprice','wp-processing','$row[0]')";
                                    if ($con->query($sqll)) {
                                        $sql= "select `post_id`,`count` from `cart` where `email`='$email'";
                                        $result = mysqli_query($con,$sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($rowss = mysqli_fetch_array($result)) {
                                                $sqlls = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$rowss[0]' ";
                                                $resultl = mysqli_query($con,$sqlls);
                                                if (mysqli_num_rows($resultl) > 0) {
                                			        while ($rowl = mysqli_fetch_array($resultl)) {
                                                        if($rowl[0]=='_price'){
                                				            $sqlt = "select post_title FROM `wp_posts`  WHERE `ID`=$rowss[0]";
                                				            $resultt = mysqli_query($con,$sqlt);
                                				            if (mysqli_num_rows($resultt) > 0) {
                                					            while ($rowt = mysqli_fetch_array($resultt)) {
                                						            $sqllk="INSERT INTO `wp_woocommerce_order_items`(`order_item_name`, `order_item_type`,`order_id`) VALUES ('$rowt[0]','line_item','$largestNumber')";
                                                                    if ($con->query($sqllk)) {
                                                                        $aeae="SELECT `order_item_id` FROM `wp_woocommerce_order_items` WHERE `order_item_name`='$rowt[0]' and `order_id`=$largestNumber";
                                                                        $resultsssh = mysqli_query($con,$aeae);
                                                                        $rowsf = mysqli_fetch_array( $resultsssh );
                                                                        $nmj = $rowsf['order_item_id'];
                                                                        $sqllm = "INSERT INTO `wp_wc_order_product_lookup`(`order_item_id`,`order_id`, `product_id`, `customer_id`, `date_created`, `product_qty`, `product_net_revenue`) 
                                                                                VALUES ('$nmj','$largestNumber','$rowss[0]','$row[0]','$date','$rowss[1]','$rowl[1]')";
                                                                        if ($con->query($sqllm)) {
                                                                            
                                                                        }
                                                                    }
                                					            }
                                				            }
                                			            }
                                		            }
                                               }
                                            }
                                        }
                                        for($i=0;$i<sizeof($value);$i++){
                                            $sqlllk = "INSERT INTO `wp_postmeta`( `post_id`, `meta_key`, `meta_value`) VALUES ('$largestNumber','$value[$i]','$meta_value[$i]')";
                                            if ($con->query($sqlllk)) {
                                                $response="Success";
                                            }
                                        }
                                    }
                				}
                            }
                        }
                    }
                    echo json_encode($response);
                }
            }
        }
      mysqli_close($con);
    }
    
    if(isset($_REQUEST["myorder_brief"])){
        $email=$_GET['email'];
        $o=1;
        $response["results"] = array();
        $sql = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$email' && user_id!=''";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "SELECT `order_id`, `date_created`, `num_items_sold`,  `total_sales`,`status`  FROM `wp_wc_order_stats` WHERE customer_id='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
				            $product["order_id"] =$rowl[0];
				            $product["date_created"] =$rowl[1];
				            $product["num_items_sold"] =$rowl[2];
				            $product["net_total"] =$rowl[3];
				            $product["status"] =substr($rowl[4],3);
				            $sqlt = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$rowl[0]'";
				            $resultt = mysqli_query($con,$sqlt);
				            if (mysqli_num_rows($resultt) > 0) {
					            while ($rowt = mysqli_fetch_array($resultt)) {
					                if($rowt[0]=='_payment_method_title'){
                                        $product[$rowt[0]] =$rowt[1];
                                    }
					            }
				            }
		            }
               }
		       array_push($response["results"], $product);
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["myorder_details"])){
        $email=$_GET['email'];
        $o=1;
        $oo=1;
        $response["results"] = array();
        $sql = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$email' && user_id!=''";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "SELECT `order_id`, `date_created`,`net_total`,`status`, `total_sales`  FROM `wp_wc_order_stats` WHERE customer_id='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
			            $product["order_id"] =$rowl[0];
			            $product["total_sales"] =$rowl[4];
			            $product["net_total"] =$rowl[2];
			            $product["date_created"] =$rowl[1];
			            $product["status"] =substr($rowl[3],3);
			            $sqlt = "SELECT `order_item_name` FROM `wp_woocommerce_order_items` WHERE order_id='$rowl[0]'";
			            $resultt = mysqli_query($con,$sqlt);
			            if (mysqli_num_rows($resultt) > 0) {
				            while ($rowt = mysqli_fetch_array($resultt)) {
                                $product["order_item_name".$o] =$rowt[0];
                                $o++;
 				            }
				            $sqlttt = "SELECT `product_id`, `product_qty`, `product_net_revenue`,  `shipping_amount` FROM `wp_wc_order_product_lookup` WHERE order_id='$rowl[0]'";
    			            $resultttt = mysqli_query($con,$sqlttt);
    			            if (mysqli_num_rows($resultt) > 0) {
    				            while ($rowttt = mysqli_fetch_array($resultttt)) {
    				                $o=$o.$oo;
                                    $product['product_id'.$oo] =$rowttt[0];
                                    $product['product_qty'.$oo] =$rowttt[1];
                                    $product['product_net_revenue'.$oo] =$rowttt[2];
                                    $product['shipping_amount'.$oo] =$rowttt[3];
     				            }
     				            $sqltt = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$rowl[0]'";
        			            $resulttt = mysqli_query($con,$sqltt);
        			            if (mysqli_num_rows($resulttt) > 0) {
        				            while ($rowtt = mysqli_fetch_array($resulttt)) {
        				                if($rowtt[0]=='_payment_method_title'){
                                                $product[$rowtt[0]] =$rowtt[1];
                                      }
        				            }
        			            }
    			            }
    			            
			            }
		            }
               }
		       array_push($response["results"], $product);
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["biling_details"])){
        $email=$_GET['email'];
        $response["results"] = array();
        $sql = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$email' && user_id!=''";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
				$product = array();
                $sqll = "SELECT `order_id` FROM `wp_wc_order_stats` WHERE customer_id='$row[0]' ";
                $resultl = mysqli_query($con,$sqll);
                if (mysqli_num_rows($resultl) > 0) {
			        while ($rowl = mysqli_fetch_array($resultl)) {
			            $product["order_id"] =$rowl[0];
			            $sqlt = "select meta_key,meta_value from `wp_postmeta`  WHERE `post_id`='$rowl[0]'";
			            $resultt = mysqli_query($con,$sqlt);
			            if (mysqli_num_rows($resultt) > 0) {
				            while ($rowt = mysqli_fetch_array($resultt)) {
				                if($rowt[0]=='_billing_first_name'||$rowt[0]=='_billing_last_name'||$rowt[0]=='_billing_address_1'
                                    ||$rowt[0]=='_billing_city'||$rowt[0]=='_billing_state'||$rowt[0]=='_billing_postcode'||$rowt[0]=='_billing_country'||$rowt[0]=='_billing_email'
                                    ||$rowt[0]=='_billing_phone'){
                                        $product[$rowt[0]] =$rowt[1];
                               }
				            }
			            }
		            }
               }
		       array_push($response["results"], $product);
            }
             echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
    
    if(isset($_REQUEST["sp_register"])){
        $fname = $_GET['fname'];
        $lname = $_GET['lname'];
        $fullname = $_GET['fname'].' '.$_GET['lname'];
        $username = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $contact_no = $_GET['contact_no'];
        $CheckSQL = "select * from wp_users where user_email='$email' and user_status=-2";
        $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
        if(isset($check)){
            $response = "Email already exists.";
            echo json_encode($response);
        }
        else{
            $CheckSQL = "select * from wp_users where user_email='$email' and user_status=2";
            $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
            if(isset($check)){
                $response = "Email already exists.";
                echo json_encode($response);
            }
            else{
                $Sql_Query = "INSERT INTO `wp_users`(`user_login`,`user_pass`,`user_nicename`,`user_email`,`user_url`,`display_name`,`user_status`) VALUES
                        ('$username','$password','$fname','$email','$contact_no','$fullname',-2)";
                if($con->query($Sql_Query)){
                    $Sql_Querys = "INSERT INTO `salesperson_distributers`(`email`) VALUES ('$email')";
                    if($con->query($Sql_Querys)){
                        $response = "Wait for Verification Email..!!";
                        echo json_encode($response);
                    }
                    else{
                        $response= "Oops an error occured try again later..!!";
                        echo json_encode($response);
                    }
                }
                else{
                    $response= "Oops an error occured try again later..!!";
                    echo json_encode($response);
                }
            }
        }
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["sp_login"])){
        $email = $_GET['email'];
        $password = $_GET['password'];
        $lat = $_GET['lat'];
        $lon= $_GET['lon'];
        $Sql_Query = "select * from wp_users where `user_email`='$email' and user_status=2";
        $result = mysqli_query($con,$Sql_Query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if($password==$row[2])
                {   
                    $sql="UPDATE `salesperson_distributers` SET `lat`='$lat',`lon`='$lon' WHERE email='$email'";
                    if ($con->query($sql)) 
                    {
                        $response = 'User successfully logged in.';
                    }
                    else
                    {
                        $response = 'Oops!! an error occured .Try agian Later..!!';
                    }
                }
                else
                {
                    $response = 'password is Incorrect..!!';
                }
            }
        }
        else{
            $response = 'User does not exist..!! or Wait for Verification and try again later..!!' ;
        }
        echo json_encode($response);
        mysqli_close($con);
    }
    
    if(isset($_REQUEST["sp_details"])){
        $email=$_GET["email"];
        $sql="SELECT * FROM `salesperson_distributers` WHERE email='$email'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        $response["results"]=array();
        if(mysqli_num_rows($result) > 0)
        {
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["distributor_email"]=$row[1];
                $product["distributor_cn"]=$row[2];
                $product["distributor_address"]=$row[3];
                if($product["distributor_email"]!=null)
                    array_push($response["results"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $product=array();
            $product["success"] = 0;
            $product["message"] = "No Sales person found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
    }
    
    if(isset($_REQUEST["live_one_app"])){
        $email=$_GET["email"];
        $response['results']=array();
        $sql="SELECT `lat`, `lon` FROM `salesperson_distributers` WHERE email='$email'";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["lat"]=urldecode($row[0]);
                $product["lon"]=urldecode($row[1]);
                array_push($response["results"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $product=array();
            $product["success"] = 0;
            $product["message"] = "No Sales person found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
    } 
    
    if(isset($_GET["live_multiple_app"])){
        $response['results']=array();
        $sql="SELECT * FROM `salesperson_distributers`";
        $result = mysqli_query($con,$sql) or die(mysql_error());
        if(mysqli_num_rows($result) > 0)
        {
            while($row=mysqli_fetch_row($result)){
                $product=array();
                $product["lat"]=urldecode($row[4]);
                $product["lon"]=urldecode($row[5]);
                $product["email"]=urldecode($row[0]);
                array_push($response["results"], $product);
            }
            echo json_encode($response);
        }
        else
        {
            $product=array();
            $product["message"] = "No driver found";
            array_push($response["results"], $product);
            echo json_encode($response);
        }
    }

    if(isset($_REQUEST["update_live_location_app"])){
        $lat=$_GET["lat"];
        $lon=$_GET["lon"];
        $email=$_GET["email"];
        $response['results']=array();
        $sql="UPDATE `salesperson_distributers` SET `lat`='$lat',`lon`='$lon' WHERE email='$email'";
        if ($con->query($sql)) 
        {
            $product["success"] = 1;
            $product["message"] = "Updated Successfully";
            array_push($response["results"], $product);
        }
        else
        {
            $product["success"] = 0;
            $product["message"] = "Oops! An error occurred.";
            array_push($response["results"], $product);
            
        }
        echo json_encode($response);
    }
    
    if(isset($_REQUEST['distrubutor_address'])){
        $email=$_GET['email'];
        $response["results"] = array();
        $product = array();
        $sql = "select customer_id from `wp_wc_customer_lookup`  WHERE `email`='$email' && user_id!=''";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $sqll = "SELECT `order_id` FROM `wp_wc_order_stats` WHERE customer_id='$row[0]' ";
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
            $address=$product['_billing_address_1'].$product['_billing_postcode'].$product['_billing_city'].$product['_billing_state'].$product['_billing_country'];
	        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyB1fH8AjDWmR83D5RXpidp_2gd5E5Ey6AA';
            $json = @file_get_contents($url);
            $data=json_decode($json);
            $status = $data->status;
            if($status=="OK")
            {
                $products = array();
                $products["lat"]=$data->results[0]->geometry->location->lat;
                $products["lon"]=$data->results[0]->geometry->location->lng;
                $products['address']=$product['_billing_address_1'].",".$product['_billing_postcode'].",".$product['_billing_city'].",".$product['_billing_state'].",".$product['_billing_country'];
                array_push($response["results"], $products);
            }
            else
            {
                $products = array();
                $products["message"] = "No location found";
                array_push($response["results"], $products);
            }
            echo json_encode($response);
        }
        else {
	        $response["success"] = 0;
            $response["message"] = "Data not found.";
            echo json_encode($response);
        }
       mysqli_close($con);
    }
}
catch(PDOException $e)
{
}
?>
