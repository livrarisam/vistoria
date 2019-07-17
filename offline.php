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

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-panel.css" rel="stylesheet" />
  <link href="assets/css/sweetalert.css" rel="stylesheet" />
  <link href="assets/css/ui.fancytree.css" rel="stylesheet">

  <!-- Bootstrap Select -->
  <link href="assets/css/bootstrap-select.min.css" rel="stylesheet" />

  <link href="assets/css/app.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
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
          <img src="images/loading.gif" class="centered"/>
        </div>
      </div>
      
      <!-- Begin Página Lista de serviços -->
      <div class="content" id="page-lista">
        <div class="container-fluid">

        </div>
      </div>
      
      <!-- Begin Página Início vistoria -->
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
      
      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright">
            &copy; <?php echo date('Y'); ?> <a target="_blank" href="http://www.creative-tim.com">Creative Tim</a>, <a target="_blank" href="http://w7smart.com.br">W7Smart</a>
          </div>
        </div>
      </footer>

    </div>
  </div>
</div>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>

<!-- Chartist JS -->
<script src="assets/js/plugins/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>

<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/material-dashboard.js" type="text/javascript"></script>

<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="assets/js/jasny-bootstrap.min.js"></script>

<!-- Bootstrap Sweet Alert -->
<script src="assets/js/sweetalert.min.js"></script>

<!-- Bootstrap File Style -->
<script src="assets/js/bootstrap-filestyle.min.js"></script>

<script src="assets/js/bootstrap-select.min.js"></script>

<script src="assets/js/upup.min.js"></script>

<script src="assets/js/jSignature.min.noconflict.js"></script>

<script src="assets/js/app-offline.js" type="text/javascript"></script>

<script type="text/javascript">

  $(document).ready(function(){
    
    setTimeout(function(){window.scrollTo(0, 0);}, 1000);
    
    $("select.dataselect").each(function(el) {
      $(this).selectpicker({
        liveSearch: true,
        style: 'btn-info btn-fill',
        noneSelectedText: ''
      });
    });

    $("select.produtoselect").each(function(el) {
      $(this).selectpicker({
        liveSearch: true,
        style: 'btn-default',
        noneSelectedText: ''
      });
    });

    if ($("#page-start").hasClass("active")) {

      setTimeout(function() { 
        var lista = localStorage.getItem('lista-servicos');
        $("#page-lista").html(lista);
        navigate("#page-lista", false) 
      }, 1000);
      
    }

  });

</script>
</body>

</html>