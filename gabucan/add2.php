<html>
<head>
	<title>Add Data</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	
  <style> 
		body{
	background-image: url(info.jpg);
	
	background-size:cover;
	
		input[type=text] {
		  width: 100%;
		  padding: 12px 20px;
		  box-sizing: border-box;
		  border: 3px solid #ccc;
		  outline: none;
		}
		
		input[type=text]:focus {
		  border: 3px solid #555;
		}
		</style>
<body>
<nav class="navbar navbar-center">
  <ul class="nav navbar-nav">
    <li><a href="add.html">Student</a></li>
     <li><a href="add2.php">Class</a></li>
       <li><a href="index3.php"> View Class</a></li>
     <li><a href="index2.php"> View Student</a></li>

  </ul>
  <ul class="nav navbar-nav navbar-right">
     
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
    </ul>
</nav>

</nav>

</body>
<?php
//including the database connection file
include_once("config.php");
if(isset($_POST['Submit'])) {
	$id = $_POST['id'];
	$classcode = $_POST['classcode'];
	$studentid = $_POST['studentid'];
	$subjectcode = $_POST['subjectcode'];
	$time = $_POST['time'];
	$teacher = $_POST['teacher'];
		
	// checking empty fields
	if(empty($classcode) || empty($subjectcode) || empty($time) || empty($teacher)) {
				
		if(empty($classcode)) {
			echo "<font color='red'>Class Code field is empty.</font><br/>";
		}
		
		if(empty($subjectcode)) {
			echo "<font color='red'>Subject Code field is empty.</font><br/>";
		}
		if(empty($time)) {
			echo "<font color='red'>Time field is empty.</font><br/>";
		}
		if(empty($teacher)) {
			echo "<font color='red'>Teacher field is empty.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database		
		$sql = "INSERT INTO tbl_class(classcode,studentid, subjectcode, time, teacher) VALUES(:classcode, :studentid,:subjectcode, :time,:teacher)";
	
		$query = $dbConn->prepare($sql);
		
				
		$query->bindparam(':classcode', $classcode);
		$query->bindparam(':studentid', $studentid);
		$query->bindparam(':subjectcode', $subjectcode);
		$query->bindparam(':time', $time);
		$query->bindparam(':teacher', $teacher);
		$query->execute();
		
		// Alternative to above bindparam and execute
		 $query->execute(array(':classcode' => $classcode, ':studentid' => $studentid, ':subjectcode' => $subjectcode, 'time' => $time, ':teacher' => $teacher  ));
		
		//display success message
		echo "<center><font color='green'><a>Data added successfully.</a></center>";
		echo "<center><br/><a href='index2.php'>View Result</a></center>";
	}
} else {
	$sql = "SELECT * FROM `tbl_student`";
	$query = $dbConn->prepare($sql);
	$result = $dbConn->query("SELECT * FROM tbl_student ORDER BY studentid DESC");
	//get data from student
	//id
	//name
?>

	<br/><br/>

<div class="container">
 <center>
<form action="add2.php" method="post" name="form1">
		<table>
            <tr> 
                <td>ID</td>
                <td><input type="text" name="id"></td>
			</tr>
			<tr> 
				<td>Class Code</td>
				<td><input type="text" name="classcode"></td>
			</tr>
			<tr> 
                <td>StudentID</td>
                <td>
					<select name="studentid">
						<?php 
							while($row = $result->fetch(PDO::FETCH_ASSOC)) { 	
								?>
								<option value="<?php echo $row['studentid']?>"><?php echo $row['fname'] . ' ' .$row['lname'] ; ?></option>
								<?php		
							}		
						?>
					</select>				
					
            </tr>
			<tr> 
				<td>Subject Code</td>
				<td><input type="text" name="subjectcode"></td>
			</tr>
			<tr> 
				<td>Time</td>
				<td><input type="time" name="time"></td>
			</tr>
			<tr>
				<td>Teacher</td>
				<td><input type="text" name="teacher"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit" value="Add" class="btn btn-danger"></td>
			</tr>
		</table>
	</form>
						</center>
<?php } ?>





</body>
</html>