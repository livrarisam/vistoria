  <form class="form-servicos" id="form-infoassuntos">

    <fieldset>
      <div class="form-group">
        <label class="col-md-12 control-label bmd-label-static" for="numero_avcb">Decreto:</label>  
        <div class="col-md-12">
          <select name="decreto" class="form-control dataselect select-decreto">
            <option value="">Selecione o decreto</option>
            <option <?php echo @$info['decreto'] == "63.911/18" ? "selected" : ""; ?> >63.911/18</option>
            <option <?php echo @$info['decreto'] == "56.819/11" ? "selected" : ""; ?> >56.819/11</option>
            <option <?php echo @$info['decreto'] == "46.076/01" ? "selected" : ""; ?> >46.076/01</option>
            <option <?php echo @$info['decreto'] == "38.069/93" ? "selected" : ""; ?> >38.069/93</option>
          </select>
        </div>
      </div>

      <div class="form-group group-categorias" <?php echo empty($info['decreto']) ? 'style="display: none;"' : ''; ?> >
        <div class="col-md-12">
          <?php 
          $categorias = getCategorias(); 

          foreach($categorias as $categoria): ?>
            <div class="checkbox">
              <label for="<?php echo $categoria['id'] ?>">
                <input type="checkbox" name="categoria[<?php echo $categoria['id'] ?>]" id="<?php echo $categoria['id'] ?>" 
                <?php echo (in_array($categoria['id'], $ids_cat) || $categoria['id'] == '10') ? 'checked' : ''; ?>
                class="it-check">
                <?php echo $categoria['it']; ?>
                <?php if($categoria['id'] != '10'): ?>
                  <div class="it-decreto pull-right" <?php echo (empty($info['decreto']) || empty($decretos[$categoria['id']]) || $decretos[$categoria['id']] == $info['decreto']) ? 'style="display: none;"' : ''; ?>>
                    <div class="col-md-12">
                      <label class="checkbox-inline" for="checkboxes-<?php echo $categoria['id']; ?>">
                        <input type="checkbox" id="checkboxes-<?php echo $categoria['id']; ?>" class="decreto-check"
                         <?php echo (!empty($info['decreto']) && !empty($decretos[$categoria['id']]) && $decretos[$categoria['id']] != $info['decreto']) ? 'checked' : ''; ?>>
                        IT com decreto divergente?
                        <select name="categoria[decreto][<?php echo $categoria['id']; ?>]" class="select-decretoit" <?php echo (empty($decretos[$categoria['id']]) || $decretos[$categoria['id']] == $info['decreto']) ? 'style="display: none;"' : ''; ?>>
                          <option value="">Selecione o decreto</option>
                          <option <?php echo @$decretos[$categoria['id']] == "63.911/18" ? "selected" : ""; ?> >63.911/18</option>
                          <option <?php echo @$decretos[$categoria['id']] == "56.819/11" ? "selected" : ""; ?> >56.819/11</option>
                          <option <?php echo @$decretos[$categoria['id']] == "46.076/01" ? "selected" : ""; ?> >46.076/01</option>
                          <option <?php echo @$decretos[$categoria['id']] == "38.069/93" ? "selected" : ""; ?> >38.069/93</option>
                        </select>                      
                      </label>
                    </div>
                  </div>
                <?php endif; ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>      

    </fieldset>
  </form>