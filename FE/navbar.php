<link href="css/main.css" rel="stylesheet">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


<!-- information environnement de dev -->
<?php

// Read the JSON file 
$json_content = file_get_contents('../config.json');
  
// Decode the JSON file
$conf_array = json_decode($json_content, true);

if(!$conf_array)
{
  $conf_array["GENERAL"]["backend-ip"] = "127.0.0.1";
  $conf_array["GENERAL"]["backend-port"] = "7779";
  $conf_array["GENERAL"]["frontend-ip"] = "127.0.0.1";
  $conf_array["GENERAL"]["frontend-port"] = "8000";
}
$backend = "http://" . $conf_array["GENERAL"]["backend-ip"] . ":" . $conf_array["GENERAL"]["backend-port"];
$frontend = "http://" . $conf_array["GENERAL"]["frontend-ip"] . ":" . $conf_array["GENERAL"]["frontend-port"];

?>

<!-- Navbar -->
<div class="fixed-top">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="main-navbar">
<?php
if( $conf_array['GENERAL']['env'] === 'dev')
{
	echo '<div class="fixed-top" align="center"><span class="badge bg-danger" align="center"><strong>Attention !</strong> Vous êtes sur l\'environnement de dev.</span></div>';
}
  echo '<div class="container-fluid';
if( $conf_array['GENERAL']['env'] === 'dev')
{
  echo ' pt-4';
}
  echo '">';
?>
  <a class="navbar-brand" href="index.php"><img src="./img/Ronde des logos 64x64.gif" height="16" alt="Logos des differents collectifs" loading="lazy" /></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Le projet</span></a>
      <a class="nav-item nav-link" href="depot.php">Déposer ses données</a>
      <a class="nav-item nav-link" href="statistiques.php">Statistiques</a>
      <a class="nav-item nav-link" href="exemples.php">Exemples d'utilisations des données</a>
      <a class="nav-item nav-link" href="tuto.php">Comment récupérer ses traces Géovélo ?</a>
    </div>
  </div>
  </div>
</nav></div>
<!-- Navbar -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script>
$(window).on("resize",function () {
               $('body').css('padding-top', parseInt($('#main-navbar').css("height")));
            });
 
$(window).on("load",function () {
               $('body').css('padding-top', parseInt($('#main-navbar').css("height")));        
});
</script>