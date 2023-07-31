<html>

<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta property="og:title" content="">
	<meta property="og:type" content="">
	<meta property="og:url" content="">
	<meta property="og:image" content="">

	<link rel="icon" href="/favicon.ico" sizes="any">
	<!-- <link rel="icon" href="/icon.svg" type="image/svg+xml"> -->
	<link rel="apple-touch-icon" href="icon.png">

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">

	<link rel="manifest" href="site.webmanifest">
	<meta name="theme-color" content="#fafafa">

	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
</head>

<body>
	<?php include "navbar.html"; ?>
	<?php
	$stock = '/var/data/haubourinavelo_fr/statistique/depot/';
	$corbeille = '/var/data/haubourinavelo_fr/statistique/corbeille/';
	$myuuid = guidv4();
	$date = date("YmdHis");
	$finale_file_name = "";
	$error_file = false;
	if (is_resource($zip = zip_open($_FILES['hFichier']['tmp_name']))) {
		//this is a zip archive
		$finale_file_name = $date . "_sent_traces_" . $myuuid . ".json";
		while (($zip_entry = zip_read($zip)) !== false) {
			$currentEntryName = zip_entry_name($zip_entry);

			// Si l'entrée est un dossier, on l'ignore
			if ($currentEntryName === "sent_traces.json") {
				file_put_contents($stock . $finale_file_name, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
			}
		}
		zip_close($zip);
	} else {
		$path_parts = pathinfo($_FILES['hFichier']['name']);
		$file_name = end(array_reverse(explode('.', $path_parts['basename'])));
		$finale_file_name = $date . "_" . $file_name . "_" . $myuuid;
		if ($path_parts['extension'] != '') {
			$finale_file_name = $finale_file_name . "." . $path_parts['extension'];
		}

		if (move_uploaded_file($_FILES['hFichier']['tmp_name'], $stock . $finale_file_name) == false) {
			$error_file = true;
			error_log("Le fichier n'a pas pu être placé dans le repertoire (" . $_FILES['hFichier']['tmp_name'] . ") (" . $stock . $finale_file_name . ")");
		}
	}

	if (($error_file === false) && file_exists($stock . $finale_file_name)) {
		$str_json = file_get_contents($stock . $finale_file_name);
		if ($str_json !== "") {
			if (($obj = json_decode($str_json, true)) != null) {
				if (count($obj) > 0) {
					$keys = array_keys($obj[0]);
					if ($keys[0] == "id" && $keys[1] == "computed_route_id" && $keys[2] == "title" && $keys[3] == "geometry" && $keys[4] == "speeds" && $keys[5] == "elevations" && $keys[6] == "distance" && $keys[7] == "duration") {
						echo "Votre fichier a bien été validé et sera traité dans les meilleur délai.";
					} else {
						$error_file = true;
						error_log("Le fichier json ne contient pas les clef Géovélo (" . $stock . $finale_file_name . ")");
					}
				} else {
					$error_file = true;
					error_log("Le fichier json ne contient pas de tableau. Est-ce un fichier Géovélo (" . $stock . $finale_file_name . ")");
				}
			} else {
				$error_file = true;
				error_log("Le fichier ne correspond pas à du json (" . $stock . $finale_file_name . ")");
			}
		} else {
			$error_file = true;
			error_log("Le fichier est vide ou n'a pas pus être lu (" . $stock . $finale_file_name . ")");
		}
	} else {
		$error_file = true;
		error_log("Le fichier n'existe pas ou une erreur est survenu précédement (" . $stock . $finale_file_name . ")");
	}

	if ($error_file === true) {
		rename($stock . $finale_file_name, $corbeille . $finale_file_name);
		echo "Une erreur est survenu lors du chargement de votre fichier.<br/><br/>Votre fichier est-il bien une archive Géovélo ?<br/><br/>Si oui, merci de ressayer plus tard.";
	}

	function guidv4($data = null)
	{
		// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
		$data = $data ?? random_bytes(16);
		assert(strlen($data) == 16);

		// Set version to 0100
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		// Set bits 6-7 to 10
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

		// Output the 36 character UUID.
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	?>
	<script src="js/vendor/modernizr-3.12.0.min.js"></script>
	<script src="js/app.js"></script>

	<script src="js/bootstrap.js"></script>
</body>

</html>