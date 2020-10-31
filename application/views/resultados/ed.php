<?php
	$pdf->SetCreator('EP');
	$pdf->SetAuthor('EP');
	$pdf->SetTitle('Encuestas Doc');
	$pdf->SetSubject('');
	$pdf->SetKeywords('');
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	$path_logo=PATH_PDF_IMAGES."unsta_header.png";
	// $path_logo="http://localhost:81/encuestas/ng/be/images/unsta_header.png";
	//$path_logo="C:\xampp\htdocs\encuestas\ng\be\images\unsta_header";

	$pdf->SetHeaderData(PDF_HEADER_LOGO, 0,'Encuestas 2019     Resultados Docentes', '');
	// $pdf->SetHeaderData("image.jpg", PDF_HEADER_LOGO_WIDTH, "Application PDF", "Application Form\nRaining Pesos, Inc. - www.rainingpesos.com");

	

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	
	$pdf->AddPage();
	

	$pdf->Image($path_logo, 158, 2, 40, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);



//----------------------------- CABECERA ----------------------
	
	$col1=20;
	$col2=10;
	$col3=$col1;
	$h=5;

	$row_att=30;
	$row_dato=60;
	$row=$row_att+$row_dato;
	
	$pdf->Cell($row,0,'','LTR',1,'LT');

	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell($row_att,0,'Período:','L',0);
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell($row_dato,0,$datos['cabecera']['periodo'],'R',1);

	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell($row_att,0,'Unidad Académica:','L',0,'L');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell($row_dato,0,$datos['cabecera']['ua'],'R',1,'LR');

	// $pdf->Cell(70,0,'','LR',1,'L');
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell($row_att,0,'Docente:','L',0,'L');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell($row_dato,0,$datos['cabecera']['docente'],'R',1,'L');

	$pdf->Cell($row,0,'','LBR',0,'R');

	// echo "<pre>".print_r($datos,true)."</pre>";
 	//            die();
	



