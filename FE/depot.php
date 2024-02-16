<!doctype html>
<html class="no-js" lang="">

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

  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">

</head>

<body>
  <!-- Navbar -->
  <?php include "navbar.php";?>

  <div class="mx-auto" style="width: 90%;">

  <p class="lead mt-4">    
    Si vous circulez sur la MEL ou les communautés de communes aux alentours et souhaitez contribuer au projet.
    Envoyer vos traces de circulation réalisées via votre application préférée. 
    Après anonymisation et validation celle-ci seront archivées pour enrichire une base de donnée des déplaces métropolitains.
  </p>
 
  <form method="post" name="oTeleversement" id="oTeleversement" action="archive.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="fichier">Sélectionnez un fichier: </label>
        <input type="file" class="form-control-file" id="hFichier" name="hFichier" lang="fr" accept=".zip,.json" />
      </div>
      <br>
      <div class="form-group">
        Dans quelles équipes avez vous participé (plusieurs choix possible):
        <select class="form-select" aria-label="Default select example" id="hTeams">
          <option selected value="none">...</option>
          <option value="Haubourdin en selle">Haubourdin en selle</option>
          <option value="Roule pour Santes">Roule pour Santes</option>
          <option value="CCPC à vélo">CCPC à vélo</option>
        </select>
      </div>
      <div>
      <br>
      <center>
      <button class="btn btn-primary" type="submit">Envoyer</button>
      </center>
      </div>
      </form>
  </div>

</body>

</html>
