<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Resultados extends CI_Controller {

        function __construct(){
           parent::__construct(); 
        }

        function generaAsignaturas(){
        	$this->load->library('Pdf_librarie');
        	$pdf = new Pdf_librarie('L','mm','A4',true,'UTF-8',false); //L HORIZONTAL, P VERTIAL (hoja)

        	$form['pdf']=$pdf;
        	$this->load->view('resultados/ea',$form);
        }

        function generaDocentes(){
            $this->load->library('Pdf_librarie');
            $pdf = new Pdf_librarie('P','mm','A4',true,'UTF-8',false); //L HORIZONTAL, P VERTIAL (hoja)

            $arrayResp=
        array(
            'cabecera'=>array(
                'periodo'=>2019,
                'ua'=>'Ingenieria',
                'docente'=>'Aguirre de Bautista, Ana Cecilia'
            ),
            'preguntas'=>
                array(
                    array(
                        'txt'=>'Asistencia y puntualidad del docente a clases y examenes',
                        'tipo'=>2,
                        'resultado'=>
                            array(
                                array(
                                    'sede'=>'U',
                                    'oe'=>'29-Diseño Grafico',
                                    'cod'=>'10F',
                                    'asignatura'=>'Comp.E.Inf.Del.Arte',
                                    'MB'=>22,
                                    'B'=>0,
                                    'M'=>1,
                                    'NC'=>0,
                                    'Eval'=>9.17,
                                    'G'=>1
                                ),
                                array(
                                    'sede'=>'U',
                                    'oe'=>'30-Locucion Nacional',
                                    'cod'=>'21A',
                                    'asignatura'=>'Prins.Estet.Hist.Arte',
                                    'MB'=>9,
                                    'B'=>1,
                                    'R'=>1,
                                    'M'=>1,
                                    'NC'=>0,
                                    'Eval'=>8.33,
                                    'G'=>2
                                )
                            )
                    ),
                    array(
                        'txt'=>'Puntualidad del docente a clases',
                        'tipo'=>2,
                        'resultado'=>
                            array(
                                array(
                                    'sede'=>'U',
                                    'oe'=>'29-Diseño Grafico',
                                    'cod'=>'10F',
                                    'asignatura'=>'Comp.E.Inf.Del.Arte',
                                    'MB'=>21,
                                    'B'=>1,
                                    'M'=>0,
                                    'NC'=>1,
                                    'Eval'=>9.07,
                                    'G'=>1
                                ),
                                array(
                                    'sede'=>'U',
                                    'oe'=>'30-Locucion Nacional',
                                    'cod'=>'21A',
                                    'asignatura'=>'Prins.Estet.Hist.Arte',
                                    'MB'=>8,
                                    'B'=>3,
                                    'R'=>0,
                                    'M'=>1,
                                    'NC'=>0,
                                    'Eval'=>8.25,
                                    'G'=>2
                                )
                            )
                    ),
                    array(
                        'txt'=>'Usted asistio a la calses del docente que esta calificando con regularidad',
                        'tipo'=>1,
                        'resultado'=>
                            array(
                                array(
                                    'sede'=>'U',
                                    'oe'=>'29-Diseño Grafico',
                                    'cod'=>'10F',
                                    'asignatura'=>'Comp.E.Inf.Del.Arte',
                                    'SI'=>21,
                                    'NO'=>1,
                                    'NC'=>0,
                                    'RESP'=>1,
                                    'G'=>1
                                ),
                                array(
                                    'sede'=>'U',
                                    'oe'=>'30-Locucion Nacional',
                                    'cod'=>'21A',
                                    'asignatura'=>'Prins.Estet.Hist.Arte',
                                    'SI'=> 8,
                                    'NO'=> 3,
                                    'NC'=>0,
                                    'RESP'=>1,
                                    'G'=>2
                                )
                            )
                    ),
                    array(
                        'txt'=>'prueba',
                        'tipo'=>1,
                        'resultado'=>
                            array(
                                array(
                                    'sede'=>'U',
                                    'oe'=>'29-Diseño Grafico',
                                    'cod'=>'10F',
                                    'asignatura'=>'sdsdsdsd',
                                    'SI'=>8,
                                    'NO'=>NULL,
                                    'NC'=>0,
                                    'RESP'=>1,
                                    'G'=>1
                                )
                            )
                    )
    
                )

        );


            /*echo "<pre>".print_r($arrayResp,true)."</pre>";
            die();*/

            $form['pdf']=$pdf;
            $form['datos']=$arrayResp;
            $this->load->view('resultados/ed',$form);
        }

        function sanear_string($string)
           {
                 
                    $string = trim($string);
                 
                    $string = str_replace(
                        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
                        $string
                    );
                 
                    $string = str_replace(
                        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                        $string
                    );
                 
                    $string = str_replace(
                        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                        $string
                    );
                 
                    $string = str_replace(
                        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                        $string
                    );
                 
                    $string = str_replace(
                        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                        $string
                    );
                 
                    $string = str_replace(
                        array('ñ', 'Ñ', 'ç', 'Ç'),
                        array('n', 'N', 'c', 'C',),
                        $string
                    );
                 
                    //Esta parte se encarga de eliminar cualquier caracter extraño
                    $string = str_replace(
                        array("\", "¨", "º", "-", "~",
                             "#", "@", "|", "!", """,
                             "·", "$", "%", "&", "/",
                             "(", ")", "?", "'", "¡",
                             "¿", "[", "^", "<code>", "]",
                             "+", "}", "{", "¨", "´",
                             ">", "< ", ";", ",", ":",
                             ".", " "),
                        '',
                        $string
                    );
                

             return $string;
        }
    
    }



?>