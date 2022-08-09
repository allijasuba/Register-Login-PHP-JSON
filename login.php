<?php require("login.class.php") ?>
<?php 
	if(isset($_POST['submit'])){
		$user = new LoginUser($_POST['username'], $_POST['password'], $_POST['month'], $_POST['day'], $_POST['year'], $_POST['student_number'], $_POST['family_name']);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Log in form</title>
	<script>
		function myFunction() {
		  var x = document.getElementById("myInput");
		  if (x.type === "password") {
			x.type = "text";
		  } else {
			x.type = "password";
		  }
		}
		function createYearOptions(){
			var years = 1900;
			var days = 1;
			var yroptions = "<option value = ''> Birth Year</option>";
			var dayoptions = "<option value = ''> Birth Day</option>";
			
			for (var i = years; i  < years +113; i++){
				yroptions += "<option value = '"+i+"'>"+i+"</option>"
			}
			for (var i = days; i  < days +31; i++){
				dayoptions += "<option value = '"+i+"'>"+i+"</option>"
			}
			
			document.getElementById('yr').innerHTML = yroptions;
			document.getElementById('day').innerHTML = dayoptions;
		}
	</script>
</head>
<body onload = "createYearOptions()">
	<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
		<h2>Log In</h2>
		<label>Student Number</label>
		<input type="text" name ="student_number" value="" placeholder = "20XX-XXXXX-XX-X"required/>
		<label>Family Name</label>
		<input type="text" name ="family_name" value="" placeholder = "Enter your Family Name"required/>
		<label>Date of Birth</label>
		<select name ="month" required>
			<option value = ''> Birth Month </option>
			<option value = 'January'> January</option>
			<option value = 'February'> February</option>
			<option value = 'March'> March</option>
			<option value = 'April'>April</option>
			<option value = 'May'>May</option>
			<option value = 'June'>June</option>
			<option value = 'July'>July</option>
			<option value = 'August'>August</option>
			<option value = 'September'>September</option>
			<option value = 'October'>October</option>
			<option value = 'November'>November</option>
			<option value = 'December'>December</option>
		</select>
		<select id = "day" name = "day" required>
		</select>
		<select id = "yr" name = "year"required>
		</select>
		<label>Username</label>
		<h5>&nbsp must only contain letter, numbers or underscores.</h5>
		<input type="text" name ="username" value="" placeholder = " Enter your Username "required/>
		<label>Password</label>
		<h5>&nbsp must be between 8-32 characters.</h5>
		<input type="password" name ="password" value="" id="myInput" placeholder = " Enter your Password "required/> 
        <input type="checkbox" onclick="myFunction()">Show Password
		<button type="submit" name="submit">LOG IN</button>
		Don't have an account? <a href = 'index.php'> SIGN UP</a>

		<p class="error"><?php echo @$user->error ?></p>
		<p class="success"><?php echo @$user->success ?></p>
	</form>

</body>
</html>