//------------------------ TIPO DE RESPUESTA SI,NO,MB,B,R,M ------------------------


	foreach ($datos['preguntas'] as $key_pregunta => $value_pregunta) { // recorre las preguntas del arreglo
		switch ($value_pregunta['tipo']) {
			case 1:

					//	SI, NO

					$col1=30;
					$col2=60;
					$col3=55;
					$col_s=2;
					$col_n=8;
					$col_e=12;
					$h=5;
					$col_t=5; 
					$col_l=9;
					$col_a=45;
					$col_t=5;
					$col_p=118; 

					$pdf->Ln(10);


					$pdf->SetFont('helvetica','B',9);
					$pdf->SetFillColor(225,225,225);
					$pdf->Cell($col_p,0,$value_pregunta['txt'],'TBLR',1,'L',1);

					$pdf->SetFont('helvetica', 'B', 8);
					$pdf->Cell($col_l,$h,'Sede','BLT',0,'L',false);
					$pdf->Cell($col3,$h,'Oferta Educativa','TB',0,'L',false);
					$pdf->Cell($col_l,$h,'Cod','BT',0,'L',false);
					$pdf->Cell($col_a,$h,'Asignatura','BRT',0,'L',false);
					//$pdf->Cell(112,$h,'','',0,'C',0);
					$pdf->SetFillColor(225,225,225);
					$pdf->SetFont('helvetica', 'B', 8);
					//$pdf->Cell($col_s,$h,'',0,1,'L',true);
					$pdf->Cell($col_n,$h,'SI','LTRB',0,'C',1);
					$pdf->Cell($col_n,$h,'NO','LTRB',0,'C',1);
					$pdf->Cell($col_n,$h,'NR','LTRB',0,'C',1);
					$pdf->Cell($col_n,$h,'Resp','LTRB',0,'C',1);
					$pdf->Cell($col_n,$h,'G','LTRB',1,'C',1);
					//$pdf->Cell($col_s,$h,'',0,1,'L',true);
					break;

			case 2:

				//	MB,B,R,M


				$col1=30;
				$col2=60;
				$col3=55;
				$col_s=2;
				$col_n=8;
				$col_e=10;
				$h=5;
				$col_t=5; 
				$col_l=9;
				$col_a=45;
				$col_t=5;
				$col_p=118; 
				

				$pdf->Ln(10);


				$pdf->SetFont('helvetica','B',9);
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell($col_p,0,$value_pregunta['txt'],'TBLR',1,'L',1);

					
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->Cell($col_l,$h,'Sede','BLT',0,'L',false);
				$pdf->Cell($col3,$h,'Oferta Educativa','TB',0,'L',false);
				$pdf->Cell($col_l,$h,'Cod','BT',0,'L',false);
				$pdf->Cell($col_a,$h,'Asignatura','BRT',0,'L',false);
				//$pdf->Cell(112,$h,'','',0,'C',0);
				$pdf->SetFillColor(225,225,225);
				$pdf->SetFont('helvetica', 'B', 8);
				//$pdf->Cell($col_s,$h,'',0,1,'L',true);
				$pdf->Cell($col_n,$h,'MB','LTRB',0,'C',1);
				$pdf->Cell($col_n,$h,'B','LTRB',0,'C',1);
				$pdf->Cell($col_n,$h,'R','LTRB',0,'C',1);
				$pdf->Cell($col_n,$h,'M','LTRB',0,'C',1);
				$pdf->Cell($col_n,$h,'NR','LTRB',0,'C',1);
				$pdf->Cell($col_n,$h,'Resp','LTRB',0,'C',1);
				$pdf->Cell($col_e,$h,'Eval','LTRB',0,'C',1);
				$pdf->Cell($col_n,$h,'G','LTRB',1,'C',1);
				//$pdf->Cell($col_s,$h,'',0,1,'L',true);

		} // end switch

	//---------------------------------- Porcentajes -----------------------------------------

	/*$mb_fila=0;
	$b_fila=0;
	$r_fila=0;
	$m_fila=0;
	$nc_fila=0;
	$si_fila=0;
	$no_fila=0;
	$t=0;
	$mb=0;
	$b=0;
	$r=0;
	$m=0;*/

	$mb=0;
	$b=0;
	$r=0;
	$m=0;
	$nc=0;
	$si=0;
	$no=0;
	$t=0;
	

	foreach ($value_pregunta['resultado'] as $key_resultado => $value_resultado) { // recorre los resultados de las pregutnas
		switch ($value_pregunta['tipo']) {
			case 1:	

				$si_fila=(array_key_exists('Si',$value_resultado) && $value_resultado['Si']!=NULL)?$value_resultado['Si']:0;
				$no_fila=(array_key_exists('No',$value_resultado) && $value_resultado['No']!=NULL)?$value_resultado['No']:0;
				$nc_fila=0;
				

				$c_fila=$si_fila+$no_fila; //resp

				if($c_fila!=0)
					$eval_fila=round(($mb_fila*9.5+$b_fila*7+$r_fila*5.5+$m_fila*2)/$c_fila,2);
				else
					$eval_fila=0;
				switch (true) {
					case $eval_fila>9:
						$g_fila=1;
						break;
					case $eval_fila<9 && $eval_fila>=7:
						$g_fila=2;
						break;
				}

				$pdf->SetFont('helvetica', '', 7);
				$pdf->Cell($col_l,$h,$value_resultado['sede'],'BL',0,'C');
				$pdf->Cell($col3,$h,$value_resultado['oe'],'B',0,'L');
				$pdf->Cell($col_l,$h,$value_resultado['cod'],'B',0,'L');
				$pdf->Cell($col_a,$h,$value_resultado['asignatura'],'BR',0,'L');
				//$pdf->Cell(108,$h,'','',0,'C',0);
				$pdf->Cell($col_n,$h,$si_fila,'LTRB',0,'C',0); //SI
				$pdf->Cell($col_n,$h,$no_fila,'LTRB',0,'C',0); //NO
				$pdf->Cell($col_n,$h,$nc_fila,'LTRB',0,'C',0); //NR
				$pdf->Cell($col_n,$h,$c_fila,'LTRB',0,'C',0); //RESP
				$pdf->Cell($col_n,$h,1,'LTRB',1,'C',0); //G

				$t+=$si_fila+$no_fila;

				
					
			break;	

			case 2:
				
				$mb_fila=(array_key_exists('MB',$value_resultado) && $value_resultado['MB']!=NULL)?$value_resultado['MB']:0;
				$b_fila=(array_key_exists('B',$value_resultado) && $value_resultado['B']!=NULL)?$value_resultado['B']:0;
				$r_fila=(array_key_exists('R',$value_resultado) && $value_resultado['R']!=NULL)?$value_resultado['R']:0;
				$m_fila=(array_key_exists('M',$value_resultado) && $value_resultado['M']!=NULL)?$value_resultado['M']:0;
				$nc_fila=(array_key_exists('NC',$value_resultado) && $value_resultado['NC']!=NULL)?$value_resultado['NC']:0;
				
				$c_fila=$mb_fila+$b_fila+$r_fila+$m_fila;


				if($c_fila!=0)
					$eval_fila=round(($mb_fila*9.5+$b_fila*7+$r_fila*5.5+$m_fila*2)/$c_fila,2);
				else
					$eval_fila=0;

				switch (true) {
					case $eval_fila>=8.5:
						$g_fila=1;
						break;
					case $eval_fila<8.5 && $eval_fila>=6:
						$g_fila=2;
						break;
					case $eval_fila<6 && $eval_fila>=4:
						$g_fila=3;
						break;
					case $eval_fila>0 && $eval_fila<4:
						$g_fila=4;		
						break;
					case $eval_fila==0:
						$g_fila=0;		
						break;

				}// switch para asignar grupo

				$pdf->SetFont('helvetica', '', 7);
				// sentencia booleana ? valor si la sentencia es cierta : valor si es fals
				$pdf->Cell($col_l,$h,$value_resultado['sede']==1 ? 'U' : $value_resultado['sede'],'BL',0,'C');
				$pdf->Cell($col3,$h,$value_resultado['oe'],'B',0,'L');
				$pdf->Cell($col_l,$h,$value_resultado['cod'],'B',0,'L');
				$pdf->Cell($col_a,$h,$value_resultado['asignatura'],'BR',0,'L');
				//$pdf->Cell(108,$h,'','',0,'C',0);
				$pdf->Cell($col_n,$h,$mb_fila,'LTRB',0,'C',0); //MB
				$pdf->Cell($col_n,$h,$b_fila,'LTRB',0,'C',0); //B
				$pdf->Cell($col_n,$h,$r_fila,'LTRB',0,'C',0); //R
				$pdf->Cell($col_n,$h,$m_fila,'LTRB',0,'C',0); //M
				$pdf->Cell($col_n,$h,$nc_fila,'LTRB',0,'C',0); //NR
				$pdf->Cell($col_n,$h,$c_fila,'LTRB',0,'C',0); //RESP
				$pdf->SetFillColor(225,225,225);
				$pdf->Cell($col_e,$h,$eval_fila,'LTRB',0,'C',1); //EVAL
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell($col_n,$h,$g_fila,'LTRB',1,'C',0); //G


				switch (true) {
					case $g_fila==1:

						$mb+=1;
						break;

					case $g_fila==2:

						$b+=1;
						break;

					case $g_fila==3:

						$r+=1;
						break;

					case $g_fila==4:

						$m+=1;
						break; 
				}// end switch cuenta los resultados para el %

				$t=$mb+$b+$r+$m;
				if($t!=0){
					$p_mb=$mb*100/$t;
					$p_b=$b*100/$t;
					$p_r=$r*100/$t;
					$p_m=$m*100/$t;
				}
				else{
					$p_mb=0;
					$p_b=0;
					$p_r=0;
					$p_m=0;
				}// end if asigna valor a las variables del %
				
			break;

			} // end switch resultados
		} // end for resultados

			switch ($value_pregunta['tipo']) {
			case 1:

				$pdf->Ln(2);
				$col1=15;
				$col_t=10;
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'Si','',0);
				$pdf->Cell($col_t,$h,1,'',0);
				$pdf->Cell($col3,$h,'1'.'%','',1);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'No','',0);
				$pdf->Cell($col_t,$h,0,'B',0);
				$pdf->Cell($col3,$h,0,'0'.'%','',1);
				$pdf->SetFont('helvetica', '', 8);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'Total','',0);
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->Cell($col2,$h,$t,'',1);

			break;

			case 2:

				$pdf->Ln(2);
				$col1=25;
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'1-Muy Bueno','',0);
				$pdf->Cell($col_t,$h,$mb,'',0);
				$pdf->Cell($col3,$h,round($p_mb,0).'%','',1);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'2-Bueno','',0);
				$pdf->Cell($col_t,$h,$b,'',0);
				$pdf->Cell($col3,$h,round($p_b,0).'%','',1);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'3-Regular','',0);
				$pdf->Cell($col_t,$h,$r,'',0);
				$pdf->Cell($col3,$h,round($p_r,0).'%','',1);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'4-Malo','',0);
				$pdf->Cell($col_t,$h,$m,'B',0);
				$pdf->Cell($col3,$h,round($p_m,0).'%','',1);
				$pdf->SetFont('helvetica', '', 8);
				$pdf->Cell(120,$h,'','',0,'C',0);
				$pdf->Cell($col1,$h,'Total','',0);
				$pdf->SetFont('helvetica', 'B', 8);
				$pdf->Cell($col2,$h,$t,'',1);
			break;	

		} // end switch porcentajes
	}// end for preguntas


$pdf->Ln(15);

//$fecha= date.timezone = "America/Argentina"
$fecha = date("d-m-y");
$pdf->Cell(15,10,'Printed: ');
$pdf->Cell(10,10,$fecha);


//DESCARGA PDF-------------------------------------------------------------

	
	//$pdf->Output($datos['cabecera']['docente'], 'I');
	//$pdf->Output(PATH_PDF_ENCUESTAS.$datos['cabecera']['docente'].'.pdf', 'F');

	
	/*$nombre_archivo=sanear_string($datos['cabecera']['docente']).md5(rand());
	$pdf->Output(PATH_PDF_ENCUESTAS.$datos['cabecera']['docente']."/".$nombre_archivo.'pdf', 'F');*/

	$pdf->Output($datos['nombre_archivo'], 'F');


?>