<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="js/vendor/modernizr-3.12.0.min.js"></script>
<script src="js/app.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
<script src="js/bootstrap.js"></script>

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

if( $conf_array['GENERAL']['env'] === 'dev')
{
	echo '<div align="center"><span class="badge bg-danger"><strong>Attention !</strong> Vous êtes sur l\'environnement de dev.</span></div>';
}

?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Navbar brand -->
      <a class="navbar-brand mt-2 mt-lg-0" href="#">
        <img src="./img/Ronde des logos 64x64.gif" height="16" alt="Logos des differents collectifs" loading="lazy" />
      </a>
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-light-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Le projet</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="depot.php">Déposer ses données</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="statistiques.php">Statistiques</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="exemples.php">Exemples d'utilisations des données</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tuto.php">Comment récupérer ses traces Géovélo ?</a>
        </li>
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->