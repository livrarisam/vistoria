  <form class="form-servicos" id="form-perguntas">

    <input type="hidden" id="id_agenda" name="id_agenda" value="<?php echo $id_vistoria ?>">
    <input type="hidden" id="concluir" name="concluir" value="0">

    <div class="row">
      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="numero_avcb">Número do projeto anterior:</label>  
        <div class="col-md-12">
          <input id="numero_avcb" name="numero_avcb" value="<?php echo @$info['numero_avcb']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
          <span class="help-block">Caso cliente não tenha, verificar o número do AVCB, via EDT no site do corpo de bombeiros ou na lista.</span>
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="iptu">Nº do IPTU:</label>  
        <div class="col-md-12">
          <input id="iptu" name="iptu" value="<?php echo @$info['iptu']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="area_construida">Área construída existente (m²)</label>  
        <div class="col-md-12">
          <input id="area_construida" name="area_construida" value="<?php echo @$info['area_construida']; ?>" type="number" step="0.01" autocomplete="off" placeholder="" class="form-control input-md">
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="area_construir">Área a construir (m²)</label>  
        <div class="col-md-12">
          <input id="area_construir" name="area_construir" value="<?php echo @$info['area_construir']; ?>" type="number" step="0.01" autocomplete="off" placeholder="" class="form-control input-md">
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="altura">Altura (m)</label>  
        <div class="col-md-12">
          <select id="altura" name="altura" class="form-control input-sm">
            <option></option>
            <option <?php echo (!empty($info['altura']) && $info['altura'] == "I") ? "selected" : "" ?> value="I">Edificação Térrea - Um pavimento</option>
            <option <?php echo (!empty($info['altura']) && $info['altura'] == "II") ? "selected" : "" ?> value="II">Edificação Baixa - Menor que 6m</option>
            <option <?php echo (!empty($info['altura']) && $info['altura'] == "III") ? "selected" : "" ?> value="III">Edificação Baixa-média altura - Entre 6m e 12m</option>
            <option <?php echo (!empty($info['altura']) && $info['altura'] == "IV") ? "selected" : "" ?> value="IV">Edificação de Média altura - Entre 12m e 23m</option>
            <option <?php echo (!empty($info['altura']) && $info['altura'] == "V") ? "selected" : "" ?> value="V">Edificação Mediamente alta - Entre 23m e 30m</option>
            <option <?php echo (!empty($info['altura']) && $info['altura'] == "VI") ? "selected" : "" ?> value="VI">Edificação alta - Acima de 30m</option>            
          </select>          
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="pavimentos">Número de pavimentos</label>  
        <div class="col-md-12">
          <input id="pavimentos" name="pavimentos" value="<?php echo @$info['pavimentos']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="ocupacao_subsolo">Ocupação do subsolo</label>  
        <div class="col-md-12">
          <input id="ocupacao_subsolo" name="ocupacao_subsolo" value="<?php echo @$info['ocupacao_subsolo']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
        </div>
      </div>

      <?php $atividades = getAtividades(); ?>
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="uso_descricao">Uso, divisão e descrição</label>  
        <div class="col-md-12">
          <select id="tipo_atividade" name="uso_descricao" class="form-control input-sm">
            <option></option>
            <?php foreach($atividades as $atividade): ?>
              <option value="<?php echo $atividade['divisao'] ?>" <?php echo (!empty($info['uso_descricao']) && $info['uso_descricao'] == $atividade['divisao']) ? "selected" : ""; ?>>
                <?php echo $atividade['divisao'] ?> - <?php echo $atividade['descricao'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="help-block">
            (Verificar tabela 1 do decreto estadual 56819/11 + anexo A da Instrução Técnica 14/11 + CNAE do cartão CNPJ)
          </span>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="risco">Risco (MJ/m²)</label>  
        <div class="col-md-12">
          <select id="risco" name="risco" class="form-control input-sm">
            <option></option>
            <option <?php echo (!empty($info['risco']) && $info['risco'] == 'Baixo (até 300 MJ/m²)') ? "selected" : ""; ?> >Baixo (até 300 MJ/m²)</option>
            <option <?php echo (!empty($info['risco']) && $info['risco'] == 'Médio (300 a 1200 MJ/m²)') ? "selected" : ""; ?> >Médio (300 a 1200 MJ/m²)</option>
            <option <?php echo (!empty($info['risco']) && $info['risco'] == 'Alto (acima de 1200 MJ/m²)') ? "selected" : ""; ?> >Alto (acima de 1200 MJ/m²)</option>
          </select>
        </div>
      </div>
      <!-- Text input-->
      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="existente">Aplica-se a IT 43? (edificação existente)</label>  
        <div class="col-md-12">
          <select id="existente" name="existente" class="form-control input-sm">
            <option></option>
            <option <?php echo (!empty($info['existente']) && $info['existente'] == 'Sim') ? "selected" : ""; ?> >Sim</option>
            <option <?php echo (!empty($info['existente']) && $info['existente'] == 'Não') ? "selected" : ""; ?> >Não</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="form-group has-info col-md-6">
        <label class="col-md-12 control-label bmd-label-static" for="proprietario">Proprietário do Imóvel</label>  
        <div class="col-md-12">
          <input id="proprietario" name="proprietario" value="<?php echo @$info['proprietario']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
        </div>
      </div>
    </div>
    <fieldset>
      <legend>Dados do contato técnico</legend>
      <div class="row">
        <!-- Text input-->
        <div class="form-group has-info col-md-4">
          <label class="col-md-12 control-label bmd-label-static" for="nome_contato">Nome</label>  
          <div class="col-md-12">
            <input id="nome_contato" name="nome_contato" value="<?php echo @$info['nome_contato']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group has-info col-md-4">
          <label class="col-md-12 control-label bmd-label-static" for="telefone_contato">Telefone</label>  
          <div class="col-md-12">
            <input id="telefone_contato" name="telefone_contato" value="<?php echo @$info['telefone_contato']; ?>" type="text" autocomplete="off" placeholder="" class="form-control input-md">
          </div>
        </div>
        <!-- Text input-->

        <div class="form-group has-info col-md-4">
          <label class="col-md-12 control-label bmd-label-static" for="email_contato">E-mail</label>  
          <div class="col-md-12">
            <input id="email_contato" name="email_contato" value="<?php echo @$info['email_contato']; ?>" type="email" autocomplete="off" placeholder="" class="form-control input-md">
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <button type="button" class="btn btn-info btn-round pull-right btn-salvaform"><i class="material-icons">done</i> Salvar</button>
      </div>

    </fieldset>

  </form>