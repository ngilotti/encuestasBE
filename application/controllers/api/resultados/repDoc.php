<?php

    class RepDoc extends CI_Controller {

        function __construct(){
            // Construct the parent class
            parent::__construct();

        }// end construct


        public function generaRepEncDoc(){

            $this->load->model('enc_vista_model', 'ev_model');
            $this->load->model('enc_preg_model', 'ep_model');
            $this->load->model('res_cabecera_model', 'rc_model');

            $arrCab=$this->rc_model->dameCabeceraNoCheck();

            foreach ($arrCab as $cab_key => $cab_value) {
                $id_cabecera=$cab_value['id']; 
                $id_tipo=1; // tipo de encuesta (1)docente (2)asignatura (3)infraestructura
                
                $arrCabecera=$this->ev_model->dameCabeceraPorId($id_cabecera);
                echo "<pre>".print_r($arrCabecera,false)."</pre>";die();
                
                $cabecera['id']=$arrCabecera['id'];
                $cabecera['periodo']=$arrCabecera['periodo'];
                $cabecera['docente']=$arrCabecera['docentes'];
                $cabecera['dni']=$arrCabecera['dni'];

                $dni=$arrCabecera['dni'];
                $ua=$arrCabecera['id_ua'].'-'.$this->limpiar_string(ucwords(strtolower($cabecera['ua'])));
                
                $preguntas=$this->ep_model->dameTxtPreg($id_tipo, $arrCabecera['id_periodo']);

                    foreach ($preguntas as $preg_key => &$preg_value) {
                        
                        $atributos=$this->ev_model->dameAtributos(
                                                    $arrCabecera['id_sede'], 
                                                    $arrCabecera['id_ua'], 
                                                    $arrCabecera['dni'], 
                                                    $preg_value['id_pregunta']
                                                    );
                        
                        switch ($preg_value['id_tipo_resp']) {
                            case 1:
                            case '1':
                                $opciones=array( 'Si',
                                                 'No'
                                                );
                                break;

                            case 2:
                            case '2':
                                $opciones=array( 'MB',
                                                 'B',
                                                 'R',
                                                 'M',
                                                 'NC'
                                                );
                                break;
                            
                        }; // end switch preg_value

                        foreach ($atributos as $atrib_key => &$atrib_value) {
                        
                            $arrayOp=array();

                            foreach ($opciones as $opcion) {

                                $arrayOp[$opcion]=$this->ev_model->dameValores(
                                                        $arrCabecera['id_sede'], 
                                                        $arrCabecera['id_ua'], 
                                                        $arrCabecera['dni'], 
                                                        $preg_value['id_pregunta'],
                                                        $atrib_value['id_oe'],
                                                        $atrib_value['id_asignatura'],
                                                        $opcion
                                                    );

                            } // end foreach opciones
                                $atrib_value=array_merge($atrib_value, $arrayOp);

                        } // end foreach atributos

                        $preg_value['resultado']=$atributos;

                    } // end foreach preguntas

                unset($preg_value);

                $res['cabecera']=$cabecera;
                $res['preguntas']=$preguntas;

                $nombre_archivo=$this->limpiar_string($cabecera['docente']);
                $ruta=PATH_PDF_ENCUESTAS.$ua;

                if(!is_dir($ruta))
                    mkdir($ruta);

                $res['nombre_archivo']=$ruta.'/'.$nombre_archivo.md5($dni.'ng&ep').'.pdf';    
                $this->generaDocente($res);
                // echo "<pre>".print_r($res,false)."</pre>";die();

                $this->rc_model->checkCabecera($cab_value['id']);

            }//end foreach cabeceras

        }// end generaResultados

        function generaDocente($arrDatos){
            $this->load->library('Pdf_librarie');
            $pdf = new Pdf_librarie('P','mm','A4',true,'UTF-8',false); //L HORIZONTAL, P VERTIAL (hoja)

            /*echo "<pre>".print_r($arrayResp,true)."</pre>";
            die();*/

            $form['pdf']=$pdf;
            $form['datos']=$arrDatos;
            $this->load->view('resultados/ed',$form);
        }// end generaEd

        function generaCabecera(){

            $this->load->model('enc_vista_model', 'ev_model');

            $arrCab=$this->ev_model->dameCabeceras();
            return $arrCab;
            // echo "<pre>".print_r($arrCab,true)."</pre>":
        }// end generaCabecera()

        function limpiar_string($string)
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
                        array("\ ", "¨", "º", "-", "~",
                             "#", "@", "|", "!", '"',
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

}//end controlador Resultados