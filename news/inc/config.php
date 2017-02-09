<?php
	$website_path = 'http://musikandi.com/';
	
	$host = "localhost";
	$database = "webkandi_music";
	$username = "webkandi_mu";
	$password = "4pqi1SBYRj";

	try {
	    $conn = new PDO('mysql:host=' . $host. ';dbname=' . $database, $username, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
	    echo 'Error whilst trying to connect to database: ' . $e->getMessage();
	}

	$categories = array(
		array(
			'name' => 'Booking Agents', // Name for category
			'category' => 'agents', // Table name as on database
			'url' => 'industry.php#agents' // URL for category
		),
		array(
			'name' => 'Americana',
			'category' => 'americana',
			'url' => 'n/a'
		),
		array(
			'name' => 'Broadcast',
			'category' => 'broadcast',
			'url' => 'media.php#broadcast'
		),
		array(
			'name' => 'Digital',
			'category' => 'digital',
			'url' => 'media.php'
		),
		array(
			'name' => 'Festivals',
			'category' => 'festivals',
			'url' => 'venues.php#festivals'
		),
		array(
			'name' => 'Worldwide',
			'category' => 'worldwide',
			'url' => 'industry.php#worldwide'
		),
		array(
			'name' => 'London',
			'category' => 'london',
			'url' => 'venues.php#london'
		),
		array(
			'name' => 'Festivals outside of the UK',
			'category' => 'nonukfests',
			'url' => 'venues.php#outside-uk'
		),
                array(
			'name' => 'Press',
			'category' => 'press',
			'url' => 'media.php#press'
		),
		array(
			'name' => 'Print',
			'category' => 'print',
			'url' => 'media.php#print'
		),
		array(
			'name' => 'Promoters',
			'category' => 'promoters',
			'url' => 'industry.php#promoters'
		),
                array(
			'name' => 'Tech',
			'category' => 'tech',
			'url' => 'bands.php#tech'
		),
		array(
			'name' => 'Venues',
			'category' => 'venues',
			'url' => 'venues.php'
		)
	);
?>