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
}catch (PDOException $e){
	echo "Connection failed: " . $e -> getMessage();
	exit;
}

?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
