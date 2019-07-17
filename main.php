<?php 

use Dompdf\Dompdf;

error_reporting(0);

include "vendor/autoload.php";
session_start();


$uploads_path = dirname(dirname(__DIR__)) . "/uploads";

if ($_SERVER['HTTP_HOST'] == "adequacao.test")
    $uploads_url  = "http://localhost/uploads";
else
    $uploads_url  = "https://capitalregularizacoes.com.br/uploads";

try {

    // Configuração do banco de dados
    if ($_SERVER['SERVER_NAME'] == "adequacao.test") 
        $db_url = 'mysql://root@localhost/capit890_beta';
    else
        $db_url = 'mysql://capit890_user:a0eNaYhca@localhost/capit890_beta';

    $dsn = parse_url($db_url);
    $pdo_uri = sprintf("%s:dbname=%s;host=%s;charset=utf8", $dsn['scheme'], substr($dsn['path'], 1),$dsn['host']);
    $pdo = new PDO($pdo_uri, $dsn['user'], @$dsn['pass']);

    $db = new Objectiveweb\DB($pdo);

    $auth = new Objectiveweb\Auth($pdo, array(
        'session_key' => 'capital_vistoria_auth',
        'table' => 'usuarios',
        'id' => 'id',
        'username' => 'login',
        'password' => 'senha',
        'name' => 'nome',
        'token' => 'token',
        'id_usuario' => 'id_usuario',
        'created' => 'dtcadastro',
        'last_login' => 'last_login'
    ));

// Envio de e-mails
    $mail = new PHPMailer;

    $mail->IsSMTP();
    $mail->SMTPDebug    = 0;
    $mail->IsHTML(true);

    $mail->Host         = "br572.hostgator.com.br";
    $mail->Port         = "465";        
    $mail->SMTPAuth     = true;
    $mail->SMTPSecure   = "ssl";
    $mail->Username     = "sistema@capitalregularizacoes.com.br";
    $mail->Password     = 'z!J%vXCg8KW,'; 
    $mail->setFrom($mail->Username);
    $mail->DKIM_domain  = 'capitalregularizacoes.com.br';
    $mail->DKIM_private = 'dkim_private.pem';
    $mail->DKIM_selector = 'phpmailer';
    $mail->DKIM_passphrase = '';
    $mail->DKIM_identity = $mail->From;
    $mail->CharSet = 'iso-8859-1';
    $mail->Encoding = 'quoted-printable'; 


} catch (Exception $e) {
    echo '<h1>Não foi possível conectar ao banco de dados</h1>';
    die();
} 


