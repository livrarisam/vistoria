  <form class="form-servicos" id="form-infoambientes">
    <fieldset>

      <div class="table-responsive">
        <table class="table">
          <thead class="text-info">
            <th></th>
            <th style="width: 50%">Ambiente</th>
            <th style="width: 20%">Pavimento</th>
            <th style="width: 20%">Fotos</th>
            <th style="width: 20%">Equipamentos</th>
          </thead>
          <tbody class="info-ambientes">
            <?php foreach($ambientes as $ambiente): ?>
              <tr class="trambi-<?php echo $ambiente['id']; ?>" data-id="<?php echo $ambiente['id']; ?>">
                <td class="td-actions text-right">
                  <button type="button" class="btn btn-rose btn-round btn-link btn-removeamb" data-original-title="" title="">
                    <i class="material-icons">close</i>
                  </button>
                  <button type="button" class="btn btn-info btn-round btn-link btn-duplicate" data-id="<?php echo $ambiente['id']; ?>" data-original-title="" title="">
                    <i class="material-icons">file_copy</i>
                  </button>
                  <td><?php echo $ambiente['nome']; ?></td>
                  <td><?php echo $ambiente['pavimento']; ?></td>
                  <td><?php echo $ambiente['fotos']; ?> fotos</td>
                  <td><?php echo $ambiente['equips']; ?> equipamentos</td>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>               
      </div>


      <div class="row">
        <div class="col-md-12">
          <button type="button" class="btn btn-default pull-right btn-novoambiente" style="margin-right: 15px;"><i class="material-icons">add</i> Novo ambiente</button>
        </div>
      </div>

    </fieldset>
    <div id="edit-ambiente" style="display: none;">
    </div>
  </form>

<!-- Modal -->
<div class="modal fade" id="descartarIt" tabindex="-1" role="dialog" aria-labelledby="financeiroLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form-descartait" data-check="0" method="post" class="form-vertical">
        <div class="modal-header">
          <h4 class="modal-title" id="financeiroLabel">Tem certeza que deseja descartar a IT para o ambiente?</h4>
        </div>
        <div class="modal-body">
          <fieldset>
          <input type="hidden" name="id_categoria" id="descarta_categoria">
          <input type="hidden" name="id_ambiente" id="descarta_ambiente">
        
          <!-- Text input-->
          <div class="form-group">
              <label class="col-md-12 control-label text-left" for="motivo">Insira o motivo:</label>  
              <div class="col-md-12">
                <select name="motivo" class="form-control select-motivo">
                  <option></option>
                  <option>Não há assunto relativos a essa IT nesse ambiente</option>
                  <option>Não há adequações, referentes a essa IT, a serem realizadas nesse ambiente</option>
                  <option>Outros</option>
                </select>
              </div>
          </div>

          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
          <input type="submit" class="btn btn-rose btnconfirma" value="Confirmar"/>
        </div>
      </form>
    </div>
  </div>
</div>  
