<?php include "main.php"; ?>
<?php include "version.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Capital Vistoria</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="manifest" href="site.webmanifest">
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#b6e6c6">

  <!--     All plugins     -->
  <link rel="stylesheet" href="assets/css/plugins.css?v=<?php echo $version; ?>">

  <link href="assets/css/app.css?v=<?php echo $version; ?>" rel="stylesheet" />

  <script src="assets/js/modernizr.js"></script>
</head>

<body class="">
  <div class="wrapper" id="wrapper">
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-voltar btn btn-default btn-round" href="#"><i class="material-icons">arrow_back_ios</i> Voltar</a>
            <a class="navbar-inicio btn btn-default btn-round" href="#"><i class="material-icons">home</i> Início</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form" style="display: none;">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
            <ul class="navbar-nav">
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      
      <!-- Begin Página loading -->
      <div class="content active" id="page-start">
        <div class="container-fluid">
          <div class="lds-spinner centered"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
      </div>

      <!-- Begin Página login -->
      <div class="content" id="page-login">
        <div class="container-fluid">
          <?php include "templates/login.php" ?>          
        </div>
      </div>
      
      <!-- Begin Página Lista de serviços -->
      <div class="content" id="page-lista">
        <?php include "templates/lista-servicos.php" ?>          
      </div>
      
      <!-- Begin Página Informações vistoria -->
      <div class="content" id="page-infos">

      </div>
      
      <!-- Begin: Página ambientes do serviço -->
      <div class="content" id="page-ambientes">

      </div>
      
      <!-- Begin: Página Detalhe do ambiente -->
      <div class="content" id="page-ambiente">
        
      </div>
      
      <!-- Begin: Página de análise da vistoria -->
      <div class="content" id="page-analise">
        
      </div>
    </div>
  </div>
</div>

<script src="assets/js/core/jquery.min.js" type="text/javascript"></script>

<!--   Core JS Files   -->
<script src="assets/js/plugins.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script src="assets/js/recorder.js"></script>

<!-- <script src="assets/js/upup.min.js"></script> -->
<!-- <script src="assets/js/idb.js"></script> -->

<script src="assets/js/app.js?v=<?php echo $version; ?>" type="text/javascript"></script>

<script type="text/javascript">

  /*if (UpUp) {
    UpUp.start({
      'cache-version': 'v23',
      'content-url': 'offline.php',
      'assets': [
        '/vistoria/assets/js/jSignature.min.noconflict.js',
        '/vistoria/assets/js/recorder.js',
        '/vistoria/assets/js/upup.min.js',
        '/vistoria/assets/css/material-dashboard.css',
        '/vistoria/assets/css/sweetalert.css',
        '/vistoria/assets/css/bootstrap-select.min.css',
        '/vistoria/assets/js/core/popper.min.js',
        '/vistoria/assets/js/core/bootstrap-material-design.min.js',
        '/vistoria/assets/js/plugins/perfect-scrollbar.jquery.min.js',
        '/vistoria/assets/js/plugins/chartist.min.js',
        '/vistoria/assets/js/plugins/bootstrap-notify.js',
        '/vistoria/assets/js/material-dashboard.js',
        '/vistoria/assets/js/jasny-bootstrap.min.js',
        '/vistoria/assets/js/sweetalert.min.js',
        '/vistoria/assets/js/bootstrap-filestyle.min.js',
        '/vistoria/assets/js/core/jquery.min.js',
        '/vistoria/assets/js/app.js',
        '/vistoria/assets/js/app-offline.js',
        '/vistoria/assets/css/bootstrap-panel.css',
        '/vistoria/assets/js/perguntas.js',
        '/vistoria/assets/css/app.css'
      ],
      'service-worker-url': '/vistoria/upup.sw.min.js'
    });
  } */


  $(document).ready(function(){

    <?php if($auth->check()): ?>
      // prepareFileSystem();
      // setTimeout(function() { sincronizar(); }, 1000);
      setTimeout(function() { navigate("#page-lista", false) }, 500);
    <?php else: ?>
      setTimeout(function() { navigate("#page-login", false) }, 500);
    <?php endif; ?>

  });

</script>
</body>

</html>