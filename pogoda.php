<?php 

$user = 'root';
$pass = '';

$dbh = new PDO('mysql:host=localhost;dbname=weather', $user, $pass);

$stmt = $dbh->prepare("SELECT city, temp, weather, pressure, humidity FROM ua_city WHERE city = :name");
		$stmt->bindParam(':name', $_GET['city']);
		$stmt->execute();
		$response = $stmt->fetch();
	
echo "Город: " . $response['city'] . "<br>";

echo "Температура: " . $response['temp']  .' градусов'   . "<br>";

echo "Погода: " . $response['weather']  . "<br>";

echo "Давление: " . $response['pressure']  . "<br>";

echo "Влажность: " . $response['humidity'] .'%'  . "<br>";

echo "<a href="\">Назад</a>";

?>