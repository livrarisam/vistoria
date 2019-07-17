
<?php if(!empty($cat['produtos']) && $cat['id'] != 10): ?>
  <select class="form-control select-produtos dataselect" data-cat="<?php echo $cat['id'] ?>" style="margin-bottom: 15px;">
    <option value="">Clique aqui para adicionar um equipamento</option>
    <?php foreach($cat['produtos'] as $item): ?>
      <option value="<?php echo $item['id']; ?>">
        <?php echo $item['produto']; ?> - <?php echo $item['classe']; ?> - <?php echo $item['material']; ?> - <?php echo $item['dimensao']; ?>
      </option>
    <?php endforeach; ?>
  </select>
<?php endif; ?>

<?php if(!empty($cat['eletricos']) && $cat['id'] != 10): ?>
  <select class="form-control select-produtos dataselect" data-cat="<?php echo $cat['id'] ?>" style="margin-bottom: 15px;">
    <option value="">Clique aqui para adicionar um equipamento elétrico</option>
    <?php foreach($cat['eletricos'] as $item): ?>
      <option value="<?php echo $item['id']; ?>">
        <?php echo $item['produto']; ?> - <?php echo $item['classe']; ?> - <?php echo $item['material']; ?> - <?php echo $item['dimensao']; ?>
      </option>
    <?php endforeach; ?>
  </select>
<?php endif; ?>

<table class="table-produtos">
  <tbody></tbody>
</table>

<?php if(!empty($cat['servicos'])): ?>
  <select class="form-control select-servicos dataselect" data-cat="<?php echo $cat['id'] ?>" style="margin-bottom: 15px;">
    <option value="">Clique aqui para adicionar um serviço</option>
    <?php foreach($cat['servicos'] as $item): ?>
      <option value="<?php echo $item['id_servico']; ?>"><?php echo $item['nome']; ?></option>
    <?php endforeach; ?>
  </select>
  <table class="table-servicos">
    <tbody></tbody>
  </table>
<?php endif; ?>


<?php if($cat['id'] != 10): ?>
<select class="form-control select-maodeobra dataselect" data-cat="<?php echo $cat['id'] ?>" style="margin-bottom: 15px;">
  <option value="">Clique aqui para adicionar mão de obra</option>
  <option value="Eletricista - Geral">Eletricista - Geral</option>
  <option value="Eletricista - Para-raios">Eletricista - Para-raios</option>
  <option value="Encanador">Encanador</option>
  <option value="Ajudante geral">Ajudante geral</option>
  <option value="Construtor (alvenaria)">Construtor (alvenaria)</option>
</select>
<table class="table-maodeobra">
  <tbody></tbody>
</table>
<?php endif; ?>

<div class="row">
  <label class="col-md-12 col-form-label" for="observacoes">Observações:</label>
  <div class="col-md-12">
    <div class="form-group has-info bmd-form-group" style="margin: 0;">
      <textarea name="categoria[<?php echo $cat['id'] ?>][obscompras]" class="form-control borders obscompras" autocomplete="false"></textarea>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <ul id="recordingslist"></ul>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="has-info bmd-form-group">
      <button type="button" onclick="startRecording(this);" class="btn btn-info btn-round record-audio"><i class='material-icons'>mic</i> Gravar</button>
      <button type="button" onclick="stopRecording(this);" class="btn btn-success btn-round save-audio" data-cat="<?php echo $cat['id'] ?>" data-amb="<?php echo $ambiente['id'] ?>"><i class='material-icons'>mic</i> Concluir</button>
      <button type="button" onclick="cancelRecording(this);" class="btn btn-rose btn-round cancel-audio"><i class='material-icons'>mic_off</i> Cancelar</button>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="has-info bmd-form-group">
      <button type="button" class="btn btn-default btn-round save-demanda" disabled>Salvar demanda</button>
      <button type="button" class="btn btn-warning btn-round cancel-demanda" style="display: none;">Cancelar demanda</button>
    </div>
  </div>
</div>