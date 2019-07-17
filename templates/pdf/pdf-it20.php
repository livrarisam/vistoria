<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. SINALIZAÇÃO DE EMERGÊNCIA: I.T. N°20/2011"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Este item estabelece as condições exigíveis que devem satisfazer o sistema de sinalização de emergência em edificações e áreas de risco, atendendo ao previsto no Regulamento do Corpo de Bombeiros, com o objetivo de reduzir o risco de ocorrência de incêndio, alertando para os riscos existentes e garantir que sejam adotadas ações adequadas à situação de risco, que orientem as ações de combate e facilitem a localização dos equipamentos e das rotas de saída para abandono seguro da edificação em caso de incêndio."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Este item estabelece as condições exigíveis que devem satisfazer o sistema de sinalização de emergência em edificações e áreas de risco, atendendo ao previsto no Regulamento do Corpo de Bombeiros, com o objetivo de reduzir o risco de incêndio, e ainda, o risco de aprisionamento humano no caso de sinistro no imóvel. "),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Os alertas de sinalização atentam a população para os riscos especiais existentes e garantem que sejam adotadas ações adequadas à situação de risco, orientando as ações de combate e facilitando a localização dos equipamentos e das rotas de saída para abandono seguro da edificação em caso de incêndio. "),0,'J');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,utf8_decode("3.$ordem.1. SINALIZAÇÃO DE SAIDAS DE ROTAS DE FUGA"),0,0);
$pdf->SetFont('Arial','',10);
$pdf->Ln(8);
$pdf->Cell(5,6,"a.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Deve-se obedecer a Simbologia para a Sinalização conforme IT 20/2011 do Decreto Estadual nº. {$info['decreto']}ABNT, NBR 13434-1, ABNT NBR 13434-2 e ABNT NBR 13434-3, conforme demonstrado a seguir:"),0,'J');

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Image('images/it20_01.jpg',40,60,140);


$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Image('images/it20_02.jpg',50,60,40);
$pdf->Image('images/it20_03.jpg',110,60,40);

$pdf->Ln(125);
$pdf->Cell(0,8,utf8_decode("Figura 5: Sinalização de portas com barras anti-pânico (modelos 1 e 2)"),0,0,'C');

$pdf->Image('images/it20_04.jpg',60,150,90);

$pdf->Ln(90);
$pdf->Cell(0,8,utf8_decode("Figura 6: Sinalização de saída sobre verga de portas - Sinalização complementar de saídas e obstáculos"),0,0,'C');

$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Image('images/it20_05.jpg',60,60,90);

$pdf->Ln(120);
$pdf->Cell(0,8,utf8_decode("Figura 7: Sinalização de saída sobre paredes e vergas de portas"),0,0,'C');

$pdf->Image('images/it20_06.jpg',60,150,90);

$pdf->Ln(90);
$pdf->Cell(0,8,utf8_decode("Figura 8: Sinalização de saída perpendicular ao sentido da fuga, em dupla face."),0,0,'C');

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);
$pdf->SetFont('Arial','',10);

$pdf->Image('images/it20_07.jpg',60,60,90);

$pdf->Ln(120);
$pdf->Cell(0,8,utf8_decode("Figura 9: Sinalização de saída no sentido da fuga, em dupla face."),0,0,'C');

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(12);
$pdf->Cell(0,8,utf8_decode("3.$ordem.2. SINALIZAÇAO DE EXTINTORES"),0,0);$pdf->Ln(6);

$pdf->SetFont('Arial','',10);
$pdf->Ln(8);
$pdf->Cell(5,6,"a.",0,0);
$pdf->MultiCell(0,6,utf8_decode("As Sinalizações dos extintores devem atender aos seguintes critérios de instalação, conforme demonstrado abaixo:"),0,'J');
$pdf->Image('images/it20_08.jpg',30,165,71);
$pdf->Image('images/it20_09.jpg',102,165,61);

$pdf->Ln(50);
$pdf->Cell(5,6,"b.",0,0);
$pdf->MultiCell(0,6,utf8_decode("As sinalizações de piso devem ser reparadas sempre que necessário;"),0,'J');
$pdf->Cell(5,6,"c.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Quando os equipamentos ficarem atrás de pilares, cantos de parede, escadas e demais situações que fiquem ocultos, a sinalização deve apontar nestes locais a direção onde estão os equipamentos."),0,'J');
$pdf->Cell(5,6,"d.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Deve-se obedecer a Simbologia para a Sinalização conforme IT 20/2011 do Decreto Estadual nº. {$info['decreto']}, ABNT NBR 13434-1, ABNT NBR 13434-2 e ABNT NBR 13434-3, conforme demonstrado a seguir:"),0,'J');

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);
$pdf->SetFont('Arial','',10);

$pdf->Image('images/it20_10.jpg',35,60,140);

$pdf->Image('images/it20_11.jpg',35,140,140);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);
$pdf->SetFont('Arial','B',11);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem.3. SINALIZAÇÃO DE LOCAIS ENERGIZADOS E RISCOS ESPECIAIS"),0,0);$pdf->Ln(6);

$pdf->SetFont('Arial','',10);
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Todos os quadros de distribuição de energia existentes no edifício devem estar sinalizados conforme ABNT NBR 13434-1, ABNT NBR 13434-2 e ABNT NBR 13434-3."),0,'J');
$pdf->Ln(4);
$pdf->MultiCell(0,6,utf8_decode("Deve-se obedecer a Simbologia para a Sinalização conforme ABNT NBR 13434-1, ABNT NBR 13434-2 e ABNT NBR 13434-3, como demonstrado a seguir:"),0,'J');

$pdf->Image('images/it20_12.jpg',50,100,120);

$pdf->SetFont('Arial','B',12);
$pdf->Ln(70);
$pdf->Cell(0,8,utf8_decode("3.$ordem.4. DETECÇÃO E ALARME DE INCÊNDIO"),0,0);$pdf->Ln(6);
$pdf->SetFont('Arial','',10);

$pdf->Ln(8);
$pdf->MultiCell(0,6,utf8_decode("DEVE-SE obedecer a Simbologia para a Sinalização conforme IT 20/2011 do Decreto Estadual nº. {$info['decreto']}, ABNT NBR 13434-1, ABNT NBR 13434-2 e ABNT NBR 13434-3, conforme demonstrado a seguir:"),0,'J');

$pdf->Image('images/it20_13.jpg',50,200,120);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);
$pdf->SetFont('Arial','B',11);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem.5. HIDRANTES"),0,0);$pdf->Ln(6);
$pdf->SetFont('Arial','',10);

$pdf->Ln(8);
$pdf->MultiCell(0,6,utf8_decode("DEVE-SE obedecer a Simbologia para a Sinalização conforme IT 20/2011 do Decreto Estadual nº. {$info['decreto']}, ABNT NBR 13434-1, ABNT NBR 13434-2 e ABNT NBR 13434-3, conforme demonstrado a seguir:"),0,'J');

$pdf->Image('images/it20_14.jpg',35,90,140);


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);
$pdf->SetFont('Arial','',10);

$starty = 73;
$tamanho = 180;
$it = "20";

include("pdf-irregularidades.php");

$ordem++;