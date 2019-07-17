<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title "><?php echo $vistoria['razao_social'] ?></h4>
          <p class="card-category">Informe os dados para iniciar a vistoria</p>
        </div>
        <div class="card-body table-responsive">
          <div class="row">
            <div class="col-md-12">
              <?php include "perguntas.php"; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title ">Assuntos pertinentes ao imóvel</h4>
        </div>
        <div class="card-body table-responsive">
          <div class="row">
            <div class="col-md-12">
              <?php include "perguntas-assuntos.php" ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title ">ART/RRT Necessárias</h4>
        </div>
        <div class="card-body table-responsive">
          <div class="row">
            <div class="col-md-12">
              <?php include "perguntas-art.php" ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid container-element">
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title ">Ambientes (segundo o projeto)</h4>
        </div>
        <div class="card-body table-responsive">
          <div class="row">
            <div class="col-md-12">
              <?php include "perguntas-ambientes.php" ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-success pull-right btn-round btn-concluirform" style="margin-right: 15px;"><i class="material-icons">done</i> Concluir formulário</button>
    </div>
  </div>
</div>