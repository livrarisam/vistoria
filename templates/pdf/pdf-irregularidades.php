<?php 

if (empty($linha)) $linha = 50;
if (empty($tamanho)) $tamanho = 160;

$pdf->SetFont('Arial','B',12);
$pdf->setFillColor(220,220,220);
$pdf->Ln($linha);
$pdf->Cell(0,8,utf8_decode("IRREGULARIDADES PERANTE A IT $it/2018"),'R,T,L',0,'C',1);
$pdf->Ln(8);
$pdf->Cell(0,$tamanho,utf8_decode(""),'R,T,L,B',0,'C');
$pdf->Ln(67);

$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(88,3,89));

$irregs = array();
foreach ($ambientes as $ambiente) {
	if ($ambiente['id_categoria'] != $categoria['id']) continue;
  foreach ($assuntos as $assunto) {
    if($assunto['id_categoria'] != $categoria['id'] || $assunto['id_ambiente'] != $ambiente['id_ambiente']) continue;	
    $hassunto = explode(" - ", $assunto['assunto']);
    if (!empty($hassunto[1]))
        $nassunto = $hassunto[1];
    else
        $nassunto = $hassunto[0];
		foreach ($fotos as $foto) {
			if ($foto['id_assunto'] != $assunto['id'] || $foto['id_ambiente'] != $ambiente['id_ambiente']) continue;
			$foto['ambiente'] = $ambiente['nome'];
			$foto['assunto'] = $nassunto;
			$foto['categoria'] = $categoria['it'];
			$irregs[] = $foto;
		}
	}
}

$y = $starty;
foreach ($irregs as $i => $irreg) {
	$foto = $irreg;
	if ($i == 0 || $i % 2 == 0) {
		if ($i != 0 && $i % 4 == 0) {
			$newpage = true;
			$y = 73;
			$pdf->AddPage();
			$pdf->Image('images/logo_ci_topo.jpg',80,10,50);
			$pdf->Image('images/rodape_email.jpg',10,255,190);

			$pdf->SetFont('Arial','B',12);

			$pdf->setFillColor(220,220,220);
			$pdf->Ln(50);
			$pdf->Cell(0,8,utf8_decode("IRREGULARIDADES PERANTE A IT $it/2011"),'R,T,L',0,'C',1);
			$pdf->Ln(8);
			$pdf->Cell(0,180,utf8_decode(""),'R,T,L,B',0,'C');
			$pdf->Ln(67);		
			$pdf->SetFont('Arial','',10);
		} else {
			$newpage = false;
		}

		$pdf->Image($foto['arquivo'],15,$y,88,55);
		$pdf->Text(15, $y+60, "Ambiente: " . utf8_decode($foto['ambiente']));
		if (empty($irregs[$i+1])) {
			$pdf->Cell(4,9,"",0,0);
			$pdf->Row(array(utf8_decode($foto['assunto'])));
		} else {
			$prevassunto = $foto['assunto'];
		}
	} elseif ($i % 2 != 0) {
		$pdf->Image($foto['arquivo'],105,$y,88,55);
		$pdf->Text(106, $y+60, "Ambiente: " . utf8_decode($foto['ambiente']));
		$pdf->Cell(4,9,"",0,0);
		$linesize = (strlen($prevassunto) > strlen($foto['assunto'])) ? strlen($prevassunto) : strlen($foto['assunto']);
		$pdf->Row(array(utf8_decode($prevassunto), '', utf8_decode($foto['assunto'])));
		if (!$newpage) {
			$y += 80;
			if ($linesize > 100)
				$pdf->Ln(67);
			elseif ($linesize < 57)
				$pdf->Ln(78);
			else
				$pdf->Ln(70);
		} else {
			$y += 83;
			if ($linesize > 100)
				$pdf->Ln(70);
			elseif ($linesize < 57)
				$pdf->Ln(78);
			else
				$pdf->Ln(73);
		}
	}
}
