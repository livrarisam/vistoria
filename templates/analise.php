<form method="post" id="form-analise" class="form-inline">
<input type="hidden" name="id_vistoria" value="<?php echo $id_vistoria; ?>">
<input type="hidden" name="revisao" value="<?php echo ++$revisao; ?>">
<?php $n = 1; ?>
<?php $mobras = array(); ?>
<?php foreach($categorias as $cat):
  $nroit  = explode(' - ', $cat['it']);
  $nroit  = current($nroit);
  $itfile = "/vistoria/files/$nroit.pdf"; 

  $catprodutos = getProdutos($cat['id']);
  $catservicos = getServicosCategoria($cat['id']); 
  $projeto     = getDocumentos($id_vistoria, 'Último projeto aprovado no corpo de bombeiros');
?>

<div class="panel panel-info">
  <div class="panel-heading">
    <strong><?php echo $cat['it']; ?></strong>
    <a href="<?php echo $itfile; ?>" target="_blank" class="btn btn-default btn-round"><i class="material-icons">cloud_download</i> Baixar IT</a>
    <button class="btn btn-default btn-round btn-unificar" data-cat="<?php echo $cat['id']; ?>" data-vistoria="<?php echo $id_vistoria; ?>"><i class="material-icons">swap_horiz</i> Unificar Demandas</button>
    <?php if(!empty($projeto)): ?>
      <div class="pull-right">
        <a href="<?php echo $uploads_url . "/" . $projeto['arquivo'] ?>" class="btn btn-rose btn-round" target="_blank"><i class="material-icons">visibility</i> Visualizar projeto aprovado</a>
      </div>    
    <?php endif; ?>
  </div>
  <div class="panel-body">
    <?php foreach ($ambientes as $ambiente): ?>
      <?php if($ambiente['id_categoria'] != $cat['id']) continue; ?>
      <div class="row">
        <div class="col-md-12">
          <?php if($ambiente['nome'] != "generico"): ?>
            <h3><?php echo "Demandas em: " . $ambiente['nome']; ?></h3>
          <?php else: ?>
            <h3>Demandas genéricas</h3>
          <?php endif; ?>
        </div>
      </div>
      <?php foreach ($assuntos as $assunto): ?>
      <?php if($assunto['id_categoria'] != $cat['id'] || $assunto['id_ambiente'] != $ambiente['id_ambiente']) continue; ?>
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <?php 
              $demanda = explode(" - ", $assunto['assunto'], 2);
              $demanda = (!empty($demanda[1])) ? $demanda[1] : $demanda[0];
            ?>
            <input type="hidden" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][nome]" value="<?php echo $assunto['assunto']; ?>"/>

            <h5><?php if($ambiente['nome'] != "generico"): ?><input type="checkbox" class="demanda-<?php echo $cat['id']; ?>" data-assunto="<?php echo $assunto['id']; ?>" /><?php endif; echo $n .". " . $demanda; ?></h5>
          
          <?php foreach ($fotos as $foto): ?>
          <?php if($foto['id_categoria'] != $cat['id'] || $foto['id_ambiente'] != $ambiente['id_ambiente'] || $foto['id_assunto'] != $assunto['id']) continue; ?>
            <div class="col-md-6" style="float: left; margin-bottom: 10px;">
              <div class="fileinput-preview fileinput-exists thumbnail">
                <input type="hidden" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][foto][<?php echo $foto['id_arquivo'] ?>]" value="<?php echo $foto['arquivo']; ?>"/>
                <img src="<?php echo $foto['arquivo']; ?>" style="width: 290px; height: 190px;">
              </div>
            </div>
          <?php endforeach; ?>
            <div class="col-md-6" style="float: left; margin-bottom: 10px;">
              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="max-width: 500px;">
                  <img src="images/add_foto.png" alt="...">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                <div>
                  <span class="btn btn-info btn-round btn-file btn-sm">
                    <span class="fileinput-new"><i class="material-icons">add_a_photo</i></span>
                    <span class="fileinput-exists"><i class="material-icons">add_a_photo</i></span>
                    <input type="file" accept="image/*" name="fotoanalise" data-amb="<?php echo $ambiente['id_ambiente']; ?>" data-cat="<?php echo $cat['id'] ?>" data-assunto="<?php echo $assunto['id']; ?>">
                  </span>
                  <a href="#" class="btn btn-rose btn-round btn-sm fileinput-exists" data-dismiss="fileinput"><i class="material-icons">close</i></a>
                  <a href="#" class="btn btn-success btn-round btn-sm fileinput-exists add-analise"><i class="material-icons">save</i> salvar</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <strong style="font-weight: bold;">Observação:</strong><br>
            <?php $obs = $db->select("vistoria_ambiente_obs", array("id_ambiente" => $ambiente['id_ambiente'], "id_assunto" => $assunto['id']))->all();
            foreach ($obs as $ob): ?>
              <input type="hidden" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][obs][<?php echo $ob['id'] ?>]" value="<?php echo $ob['observacao']; ?>"/>
              <p><?php echo $ob['observacao']; ?></p>
            <?php endforeach; ?>

            <strong style="font-weight: bold;">Áudios:</strong>
            <ul id="recordingslist" style="margin-top: 10px;">
            <?php foreach ($audios as $audio): ?>
            <?php if($audio['id_categoria'] != $cat['id'] || $audio['id_ambiente'] != $ambiente['id_ambiente'] || $audio['id_assunto'] != $assunto['id']) continue; ?>
              <li>
                <input type="hidden" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][audio][<?php echo $audio['id_arquivo'] ?>]" value="<?php echo $audio['arquivo']; ?>"/>
                <audio controls="" src="<?php echo $audio['arquivo']; ?>"></audio>
              </li>
            <?php endforeach; ?>
            </ul>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-12 lista-equips" style="margin-top: 18px;">
            <strong style="font-weight: bold;">Adequações sugeridas pelo vistoriador:</strong>
            <?php foreach ($produtos as $produto): ?>
            <?php if($produto['id_categoria'] != $cat['id'] || $produto['id_ambiente'] != $ambiente['id_ambiente'] || $produto['id_assunto'] != $assunto['id']) continue; ?>
              <div class="form-group">
                <button type="button" class="btn btn-rose btn-round btn-link remove-lista" data-original-title="" title="">
                  <i class="material-icons">close</i>
                </button>
                <div><?php echo $produto['produto']; ?>:</div>
                <div class="col-md-2">
                  <input type="number" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][produto][<?php echo $produto['id']; ?>]" class="form-control input-sm" value="<?php echo $produto['qtd']; ?>" required>
                </div>
              </div>
            <?php endforeach; ?>
            <?php foreach ($servicos as $servico): ?>
            <?php if($servico['id_categoria'] != $cat['id'] || $servico['id_ambiente'] != $ambiente['id_ambiente'] || $servico['id_assunto'] != $assunto['id']) continue; ?>
              <div class="form-group">
                <button type="button" class="btn btn-rose btn-round btn-link remove-lista" data-original-title="" title="">
                  <i class="material-icons">close</i>
                </button>
                Serviço: <?php echo $servico['servico']; ?>
                <input type="hidden" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][servico][<?php echo $servico['id_servico']; ?>]" class="form-control input-sm" value="<?php echo $produto['qtd']; ?>" required>
              </div>
            <?php endforeach; ?>
            <?php foreach ($maodeobras as $maodeobra): ?>
            <?php if($maodeobra['id_categoria'] != $cat['id'] || $maodeobra['id_ambiente'] != $ambiente['id_ambiente'] || $maodeobra['id_assunto'] != $assunto['id']) continue; ?>
              <div class="form-group">
                <button type="button" class="btn btn-rose btn-round btn-link remove-lista" data-original-title="" title="">
                  <i class="material-icons">close</i>
                </button>
                <?php 
                  if(empty($mobras[$maodeobra['maodeobra']]))
                    $mobras[$maodeobra['maodeobra']]  = (int)$maodeobra['qtd'];
                  else
                    $mobras[$maodeobra['maodeobra']] += (int)$maodeobra['qtd'];
                ?>
                <div><?php echo $maodeobra['maodeobra']; ?>:</div>
                <div class="col-md-6">
                  <input type="number" name="demanda[<?php echo $cat['id']; ?>][<?php echo $ambiente['id_ambiente']; ?>][<?php echo $assunto['id']; ?>][maodeobra][<?php echo $maodeobra['maodeobra']; ?>]" class="form-control input-sm" value="<?php echo $maodeobra['qtd']; ?>" required> Períodos
                </div>
              </div>
            <?php endforeach; ?>         
          </div>
          <div class="col-md-6 col-sm-12" style="margin-top: 18px;">
            <?php include "produtos-analise.php" ?>
          </div>
        </div>
        <hr/>
        <?php $n++; ?> 
      <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
</div> 
<?php endforeach; ?>

<div class="panel panel-primary">
  <div class="panel-heading"><strong>Mão de obra total</strong></div>
  <div class="panel-body">
    <ul>
      <?php foreach($mobras as $m => $qtd): ?>
        <li><?php echo $m; ?> <input type="number" name="mobra[<?php echo $m; ?>]" class="form-control input-mobra" placeholder="períodos" required> <strong>(<?php echo $qtd ?> períodos na vistoria)</strong></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<div class="row" style="width: 100%;">
  <div class="col-md-12">
    <button type="button" class="btn btn-success btn-round pull-right btn-sendrelatorio"><i class="material-icons">done</i> Enviar relatório</button>
    <button type="button" class="btn btn-info btn-round pull-right btn-revisao" data-vistoria="<?php echo $id_vistoria; ?>"><i class="material-icons">save</i> Finalizar revisão</button>
  </div>
</div>
</form>