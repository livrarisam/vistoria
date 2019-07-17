<fieldset>
  <?php if(empty($ambiente)): ?>
    <legend>Novo ambiente</legend>
  <?php else: ?>
    <legend>Editar ambiente</legend>
    <input type="hidden" name="id_ambiente" value="<?php echo $ambiente['id']; ?>">
  <?php endif; ?>  
  <div class="row">
    <div class="col-md-12">

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="nome_ambiente">Nome</label>  
      <div class="col-md-12">
        <input type="text" name="nome_ambiente" id="nome_ambiente" class="form-control input-sm" value="<?php echo @$ambiente['nome']; ?>" />
      </div>
    </div>

    <!-- Select input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="nome_ambiente">Pavimento</label>
      <div class="col-md-12">
        <select name="pavimento" class="select-pavimentos form-control">
          <option></option>
        </select>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <div class="col-md-12">
        <label for="ambiente_it_decreto">
          <input type="checkbox" name="ambiente_it_decreto" id="ambiente_it_decreto"> Ambiente com decreto divergente?
        </label>
      </div>
    </div>

    <!-- Text input-->
    <div id="ambiente-decreto" style="display: none;">
      <label class="col-md-4 control-label" for="nome_ambiente">Decreto</label>  
      <div class="col-md-12">
        <select name="decreto" class="form-control dataselect">
          <option value=""></option>
          <option>63.911/18</option>
          <option>56.819/11</option>
          <option>46.076/01</option>
          <option>38.069/93</option>
        </select>
      </div>
    </div>

</fieldset>
<fieldset>
  <legend>Assuntos pertinentes ao ambiente</legend>
  <div class="form-group">
    <?php foreach($categorias as $cat): 
      if (!in_array($cat['id'], $ids_cat)) continue; 
        if (empty($id_ambiente)) {
          $equipamentos = getEquipamentos($cat['id']); 
        } else {
          $equipamentos = getEquipamentos($cat['id'], $id_ambiente);
          if (empty($equipamentos)) {
            $equipamentos = getEquipamentos($cat['id']); 
          }
        } ?>
      
      <div class="col-md-6 pull-left"> 
      <div class="panel panel-info pancat-<?php echo $cat['id']; ?>">
      <div class="panel-heading">
        <input type="hidden" name="categoria[<?php echo $cat['id']; ?>]" value="1">              
        <strong><?php echo $cat['it']; ?></strong>
        <?php if($cat['id'] != '10'): ?>
          <button type="button" class="btn btn-default btn-sm btn-descartait" data-id="<?php echo $cat['id']; ?>" data-amb="<?php echo empty($ambiente['id']) ? "novo" : $ambiente['id']; ?>">Descartar IT</button>
        <?php endif; ?>
      </div>
      <div class="panel-body">
        <?php foreach($equipamentos as $equip): ?>
          <div class="row" style="margin-bottom: 5px; /* border-bottom: 1px solid #bce8f1; */ padding-bottom: 5px;">
            <div class="col-md-8">
              <?php echo $equip['equipamento']; ?>
            </div>
            <div class="col-md-4">
              <input type="number" name="equipamento[<?php echo $cat['id']; ?>][<?php echo $equip['id']; ?>]" placeholder="Qtd" value="<?php echo @$equip['qtd']; ?>">
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    </div>
    <?php endforeach; ?>
  </div>
</fieldset>
<fieldset>
  <div class="row">
    <div class="col-md-12">
      <button class="btn btn-info pull-right" style="margin-right: 15px;"><i class="material-icons">save</i> Salvar ambiente</button>
    </div>
  </div>

</fieldset>
