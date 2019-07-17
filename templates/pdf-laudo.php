<?php 
require('pdf_mc_table.php');

$pdf = new PDF_MC_Table();

$pdf->SetMargins(0,0,0);
$pdf->SetAutoPageBreak(true,0);

$pdf->AddPage();
$pdf->Image('images/logo_ci_grande.jpg',5,20,199);
$pdf->Ln(236);
$pdf->SetFont('Arial','',12);



$pdf->Ln(8);
$pdf->Cell(0,8," ",0,0);
$pdf->setFillColor(32,56,100);
$pdf->SetFont('Arial','',4)
;$pdf->Ln(1);
$pdf->Cell(0,1," ",0,0,0,1);
$pdf->setFillColor(222,235,246);
$pdf->Ln(1);
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,5," ",0,0,0,1);
$pdf->Ln(5);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,8,utf8_decode("Laudo Técnico Fotográfico de"),0,0,'C',1);
$pdf->Ln(8);
$pdf->Cell(0,8,utf8_decode("Adequações"),0,0,'C',1);
$pdf->SetFont('Arial','',12);
$pdf->Ln(8);
$pdf->Cell(0,10,utf8_decode($cliente['razao_social']),0,0,'C',1);
$pdf->Ln(10);
$pdf->Cell(0,10,utf8_decode($endereco['endereco'] . ', ' . $endereco['numero'] . ' ' . $endereco['cidade'] . ' - ' . $endereco['uf']),0,0,'C',1);
$pdf->Ln(10);

setlocale(LC_ALL, null);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$mes = ucfirst(strftime('%B', time()));

$pdf->Cell(0,10,utf8_decode("$mes de 2019"),0,0,'C',1);

$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,10);

$pdf->setFillColor(220,220,220);
$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255, 190);

