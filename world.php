<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try{
	$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", 	$username, $password);
	$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if(isset($_GET['country']) && !empty($_GET['country'])){
		$country = $_GET['country'];
		$stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
		$stmt -> execute([':country' => "%$country%"]);
	} else{
		$stmt = $conn -> query("SELECT * FROM countries");
	}

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo '<table border = "1">';
	echo '<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr><thead>';
	echo '<tbody>';
	foreach($results as $row){
		echo '<tr>';
		echo '<td>'.htmlspecialchars($row['name']).'</td>';
		echo '<td>'.htmlspecialchars($row['continent']).'</td>';
		echo '<td>'.htmlspecialchars($row['independence_year']).'</td>';
		echo '<td>'.htmlspecialchars($row['head_of_state']).'</td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}catch (PDOException $e){
	echo "Connection failed: " . $e -> getMessage();
	exit;
}

?>

