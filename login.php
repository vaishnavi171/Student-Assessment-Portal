<?php
  require "dbconnect.php";
  if(isset($_POST['login']))
  {
    if ( isset($_SESSION['Twinkle'])!="" ) 
    {
      header("Location: index1.php");
      exit;
    }
    $errMSG='';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashPassword = hash('sha256',$password);
    if($email=="admin@gmail.com"&& $password=="password")
    {
      header("Location:Admin/index.html");
    }
    
    $res=mysqli_query($scon,"SELECT * FROM information WHERE email='$email'");
    $row=mysqli_fetch_array($res);
    $count = mysqli_num_rows($res);      
    
    if($count == 1 && $row['pass'] == $password)
    {
      if($row['category']=="Staff")
      {
        $_SESSION['Users'] = $row['email'];
        header("Location: Staff/index.html");
      }
      else if($row['category']=="Student")
      {
        $_SESSION['Users'] = $row['email'];
        header("Location: Student/BS3/dashboard.html");
      }
    }
    else{
      $errMSG = "Invalid data. Check credentials. <br>";
    }            
  }

  if(isset($_POST['signup']))
  {
    $errMSG='';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $category = $_POST['category'];
    $hashPassword = hash('sha256',$password);
    if($password == $repassword)
    {
      $res=mysqli_query($scon,"SELECT * FROM information WHERE email='$email'");
      $row=mysqli_fetch_array($res);
      $count = mysqli_num_rows($res);
      if($count == 0)
      {
        $sql = "INSERT INTO information (username, email, category, pass)VALUES ('$username', '$email', '$category', '$password')";
        if ($scon->query($sql) === TRUE) {
          echo "New record created successfully";
        }
        else
        {
          echo "Error: " . $sql . "<br>" . $scon->error;
        }
      } 
      else{
        $errMSG="E-mail already taken";
      }   
    }
    else
    {
      $errMSG="Check the Password";
    }

  }
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Signin-Signup</title>
        <link rel="stylesheet" href="css/login.css">
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>	
</head>
<body>
   <div class="pagewrapper">
		
		<div class="greenbox fullwidth">
			
			<div class="purplebox">
				<h1>Login</h1>
					<form action="login.php" method="post">
    					
						<div class="form-group fullwidth">
      						<label for="usr">Email:</label>
      						<input type="text" class="form-control" id="usr" name="email">
    					</div>
    					
						<div class="form-group">
      						<label for="pwd">Password:</label>
      						<input type="password" class="form-control" id="pwd" name="password">
    					</div>
						
						<div class="button">
    					<button type="submit" class="btn btn-primary" name="login">Log in </button>
						</div>
  					</form>
			</div>
			
			<div class="purplebox">
				<h1>Signup</h1>
				<form action="login.php" method="post">
    					
						<div class="form-group fullwidth">
      						<label for="usr">UserName:</label>
      						<input type="text" class="form-control" id="usr" name="username">
    					</div>
					
						<div class="form-group">
      						<label for="mail">Email:</label>
      						<input type="email" class="form-control" id="mail" name="email">
    					</div>
    					
						<div class="form-group">
      						<label for="pwd">Password:</label>
      						<input type="password" class="form-control" id="pwd" name="password">
    					</div>
    					
						<div class="form-group">
      						<label for="repwd">Password:</label>
      						<input type="password" class="form-control" id="repwd" name="repassword">
    					</div>
					
						
						<div class="form-check">
      						<label class="form-check-label" for="radio1">
        					<input type="radio" class="form-check-input" id="radio1" name="category" value="Staff" checked>Staff
      						</label>
    					</div>
    					<div class="form-check">
      						<label class="form-check-label" for="radio2">
        					<input type="radio" class="form-check-input" id="radio2" name="category" value="Student">Student
      						</label>
    					</div>
					
						<div class="button">
    						<button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
						</div>
					
						
				</form>
			</div>
			
		</div>
	
	</div>
   
    <!-- tab-content -->

        <div id='stars'></div>
        <div id='stars2'></div>
        <div id='stars3'></div>
        

</body>
</html>