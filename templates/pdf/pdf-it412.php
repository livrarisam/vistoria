<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. INSPEÇÃO VISUAL EM INSTALAÇÕES ELÉTRICAS DE BAIXA TENSÃO  - IT 41"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta instrução técnica estabelece os parâmetros para a realização de inspeção visual (básica) das instalações elétricas de baixa tensão das edificações e áreas de risco, atendendo às exigências do Decreto Estadual nº {$info['decreto']}."),0,'J');
$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("Nas linhas elétricas em que os cabos forem fixados diretamente em paredes ou tetos, só devem ser usados cabos unipolares ou multipolares. Os condutores isolados só são admitidos em condutos fechados, ou em perfilados, conforme norma NBR 5410/04."),0,'J');

$pdf->Image('images/it41.jpg',55,110,90);

$pdf->Ln(95);
$pdf->MultiCell(0,6,utf8_decode("Como regra geral, todos os circuitos devem dispor de dispositivos de proteção contra sobrecorrentes (sobrecarga e curto-circuito)."),0,'J');
$pdf->MultiCell(0,6,utf8_decode("As partes vivas acessíveis a pessoas que não sejam advertidas (BA4) ou qualificadas (BA5) devem estar isoladas e/ou protegidas por barreiras ou invólucros."),0,'J');
$pdf->MultiCell(0,6,utf8_decode("Todo circuito deve dispor de condutor de proteção \"fio-terra\" em toda sua extensão. Um condutor de proteção pode ser comum a mais de um circuito. E todas as massas da instalação devem estar ligadas a condutores de proteção."),0,'J');
$pdf->MultiCell(0,6,utf8_decode("Todas as tomadas de corrente fixas das instalações devem ser do tipo com polo de aterramento (2 polos + terra, ou 3 polos + terra)."),0,'J');

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Ln(50);
$pdf->MultiCell(0,6,utf8_decode("Os quadros de distribuição devem ser instalados em locais de fácil acesso e serem providos de identificação do lado externo, legível e não facilmente removível. Além disso, conforme requisito da IT 20/11 - Sinalização de segurança, deve ser afixada, no lado externo dos quadros elétricos, sinalização de alerta."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Todos os componentes dos quadros devem ser identificados de tal forma que a correspondência entre os componentes e os respectivos circuitos possa ser prontamente reconhecida. Essa identificação deve ser legível, indelével, posicionada de forma a evitar risco de confusão e corresponder à notação adotada no projeto."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Os circuitos dos serviços de segurança devem ser independentes de outros circuitos."),0,'J');


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$it = "41";

include("pdf-irregularidades.php");

$ordem++;