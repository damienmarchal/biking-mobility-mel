<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Campagne de collecte des traces de circulations vélos 2023: Statistiques</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="apple-touch-icon" href="icon.png">

  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
</head>

<body>
  <!-- Navbar -->
  <?php include "navbar.php"; ?>

  <div class="mx-auto" style="width: 90%;">
    <p class="lead mt-4 rounded">
      Nombre des soumissions: <span id="count">...</span> <br>
      Nombre de trajets: <span id="trace_count">...</span> <br>
      Nombre de km: <span id="total_distance">...</span> <br>
    </p>
    <div class="mt-4">
      <p class="lead mt-4">
        Historique des soumissions:
      </p>
      <table id="example2" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Date soumission</th>
            <th>Nombre de traces</th>
            <th>km (Total)</th>
          </tr>
        </thead>
      </table>
    </div>


    <!--
    <p class="lead mt-4">
    Classement des équipes #MaiAVélo qui ont le plus contribué à cette base de donnée:
    </p>
    <table id="example" class="display" style="width:100%">
    <thead>
      <tr>
      <th>Nom équipe</th>
      <th>Nombre de traces</th>
      <th>Nombre de km</th>
      </tr>
    </thead>
    </table>
    -->
  </div>

  <script language="javascript">
    $.ajax({
      url: '<?php echo $backend; ?>/status',
      dataType: "json",
      cache: false,
      success: function (json) {
        for (const [key, value] of Object.entries(json)) {
          $("#" + key).replaceWith( Number(value).toFixed(0))
        }
      }
    })

    // new DataTable('#example', {
    //   ajax: '<?php echo $frontend; ?>/data/contributions.json',
    //   columns: [
    //     { "data": "name" },
    //     { "data": "trace-count" },
    //     { "data": "distance" }
    //   ]
    // });
    new DataTable('#example2', {
      ajax:
        {
          "url": '<?php echo $backend; ?>/submission_history',
          "dataType" : "json",
          "dataSrc" : ""
        },
      columns: [
        { "data": "date" },
        { "data": "trace_count" },
        { "data": "total_distance", render: function(a){ return Number(a).toFixed(1) } }
      ]
    });


  </script>

</body>

</html>