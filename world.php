<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try{
	$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", 	$username, $password);
	$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$lookupType = isset($_GET['lookup']) ? $_GET['lookup']: '';
	$results = null;

	if(isset($_GET['country']) && !empty($_GET['country'])){
		$country = $_GET['country'];
		

		if($lookupType === 'cities'){
			$stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population, countries.name AS country_name FROM cities JOIN countries ON cities.country_code = code WHERE countries.name LIKE :country");
			$stmt -> execute([':country' => "%$country%"]);
			$results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		}else{
			$stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
			$stmt -> execute([':country' => "%$country%"]);
			$results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		}
	} else{
		$stmt = $conn -> query("SELECT * FROM countries");
		$results = $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}
	if ($results === null || count($results) === 0) {
        	echo "<p>No results found.</p>";
    	} else {
	
		if ($lookupType === 'cities'){
			echo '<h2>Cities in ' . htmlspecialchars($country) . '</h2>';
        		echo '<table border="1">';
        		echo '<thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead>';
        		echo '<tbody>';
        		foreach ($results as $row) {
            			echo '<tr>';
            			echo '<td>' . htmlspecialchars($row['city_name']) . '</td>';
            			echo '<td>' . htmlspecialchars($row['district']) . '</td>';
            			echo '<td>' . htmlspecialchars($row['population']) . '</td>';
            			echo '</tr>';
        		}
        		echo '</tbody>';
       			echo '</table>';
    		} else {
			echo '<h2>Countries</h2>';
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
		}
	}
}catch (PDOException $e){
	echo "Connection failed: " . $e -> getMessage();
	exit;
}

?>

