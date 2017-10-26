<?php
// User login. 
session_start();

include_once("includes/jossophp.php");

if($_SESSION['loggedin']=="yes"){
	
	//already logged in
	include("includes/header.php");
	
	?>
	
	
	<br><br>
	
	You are already logged in as: <?=$_SESSION['email']?>. (<a href="logout.php">Logout</a>)
	
	<br><br>
	
	<?
	include("includes/footer.php");
	exit();
}


if($_POST['submit']!=""){

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if($userdata=geopasslogin($username,$password)){

		$email = $userdata['email'];
		$firstname = $userdata['firstname'];
		$lastname = $userdata['lastname'];
		$ip = $_SERVER['REMOTE_ADDR'];

		$_SESSION['email']=$email;
		$_SESSION['firstname']=$firstname;
		$_SESSION['lastname']=$lastname;
		$_SESSION['password']=$password;
		$_SESSION['loggedin']="yes";
		
		$newpage = $_SESSION['currentpage'];
		if($newpage==""){$newpage="/";}
		
		header("Location:".$newpage);
		exit();

	}else{

		$error = $geopassloginerror;
	}

}


//show login page

include("includes/header.php");

?>



<?
if($error!=""){
?>

<div style="padding:20px;background-color:#FFE6E6;border:#FF3300 1px dashed;color:#FF3300;margin-top:15px;">
<?=$error?>
</div>

<?
}
?>

<form method="POST">
<div style="padding:20px;background-color:#eeeeee;border:#27b 1px solid;margin-top:15px;">
	<table style="background-color:#eeeeee;font: 11px Lucida Grande,Arial,sans-serif;color:#789;">
		<tr><td colspan="2"><img src="includes/geopass.jpg" border="0"></td></tr>
		<tr><td>GeoPass ID (email):</td><td><input type="text" name="username"></td></tr>
		<tr><td>Password:</td><td><input type="password" name="password"></td></tr>
		<tr><td></td><td><input type="submit" name="submit" value="Submit"></td></tr>
		<tr>
			<td colspan="2">
				<div align="center">
					<a style="color:#27b;text-decoration:none;" href="https://geopass.iedadata.org/josso/register.jsp">Don't have a GeoPass ID?  Sign up now!</a><br>
					<a style="color:#27b;text-decoration:none;" href="https://geopass.iedadata.org/josso/lost_password.jsp">Forgot/Change your password?</a>
				</div>
			</td>
		</tr>
	</table>
</div>
</form>







<?

include("includes/footer.php");

?>