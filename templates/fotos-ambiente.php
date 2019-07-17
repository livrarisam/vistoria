<div class="row">

  <div class="col-md-12">
    <div class="card ">
      <div class="card-header card-header-info card-header-text">
        <div class="card-text">
          <h4 class="card-title title-ambiente">Detalhes do ambiente</h4>
        </div>
      </div>
      <div class="card-body ">
        <form method="post" id="form-nomeambiente" class="form-horizontal">
          <div class="row">
            <label class="col-sm-12 col-form-label" for="nome">Nome</label>
            <div class="col-sm-12">
              <div class="form-group has-info bmd-form-group">
                <input type="hidden" name="id_ambiente" value="<?php echo $ambiente['id'] ?>">
                <input type="text" name="nome" class="form-control" value="<?php echo $ambiente['nome']; ?>" required autocomplete="false">
                <span class="bmd-help">Nome do ambiente, ex: Recepção, Corredor, Escada...</span>
                <button type="button" class="btn btn-info btn-round btn-sm btn-rowits"><i class="material-icons">edit</i> Inserir ITs</button>
              </div>
            </div>
          </div>
          <div class="row row-its" style="display: none;">
            <div class="col-md-12">
              <?php 
              $its = getCategorias(); 

              foreach($its as $it): 
                if (in_array($it['id'], $ids_cat)) continue; ?>
                <div class="checkbox">
                  <label for="<?php echo $it['id'] ?>">
                    <input type="checkbox" name="its[<?php echo $it['id'] ?>]">
                    <?php echo $it['it']; ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>            
          </div>
          <div class="row">
            <div class="col-md-12">
              <button class="btn btn-info btn-round pull-right"><i class="material-icons">done</i> Salvar</button>
            </div>
          </div>
        </form>
      </div>            
    </div>
  </div>

  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-info card-header-text">
        <div class="card-text">
          <h4 class="card-title title-ambiente">Adequações / Quantitativo</h4>
        </div>
        <div class="pull-right">
          <a href="/vistoria/not_found" class="btn btn-info btn-round" target="_blank"><i class="material-icons">visibility</i> Visualizar projeto aprovado</a>
        </div>
      </div>
      <div class="card-body">
        <form method="post" id="form-assuntos" enctype="multipart/form-data">
          <input type="hidden" id="id_ambiente" name="id_ambiente" value="<?php echo $ambiente['id'] ?>">
          <div class="row">
            <div class="col-md-12">
              <?php include "adequacoes.php" ?>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="descartarfotosIt" tabindex="-1" role="dialog" aria-labelledby="financeiroLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form-descartait" data-check="0" method="post" class="form-vertical">
        <div class="modal-header">
          <h4 class="modal-title" id="financeiroLabel">Tem certeza que deseja descartar a IT para o ambiente?</h4>
        </div>
        <div class="modal-body">
          <fieldset>
          <input type="hidden" name="id_categoria" id="descarta_categoria">
          <input type="hidden" name="id_ambiente" value="<?php echo $ambiente['id'] ?>">
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