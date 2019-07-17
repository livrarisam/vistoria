<?php 

$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(163,183,208);

$pdf->Ln(50);
$pdf->Cell(0,8,utf8_decode("3.$ordem. ILUMINAÇÃO DE EMERGÊNCIA: I.T. N°18/2018"),0,0,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->Ln(12);
$pdf->MultiCell(0,6,utf8_decode("Esta Instrução Técnica estabelece as condições necessárias para o projeto e instalação do sistema de iluminação de emergência em edificações e áreas de risco, atendendo ao previsto no Regulamento do Corpo de Bombeiros."),0,'J');
$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("Para efeito desta instrução técnica, são aceitos os seguintes tipos de sistemas de iluminação de emergência:"),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- CONJUNTO DE BLOCOS AUTÔNOMOS;"),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- SISTEMA CENTRALIZADO COM BATERIAS RECARREGÁVEIS;"),0,'J');
$pdf->MultiCell(0,6,utf8_decode("- SISTEMA CENTRALIZADO COM GRUPO MOTOGERADOR COM ARRANQUE AUTOMÁTICO."),0,'J');

$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("O sistema de iluminação de emergência deve:"),0,'J');
$pdf->Cell(5,6,"",0,0);
$pdf->MultiCell(0,6,utf8_decode("a. Permitir o controle visual das áreas abandonadas para que seja possível localizar pessoas impedidas de locomoverem-se;"),0,'J');
$pdf->Cell(5,6,"",0,0);
$pdf->MultiCell(0,6,utf8_decode("b. Proteger a segurança patrimonial e facilitar a localização de pessoas indesejadas pelo pessoal da intervenção;"),0,'J');
$pdf->Cell(5,6,"",0,0);
$pdf->MultiCell(0,6,utf8_decode("c. Sinalizar, de forma inequívoca, as rotas de fuga utilizáveis, no momento do abandono de cada local;"),0,'J');
$pdf->Cell(5,6,"",0,0);
$pdf->MultiCell(0,6,utf8_decode("d. Sinalizar o topo do prédio para a aviação civil e militar."),0,'J');

$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("Em casos especiais, a iluminação de emergência deve garantir, sem interrupção, os serviços de primeiros socorros, de controle aéreo, marítimo, ferroviário e serviços essenciais instalados no edifício com falta de iluminação."),0,'J');
$pdf->Ln(6);
$pdf->MultiCell(0,6,utf8_decode("No caso de abandono total do edifício, o tempo da iluminação deve incluir o tempo previsto para a evacuação e o tempo necessário para que o pessoal da intervenção localize pessoas perdidas ou sem possibilidade de abandonar o local por meios próprios. Esses valores devem estar contidos na documentação de segurança do edifício, aprovada pelo usuário e pelo poder público."),0,'J');
$pdf->MultiCell(0,6,utf8_decode("As regras para projetar e instalar qualquer tipo de sistema de iluminação de emergência nas edificações ou áreas de risco deverá atender aos prescritos na NBR-10898 da ABNT, em vigor desde o dia 14/04/2013."),0,'J');


$pdf->AddPage();
$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
$pdf->Image('images/rodape_email.jpg',10,255,190);

$starty = 73;
$tamanho = 180;
$it = "18";

include("pdf-irregularidades.php");

$ordem++;