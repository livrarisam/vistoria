<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-info card-header-text">
          <div class="card-text">
            <h4 class="card-title title-ambiente">Foto da fachada</h4>
          </div>
        </div>
        <div class="card-body card-fachada">
          <div class="row">
            <div class="col-md-12">
              <div class="fileinput fileinput-<?php echo (!empty($info['foto_fachada'])) ? "exists" : "new"; ?> text-center" data-provides="fileinput">
                <div class="fileinput-new thumbnail">
                  <img src="images/add_foto.png" alt="...">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail">
                  <?php if (!empty($info['foto_fachada'])): ?>
                    <img src="images/view_foto.png" class="unloaded" data-src="<?php echo $uploads_url . $info['foto_fachada']; ?>">
                  <?php endif; ?>
                </div>
                <div>
                  <span class="btn btn-info btn-round btn-file btn-sm">
                    <span class="fileinput-new"><i class="material-icons">add_a_photo</i></span>
                    <span class="fileinput-exists"><i class="material-icons">add_a_photo</i></span>
                    <input type="file" accept="image/*" name="fachada_foto">
                  </span>
                  <a href="#" class="btn btn-rose btn-round btn-sm fileinput-exists" data-dismiss="fileinput"><i class="material-icons">close</i></a>
                </div>
              </div>
            </div>
          </div>
        </div>            
      </div>
    </div>

    <div class="col-md-12">

      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title"><strong>Clique no ambiente para visualizar detalhes e elaborar relatório</strong></h4>
        </div>
        <div class="card-body table-responsive">
          <table class="table">
            <thead class="text-info">
              <th></th>
              <th style="width: 50%">Ambiente</th>
              <th style="width: 25%">Fotos</th>
              <th style="width: 25%">Equipamentos</th>
            </thead>
            <tbody class="lista-ambientes">
              <?php foreach($ambientes as $ambiente): 
                if ($ambiente['nome'] == "Fachada") continue;
                ?>
                <tr data-id="<?php echo $ambiente['id']; ?>">
                  <td class="td-actions text-right">
                    <button type="button" class="btn btn-rose btn-round btn-link" data-original-title="" title="">
                      <i class="material-icons">close</i>
                    </button>
                    <td><a href="#" style="text-decoration: underline;"><?php echo $ambiente['nome']; ?></a></td>
                    <td><?php echo $ambiente['fotos']; ?> fotos</td>
                    <td><?php echo $ambiente['equips']; ?> equipamentos</td>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-info card-header-text">
          <div class="card-text">
            <h4 class="card-title title-ambiente">Novo ambiente</h4>
          </div>
        </div>
        <div class="card-body ">
          <form method="post" id="form-ambientes" class="form-horizontal">
            <div class="row">
              <label class="col-md-2 col-form-label" for="nome">Nome</label>
              <div class="col-md-10">
                <div class="form-group has-info bmd-form-group">
                  <input type="text" name="nome" class="form-control" required autocomplete="false">
                  <span class="bmd-help">Nome do ambiente, ex: Recepção, Corredor, Escada...</span>
                </div>
              </div>
              <div class="col-md-12">
                <input type="hidden" id="id_vistoria" name="id_vistoria" value="<?php echo $id_vistoria; ?>">
                <button class="btn btn-info btn-round pull-right"><i class="material-icons">done</i></button>
              </div>
            </div>
          </form>
        </div>            
      </div>
    </div>

    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-info card-header-text">
          <div class="card-text">
            <h4 class="card-title title-ambiente">Projeto técnico e documentos</h4>
          </div>
        </div>
        <div class="card-body">
          <?php foreach ($documentos as $documento): ?>
            <div class="row">
              <div class="col-md-12">
                <?php if (is_file($uploads_path . "/producao/" . $documento['arquivo'])): ?>
                  <a href="<?php echo $uploads_url . "/producao/" . $documento['arquivo']; ?>" target="_blank" class="btn btn-default btn-round"><i class="material-icons">cloud_download</i> <?php echo (!empty($documento['titulo'])) ? $documento['titulo'] : $documento['documento']; ?></a>
                <?php else: ?>
                  <a href="<?php echo $uploads_path . '/' . $documento['arquivo']; ?>" target="_blank" class="btn btn-default btn-round"><i class="material-icons">cloud_download</i> <?php echo (!empty($documento['titulo'])) ? $documento['titulo'] : $documento['documento']; ?></a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>            
      </div>
    </div>

    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-info card-header-text">
          <div class="card-text">
            <h4 class="card-title title-ambiente">Detalhes construtivos / Tipo da edificaçao / Detalhes executivos</h4>
          </div>
        </div>
        <div class="card-body card-gerais">
          <div class="row">
            <?php foreach($fotos_vistoria as $foto): ?>
            <form method="post" action="/vistoria/" class="form-horizontal form-gerais">
              <div class="col-md-12 text-center">
                <div class="fileinput fileinput-exists text-center" data-provides="fileinput">
                  <div class="fileinput-new thumbnail">
                    <img src="images/add_foto.png" alt="...">
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail">
                    <img src="images/view_foto.png" class="unloaded" data-src="<?php echo $foto['arquivo']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="geral_titulo" class="form-control" placeholder="Título da foto" value="<?php echo @$foto['titulo']; ?>">
                </div>
                <div class="form-group" style="margin-top: 0px;">
                  <textarea name="geral_descricao" class="form-control" placeholder="Descrição da foto"><?php echo @$foto['descricao']; ?></textarea>
                </div>
              </div>
            </form>
            <?php endforeach; ?>
            <form method="post" action="/vistoria/" class="form-horizontal form-gerais">
              <div class="col-md-12 text-center">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                  <div class="fileinput-new thumbnail">
                    <img src="images/add_foto.png" alt="...">
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail"></div>
                  <div>
                    <span class="btn btn-info btn-round btn-file btn-sm">
                      <span class="fileinput-new"><i class="material-icons">add_a_photo</i></span>
                      <span class="fileinput-exists"><i class="material-icons">add_a_photo</i></span>
                      <input type="file" accept="image/*" name="foto_geral">
                    </span>
                    <a href="#" class="btn btn-rose btn-round btn-sm fileinput-exists btn-remove" data-dismiss="fileinput"><i class="material-icons">close</i></a>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="geral_titulo" class="form-control" placeholder="Título da foto">
                </div>
                <div class="form-group" style="margin-top: 0px;">
                  <textarea name="geral_descricao" class="form-control" placeholder="Descrição da foto"></textarea>
                </div>
                <div class="form-group" style="margin-top: 0px;">
                  <button class="btn btn-round btn-info"><i class="material-icons">save</i> Salvar</button>
                </div>
              </div>
            </form>
          </div>
        </div>            
      </div>
    </div>    

    <div class="col-md-12">
      <div class="card ">
        <div class="card-header card-header-info card-header-text">
          <div class="card-text">
            <h4 class="card-title title-ambiente">Dados do cliente</h4>
          </div>
        </div>
        <div class="card-body ">
          <form method="get" action="/vistoria/" class="form-horizontal">
            <div class="row row-cliente">

              <label class="col-md-2 col-form-label" for="nome">Foto do cliente</label>
              <div class="col-md-10">
                <div class="text-center fileinput fileinput-<?php echo (!empty($info['foto_fachada'])) ? "exists" : "new"; ?>" data-provides="fileinput">
                  <div class="fileinput-new thumbnail">
                    <img src="images/add_foto.png" alt="...">
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail">
                    <?php if (!empty($info['foto_cliente'])): ?>
                      <img src="images/view_foto.png" class="unloaded" data-src="<?php echo $uploads_url . $info['foto_cliente']; ?>">
                    <?php endif; ?>                    
                  </div>
                  <div>
                    <span class="btn btn-info btn-round btn-file btn-sm">
                      <span class="fileinput-new"><i class="material-icons">add_a_photo</i></span>
                      <span class="fileinput-exists"><i class="material-icons">add_a_photo</i></span>
                      <input type="file" accept="image/*" name="foto_cliente">
                    </span>
                    <a href="#" class="btn btn-rose btn-round btn-sm fileinput-exists btn-remove" data-dismiss="fileinput"><i class="material-icons">close</i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-2 col-form-label" for="nome">Nome do cliente</label>
              <div class="col-md-10">
                <div class="form-group has-info bmd-form-group">
                  <input type="text" name="nome" id="nome-cliente" class="form-control" required autocomplete="false" value="<?php echo @$info['nome_cliente']; ?>">
                </div>
              </div>
              <label class="col-md-2 col-form-label" for="rg">RG do cliente</label>
              <div class="col-md-10">
                <div class="form-group has-info bmd-form-group">
                  <input type="text" name="rg" id="rg-cliente" class="form-control" required autocomplete="false" value="<?php echo @$info['rg_cliente']; ?>">
                </div>
              </div>
              <label class="col-md-2 col-form-label" for="nome">Assinatura</label>
              <div class="col-md-10">
                <div id="signatureparent">
                  <?php if(empty($info['assinatura_cliente'])): ?>              
                    <div id="signature"></div>
                  <?php else: ?>
                    <div id="signature" style="display: none;"></div>
                    <img src="<?php echo $uploads_url . $info['assinatura_cliente']; ?>" id="assinatura-cliente">
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-12">
                <input type="hidden" id="valida-assinatura"/>
                <button type="button" class="btn btn-success btn-round pull-right btn-concluir" data-loading-text="Aguarde..."><i class="material-icons">done</i> Finalizar vistoria</button>
                <button type="button" class="btn btn-info btn-round pull-right btn-salvavistoria"><i class="material-icons">save</i> Salvar vistoria</button>
                <button type="button" class="btn btn-round pull-right clear-signature"><i class="material-icons">clear</i> Limpar assinatura</button>
              </div>
            </div>
          </form>
        </div>            
      </div>
    </div>

  </div>
</div>