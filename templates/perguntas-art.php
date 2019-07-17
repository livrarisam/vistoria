  <form class="form-servicos" id="form-infoart">

    <fieldset>

      <div class="form-group group-art">
        <div class="col-md-12">
          <?php 
          $arts = getArts(); 

          foreach($arts as $art): ?>
            <div class="checkbox">
              <label for="art-<?php echo $art['id'] ?>">
                <input type="checkbox" name="art[<?php echo $art['id'] ?>]" id="art-<?php echo $art['id'] ?>" 
                <?php echo (in_array($art['id'], $ids_art)) ? 'checked' : ''; ?> class="art-check">
                <?php echo $art['nome']; ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>      

    </fieldset>
  </form>