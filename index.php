<?php 

$apiKey = "96bb4140074adebe9b35a339f7bfd318";


$url = "http://api.openweathermap.org/data/2.5/group?id=703446,698740,689558,706483,702550&lang=zh_cn&units=metric&appid=96bb4140074adebe9b35a339f7bfd318";
 
$ch = curl_init();
 
// Настройка запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
 
$data = json_decode(curl_exec($ch), TRUE);



$user = 'root';
$pass = '';

$dbh = new PDO('mysql:host=localhost;dbname=weather', $user, $pass);


$stmt = $dbh->prepare("SELECT city, temp, weather, pressure, humidity FROM ua_city WHERE city = :name");
		$stmt->bindParam(':name', $kyiv = 'kyiv Oblast');
		$stmt->execute();
		$response = $stmt->fetch();

echo "Город: " . $response['city'] . "<br>";

echo "В столице сейчас: " . $response['temp'] .' градусов'  . "<br>";

echo "Погода: " . $response['weather']  . "<br>";

echo "Давление: " . $response['pressure']  . "<br>";

echo "Влажность: " . $response['humidity'] .'%' . "<br>";

foreach ($data['list'] as $key => $value) {

			$city = $value['name'];
			$temp = $value['main']['temp'];
			$pressure = $value['main']['pressure'];
			$humidity = $value['main']['humidity'];
			$weather = $value['weather'][0]['main'];

			$stmt = $dbh->prepare("SELECT city FROM ua_city WHERE city = :name");
    		$stmt->bindParam(':name', $city);
    		$stmt->execute();
    		$response = $stmt->fetch();

	if ($response['city'] === $city) {
   	   				
   	

   	}else{

   	   	if ($weather === 'Clouds') {
   	   		$weather = 'Облачно';
   	   	}
      				
      	if ($weather === 'Rain') {
   	   		$weather = 'Дождь';
   	   		print_r($weather);
   	   	}


			      $add = $dbh->prepare("INSERT INTO ua_city (city, temp, weather, pressure, humidity) VALUES (:name, :temp, :weather, :pressure, :humidity)");
			      $add->bindParam(':name', $city);
			      $add->execute();
			      
			      $add->bindParam(':temp', $temp);
			      $add->execute();

			      $add->bindParam(':weather', $weather);
			      $add->execute();

			      $add->bindParam(':pressure', $pressure);
			      $add->execute();

			      $add->bindParam(':humidity', $humidity);
			      $add->execute();

    
    }
}

curl_close($ch);

echo "<pre>";

?>



<a href="/pogoda.php?city=Kyiv Oblast">Киев</a>
<a href="/pogoda.php?city=Lviv">Львов</a>
<a href="/pogoda.php?city=Odesa">Одесса</a>
<a href="/pogoda.php?city=Vinnytsia">Винница</a>
<a href="/pogoda.php?city=Kharkiv">Харьков</a>

