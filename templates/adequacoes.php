<?php foreach($categorias as $cat): 
  $nroit  = explode(' - ', $cat['it']);
  $nroit  = current($nroit);
  $itfile = "/vistoria/files/$nroit.pdf";
  $checklist = getChecklist($cat['id']);
?>
<div class="panel panel-info panel-descarta<?php echo $cat['id'] ?>" id="categoria-<?php echo $cat['id'] ?>">
  <div class="panel-heading">
    <strong><?php echo $cat['it']; ?></strong>
    <a href="<?php echo $itfile; ?>" target="_blank" class="btn btn-default btn-round"><i class="material-icons">cloud_download</i> Baixar IT</a>
    <?php if(!empty($checklist)): ?>
      <button type="button" data-toggle="modal" data-target="#checklist<?php echo $cat['id']; ?>" class="btn btn-default btn-round"><i class="material-icons">done</i> 
      Checklist</button>
    <?php endif; ?>
      <button type="button" class="btn btn-rose btn-round btn-descartafotoit" data-id="<?php echo $cat['id']; ?>"><i class="material-icons">delete</i> Descartar IT</button>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <?php $cequipamentos = getEquipamentos($cat['id'], $ambiente['id']); ?>
        <?php if(!empty($cequipamentos)): ?>
          <?php foreach($cequipamentos as $equip): ?>
            <div class="row" style="margin-bottom: 5px; /* border-bottom: 1px solid #bce8f1; */ padding-bottom: 5px;">
              <div class="col-md-8">
                <?php echo $equip['equipamento']; ?>: <?php echo $equip['qtd']; ?> no projeto, <input type="number" name="qtd" length="3"> existentes
              </div>
            </div>
          <?php endforeach; ?>
          <hr>
        <?php endif; ?>
      </div>
      <div class="col-md-6" style="border-right: 1px dotted #ccc; ">
        <div class="row">
          <div class="col-md-12 pull-left">
            <select class="assuntoselect dataselect form-control select-<?php echo $cat['id'] ?>" placeholder="Selecione o assunto" data-cat="<?php echo $cat['id'] ?>">
              <option></option>
              <?php foreach($cat['assuntos'] as $assunto): if ($assunto['dest'] != 'S') continue; ?>
                <option value="<?php echo $assunto['id']; ?>"><?php echo $assunto['assunto'] ?></option>
              <?php endforeach; ?>
              <?php foreach($cat['assuntos'] as $assunto): if ($assunto['dest'] == 'S') continue; ?>
                <option value="<?php echo $assunto['id']; ?>"><?php echo $assunto['assunto'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="row" style="min-height: 100px;">
          <?php foreach($cat['assuntos'] as $assunto): ?>
            <div id="panel-<?php echo $assunto['id']; ?>" class="panel-collapse collapse panel-fotos col-md-12">
              <div class="panel-body">
                <div class="row">
                  <?php foreach($fotos as $foto):
                    if ($foto['id_categoria'] != $cat['id'] || $foto['id_assunto'] != $assunto['id'])
                      continue;
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="fileinput text-center fileinput-exists" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                          <img src="images/add_foto.png" alt="...">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail">
                          <img src="images/view_foto.png" class="unloaded" data-src="<?php echo $foto['arquivo']; ?>">
                        </div>
                        <div>
                          <span class="btn btn-info btn-round btn-file btn-sm">
                            <span class="fileinput-new"><i class="material-icons">add_a_photo</i></span>
                            <span class="fileinput-exists"><i class="material-icons">add_a_photo</i></span>
                            <input type="file" accept="image/*" name="categoria[<?php echo $cat['id'] ?>][assuntos][<?php echo $assunto['id']; ?>][foto][]">
                          </span>
                          <a href="#" class="btn btn-rose btn-round btn-sm fileinput-exists btn-remove" data-id="<?php echo $foto['id']; ?>"><i class="material-icons">close</i></i></a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>

                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                      <div class="fileinput-new thumbnail">
                        <img src="images/add_foto.png" alt="...">
                      </div>
                      <div class="fileinput-preview fileinput-exists thumbnail"></div>
                      <div>
                        <span class="btn btn-info btn-round btn-file btn-sm">
                          <span class="fileinput-new"><i class="material-icons">add_a_photo</i></span>
                          <span class="fileinput-exists"><i class="material-icons">add_a_photo</i></span>
                          <input type="file" accept="image/*" name="categoria[<?php echo $cat['id'] ?>][assuntos][<?php echo $assunto['id']; ?>][foto][]">
                        </span>
                        <a href="#" class="btn btn-rose btn-round btn-sm fileinput-exists btn-remove" data-dismiss="fileinput"><i class="material-icons">close</i></i></a>
                      </div>
                    </div>
                  </div>

                </div>
                
              </div>
            </div>        
          <?php endforeach; ?>
        </div>
        <div class="row">
          <div class="col-md-12 row-demandas">
            <h4>Demandas salvas:</h4>
            <table class="table table-striped table-demandas">
              <tr>
                <th>Id</th>
                <th>Assuntos</th>
                <th>Produtos</th>
                <th>Mão de obra</th>
              </tr>
            <?php 
              foreach($cat['assuntos'] as $assunto):
                $demanda = getDemanda($cat['id'], $ambiente['id'], $assunto['id']);
                $numero  = explode(" - ", $assunto['assunto']);
                $numero  = current($numero);
                if (!empty($demanda)): ?>
                  <tr class="demanda-<?php echo $assunto['id'] ?>">
                    <td><?php echo $assunto['id'] ?></td>
                    <td><a href="#" class="show-demanda demanda-<?php echo $assunto['id'] ?>" data-id="<?php echo $assunto['id'] ?>">
                      <?php echo $numero ?>
                    </a></td>
                    <td><?php echo $demanda['qtd_produto'] ?></td>
                    <td><?php echo $demanda['qtd_maoobra'] ?></td>
                  </tr>
                  <?php /*echo "<a href='#' class='show-demanda demanda-".$assunto['id']."' data-id='".$assunto['id']."'>".$assunto['assunto']."</a><br>";*/ ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <?php include "produtos.php" ?>
      </div>
    </div>
  </div>
</div>      

<!-- Modal -->
<div class="modal fade" id="checklist<?php echo $cat['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="financeiroLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="financeiroLabel">Checklist: <?php echo $cat['it']; ?></h4>
      </div>
      <div class="modal-body">
        <fieldset>
          <ul>
            <?php foreach($checklist as $check): ?>
              <li><?php echo $check['checklist']; ?></li>
            <?php endforeach; ?>
          </ul>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>  
<?php endforeach; ?>