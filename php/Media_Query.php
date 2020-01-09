<?php
    global $Type;
	include 'environment.php';

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
			
	$sql = 
	"
	select Description 
        from type_content tc 
            join site_content sc 
                on tc.ID = sc.Type_ID
        where
            tc.Type = '$Type'
            and
            sc.Time >= curdate()

	";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
			echo $row["Description"];
		}
	} 
	else 
	{
		echo "0 results";
	}

	$conn->close();
?>


