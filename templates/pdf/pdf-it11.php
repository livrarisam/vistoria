<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. SAÍDAS DE EMERGÊNCIA: I.T. N°11/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica estabelece os requisitos mínimos necessários para o dimensionamento das saídas de emergência, no intuito de que sua população possa abandonar a edificação em caso de incêndio ou pânico, completamente protegida em sua integridade física. Além disso, o atendimento a esta IT garante o acesso de guarnições de bombeiros para o combate ao fogo ou retirada de pessoas, atendendo o previsto no Regulamento do Corpo de Bombeiros."),0,'J');
$pdf->MultiCell(0,6,utf8_decode("Em suma, esta norma dispõe sobre a quantidade e tipo de saídas e acessos necessários, considerando suas características físicas, ocupação e lotação, tais como: portas, escadas, rampas, elevadores, corredores de circulação, etc."),0,'J');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,utf8_decode("3.$ordem.1. Escadas"),0,0);

$pdf->SetFont('Arial','',10);
$pdf->Ln(8);
$pdf->MultiCell(0,6,utf8_decode("Todas as escadas devem possuir corrimão contínuo em toda sua extensão, e com as extremidades voltadas para a parede. As escadas deverão dispor de corrimão, instalado entre 0,80m e 0,92m de altura, conforme as seguintes especificações:"),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- Apenas de um lado, para escadas secundárias com largura inferior a 1,00m;"),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- De ambos os lados, para escada com largura igual ou superior a 1,00m;"),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- Intermediário, quando a largura for igual ou superior a 2,40m de forma a garantir largura máxima de 1,20m para cada lance."),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- Quando as escadas não estiverem confinadas por paredes, as mesmas deverão possuir guarda-corpos com altura mínima de 1,05m, que podem ser construídos de alvenaria, concreto, divisórias levas, grades balaustradas, grades com longarinas horizontais, etc. As especificações de resistência dos guarda-corpos e distanciamentos mínimos de elementos estão dispostas nas figuras a seguir:"),0,'J');

$pdf->Image('images/it11_01.jpg',24,200,60);
$pdf->Image('images/it11_02.jpg',115,200,60);

$pdf->Ln(52);
$pdf->Cell(90,8,utf8_decode("Figura 1: Exemplo instalação de corrimão"),0,0,'C');
$pdf->Cell(90,8,utf8_decode("Figura 2: Exemplo instalação de corrimão"),0,0,'C');


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Image('images/it11_03.jpg',30,60,140);
$pdf->Ln(160);
$pdf->Cell(0,8,utf8_decode("Figura 3: Pormenores construtivos da instalação de guardas e as cargas a que elas devem resistir"),0,0,'C');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,utf8_decode("3.$ordem.2. ROTAS DE FUGA"),0,0);
$pdf->SetFont('Arial','',10);
$pdf->Ln(8);
$pdf->MultiCell(0,6,utf8_decode("As larguras mínimas das saídas de emergência, em qualquer caso, devem ser de 1,2 m, para as ocupações em geral. A largura deve ser medida em sua parte mais estreita, não sendo admitidas saliências de alisares, pilares e outros, com dimensões maiores que as indicadas na Figura 4."),0,'J');

$pdf->Image('images/it11_04.jpg',50,210,120);

$pdf->Ln(45);
$pdf->Cell(0,8,utf8_decode("Figura 4: Medida da largura em corredores e passagens"),0,0,'C');



$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','',10);
$pdf->setFillColor(220,220,220);
$pdf->Ln(50);
$pdf->MultiCell(0,6,utf8_decode("As distâncias máximas a serem percorridas para atingir as portas de acesso às saídas das edificações e o acesso às escadas ou às portas das escadas (nos pavimentos) constam da Tabela 2 (Anexo \"B\") e devem ser consideradas a partir da porta de acesso da unidade autônoma mais distante, desde que o seu caminhamento interno não ultrapasse 10 m."),0,'J');

$starty = 99;
$linha = 4;
$tamanho = 165;
$it = "11";

include("pdf-irregularidades.php");

$ordem++;