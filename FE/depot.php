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

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">

  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">

  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
</head>

<body>
  <!-- Navbar -->
  <?php include "navbar.html";?>
   
  <!-- Add your site or application content here -->
  <p>Ici le formulaire de dépo</p>
  
  <form method="post" name="oTeleversement" id="oTeleversement" action="archive.php" enctype="multipart/form-data">
  <div class="form-group">
  <label for="fichier">Sélectionner un fichier</label>
  <input type="file" class="form-control-file" id="hFichier" name="hFichier" lang="fr" accept=".zip,.json" />
  </div>
  <button class="btn btn-primary" type="submit">Envoyer</button>
  </form>

  <script src="js/vendor/modernizr-3.12.0.min.js"></script>
  <script src="js/app.js"></script>

  <script src="js/bootstrap.js"></script>

</body>

</html>
