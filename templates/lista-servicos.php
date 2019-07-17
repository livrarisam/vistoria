<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-info btn-round btn-filtervistoria"><i class="material-icons">filter_list</i> Filtrar vistoria</button>
      <button type="button" class="btn btn-info btn-round btn-filteranalise"><i class="material-icons">filter_list</i> Filtrar análise</button>
      <input type="text" id="filter-name" placeholder="Filtrar por nome" style="border-radius: 30px; padding: 6px; width: 30%;">
    </div>
  </div>
  <div class="row">
    <?php foreach ($vistorias as $vistoria):
      if (!empty($vistoria['dtevento'])) {
        $dtevento = implode('/', array_reverse(explode('-', $vistoria['dtevento'])));
      } else {
        $dtevento = "Pendente";
      }

      ?>

      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="card card-servico <?php echo $vistoria['id_servico'] ?>">
          <div class="card-header card-header-info">
            <h4 class="card-title"><?php echo $vistoria['razao_social']; ?></h4>
          </div>
          <div class="card-body">
            <h6 class="card-category text-gray"><?php echo $vistoria['rua'] ?>, <?php echo $vistoria['numero'] ?>, <?php echo $vistoria['cep'] ?> <?php echo $vistoria['cidade'] ?> - <?php echo $vistoria['uf'] ?></h6>
            <p class="card-description">
              <?php echo getEquipsbyVistoria($vistoria['id_servico']); ?> equipamentos<br>
              <?php echo getAmbientesbyVistoria($vistoria['id_servico']); ?> ambientes
            </p>
            <?php if(!empty($dtevento)): ?>
              <p class="card-description">
                <strong>Agendamento:</strong> <?php echo $dtevento ?>
              </p>
            <?php endif; ?>

            <!-- <h5 class="card-category card-offline" style="color: #5cb85c;"><strong>Disponível offline</strong></h5> -->

            <a href="#page-infos" class="btn btn-info btn-round navigate-infos" data-id="<?php echo $vistoria['id_servico'] ?>"><i class="material-icons">info</i> Formulário tecnico</a>
            <?php if($vistoria['status'] == "Confirmado" && $vistoria['servico_status'] == "Vistoria In-Loco"): ?>
              <a href="#page-detalhe" class="btn btn-info btn-round navigate-ambientes" data-id="<?php echo $vistoria['id_servico'] ?>"><i class="material-icons">home</i> Relatório/vistoria</a>
            <?php endif; ?>
            <?php if($vistoria['status'] == "Em análise"): ?>
              <a href="#page-detalhe" class="btn btn-info btn-round navigate-analise" data-id="<?php echo $vistoria['id_servico'] ?>"><i class="material-icons">home</i> Analisar vistoria técnica</a>
            <?php endif; ?>
            <!-- <button type="button" class="btn btn-info btn-round btn-sm btn-sinc" data-id="<?php echo $vistoria['id_servico'] ?>"><i class="material-icons">link</i> Sincronizar</button> -->
          </div>
        </div>
      </div>

    <?php endforeach; ?>
  </div>
</div>