if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['password'])) {

    $username = $_POST['email'];
    $password = $_POST['password']; 

    try {
        $user = $auth->login($username, $password);
        if (empty($user['tipo'])) {
            $auth->logout();
            header("Location: /vistoria/?fail");
            exit();
        }

        setcookie("tecnico", json_encode($user), time() + 86400 * 2, "/vistoria/");
        header("Location: /vistoria/");
        exit();
    }
    catch(Exception $ex) {
        header("Location: /vistoria/?fail");
        exit();
    }   
} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaInfos") {
    $user = $auth->user();
    
    $id_agenda = $_POST['id_agenda'];
    unset($_POST['id_agenda']);
    $conclui = $_POST['concluir'];
    unset($_POST['concluir']);

    $db->delete("vistoria_dados", "id_vistoria = '$id_agenda' and campo != 'decreto'");

    foreach ($_POST as $campo => $valor) {
        if(is_array($valor))
            $valor = json_encode(array_values($valor));

        $insert = array(
            "id_vistoria" => $id_agenda,
            "id_usuario" => $user['id'],
            "campo" => $campo,
            "valor" => $valor
        );
        $db->insert("vistoria_dados", $insert);
    }

    if ($conclui == '1') {
        $update = array("status" => "Vistoria In-Loco");
        $where = array("id" => $id_agenda);
        $db->update("orcamentos_servicos", $update, $where);
    }

    $ambientes = getPaginaAmbientes($id_agenda);

    echo json_encode(array("result" => true, "ambientes" => $ambientes)); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaInfosArts") {
    $user = $auth->user();
    
    $id_agenda = $_POST['id_agenda'];

    $db->delete("vistoria_arts", array("id_vistoria" => $id_agenda));

    foreach ($_POST['art'] as $id_art => $valor) {
        if ($valor == "on") {

            $insert = array(
                "id_vistoria" => $id_agenda,
                "id_servico" => $id_art
            );
            $db->insert("vistoria_arts", $insert);
        }
    }

    echo json_encode(array("result" => true)); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaInfosAssuntos") {
    $user = $auth->user();
    
    $id_agenda = $_POST['id_agenda'];

    $db->delete("vistoria_categorias", array("id_vistoria" => $id_agenda));

    foreach ($_POST['categoria'] as $id_categoria => $valor) {
        if ($valor == "on") {
            if (!empty($_POST['categoria']['decreto'][$id_categoria]))
                $decreto = $_POST['categoria']['decreto'][$id_categoria];
            else
                $decreto = $_POST['decreto'];

            $insert = array(
                "id_vistoria" => $id_agenda,
                "id_categoria" => $id_categoria,
                "decreto" => @$decreto
            );
            $db->insert("vistoria_categorias", $insert);
        }
    }

    $db->delete("vistoria_dados", array("campo" => "decreto", "id_vistoria" => $id_agenda));
    $insert = array(
        "id_vistoria" => $id_agenda,
        "id_usuario" => $user['id'],
        "campo" => "decreto",
        "valor" => $_POST['decreto']
    );
    $dados = $db->insert("vistoria_dados", $insert);

    echo json_encode(array("result" => true)); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaAmbientes") {

    $id_vistoria = $_POST['id_vistoria'];

    $insert = array(
        "id_vistoria" => $id_vistoria,
        "nome" => $_POST['nome'],
    );
    $id_ambiente = $db->insert("vistoria_ambientes", $insert);

    $categorias = $db->select("vistoria_categorias", array("id_vistoria" => $id_vistoria))->all();
    foreach ($categorias as $key => $value) {
        $insert = array(
            "id_ambiente" => $id_ambiente,
            "id_categoria" => $value['id_categoria'],
        );
        $db->insert("vistoria_ambientes_categorias", $insert);
    }

    echo json_encode(array("result" => true, "id_vistoria" => $id_vistoria, "id_ambiente" => $id_ambiente)); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "criaAssuntos") {
    $id_categoria = $_POST['id_categoria'];
    $assunto = $_POST['assunto'];

    $insert = array(
        "id_categoria" => $id_categoria,
        "assunto"      => $assunto,
        "dest"         => 'S',
    );
    $id_assunto = $db->insert("produtos_categorias_assuntos", $insert);

    echo json_encode(array("result" => true, "id_assunto" => $id_assunto)); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaAssuntos") {
    $id_ambiente = $_POST['id_ambiente'];
    $id_assunto  = $_POST['id_assunto'];
    $dassunto = $db->select("produtos_categorias_assuntos", array("id" => $id_assunto))->fetch();

    if (!empty($_POST['categoria'])) {
        $db->delete("vistoria_ambiente_produtos", array("id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto));
        $db->delete("vistoria_ambiente_obs", array("id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto));
    }

    foreach ($_POST['categoria'] as $id_categoria => $cat) {
        $qtd_produto = 0;
        $qtd_servico = 0;
        $qtd_maoobra = 0;

        if (!empty($cat['obscompras'])) {
            $insert = array(
                "id_ambiente"  => $id_ambiente,
                "id_categoria" => $id_categoria,
                "id_assunto"   => $id_assunto,
                "observacao"   => $cat['obscompras'],
            );
            $db->insert("vistoria_ambiente_obs", $insert);
        }

        if (!empty($cat['equip'])) {
            foreach ($cat['equip'] as $id_produto => $qtd) {
                $qtd_produto++;
                $insert = array(
                    "id_ambiente"  => $id_ambiente,
                    "id_categoria" => $id_categoria,
                    "id_assunto"   => $id_assunto,
                    "id_produto"   => $id_produto,
                    "qtd"          => $qtd,
                );
                $db->insert("vistoria_ambiente_produtos", $insert);
            }
        }

        if (!empty($cat['servico'])) {
            foreach ($cat['servico'] as $id_servico => $qtd) {
                $qtd_servico++;
                $insert = array(
                    "id_ambiente"  => $id_ambiente,
                    "id_categoria" => $id_categoria,
                    "id_assunto"   => $id_assunto,
                    "id_servico"   => $id_servico
                );
                $db->insert("vistoria_ambiente_produtos", $insert);
            }
        }

        if (!empty($cat['maodeobra'])) {
            foreach ($cat['maodeobra'] as $maodeobra => $qtd) {
                $qtd_maoobra++;
                $insert = array(
                    "id_ambiente"  => $id_ambiente,
                    "id_categoria" => $id_categoria,
                    "id_assunto"   => $id_assunto,
                    "maodeobra"    => $maodeobra,
                    "qtd"          => $qtd
                );
                $db->insert("vistoria_ambiente_produtos", $insert);
            }
        }

    }
        
    if (!empty($_FILES['record'])) {
        $filename  = $_FILES['record']['tmp_name'];
        $truename  = $_FILES['record']['name'];
        $ext       = pathinfo($truename, PATHINFO_EXTENSION);
        $fileaudio = "/vistoria/audio_$id_ambiente"."_$id_categoria"."_$id_assunto".".".$ext;
        $filepath  = $uploads_path . $fileaudio;
        $audiourl  = $uploads_url . $fileaudio;
        move_uploaded_file($filename, $filepath);                      

        $insert = array(
            "id_ambiente"   => $id_ambiente,
            "id_categoria"  => $id_categoria,
            "id_assunto"    => $id_assunto,
            "arquivo"       => $audiourl,
            "tipo"          => "audio"
        );
        try {
            $db->insert("vistoria_ambiente_arquivos", $insert);
        } catch (Exception $e) {
            // does nothing
        }        
    }

    if (!empty($_FILES['categoria'])) {
        foreach ($_FILES['categoria']['tmp_name'] as $id_categoria => $cat) {
            foreach ($cat['assuntos'] as $id_assunto => $assunto) {
                foreach ($assunto['foto'] as $i => $filename) {
                    $count = 1;
                    $truename = $_FILES['categoria']['name'][$id_categoria]['assuntos'][$id_assunto]['foto'][$i];
                    $justname = "/vistoria/$id_ambiente"."_$id_categoria"."_$id_assunto"."_".$count.".jpg";
                    while (is_file($uploads_path . $justname)) {
                        $count++;
                        $justname = "/vistoria/$id_ambiente"."_$id_categoria"."_$id_assunto"."_".$count.".jpg";
                    }
                    $filepath = $uploads_path . $justname;
                    $fileurl  = $uploads_url . $justname;

                    $result = move_uploaded_file($filename, $filepath);

                    $insert = array(
                        "id_ambiente"   => $id_ambiente,
                        "id_categoria"  => $id_categoria,
                        "id_assunto"    => $id_assunto,
                        "arquivo"       => $fileurl,
                    );

                    try {
                        $db->insert("vistoria_ambiente_arquivos", $insert);
                    } catch (Exception $e) {
                        // does nothing
                        echo json_encode(array("result" => false)); die();
                    }
                }
            }
        }

    }

    $assunto = explode(" - ", $dassunto['assunto']);
    $assunto = current($assunto);

    $result = array(
        "result"      => true, 
        "id_ambiente" => $id_ambiente, 
        "id_assunto"  => $id_assunto, 
        "assunto"     => $assunto,
        "qtd_produto" => @$qtd_produto,
        "qtd_servico" => @$qtd_servico,
        "qtd_maoobra" => @$qtd_maoobra,
        "audio"       => @$audiourl,
    );

    echo json_encode($result); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaAmbiente") {
    if (!empty($_POST['its'])) {
        foreach ($_POST['its'] as $id_categoria => $value) {
            $insert = array(
                "id_ambiente" => $_POST['id_ambiente'],
                "id_categoria" => $id_categoria,
                "qtd" => "0"
            );
            $db->insert("vistoria_ambientes_categorias", $insert);
        }
    }
    
    $update = array("nome" => $_POST['nome']);
    $where = array("id" => $_POST['id_ambiente']);

    $db->update("vistoria_ambientes", $update, $where);

    echo json_encode(array("result" => true, "id_ambiente" => $_POST['id_ambiente'])); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "descartaIt") {
    
    $where = array("id_ambiente" => $_POST['id_ambiente'], "id_categoria" => $_POST['id_categoria']);

    $db->delete("vistoria_ambientes_categorias", $where);

    echo json_encode(array("result" => true, "id_categoria" => $_POST['id_categoria'])); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaRiscos") {
    $db->delete("vistoria_riscos", array("id_vistoria" => $_POST['id_vistoria']));

    foreach ($_POST['riscos'] as $id => $value) {
        $insert = array(
            "id_vistoria" => $_POST['id_vistoria'],
            "id_risco" => $id
        );

        $db->insert("vistoria_riscos", $insert);
    }

    echo json_encode(array("result" => true, "id_vistoria" => $_POST['id_vistoria'])); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "salvaVistoria") {

    if (!empty($_FILES['assinatura']['tmp_name'])) {
        $filename = $_FILES['assinatura']['tmp_name'];
        $fileassinatura = "/vistoria/".$_POST['id_agenda']."_assinatura.png";
        $filepath = $uploads_path . $fileassinatura;
        $fileurl  = $uploads_url . $fileassinatura;
        move_uploaded_file($filename, $filepath);

        $db->delete("vistoria_dados", array("id_vistoria" => $_POST['id_agenda'], "campo" => "assinatura_cliente"));
        $insert = array(
            "id_vistoria" => $_POST['id_agenda'],
            "campo" => "assinatura_cliente",
            "valor" => $fileassinatura
        );
        $db->insert("vistoria_dados", $insert);
    }

    if (!empty($_FILES['fachada_foto']['tmp_name'])) {
        $filename = $_FILES['fachada_foto']['tmp_name'];
        $ext = pathinfo($_FILES['fachada_foto']['name'], PATHINFO_EXTENSION);
        $fotofachada = "/vistoria/".$_POST['id_agenda']."_fachada.$ext";
        $filepath = $uploads_path . $fotofachada;
        $fileurl  = $uploads_url . $fotofachada;
        move_uploaded_file($filename, $filepath);

        $db->delete("vistoria_dados", array("id_vistoria" => $_POST['id_agenda'], "campo" => "foto_fachada"));
        $insert = array(
            "id_vistoria" => $_POST['id_agenda'],
            "campo" => "foto_fachada",
            "valor" => $fotofachada
        );
        $db->insert("vistoria_dados", $insert);
    }

    if (!empty($_FILES['foto_cliente']['tmp_name'])) {
        $filename = $_FILES['foto_cliente']['tmp_name'];
        $ext = pathinfo($_FILES['foto_cliente']['name'], PATHINFO_EXTENSION);
        $fotocliente = "/vistoria/".$_POST['id_agenda']."_cliente.$ext";
        $filepath = $uploads_path . $fotocliente;
        $fileurl  = $uploads_url . $fotocliente;
        move_uploaded_file($filename, $filepath);

        $db->delete("vistoria_dados", array("id_vistoria" => $_POST['id_agenda'], "campo" => "foto_cliente"));
        $insert = array(
            "id_vistoria" => $_POST['id_agenda'],
            "campo" => "foto_cliente",
            "valor" => $fotocliente
        );
        $db->insert("vistoria_dados", $insert);
    }


    $db->delete("vistoria_dados", array("id_vistoria" => $_POST['id_agenda'], "campo" => "nome_cliente"));
    $insert = array(
        "id_vistoria" => $_POST['id_agenda'],
        "campo" => "nome_cliente",
        "valor" => $_POST['nome']
    );
    $db->insert("vistoria_dados", $insert);
    
    $db->delete("vistoria_dados", array("id_vistoria" => $_POST['id_agenda'], "campo" => "rg_cliente"));
    $insert = array(
        "id_vistoria" => $_POST['id_agenda'],
        "campo" => "rg_cliente",
        "valor" => $_POST['rg']
    );
    $db->insert("vistoria_dados", $insert);

    echo json_encode(array("result" => true)); die();


} elseif (!empty($_GET['action']) && $_GET['action'] == "concluiVistoria") {
    $user = $auth->user();

    $agenda    = $db->select("agenda", array("id_servico" => $_POST['id_agenda'], "status" => "Confirmado"))->fetch();
    $ambientes = $db->select('vistoria_ambientes', array('id_vistoria' => $_POST['id_agenda']))->all();
    foreach ($ambientes as $ambiente) {
        $ambcats  = $db->select('vistoria_ambientes_categorias', array('id_ambiente' => $ambiente['id']))->all();
        foreach ($ambcats as $ambcat) {
            $categoria[$ambcat['id_categoria']][$ambiente['id']] = array();
            $fotos = $db->select('vistoria_ambiente_arquivos', array('id_ambiente' => $ambiente['id'], 'id_categoria' => $ambcat['id_categoria'], 'tipo' => 'foto'))->all();
            if (empty($fotos) && $ambcat['id_categoria'] != '10') {
                $cat = $db->select('produtos_categorias', array('id' => $ambcat['id_categoria']))->fetch();
                echo json_encode(array("result" => false, "message" => "Não foi cadastrado nenhuma foto no ambiente '".$ambiente['nome']."' em: " . $cat['it'])); exit();
            }
            $categoria[$ambcat['id_categoria']][$ambiente['id']]['fotos'] = $fotos;

            $produtos = $db->select('vistoria_ambiente_produtos', array('id_ambiente' => $ambiente['id'], 'id_categoria' => $ambcat['id_categoria']))->all();
            if (empty($produtos)) {
                $cat = $db->select('produtos_categorias', array('id' => $ambcat['id_categoria']))->fetch();
                echo json_encode(array("result" => false, "message" => "Não foi cadastrado nenhum equipamento ou serviço no ambiente '".$ambiente['nome']."' em: " . $cat['it'])); exit();
            }
            $categoria[$ambcat['id_categoria']][$ambiente['id']]['produtos'] = $produtos;
        }
    }

    $db->update("agenda", array("status" => "Em análise"), array("id" => $agenda['id']));

    echo json_encode(array("result" => true));
    die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "getDemanda") {
    $id_ambiente = $_POST['id_ambiente'];
    $id_assunto  = $_POST['id_assunto'];

    $demandas    = $db->select("vistoria_ambiente_produtos", array("id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto))->all();
    $produtos    = array();
    $servicos    = array();
    $maodeobras  = array();
    $audios      = $db->select("vistoria_ambiente_arquivos", array("id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto, "tipo" => "audio"))->all();
    $observacao  = $db->select("vistoria_ambiente_obs", array("id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto))->fetch();


    foreach ($demandas as $demanda) {
        if (!empty($demanda['id_produto'])) {
            $produto = $db->select("produtos", array("id" => $demanda['id_produto']))->fetch();
            $produtos[] = array(
                "id"      => $produto['id'],
                "produto" => $produto['nome'],
                "qtd"     => $demanda['qtd'],
                "cat"     => $demanda['id_categoria']
            );
        }

        if (!empty($demanda['id_servico'])) {
            $servico = $db->select("servicos", array("id" => $demanda['id_servico']))->fetch();
            $servicos[] = array(
                "id"      => $servico['id'],
                "servico" => $servico['nome'],
                "cat"     => $demanda['id_categoria']
            );
        }

        if (!empty($demanda['maodeobra'])) {
            $maodeobras[] = array(
                "maodeobra" => $demanda['maodeobra'],
                "qtd"       => $demanda['qtd'],
                "cat"       => $demanda['id_categoria']
            );
        }
    }

    $return = array(
        "produtos"   => $produtos,
        "servicos"   => $servicos,
        "maodeobras" => $maodeobras,
        "audios"     => $audios,
        "observacao" => $observacao['observacao'],
    );
    echo json_encode($return); exit;

} elseif (!empty($_GET['action']) && $_GET['action'] == "getInfos") {
    $id_vistoria = $_POST['id_vistoria'];

    $sql = "SELECT a.id, os.id as id_servico, a.dtevento, a.horaini, cli.razao_social
            FROM orcamentos_servicos os
            LEFT JOIN agenda a ON os.id = a.id_servico
            INNER JOIN orcamentos orc ON orc.id = os.id_orcamento
            INNER JOIN clientes cli ON cli.id = orc.id_cliente
            WHERE os.id = '$id_vistoria' 
            order by a.dtevento desc";

    $query = $db->query($sql);
    $query->exec(array());
    $vistoria = $query->fetch();

    $sql = "select *, 
            (select count(*) from vistoria_ambiente_arquivos where id_ambiente = va.id and tipo = 'foto') as fotos,
            (select count(*) from vistoria_ambiente_produtos where id_ambiente = va.id) as equips
            from vistoria_ambientes va
            where id_vistoria = '$id_vistoria' ";

    $query = $db->query($sql);
    $query->exec(array());
    $ambientes = $query->all();

    $selecionadas = $db->select("vistoria_categorias", array("id_vistoria" => $id_vistoria))->all();
    $decretos = array();
    $ids_cat = array();
    foreach($selecionadas as $row) { 
        $decretos[$row['id_categoria']] = $row['decreto']; 
        $ids_cat[] = $row['id_categoria']; 
    }

    $artselecionadas = $db->select("vistoria_arts", array("id_vistoria" => $id_vistoria))->all();
    $ids_art = array();
    foreach($artselecionadas as $row) { 
        $ids_art[] = $row['id_servico']; 
    }

    $dados = $db->select("vistoria_dados", array("id_vistoria" => $id_vistoria))->all();
    foreach($dados as $key => $value) {
        $info[$value['campo']] = $value['valor'];
    }

    ob_start();
    include "templates/infos-servico.php";
    $markeup = ob_get_contents();
    ob_end_clean();
    $markeup = preg_replace("|\n|", "", $markeup);
    $markeup = preg_replace("|\r|", "", $markeup);
    $markeup = str_replace("  ", " ", $markeup);
    
    die($markeup);

}  elseif (!empty($_GET['action']) && $_GET['action'] == "getAmbientes") {
    $id_vistoria = $_POST['id_vistoria'];

    $markeup = getPaginaAmbientes($id_vistoria);   
    $markeup = preg_replace("|\n|", "", $markeup);
    $markeup = preg_replace("|\r|", "", $markeup);
    $markeup = str_replace("  ", " ", $markeup); 
    
    die($markeup);

}  elseif (!empty($_GET['action']) && $_GET['action'] == "getAmbiente") {
    $id_ambiente = $_POST['id_ambiente'];

    $ambiente = $db->select("vistoria_ambientes", array("id" => $id_ambiente))->fetch();
    if (empty($ambiente)) {
        die("error");
    }
    
    $sql      = "select ve.*, p.nome from vistoria_ambiente_produtos ve 
                 inner join produtos p on ve.id_produto = p.id
                 where id_ambiente = '$id_ambiente' ";
    $query = $db->query($sql);
    $query->exec(array());
    $equipamentos = $query->all();

    $sql      = "select ve.*, s.nome from vistoria_ambiente_produtos ve 
                 inner join servicos s on ve.id_servico = s.id
                 where id_ambiente = '$id_ambiente' ";
    $query = $db->query($sql);
    $query->exec(array());
    $servicos = $query->all();

    $fotos = $db->select("vistoria_ambiente_arquivos", array("id_ambiente" => $id_ambiente, "tipo" => "foto"))->all();

    $categorias = getCategorias($id_ambiente);
    if (empty($categorias)) {
        $categorias = $db->select("produtos_categorias", array("id" => "10"))->all();
    }

    foreach ($categorias as $i => $cat) {
        $categorias[$i]["produtos"]  = getProdutos($cat['id']);
        $categorias[$i]["eletricos"] = getEletricos($cat['id']);
        $categorias[$i]["assuntos"]  = getAssuntos($cat['id']);
        $categorias[$i]["maodeobra"] = getMaodeobra();
        $categorias[$i]["servicos"]  = getServicosCategoria($cat['id']);
    }


    $ids_cat = array();
    foreach($categorias as $row) { 
        $ids_cat[] = $row['id']; 
    }    

    ob_start();
    include "templates/fotos-ambiente.php";
    $markeup = ob_get_contents();
    ob_end_clean();
    $markeup = preg_replace("|\n|", "", $markeup);
    $markeup = preg_replace("|\r|", "", $markeup);
    $markeup = str_replace("  ", " ", $markeup);
    
    die($markeup);

}  elseif (!empty($_GET['action']) && $_GET['action'] == "salvaInfoAmbiente") {
    if (empty($_POST['id_ambiente'])) {

        $insert = array(
            "id_vistoria" => $_POST['id_agenda'],
            "nome" => $_POST['nome_ambiente'],
            "pavimento" => @$_POST['pavimento'],
        );
        $id_ambiente = $db->insert("vistoria_ambientes", $insert);

    } else {

        $id_ambiente = $_POST['id_ambiente'];
        $update = array("nome" => $_POST['nome_ambiente'], "pavimento" => @$_POST['pavimento']);
        $where = array("id" => $id_ambiente);

        $db->update("vistoria_ambientes", $update, $where);
        $db->delete("vistoria_ambientes_categorias", array("id_ambiente" => $id_ambiente));

    }

    foreach ($_POST['categoria'] as $id_categoria => $value) {
        if (!empty($_POST['equipamento'][$id_categoria ])){
            foreach ($_POST['equipamento'][$id_categoria ] as $id_equipamento => $qtd) {
                $insert = array(
                    "id_ambiente" => $id_ambiente,
                    "id_categoria" => $id_categoria,
                    "id_equipamento" => $id_equipamento,
                    "qtd" => $qtd,
                );
                
                $db->insert("vistoria_ambientes_categorias", $insert);
            }
        } else {
            $insert = array(
                "id_ambiente" => $id_ambiente,
                "id_categoria" => $id_categoria
            );
            
            $db->insert("vistoria_ambientes_categorias", $insert);
        }
    }

    echo json_encode(array("result" => true)); die();

} elseif (!empty($_GET['action']) && $_GET['action'] == "getInfoAmbiente") {
    $id_vistoria = $_POST['id_vistoria'];

    if (!empty($_POST['id_ambiente'])) {
        $id_ambiente = $_POST['id_ambiente'];
        $ambiente = $db->select("vistoria_ambientes", array("id" => $id_ambiente))->fetch();

        $categorias = getCategorias($id_ambiente);
        if (empty($categorias))
            $categorias = getCategorias();

    } else {

        $categorias = getCategorias();

    }

    $selecionadas = $db->select("vistoria_categorias", array("id_vistoria" => $id_vistoria))->all();
    $decretos = array();
    $ids_cat = array();

    foreach($selecionadas as $row) { 
        $decretos[$row['id_categoria']] = $row['decreto']; 
        $ids_cat[] = $row['id_categoria']; 
    }

    $dados = $db->select("vistoria_dados", array("id_vistoria" => $id_vistoria))->all();
    foreach($dados as $key => $value) {
        $info[$value['campo']] = $value['valor'];
    }

    ob_start();
    include "templates/edit-ambiente.php";
    $markeup = ob_get_contents();
    ob_end_clean();
    $markeup = preg_replace("|\n|", "", $markeup);
    $markeup = preg_replace("|\r|", "", $markeup);
    $markeup = str_replace("  ", " ", $markeup);
    
    die($markeup);

} elseif (!empty($_GET['action']) && $_GET['action'] == "getAnalise") {
    $id_vistoria = $_POST['id_vistoria'];

    $salva = $db->select("vistoria_demandas", array("id_vistoria" => $id_vistoria), array("order" => "id desc"))->fetch();

    $categorias = array();
    $ambientes  = array();
    $assuntos   = array();
    $fotos      = array();
    $audios     = array();
    $obs        = array();
    $produtos   = array();
    $servicos   = array();
    $maodeobras = array();
    if (!empty($salva)) {
        $revisao = $salva['revisao'];
        parseJsonDemandas($salva['demandas'], $categorias, $ambientes, $assuntos, $fotos, $audios, $obs, $produtos, $servicos, $maodeobras);
    } else {
        $revisao = 0;
        
        $sql = "select distinct vac.id_categoria, pc.id, pc.it from vistoria_ambientes_categorias vac
                inner join produtos_categorias pc on vac.id_categoria = pc.id
                inner join vistoria_ambientes va on vac.id_ambiente = va.id
                where va.id_vistoria = '$id_vistoria'
                order by pc.it";
        $query = $db->query($sql);
        $query->exec(array());
        $categorias = $query->all();

        $sql = "select distinct vac.id_categoria, vac.id_ambiente, va.nome from vistoria_ambientes_categorias vac
                inner join vistoria_ambientes va on vac.id_ambiente = va.id
                where va.id_vistoria = '$id_vistoria'
                order by va.nome";
        $query = $db->query($sql);
        $query->exec(array());
        $ambientes = $query->all();

        $sql = "select distinct pac.*, vaa.id_ambiente from vistoria_ambiente_arquivos vaa
                inner join vistoria_ambientes va on vaa.id_ambiente = va.id
                inner join produtos_categorias_assuntos pac on pac.id = vaa.id_assunto
                where va.id_vistoria = '$id_vistoria'
                order by pac.assunto";
        $query = $db->query($sql);
        $query->exec(array());
        $assuntos = $query->all();

        $sql = "select *, vaa.id as id_arquivo from vistoria_ambiente_arquivos vaa
                inner join vistoria_ambientes va on vaa.id_ambiente = va.id
                inner join produtos_categorias_assuntos pac on pac.id = vaa.id_assunto
                where va.id_vistoria = '$id_vistoria' and vaa.tipo = 'foto'
                order by pac.assunto";
        $query = $db->query($sql);
        $query->exec(array());
        $fotos = $query->all();

        $sql = "select *, vaa.id as id_arquivo from vistoria_ambiente_arquivos vaa
                inner join vistoria_ambientes va on vaa.id_ambiente = va.id
                inner join produtos_categorias_assuntos pac on pac.id = vaa.id_assunto
                where va.id_vistoria = '$id_vistoria' and vaa.tipo = 'audio'
                order by pac.assunto";
        $query = $db->query($sql);
        $query->exec(array());
        $audios = $query->all();

        $sql = "select *, s.nome as servico from vistoria_ambiente_produtos vap
                inner join servicos s on s.id = vap.id_servico
                inner join vistoria_ambientes va on vap.id_ambiente = va.id
                where va.id_vistoria = '$id_vistoria'
                order by s.nome";
        $query = $db->query($sql);
        $query->exec(array());
        $servicos = $query->all();

        $sql = "select *, p.nome as produto from vistoria_ambiente_produtos vap
                inner join produtos p on p.id = vap.id_produto
                inner join vistoria_ambientes va on vap.id_ambiente = va.id
                where va.id_vistoria = '$id_vistoria'
                order by p.nome";
        $query = $db->query($sql);
        $query->exec(array());
        $produtos = $query->all();

        $sql = "select * from vistoria_ambiente_produtos vap
                inner join vistoria_ambientes va on vap.id_ambiente = va.id
                where va.id_vistoria = '$id_vistoria'
                and maodeobra is not null and maodeobra != ''
                order by maodeobra";
        $query = $db->query($sql);
        $query->exec(array());
        $maodeobras = $query->all();

    }

    ob_start();
    include "templates/analise.php";
    $markeup = ob_get_contents();
    ob_end_clean();
    $markeup = preg_replace("|\n|", "", $markeup);
    $markeup = preg_replace("|\r|", "", $markeup);
    $markeup = str_replace("  ", " ", $markeup);
    
    die($markeup);

}  elseif (!empty($_GET['action']) && $_GET['action'] == "salvaAnalise") {
    $id_vistoria = $_POST['id_vistoria'];
    $revisao     = $_POST['revisao'];
    $demandas    = json_encode($_POST['demanda']);

    $insert = array(
        "id_vistoria" => $id_vistoria,
        "revisao"     => $revisao,
        "demandas"    => $demandas,
    );
    $db->insert("vistoria_demandas", $insert);

    echo json_encode(array("result" => true)); die();

}  elseif (!empty($_GET['action']) && $_GET['action'] == "mergeDemanda") {
    $id_vistoria  = $_POST['id_vistoria'];
    $id_categoria = $_POST['id_categoria'];
    $revisao      = $_POST['revisao'];
    $assuntos     = explode(",", $_POST['demandas']);

    $salva = $db->select("vistoria_demandas", array("id_vistoria" => $id_vistoria), array("order" => "id desc"))->fetch();
    $demandas = json_decode($salva['demandas'], "ARRAY_A");
    $merge = array(
        "id_ambiente" => array(),
        "nome" => array(),
        "foto" => array(),
        "servico" => array(),
        "produto" => array(),
        "maodeobra" => array(),
    );

    foreach ($demandas[$id_categoria] as $id_ambiente => $categoria) {
        foreach ($categoria as $id_assunto => $assunto) {
            if (in_array($id_assunto, $assuntos)) {
                $mesmo_ambiente = true;
                if (!empty($merge['id_ambiente'])) {
                    if (!in_array($id_ambiente, $merge['id_ambiente'])) {
                        $mesmo_ambiente = false;
                    }
                }
                $merge['id_ambiente'][] = $id_ambiente;

                if (empty($merge['nome']))
                    $merge['nome'] = $assunto['nome'];

                if (!empty($assunto['foto'])) {
                    foreach ($assunto['foto'] as $foto) {
                        $merge['foto'][] = $foto;
                    }
                }

                if (!empty($assunto['audio'])) {
                    foreach ($assunto['audio'] as $audio) {
                        $merge['audio'][] = $audio;
                    }
                }

                if (!empty($assunto['obs'])) {
                    foreach ($assunto['obs'] as $obs) {
                        $merge['obs'][] = $obs;
                    }
                }

                if (!empty($assunto['servico'])) {
                    foreach ($assunto['servico'] as $id_servico => $servico) {
                        $merge['servico'][$id_servico] = $servico;
                    }
                }

                if (!empty($assunto['produto'])) {
                    foreach ($assunto['produto'] as $id_produto => $produto) {
                        $merge['produto'][$id_produto] = $produto;
                    }
                }

                if (!empty($assunto['maodeobra'])) {
                    foreach ($assunto['maodeobra'] as $id_maodeobra => $maodeobra) {
                        $merge['maodeobra'][$id_maodeobra] = $maodeobra;
                    }
                }
            }
        }
    }

    if ($mesmo_ambiente) {
        $merge_ambiente = current($merge['id_ambiente']);
        unset($merge['id_ambiente']);
        for ($i=0; $i < count($assuntos); $i++) { 
            if ($i == 0) {
                $demandas[$id_categoria][$merge_ambiente][$assuntos[$i]] = $merge;
            } else {
                unset($demandas[$id_categoria][$merge_ambiente][$assuntos[$i]]);
            }
        }
    } else {
        for ($i=0; $i < count($assuntos); $i++) { 
            unset($demandas[$id_categoria][$merge['id_ambiente'][$i]][$assuntos[$i]]);
            if (empty($demandas[$id_categoria][$merge['id_ambiente'][$i]])) {
                unset($demandas[$id_categoria][$merge['id_ambiente'][$i]]);
            }
            if ($i == 0) {
                $demandas[$id_categoria][0][$assuntos[$i]] = $merge;
                unset($demandas[$id_categoria][0][$assuntos[$i]]['id_ambiente']);
            }
        }
    }

    $insert = array(
        "id_vistoria" => $id_vistoria,
        "revisao"     => $revisao,
        "demandas"    => json_encode($demandas),
    );
    $db->insert("vistoria_demandas", $insert);

    echo json_encode(array("result" => true)); die();


}  elseif (!empty($_GET['action']) && $_GET['action'] == "concluiAnalise") {
    $user = $auth->user();


    $proposta  = $db->select('orcamentos_servicos', array("id" => $_POST['id_agenda']))->fetch();
    $agenda    = $db->select("agenda", array("id_servico" => $_POST['id_agenda'], "status" => "Em análise"))->fetch();
    $dados     = $db->select('orcamentos_servicos_dados', array("id_orcamentos_servicos" => $_POST['id_agenda']))->fetch();
    $orcamento = $db->select('orcamentos', array('id' => $proposta['id_orcamento']))->fetch();
    $cliente   = $db->select('clientes', array('id' => $orcamento['id_cliente']))->fetch();
    $endereco  = $db->select('enderecos', array('id' => $orcamento['id_endereco']))->fetch();
    $arts      = $db->select('vistoria_arts', array('id_vistoria' => $_POST['id_agenda']))->all();
    $vdados    = $db->select('vistoria_dados', array("id_vistoria" => $_POST['id_agenda']))->all();
    $demandas  = $db->select('vistoria_demandas', array('id_vistoria' => $_POST['id_agenda']))->fetch();
    $projeto   = getDocumentos($_POST['id_agenda'], 'Último projeto aprovado no corpo de bombeiros');
    $analista  = $user['nome'];

    $categorias = array();
    $ambientes  = array();
    $assuntos   = array();
    $fotos      = array();
    $audios     = array();
    $obs        = array();
    $produtos   = array();
    $servicos   = array();
    $maodeobras = array();
    parseJsonDemandas($demandas['demandas'], $categorias, $ambientes, $assuntos, $fotos, $audios, $obs, $produtos, $servicos, $maodeobras);

    foreach($vdados as $key => $value) {
        $info[$value['campo']] = $value['valor'];
    }

    $info['uso_descricao'] = empty($info['uso_descricao']) ? "" : $info['uso_descricao'];
    $info['pavimentos'] = empty($info['pavimentos']) ? "" : $info['pavimentos'];
    $info['iptu'] = empty($info['iptu']) ? "" : $info['iptu'];
    $info['area_construida'] = empty($info['area_construida']) ? "" : $info['area_construida'];
    $info['numero_avcb'] = empty($info['numero_avcb']) ? "" : $info['numero_avcb'];
    $info['proprietario'] = empty($info['proprietario']) ? "" : $info['proprietario'];
    $info['decreto'] = empty($info['decreto']) ? "" : $info['decreto'];
    $info['decreto'] = empty($info['decreto']) ? "" : $info['decreto'];
    $info['foto_fachada'] = empty($info['foto_fachada']) ? "" : $info['foto_fachada'];
    $info['decreto'] = empty($info['decreto']) ? "" : $info['decreto'];
    $info['uso_descricao'] = empty($info['uso_descricao']) ? "" : $info['uso_descricao'];
    $info['altura'] = empty($info['altura']) ? "" : $info['altura'];
    $info['risco'] = empty($info['risco']) ? "" : $info['risco'];
    $info['decreto'] = empty($info['decreto']) ? "" : $info['decreto'];

    foreach ($arts as $key => $value) {
        $servico = $db->select('servicos', array('id' => $value['id_servico']))->fetch();
        $arts[$key]['art'] = $servico['nome'];
    }

    $orcamento['valor'] = 0;
    $orcamento['status'] = "O";
    $orcamento['descricao'] = "Aguardando envio";
    $orcamento['prioridade'] = "-1";
    $orcamento['tipo'] = "produtos";
    $orcamento['id_adequacao'] = $proposta['id'];

    unset($orcamento['id']);
    unset($orcamento['arquivo']);
    unset($orcamento['dtinicio']);
    unset($orcamento['dtcadastro']);
    unset($orcamento['dtcadastro']);
    unset($orcamento['dtenvio']);
    unset($orcamento['dtaprovacao']);
    unset($orcamento['dtalteracao']);
    $id_orcamento = $db->insert("orcamentos", $orcamento);

    $insert_obs = array(
      "id_orcamento"  => $id_orcamento,
      "observacao"    => "Proposta gerada automaticamente pelo sistema de vistoria, caso haja dúvidas favor esclarecer com o departamento técnico",
      "id_usuario"    => $user['id'],
    );
    $db->insert("orcamentos_observacoes", $insert_obs);

    $newservico = $proposta;
    $newservico['id_servico'] = 9999;
    $newservico['id_orcamento'] = $id_orcamento;
    $newservico['status'] = "Novo serviço";

    unset($newservico['id']);
    unset($newservico['status_adequacao']);
    unset($newservico['valor_adequacao']);
    unset($newservico['prazo_status']);
    unset($newservico['token']);
    unset($newservico['dtinicio']);
    unset($newservico['dtcadastro']);
    $db->insert('orcamentos_servicos', $newservico);

    foreach ($produtos as $produto) {
        if (!empty($produto['id_produto']) && !empty($produto['qtd'])) {
            $insert = array(
              'id_orcamentos_servicos'  => $proposta['id'],
              'id_produto'              => $produto['id_produto'],
              'id_ambiente'             => $produto['id_ambiente'],
              'id_categoria'            => $produto['id_categoria'],
              'qtd'                     => $produto['qtd'],
              'valor'                   => "0",
            );
            $db->insert('orcamentos_servicos_produtos', $insert);
        }
    }

    if (!empty($_POST['mobra']) && is_array($_POST['mobra'])) {
        foreach ($_POST['mobra'] as $key => $value) {
            $insert = array(
              'id_orcamento'  => $id_orcamento,
              'maodeobra'     => $key,
              'periodos'      => $value,
            );
            $db->insert('orcamentos_maodeobra', $insert);
        }
    }

    $set    = array("status" => "Concluído");
    $where  = array("id" => $agenda['id']);

    $db->update("agenda", $set, $where);

    ob_start();
    include "templates/pdf-laudo.php";
    $pdf = ob_get_contents();
    ob_end_clean();

    $filename = "vistoria/".$_POST['id_agenda']."_laudo_vistoria.pdf";

    file_put_contents($uploads_path . "/" . $filename, $pdf);

    $insert_doc = array(
      "id_orcamentos_servico" => $proposta['id'],
      "status"                => "concluido",
      "titulo"                => "Laudo Técnico Fotográfico",
      "arquivo"               => $filename,
    );
    $db->insert("orcamentos_documentos_producao", $insert_doc);  

    $insert_doc = array(
      "id_orcamento" => $id_orcamento,
      "nome"         => $filename,
      "tipo"         => "Doc",
    );
    $db->insert("orcamentos_documentos", $insert_doc);

    echo json_encode(array("result" => true)); die();

}  elseif (!empty($_GET['action']) && $_GET['action'] == "uploadAudio") {
    $id_ambiente   = $_POST['idambiente'];
    $id_categoria  = $_POST['idcategoria'];
    $id_assunto    = $_POST['idassunto'];

    if (!empty($_FILES['record'])) {
        $filename  = $_FILES['record']['tmp_name'];
        $truename  = $_FILES['record']['name'];
        $fileaudio = "/vistoria/audio_$id_ambiente"."_$id_categoria"."_$id_assunto"."_".time().".wav";
        $filepath  = $uploads_path . $fileaudio;
        $audiourl  = $uploads_url . $fileaudio;
        move_uploaded_file($filename, $filepath);                      

        $insert = array(
            "id_ambiente"   => $id_ambiente,
            "id_categoria"  => $id_categoria,
            "id_assunto"    => $id_assunto,
            "arquivo"       => $audiourl,
            "tipo"          => "audio"
        );
        try {
            $id_audio = $db->insert("vistoria_ambiente_arquivos", $insert);
        } catch (Exception $e) {
            // does nothing
        }        
    }

    echo json_encode(array("result" => true, "idaudio" => $id_audio)); die();

}  elseif (!empty($_GET['action']) && $_GET['action'] == "deleteAudio") {
    $id_audio   = $_POST['idaudio'];

    $db->delete("vistoria_ambiente_arquivos", array("id" => $id_audio));

    echo json_encode(array("result" => true)); die();

}  elseif (!empty($_GET['action']) && $_GET['action'] == "salvaGerais") {
    $id_vistoria = $_POST['id_vistoria'];
    $titulo      = @$_POST['geral_titulo'];
    $descricao   = @$_POST['geral_descricao'];

    if (!empty($_FILES['foto_geral'])) {
        $filename  = $_FILES['foto_geral']['tmp_name'];
        $truename  = $_FILES['foto_geral']['name'];
        if ($truename == 'blob') {
            $truename = time() . ".jpg";
        }        
        $filegeral = "/vistoria/geral_$id_vistoria"."_$truename";
        $filepath  = $uploads_path . $filegeral;
        $fileurl   = $uploads_url . $filegeral;
        move_uploaded_file($filename, $filepath); 

        $insert = array(
            "id_vistoria"   => $id_vistoria,
            "arquivo"       => $fileurl,
            "titulo"        => $titulo,
            "descricao"     => $descricao
        );
        $id_foto = $db->insert("vistoria_fotos", $insert);

        echo json_encode(array("result" => true, "id_foto" => $id_foto)); die();
    }

}  elseif (!empty($_GET['action']) && $_GET['action'] == "addAnalise") {
    $id_ambiente  = $_POST['id_ambiente'];
    $id_categoria = $_POST['id_categoria'];
    $id_assunto   = $_POST['id_assunto'];

    if (!empty($_FILES['fotoanalise'])) {

        $truename = $_FILES['fotoanalise']['name'];
        $filename = $_FILES['fotoanalise']['tmp_name'];
        if ($truename == 'blob') {
            $truename = time() . ".jpg";
        }
        $justname = "/vistoria/$id_ambiente"."_$id_categoria"."_$id_assunto"."_".$truename;
        $filepath = $uploads_path . $justname;
        $fileurl  = $uploads_url . $justname;

        $result = move_uploaded_file($filename, $filepath);

        $insert = array(
            "id_ambiente"   => $id_ambiente,
            "id_categoria"  => $id_categoria,
            "id_assunto"    => $id_assunto,
            "arquivo"       => $fileurl,
        );

        try {
            $id_foto = $db->insert("vistoria_ambiente_arquivos", $insert);
        } catch (Exception $e) {
            echo json_encode(array("result" => false)); die();
        }
    }

    echo json_encode(array("result" => true, "idfoto" => $id_foto, "urlfoto" => $fileurl)); die();


}  elseif (!empty($_GET['action']) && $_GET['action'] == "deleteAmbiente") {
    $id_ambiente = $_POST['id_ambiente'];

    $produtos = $db->select("vistoria_ambiente_produtos", array("id_ambiente" => $id_ambiente))->all();
    $fotos    = $db->select("vistoria_ambiente_arquivos", array("id_ambiente" => $id_ambiente))->all();
    
    if (!empty($produtos) || !empty($fotos)) {
        $result = array("result" => false);
    } else {
        $db->delete("vistoria_ambientes", array("id" => $id_ambiente));
        $result = array("result" => true);
    }

    die(json_encode($result));
}  elseif (!empty($_GET['action']) && $_GET['action'] == "deleteImage") {
    $id_image = $_POST['id_image'];

    $db->delete("vistoria_ambiente_arquivos", array("id" => $id_image));

    $result = array("result" => true);
    die(json_encode($result));
} else {
    if ($auth->check()) {
        $user = $auth->user();

        $data = new DateTime();
        $data->modify('-1 month');
        $posterior = $data->format('Y-m-d');
        $data->modify('+2 month');
        $anterior = $data->format('Y-m-d');

        $sql = "SELECT a.id, os.id as id_servico, a.tipo, a.dtevento, a.horaini, a.status, 
                os.STATUS AS servico_status, cli.razao_social, end.endereco as rua, end.numero, 
                end.cep, end.cidade, end.uf
                FROM orcamentos_servicos os
                LEFT JOIN agenda a ON os.id = a.id_servico
                INNER JOIN orcamentos orc ON orc.id = os.id_orcamento
                INNER JOIN clientes cli ON cli.id = orc.id_cliente
                INNER JOIN enderecos end ON end.id = orc.id_endereco 
                WHERE   (os.status = 'Preenchimento de dados')
                OR      (os.status = 'Vistoria In-Loco' AND a.tipo = 'vistoria'
                            AND a.status in ('Confirmado', 'Em análise') 
                            AND a.dtevento <= '$anterior' AND a.dtevento >= '$posterior')
                ORDER BY os.id desc, a.status desc, a.dtevento desc";

        $query = $db->query($sql);
        $query->exec(array());
        $vistorias = $query->all();


        if (!empty($vistorias)) {
            ob_start();
            include "templates/lista-servicos.php";
            $markeup = ob_get_contents();
            ob_end_clean();
            $markeup = preg_replace("|\n|", "", $markeup);
            $markeup = preg_replace("|\r|", "", $markeup);
            $markeup = str_replace("  ", " ", $markeup);
        }  

    }
}

function getEquipsbyVistoria($id_vistoria) {
    global $db;

    $sql = "select count(*) as total from vistoria_ambiente_produtos ve
            inner join vistoria_ambientes va on va.id = ve.id_ambiente
            where va.id_vistoria = '$id_vistoria' ";

    $query = $db->query($sql);
    $query->exec(array());
    $equips = $query->fetch();

    return $equips['total'];

}

function getFotosbyVistoria($id_vistoria) {
    global $db;

    $sql = "select count(*) as total from vistoria_ambiente_arquivos vf
            inner join vistoria_ambientes va on va.id = vf.id_ambiente
            where va.id_vistoria = '$id_vistoria' and vf.tipo = 'foto' ";

    $query = $db->query($sql);
    $query->exec(array());
    $fotos = $query->fetch();

    return $fotos['total'];

}

function getAmbientesbyVistoria($id_vistoria) {
    global $db;

    $sql = "select count(*) as total from vistoria_ambientes
            where id_vistoria = '$id_vistoria' ";

    $query = $db->query($sql);
    $query->exec(array());
    $ambs = $query->fetch();

    return $ambs['total'];

}

function getDocumentos($id_servico, $titulo = null) {
    global $db;

    $sql = "select odp.*, ds.documento from orcamentos_documentos_producao odp
            left join documentos_servico ds on odp.id_documentos_servico = ds.id
            where odp.id_orcamentos_servico = '$id_servico' ";

    if (!empty($titulo)) {
        $sql .= " and ds.documento = '$titulo'";
    }

    $query = $db->query($sql);
    $query->exec(array());

    if (empty($titulo)) {
        $doctos = $query->all();
    } else {
        $doctos = $query->fetch();
    }

    return $doctos;

}

function getAtividades() {
    global $db;

    $sql = "select * from atividades";

    $query = $db->query($sql);
    $query->exec(array());
    $atividades = $query->all();

    return $atividades;

}

function getCategorias($id_ambiente = array()) {
    global $db;

    if (empty($id_ambiente)) {
        $sql = "select * from produtos_categorias order by it";
    } else {
        $sql = "select distinct pc.* from produtos_categorias pc 
                inner join vistoria_ambientes_categorias vac on vac.id_categoria = pc.id
                where vac.id_ambiente = '$id_ambiente'
                order by pc.it";
    }

    $query = $db->query($sql);
    $query->exec(array());
    $categorias = $query->all();

    return $categorias;
}

function getArts() {
    global $db;

    $sql = "select * from servicos where nome like 'RT %' order by nome";

    $query = $db->query($sql);
    $query->exec(array());
    $arts = $query->all();

    return $arts;
}

function getEquipamentos($id_categoria, $id_ambiente = array()) {
    global $db;

    if (empty($id_ambiente)) {
        $sql = "select * from produtos_categorias_equipamentos
                where id_categoria = '$id_categoria' order by ordem";
    } else {
        $sql = "select pce.*, vac.qtd from produtos_categorias_equipamentos pce
                inner join vistoria_ambientes_categorias vac on vac.id_equipamento = pce.id
                where pce.id_categoria = '$id_categoria' and vac.id_ambiente = '$id_ambiente'
                order by pce.ordem";
    }

    $query = $db->query($sql);
    $query->exec(array());
    $equipamentos = $query->all();

    return $equipamentos;
}

function getDemanda($id_categoria, $id_ambiente, $id_assunto) {
    global $db;

    $demandas = $db->select("vistoria_ambiente_produtos", array("id_categoria" => $id_categoria, "id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto))->all();
    $demanda = array();
    if (!empty($demandas)) {
        $audio = $db->select("vistoria_ambiente_arquivos", array("id_categoria" => $id_categoria, "id_ambiente" => $id_ambiente, "id_assunto" => $id_assunto, "tipo" => "audio"))->all();

        $qtd_produto = 0;
        $qtd_servico = 0;
        $qtd_maoobra = 0;
        foreach ($demandas as $demanda) {
            if (!empty($demanda['id_produto'])) $qtd_produto++;
            if (!empty($demanda['id_servico'])) $qtd_servico++;
            if (!empty($demanda['maodeobra']))  $qtd_maoobra++;
        }

        $demanda = array(
            "qtd_produto" => $qtd_produto,
            "qtd_servico" => $qtd_servico,
            "qtd_maoobra" => $qtd_maoobra,
            "qtd_maoobra" => $qtd_maoobra,
            "audio"       => $audio,
        );
    }

    return $demanda;
}

function getProdutos($id_categoria) {
    global $db;

    $sql = "select p.id, pc.classe as produto,  ps.classe as classe, pm.material, pd.dimensao
    from produtos p
    inner join produtos_classes pc on pc.id = p.id_classe
    left  join produtos_classes ps on ps.id = p.id_subclasse
    left  join produtos_materiais pm on pm.id = p.id_material
    left  join produtos_dimensoes pd on pd.id = p.id_dimensao
    where p.id_categoria = '$id_categoria' and p.ativo = '1'
    order by pc.classe";

    $query = $db->query($sql);
    $query->exec(array());
    $assuntos = $query->all();

    return $assuntos;
}

function getEletricos($id_categoria) {
    global $db;

    $cats = array('14','23','16','3','7','26');

    if (in_array($id_categoria, $cats)) {
        $sql = "select p.id, pc.classe as produto,  ps.classe as classe, pm.material, pd.dimensao
        from produtos p
        inner join produtos_classes pc on pc.id = p.id_classe
        left  join produtos_classes ps on ps.id = p.id_subclasse
        left  join produtos_materiais pm on pm.id = p.id_material
        left  join produtos_dimensoes pd on pd.id = p.id_dimensao
        where p.id_categoria = '30' and p.ativo = '1'
        order by pc.classe";

        $query = $db->query($sql);
        $query->exec(array());
        $assuntos = $query->all();
    
        return $assuntos;
    } else {
        return array();
    }

}

function getAssuntos($id_categoria) {
    global $db;

    $sql = "select * from produtos_categorias_assuntos where id_categoria = '$id_categoria' order by assunto";

    $query = $db->query($sql);
    $query->exec(array());
    $assuntos = $query->all();

    return $assuntos;
}

function getChecklist($id_categoria) {
    global $db;

    $sql = "select * from produtos_categorias_checklists where id_categoria = '$id_categoria' order by checklist";

    $query = $db->query($sql);
    $query->exec(array());
    $checklists = $query->all();

    return $checklists;
}

function getMaodeobra() {
    global $db;

    $sql = "select distinct funcao from maodeobra";

    $query = $db->query($sql);
    $query->exec(array());
    $maodeobra = $query->all();

    return $maodeobra;
}

function getServicosCategoria($id_categoria) {
    global $db;

    $sql = "SELECT pcs.*, s.nome FROM produtos_categorias_servicos pcs
            INNER JOIN servicos s ON s.id = pcs.id_servico
            WHERE pcs.id_categoria = '$id_categoria' ORDER BY s.nome";

    $query = $db->query($sql);
    $query->exec(array());
    $servicos = $query->all();

    return $servicos;
}

function getPaginaAmbientes($id_vistoria) {
    global $db;
    global $uploads_url;
    global $uploads_path;

    $sql = "SELECT a.id, a.id_servico, a.dtevento, a.horaini, cli.razao_social
            FROM agenda a
            INNER JOIN orcamentos_servicos os ON os.id = a.id_servico
            INNER JOIN orcamentos orc ON orc.id = os.id_orcamento
            INNER JOIN clientes cli ON cli.id = orc.id_cliente
            WHERE a.id = '$id_vistoria' ";

    $query = $db->query($sql);
    $query->exec(array());
    $vistoria = $query->fetch();

    $sql = "select p.id, p.nome, sum(qtd) as total 
            from vistoria_ambiente_produtos ve 
            inner join produtos p on ve.id_produto = p.id
            inner join vistoria_ambientes va on va.id = ve.id_ambiente
            where id_vistoria = '$id_vistoria'
            group by p.id, p.nome ";

    $query = $db->query($sql);
    $query->exec(array());
    $equipamentos = $query->all();

    $sql = "select *, 
            (select count(*) from vistoria_ambiente_arquivos where id_ambiente = va.id and tipo='foto') as fotos,
            (select count(*) from vistoria_ambiente_produtos where id_ambiente = va.id) as equips
            from vistoria_ambientes va
            where id_vistoria = '$id_vistoria' ";

    $query = $db->query($sql);
    $query->exec(array());
    $ambientes = $query->all();


    $riscos = array(
        'Armazenamento de líquidos inflamáveis/combustíveis',
        'Gás Liquefeito de Petróleo',
        'Armazenamento de produtos perigosos',
        'Fogos de artifício',
        'Vaso sob pressão'
    );

    $riscos_vistoria = $db->select('vistoria_riscos', array('id_vistoria' => $id_vistoria))->all();
    $fotos_vistoria  = $db->select('vistoria_fotos', array('id_vistoria' => $id_vistoria))->all();
    $riscos_vistoria = array_map(function($row) { return $row['id_risco']; }, $riscos_vistoria);

    $dados = $db->select("vistoria_dados", array("id_vistoria" => $id_vistoria))->all();
    foreach($dados as $key => $value) {
        $info[$value['campo']] = $value['valor'];
    }

    $documentos = getDocumentos($id_vistoria);

    ob_start();
    include "templates/vistoria.php";
    $markeup = ob_get_contents();
    ob_end_clean();
    $markeup = preg_replace("|\n|", "", $markeup);
    $markeup = preg_replace("|\r|", "", $markeup);
    $markeup = str_replace("  ", " ", $markeup);

    return $markeup;   
}

function parseJsonDemandas($json, &$categorias, &$ambientes, &$assuntos, &$fotos, &$audios, &$obs, &$produtos, &$servicos, &$maodeobras) {
    global $db;

    $demandas = json_decode($json, "ARRAY_A");
    foreach ($demandas as $id_categoria => $demanda) {
        $categorias[] = $db->select("produtos_categorias", array("id" => $id_categoria))->fetch();
        foreach ($demanda as $id_ambiente => $categoria) {
            if ($id_ambiente == '0') {
                $ambs['nome'] = 'generico';
            } else {
                $ambs = $db->select("vistoria_ambientes", array("id" => $id_ambiente))->fetch();
            }
            $ambs['id_categoria'] = $id_categoria;
            $ambs['id_ambiente'] = $id_ambiente;
            $ambientes[] = $ambs;
            foreach ($categoria as $id_assunto => $assunto) {
                $assuntos[] = array(
                    "id"           => $id_assunto,
                    "assunto"      => $assunto['nome'],
                    "id_ambiente"  => $id_ambiente,
                    "id_categoria" => $id_categoria,
                );

                if (!empty($assunto['foto'])) {
                    foreach ($assunto['foto'] as $key => $foto) {
                        $fotos[] = array(
                            "id_arquivo"   => $key,
                            "id_ambiente"  => $id_ambiente,
                            "id_categoria" => $id_categoria,
                            "id_assunto"   => $id_assunto,
                            "arquivo"      => $foto,
                            "tipo"         => "foto",
                        );
                    }
                }

                if (!empty($assunto['audio'])) {
                    foreach ($assunto['audio'] as $key => $audio) {
                        $audios[] = array(
                            "id_arquivo"   => $key,
                            "id_ambiente"  => $id_ambiente,
                            "id_categoria" => $id_categoria,
                            "id_assunto"   => $id_assunto,
                            "arquivo"      => $audio,
                            "tipo"         => "audio",
                        );
                    }
                }

                if (!empty($assunto['obs'])) {
                    foreach ($assunto['obs'] as $key => $observacao) {
                        $obs[] = array(
                            "id"           => $key,
                            "id_ambiente"  => $id_ambiente,
                            "id_categoria" => $id_categoria,
                            "id_assunto"   => $id_assunto,
                            "observacao"   => $observacao,
                        );
                    }
                }

                if (!empty($assunto['servico'])) {
                    foreach ($assunto['servico'] as $id_servico => $qtd) {
                        $servico = $db->select("servicos", array("id" => $id_servico))->fetch();
                        $servicos[] = array(
                            "id_ambiente"  => $id_ambiente,
                            "id_categoria" => $id_categoria,
                            "id_assunto"   => $id_assunto,
                            "id_servico"   => $id_servico,
                            "servico"      => $servico['nome'],
                        );
                    }
                }

                if (!empty($assunto['produto'])) {
                    foreach ($assunto['produto'] as $id_produto => $qtd) {
                        $produto = $db->select("produtos", array("id" => $id_produto))->fetch();
                        $produtos[] = array(
                            "id"           => $id_produto,
                            "qtd"          => $qtd,
                            "id_produto"   => $id_produto,
                            "id_ambiente"  => $id_ambiente,
                            "id_categoria" => $id_categoria,
                            "id_assunto"   => $id_assunto,
                            "produto"      => $produto['nome'],
                        );
                    }
                }

                if (!empty($assunto['maodeobra'])) {
                    foreach ($assunto['maodeobra'] as $maodeobra => $qtd) {
                        $maodeobras[] = array(
                            "qtd"          => $qtd,
                            "maodeobra"    => $maodeobra,
                            "id_ambiente"  => $id_ambiente,
                            "id_categoria" => $id_categoria,
                            "id_assunto"   => $id_assunto,
                        );
                    }
                }
            }
        }
    }
}

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $newname;
}

?>