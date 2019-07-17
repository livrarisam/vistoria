<strong style="font-weight: bold;">Adicionar adequação:</strong>

<?php if(!empty($catprodutos) && $cat['id'] != 10): ?>
  <div class="form-group">
    <select class="form-control select-produtos" 
      data-cat = "<?php echo $cat['id'] ?>" 
      data-amb = "<?php echo $ambiente['id_ambiente'] ?>" 
      data-assunto = "<?php echo $assunto['id'] ?>" 
      style="margin-bottom: 15px; width: 90%;">

      <option value="">Clique aqui para adicionar um equipamento</option>
      <?php foreach($catprodutos as $item): ?>
        <option value="<?php echo $item['id']; ?>">
          <?php echo $item['produto']; ?> - <?php echo $item['classe']; ?> - <?php echo $item['material']; ?> - <?php echo $item['dimensao']; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
<?php endif; ?>

<?php if(!empty($catservicos)): ?>
  <div class="form-group">
    <select class="form-control select-servicos" 
      data-cat = "<?php echo $cat['id'] ?>" 
      data-amb = "<?php echo $ambiente['id_ambiente'] ?>" 
      data-assunto = "<?php echo $assunto['id'] ?>" 
      style="margin-bottom: 15px; width: 90%;">

      <option value="">Clique aqui para adicionar um serviço</option>
      <?php foreach($catservicos as $item): ?>
        <option value="<?php echo $item['id_servico']; ?>"><?php echo $item['nome']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
<?php endif; ?>


<?php if($cat['id'] != 10): ?>
  <div class="form-group">
    <select class="form-control select-maodeobra" 
      data-cat = "<?php echo $cat['id'] ?>" 
      data-amb = "<?php echo $ambiente['id_ambiente'] ?>" 
      data-assunto = "<?php echo $assunto['id'] ?>" 
      style="margin-bottom: 15px; width: 90%;">

      <option value="">Clique aqui para adicionar mão de obra</option>
      <option value="Eletricista - Geral">Eletricista - Geral</option>
      <option value="Eletricista - Para-raios">Eletricista - Para-raios</option>
      <option value="Encanador">Encanador</option>
      <option value="Ajudante geral">Ajudante geral</option>
      <option value="Construtor (alvenaria)">Construtor (alvenaria)</option>
    </select>
  </div>
<?php endif; ?>