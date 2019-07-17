<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->MultiCell(0,8,utf8_decode("3.$ordem MANIPULAÇÃO, ARMAZENAMENTO E UTILIZAÇÃO DE GÁS LIQUEFEITO DE PETRÓLEO (GLP) CONFORME IT Nº 28/2011"),0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(8);
$pdf->MultiCell(0,6,utf8_decode("Este item estabelece as medidas de segurança contra incêndio para os locais destinados a manipulação, armazenamento, utilização, instalações internas e centrais de GLP (gás liquefeito de petróleo), atendendo ao previsto no Decreto Estadual nº {$info['decreto']}."),0,'J');

$pdf->Image('images/it28_01.jpg',45,105,120);

$pdf->Ln(65);
$pdf->MultiCell(0,6,utf8_decode("A tubulação não pode fazer parte de elemento estrutural, assim como não pode passar no interior dos seguintes  locais: dutos de lixo, ar condicionado e águas pluviais, reservatório de água, dutos para incineradores de lixo, poços e elevadores, compartimentos de equipamentos elétricos, compartimentos destinados a dormitórios, exceto quando destinada à conexão de equipamento hermeticamente isolado, poços de ventilação capazes de confinar o gás proveniente de eventual vazamento, qualquer vazio ou parede contígua a qualquer vão formado pela estrutura ou alvenaria, ou por estas e o solo, sem a devida ventilação. "),0,'J');

$pdf->Image('images/it28_02.jpg',45,210,120);

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->Ln(50);
$pdf->MultiCell(0,8,utf8_decode("Exigências para recipientes transportáveis de GLP com capacidade de volume até 13 kg de GLP (0,032 m³ ou 32 litros)
Para locais que armazenem, para consumo próprio, cinco ou menos recipientes transportáveis, com massa líquida de até 13 kg de GLP, cheios, parcialmente cheios ou vazios, devem ser observados os seguintes requisitos:"),0,'J');
$pdf->Ln(6);
$pdf->Cell(8,6,"1.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Possuir ventilação natural; "),0,'J');
$pdf->Cell(8,6,"2.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Protegidos do sol, da chuva e da umidade; "),0,'J');
$pdf->Cell(8,6,"3.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Protegidos do sol, da chuva e da umidade; "),0,'J');
$pdf->Cell(8,6,"4.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Estar afastado, no mínimo, 1,5 m de ralos, caixas de gordura e esgotos, bem como de galerias subterrâneas e similares. "),0,'J');
$pdf->Cell(8,6,"5.",0,0);
$pdf->MultiCell(0,6,utf8_decode("A utilização de recipientes com capacidade igual ou inferior a 13 kg de GLP é vedada no interior das edificações, exceto para uso doméstico, nas condições abaixo: "),0,'J');
$pdf->Cell(8,6,"6.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Residências unifamiliares (casas térreas ou assobradadas); "),0,'J');
$pdf->Cell(8,6,"7.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Edificações multifamiliares existentes, de acordo com a legislação do Corpo de Bombeiros;"),0,'J');
$pdf->Cell(8,6,"8.",0,0);
$pdf->MultiCell(0,6,utf8_decode("\"Trailers e barracas\" em eventos temporários;"),0,'J');
$pdf->Cell(8,6,"9.",0,0);
$pdf->MultiCell(0,6,utf8_decode("Nas demais ocupações, limitado a 1 recipiente para consumo, com proteção contra danos mecânicos e físicos;"),0,'J');
$pdf->Cell(8,6,"10.",0,0);
$pdf->MultiCell(0,6,utf8_decode("A mangueira entre o aparelho e o botijão deve ser do tipo metálica flexível, de acordo com normas pertinentes, sendo vedado o uso de mangueira plástica ou borracha."),0,'J');


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "28";

include("pdf-irregularidades.php");

$ordem++;