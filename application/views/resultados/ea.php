<?php
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('');
	$pdf->SetTitle('Encuestas Asig');
	$pdf->SetSubject('');
	$pdf->SetKeywords('');
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	$path_logo=PATH_PDF_IMAGES."unsta_header.png";
	//$path_logo="http://localhost/encuestas2019/be/application/images/unsta.png";
	//$path_logo="C:\xampp\htdocs\encuestas2019\be\application\images";

	$pdf->SetHeaderData($path_logo, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Resultados de Asignaturas', PDF_HEADER_STRING);

	

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	$pdf->AddPage();

	$pdf->Image($path_logo, 230, 1, 0, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

	$col1=20;
	$col2=10;
	$col3=$col1;
	$h=5;


	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(55,0,'Período: 2019','LT',0);
	$pdf->Cell(35,0,'Nro control: 1,234','TR',1,'R');
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(45,0,'Sede:','L',0,'R');
	$pdf->Cell(45,0,'CENTRAL','R',1,'L');
	$pdf->Cell(45,0,'Unidad Académica:','L',0,'R');
	$pdf->Cell(45,0,'FILOSOFIA','R',1,'L');
	$pdf->Cell(45,0,'Oferta:','L',0,'R');
	$pdf->Cell(45,0,'49-LIC. EN FILOSOFIA (2010)','R',1,'L');
	$pdf->Cell(45,0,'Curso:','L',0,'R');
	$pdf->Cell(45,0,'1','R',1,'L');
	$pdf->Cell(45,0,'Cant de Asig:','L',0,'R');
	$pdf->Cell(45,0,'8','R',1,'L');
	$pdf->Cell(45,0,'Cant de alumnos Insc:','L',0,'R');
	$pdf->Cell(45,0,'9','R',1,'L');
	$pdf->Cell(45,0,'Cant de alumnos que resp:','L',0,'R');
	$pdf->Cell(45,0,'8','R',1,'L');
	$pdf->Cell(45,0,'','BL',0,'R');
	$pdf->Cell(45,0,'','BR',1,'L');



	$pdf->Ln(10);
	$pdf->SetFillColor(150,152,154);
	$col1=30;
	$col2=60;
	$col3=120;
	$col_s=2;
	$col_n=8;
	$col_e=12;
	$h=5;
	$col_t=5;
	$col_p=150;
	$col_r=40;
	$pdf->SetFont('helvetica', 'B', 8); 
	$pdf->Cell($col1,$h,'Cod','BLT',0,'L',true);
	$pdf->Cell($col2,$h,'Asignatura','BRT',1,'L',true);
	
	$pdf->SetFont('helvetica', '', 8); 
	$pdf->Cell($col1,$h,'30Y','BL',0,'L');
	$pdf->Cell($col2,$h,'FORMACION HUMANISTICA I','BRT',1,'L');
		

	
	$pdf->Ln(10);

	$pdf->Cell(150,$h,'','',0,'C',0);
	$pdf->SetFillColor(225,225,225);
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell($col_n,$h,'Si','LTRB',0,'C',1);
	$pdf->Cell($col_n,$h,'No','LTRB',0,'C',1);
	$pdf->Cell($col_n,$h,'NR','LTRB',0,'C',1);
	$pdf->Cell($col_n,$h,'Resp','LTRB',0,'C',1);
	$pdf->Cell($col_n,$h,'G','LTRB',1,'C',1);
	//$pdf->Cell($col_s,$h,'',0,1,'L',true);	




	$pdf->SetFont('helvetica', 8);
	$pdf->Cell($col_p,0,'¿Conoce a todos los integrantes de la catedra que usted esta evaluando en este momento?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿Sabe quien es el docente responsable de la catedra?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿La catedra dio a conocer la planificacion de la asignatura?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿La catedra responsable dio a conocer los criterios de evaluacion que aplicaria en trabajos practicos y examenes?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿Que tipo de bibliografia utiliza la catedra?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿El tiempo dedicado al dictado de la asignatura en el plan de estudios es suficiente para la compresion de los temas?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿Conoce los detalles de la planificacion de la asignatura?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'¿Que material utiliza para estudiar esta asignatura?','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'El grado de cumplimiento de la planificacion de la asignatura','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'La bibliografia indicada por la catedra para la asignatura es','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'La relacion entre los contenidos desarrollados y los contenidos evaluados','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G
	$pdf->Cell($col_p,0,'La organizacion y el funcionamiento de la asignatura','TBLR',0,'L');
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //SI
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NO
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //NR
	$pdf->Cell($col_n,0,'','LTRB',0,'C',0); //RESP
	$pdf->Cell($col_n,0,'','LTRB',1,'C',0); //G


	

	$pdf->Ln(10);
	$col1=15;
	$col2=20;
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell(150,$h,'','',0,'C',0);
	$pdf->Cell($col1,$h,'Si','',0);
	$pdf->Cell($col_t,$h,'0','',0);
	$pdf->Cell($col2,$h,'0%','',1);
	$pdf->Cell(150,$h,'','',0,'C',0);
	$pdf->Cell($col1,$h,'No','',0);
	$pdf->Cell($col_t,$h,'0','B',0);
	$pdf->Cell($col2,$h,'0%','',1);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->Cell(150,$h,'','',0,'C',0);
	$pdf->Cell($col1,$h,'Total','',0);
	$pdf->SetFont('helvetica', 'B', 8);
	$pdf->Cell($col2,$h,'0','',1);



	$pdf->Ln(10);



	$pdf->Output('ea.pdf', 'I');

?>