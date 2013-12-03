<!doctype html>
<body>
<h3>Results from Google Cloud SQL</h3>

<?php
	//------------------------------------------
	// YOUR IP
	//------------------------------------------
	echo "<table class=simpletable border=1>";
	echo "<tr><th align=left>YOUR IP</th></tr>";
    echo "<tr><td align=left>" . $_SERVER["REMOTE_ADDR"] . "</td></tr>";
	echo "</table>";
	
	echo "<br>";
	//------------------------------------------
	// DB INFO
	//------------------------------------------
	$mysqli = new mysqli(null, "root", null, "glass_db", null, "/cloudsql/wildlabglass:wildlabglass");
	//$mysqli = new mysqli("173.194.109.242", "root", "test001", "glass_db");
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		$mysqli->close();
		exit();
	}
	echo "<table class=simpletable border=1>";
	echo "<tr><th align=left>HOST INFO</th></tr>";
    echo "<tr><td align=left>" . $mysqli->host_info . "</td></tr>";
	echo "</table>";
	
	echo "<br>";
	//------------------------------------------
	// list all databases
	//------------------------------------------
	$res = $mysqli->query("SHOW DATABASES");
	//$res = mysqli_query($mysqli,"SHOW DATABASES");
	echo "<table class=simpletable border=1>";
	echo "<tr><th align=left>ALL DATABASES</th></tr>";
	while($cRow = mysqli_fetch_array($res)){
    	echo "<tr><td align=left>" . $cRow[0] . "</td></tr>";
	}
	echo "</table>";

	echo "<br>";


	//------------------------------------------
	// make sure there's a table called 'credentials'
	//------------------------------------------
		
	// Create table if not exist 
	$statement="CREATE TABLE IF NOT EXISTS credentials (userid VARCHAR(255) NOT NULL UNIQUE, credentials TEXT NOT NULL)";

	// Execute query
	if ($mysqli->query($statement))
	{
		echo "<h1>Table credentials created successfully</h1>";
	} else {
		echo "Error creating table: " . mysqli_error($mysqli);
	}
		
	$db = $mysqli;	

	echo "<br>";
	//------------------------------------------
	// list everything in 'credentials'
	//------------------------------------------

	$query_statement = "SELECT userid, credentials FROM credentials";
	$result = $db->query($query_statement);

		 		
	echo "<h2>list everything in credentials table</h2>";
	
	echo "<table class=simpletable border=1>";
	echo "<tr><th align=left>userId</th>";
	echo "<th align=left>credentials</th></tr>";

	$resultArray = array();
  	while ($singleResult = $result->fetch_array(MYSQLI_ASSOC)){
    	array_push($resultArray, $singleResult);
		echo "<tr><td align=left>" . $singleResult["userid"] . "</td>";
		echo "<td align=left>" . $singleResult["credentials"] . "</td></tr>";
  	}
	
	echo "</table>";
	echo "<br>";
	
 
	//------------------------------------------
	// get User ID
	//------------------------------------------
 	// echo "get userId";
 	// echo "<br>";
//   
//  
   // $user_id = $db->real_escape_string(strip_tags("aaaaa"));
// 
  	// $query_statement = "SELECT * FROM credentials WHERE userid = '$user_id'";
  	// $result = $db->query($query_statement);
// 
  	// $row = $result->fetch_array(MYSQLI_ASSOC);
	// echo $row['credentials'];
	
	
	//------------------------------------------
	// store
	//------------------------------------------
 	// echo "store";
 	// echo "<br>";
// 		
  // $user_id = $db->real_escape_string(strip_tags("ccccc"));
  // $credentials = $db->real_escape_string(strip_tags("333333"));
// 
  // $insert = "REPLACE INTO credentials VALUES ('$user_id', '$credentials')";
  $db->query($insert);

	

?>


<!-- Style the results table -->
<style type="text/css">
h2 {font-family:verdana;font-size:15px;color:#181C26;}
h3 {font-family:verdana;font-size:24px;color:#181C26;}
table.simpletable {font-family:verdana;font-size:15px;color:#40434A;border-width:1px;border-color:#778AB8;border-collapse:collapse;}
table.simpletable th {border-width: 1px;padding: 10px;border-style: solid;border-color:#778AB8;background-color:#dedede;}
table.simpletable td {border-width: 1px;padding: 10px;border-style: solid;border-color: #778AB8;background-color: #ffffff;}
</style>
 
<!-- Add commas to numbers appearing in the table cell with the attribute 'class=addCommas'-->
<script type="text/javascript">
function formatNumberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
 
var elements = document.querySelectorAll('td.addCommas');
var i;
for (i in elements) {
   if(elements[i].innerHTML != undefined) {
         elements[i].innerHTML = formatNumberWithCommas(elements[i].innerHTML);
   }
}
</script>
 
</body>
</html>