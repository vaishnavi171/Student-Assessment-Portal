<?php
include "../dbconnect.php";
if(isset($_POST['submit'])){
	require_once('PhpSpreadSheet/vendor/autoload.php');
	$allowed_extensions = array('xls','csv','xlsx');
        $fileName=$_FILES['filename']['name'];
        $fileerr=$_FILES['filename']['error'];
        $filetemp=$_FILES['filename']['tmp_name'];
        $file_array=explode(".",$fileName);
		$fileext=end($file_array);
		if(in_array($fileext,$allowed_extensions))
		{
			$fileType=\PhpOffice\PhpSpreadsheet\IOFactory::identify($fileName);
			$reader=\PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);
			$spreadsheet=$reader->load($filetemp);
			$data=$spreadsheet->getActiveSheet()->toArray();
			$sql="select table_number from assign_numbers limit 1";
			$assign_num=mysqli_query($scon,$sql);
			$row = mysqli_fetch_assoc($assign_num);
			$name="quiz".$row['table_number'];
			$sql = "create table $name(id int AUTO_INCREMENT primary key,Questions varchar(50),option1 varchar(30),option2 varchar(30),option3 varchar(30),option4 varchar(30),answer varchar(30))";
			$retval = mysqli_query($scon,$sql);
			foreach($data as $r)
			{
				$query="Insert into $name(Questions,option1,option2,option3,option4,answer) values('$r[0]','$r[1]','$r[2]','$r[3]','$r[4]','$r[5]')";
				if($scon->query($query));
			}
			$sql="update assign_numbers set table_number=table_number+1";
			mysqli_query($scon,$sql);
						
		}
		else
		{
			echo "invalid";
		}
}
?>
		<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/mcqupload.css">
    
</head>
<style>
button{
            background-color: #808080;
            color: white;
            padding: 16px 16px;
            margin: 8px 0px;
            width: 100%;
        }
  
lang{
width:500px;
}
</style>
<body>

    <div class="main">

        <section class="signup">
            <!-- <img src="img/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form" action="" enctype="multipart/form-data">
                        <h2 class="form-title">UPLOAD QUESTIONS</h2>
                        <div class="form-group">
                            <h4>STAFF NAME</h4>
                            <input type="text" class="form-input" name="name" id="name" placeholder="staff name"/>
                        </div>
                        <div class="form-group">
                            <h4>DEPARTMENT</h4>
                            <input type="text" class="form-input" name="dept" id="dept" placeholder="Dept"/>
                        </div>
			<div class="form-group">
			 <h4>LANGUAGE</h4>
  			 <input type="radio" id="c" name="lang" value="c">
  		 	 <label for="c">C</label><br>
  			 <input type="radio" id="c++" name="lang" value="c++">
  			 <label for="c++">C++</label><br>
  			 <input type="radio" id="java" name="lang" value="java">
  			 <label for="java">JAVA</label><br>
			 <input type="radio" id="python" name="lang" value="python">
  			 <label for="python">PYTHON</label>
			</div>
                        <div>
  			<div class="form-group">
    			
  			<input type="file" name="filename"/>
			</div>
 
                        <div class="form-group">
                          <br>  <button type="submit" name="submit" id="submit"  value="Submit">SUBMIT</button>
                            
                        </div>
                    </form>

                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>