$pdf->Ln(50);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode("DADOS GERAIS"),'R,L,T',0,'C',1);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,utf8_decode("Data da vistoria técnica: "),'L,T',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(140,8,utf8_decode(date('d/m/Y')),'R,T',0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,utf8_decode("Revisão: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(170,8,utf8_decode("00"),'R',0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,utf8_decode("Finalidade do Trabalho: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(140,8,utf8_decode("Assessoria Técnica para orientação quanto às adequações necessárias"),'R',0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8," ",'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(140,8,utf8_decode("para renovação do Auto de Vistoria do Corpo de Bombeiros."),'R',0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(48,8,utf8_decode("Responsável Técnico: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(142,8,utf8_decode("Junio Roberto do Nascimento - CAU/SP A 36258-1"),'R',0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(48,8,utf8_decode("Analista Responsável: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(142,8,utf8_decode($analista),'R',0,'L');


$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode("DADOS DO IMÓVEL"),'R,L,T',0,'C',1);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("Referência: "),'L,T',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($cliente['razao_social']),'R,T',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("Ocupação: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($info['uso_descricao']),'R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("CNPJ: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($cliente['cnpj']),'R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("Endereço: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($endereco['endereco'] . ', ' . $endereco['numero']),'R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("Município: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($endereco['cidade']),'R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("Estado: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($endereco['uf']),'R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,6,utf8_decode("CEP: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(160,6,utf8_decode($endereco['cep']),'R',0,'L');
$pdf->Ln(6);
$pdf->Cell(0,6," ",'L,R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(33,6,utf8_decode("Nº Pavimentos: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(157,6,utf8_decode($info['pavimentos']),'R',0,'L');
$pdf->Ln(6);
$pdf->Cell(0,6," ",'L,R',0,'L');
if (!empty($info['iptu'])) {
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(15,6,utf8_decode("IPTU: "),'L',0,'L');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(175,6,utf8_decode($info['iptu']),'R',0,'L');
}
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(15,6,utf8_decode("Área: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(175,6,utf8_decode($info['area_construida'] . " m²"),'R',0,'L');
$pdf->Ln(6);
$pdf->Cell(0,6," ",'L,R',0,'L');
if (!empty($info['numero_avcb'])) {
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(35,6,utf8_decode("AVCB Anterior: "),'L',0,'L');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(155,6,utf8_decode($info['numero_avcb']),'R',0,'L');
}
$pdf->Ln(6);
$pdf->Cell(0,6," ",'L,R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,6,utf8_decode("Proprietário do Imóvel: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(140,6,utf8_decode($info['proprietario']),'R',0,'L');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,6,utf8_decode("Responsável pelo Uso: "),'L',0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(140,6,utf8_decode($cliente['razao_social']),'R',0,'L');
$pdf->Ln(6);
$pdf->Cell(0,6," ",'L,R,B',0,'L');


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->setFillColor(163,183,208);
$pdf->Ln(55);
$pdf->Cell(0,8,"1. Objetivo",0,0,'C',1);

$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Este relatório tem como objetivo avaliar as condições dos sistemas de proteção contra incêndio do imóvel, conforme acervo fotográfico obtido em 13/04/2018, observando suas características físicas, no intuito de avaliar se estão em conformidade legal em relação ao Decreto Estadual nº {$info['decreto']} do Corpo de Bombeiros do Estado de São Paulo."),0,'J');

$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("Reiteramos que o Decreto {$info['decreto']} dispõe sobre as medidas de segurança contra incêndio nas edificações e áreas de risco no Estado de São Paulo, objetivando proteger a vida dos ocupantes ocupantes das edificações, dificultar a propagação do incêndio, proporcionar meios de controle e extinção de incêndio, dar condições de acesso para as operações do Corpo de Bombeiros e proporcionar a continuidade dos serviços nas edificações e áreas de risco após um sinistro."),0,'J');

$pdf->Ln(6);
$pdf->Cell(0,8,utf8_decode("2. Características Legais"),0,0,'C',1);

$pdf->Ln(12);
$pdf->Cell(0,6,utf8_decode("O Imóvel em estudo está situado na " . $endereco['endereco'] . ', ' . $endereco['numero'] . ' ' . $endereco['cidade'] . ' - ' . $endereco['uf']),0,0);

$pdf->Ln(6);
$pdf->Cell(0,8," ",0,0);

$pdf->SetFont('Arial','B',12);
$pdf->Ln(6);
$pdf->Cell(0,6,utf8_decode("Fachada do imóvel"),0,0,'C');

$pdf->Image($uploads_path . $info['foto_fachada'],45,175,120);

$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Ln(55);
$pdf->MultiCell(0,6,utf8_decode("A Legislação de Proteção Contra Incêndio em vigor no Estado de São Paulo é o Decreto Estadual {$info['decreto']}."),0,'J');

$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("A supracitada legislação prevê que o imóvel seja inicialmente classificado perante a sua ocupação. Constatamos, conforme enquadramento legal que se trata de uma edificação com atividade ({$info['uso_descricao']})."),0,'J');

$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("Altura da edificação é considerada {$info['altura']}. Lembrando que, a altura se dá do piso mais alto até o piso de saída da edificação."),0,'J');

$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("A carga de incêndio é considerada de risco {$info['risco']}."),0,'J');

$ordem = 1;
foreach ($categorias as $categoria) {
	$linha = 50;
	$tamanho = 160;
	$itname = explode(" - ", $categoria['it'], 2);
	$itnro = str_replace("IT", "", $itname[0]);
	if (is_file("templates/pdf/pdf-it$itnro.php")) {
		include "templates/pdf/pdf-it$itnro.php";
	}
}

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);

$pdf->setFillColor(163,183,208);
$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("4. RECOMENDAÇÕES DE SEGURANÇA"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Manutenção das salas técnicas de modo a permanecerem sempre limpas e organizadas, evitando-se acidentes;"),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Manter as rotas de fuga sempre desobstruídas, não promovendo o armazenamento de materiais de escritório, vasos e quaisquer objetos que possam vir a colocar em risco a vida dos ocupantes da edificação em caso de incêndio;"),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Manter os extintores desobstruídos para melhor manuseio, caso necessário."),0,'J');

$pdf->SetFont('Arial','B',12);
$pdf->Ln(12);
$pdf->Cell(0,8,utf8_decode("5. ATESTADOS E DOCUMENTOS"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Para a solicitação de vistoria junto ao Corpo de Bombeiros para a renovação do AVCB, considerando-se a metragem total da edificação, {$info['area_construida']} m², será necessária a apresentação dos seguintes atestados técnicos emitidos por profissionais habilitados com as respectivas ARTs/RRTs, como segue:"),0,'J');

foreach ($arts as $art) {
	$pdf->Ln(8);
	$pdf->Cell(0,6,utf8_decode($art['art']),0,0);
}

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);

$pdf->setFillColor(163,183,208);
$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("6. CONCLUSÃO E ENCERRAMENTO"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Findamos este relatório diagnóstico, composto por ".$pdf->PageNo()." páginas, objetivando o enquadramento da edificação em relação ao Decreto do Corpo de Bombeiros em vigor, Decreto {$info['decreto']}."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Neste relatório procuramos abordar as principais irregularidades levantadas em vistoria, as compatibilizando com a documentação enviada, com o intuito de obter o AVCB do imóvel."),0,'J');

if (empty($projeto)) {
	$pdf->Ln(4);
	$pdf->MultiCell(0,6,utf8_decode("Este relatório não possui subsídio do projeto aprovado, portanto contempla apenas as condições dos equipamentos e orientação superficial."),0,'J');
}

$pdf->SetFont('Arial','B',12);
$pdf->Ln(40);

$pdf->Image('images/junio.jpg',120,130,60);

$pdf->Cell(0,8,utf8_decode("Junio Roberto do Nascimento"),0,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Ln(10);
$pdf->Cell(0,8,utf8_decode("Responsavel Técnico"),0,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Ln(10);
$pdf->Cell(0,8,utf8_decode("CAU/SP - A 36258-1"),0,0,'R');

$pdf->Output();