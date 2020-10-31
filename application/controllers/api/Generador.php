<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Generador extends REST_Controller {

      
  private $val=array(
  'sede'  => null,
  'unidad'=> null,
  'oferta'=> null,
  'asig'  => null,
  'doc' => null,
  );

  function __construct(){

    // Construct the parent class
    parent::__construct();
    // Configure limits on our controller methods
    // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
    $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
    $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
    $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    // Carga de modelos
    $this->load->model('enc_sedes_model','es_model');
    $this->load->model('enc_unidad_model','eua_model');
    $this->load->model('enc_ofertas_model','eoe_model');
    $this->load->model('enc_planes_model', 'ep_model');
    $this->load->model('enc_asignatura_model', 'ea_model');
    $this->load->model('enc_doc_model', 'edoc_model');
    $this->load->model('enc_gral_model', 'egral_model');
    $this->load->model('enc_preg_model', 'epreg_model');
    $this->load->model('enc_gral_preg_model', 'egralpreg_model');
    $this->load->model('enc_tipo_model', 'et_model');
  }// end construct

  public function generarEncGral_get(){

    $res=array();
    $id_periodo = 2;

    $tipo_enc = $this->et_model->dameTipo();


    foreach ($tipo_enc as $tipo_key => $tipo_value) {

      // echo "<br><br><br> ________________________________________________<br>".$tipo_value['tipo_enc']." - ".$tipo_value['id_tipo_enc']."<br>________________________________________________";
      
      $preguntas = $this->epreg_model->damePreguntas($tipo_value['id_tipo_enc'],$id_periodo);
      // echo "<pre>".print_r($preguntas)."</pre>";die();

      $sedes=$this->es_model->dameSedes();
      
      if ($sedes==0){
          continue;               
      }// end if



      foreach ($sedes as $sede_key => $sede_value) {

        // echo "<br><br><br>------------------------------------------------------ <br>".$sede_value['sede']." - ".$sede_value['id_sede']."<br>------------------------------------------------------";
        
        $uuaa = $this->eua_model->dameUnidades($sede_value['id_sede']);
         // echo "<pre>".print_r($uuaa,false)."</pre>";
          
        if ($uuaa==0){
          continue;               
        }// end if
       



        foreach ($uuaa as $ua_key => $ua_value) {
          
          // echo  '<br><br> ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ <br>{'.$ua_value['ua'].'} - '.$ua_value['id_ua']."<br> ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ";
          
          $oferta = $this->eoe_model->dameOfertas($sede_value['id_sede'],$ua_value['id_ua']);

          if ($oferta==0){
            continue;               
          }// end if




          foreach ($oferta as $oe_key => $oe_value) {

            // echo "<br><br><br> + + [ [ ".$oe_value['oe']." ] ] - ".$oe_value['id_oe']."<br> ===================================== <br>";

            $asignaturas = $this->ea_model->dameAsignaturasHabilitadasPorOferta($oe_value['id_oe']);

            if ($asignaturas==0){
              continue;               
            }//end if





            foreach ($asignaturas as $asig_key => $asig_value) {
            
              // echo "<br> * (".$asig_value['asignatura'].") - ".$asig_value['id_asignatura'];
            
              $res['id_tipo_enc']   = $tipo_value['id_tipo_enc'];
              $res['id_sede']       = $sede_value['id_sede'];
              $res['id_asignatura'] = $asig_value['id_asignatura'];
              $res['id_ua']         = $ua_value['id_ua'];
              $res['id_oe']         = $oe_value['id_oe'];
              $res['id_periodo']    = $id_periodo;


  
                $response[]=$res;
                $idEncGral = $this->egral_model->insert($res);
                // echo "<pre>".print_r($insert,false)."</pre>";

                $docentes = $this->edoc_model->dameIdsDocentesPorAsig($asig_value['id_asignatura'], $sede_value['id_sede']);
                // echo "<pre>".print_r($docentes)."</pre>";
                
                if($docentes==0){
                  continue;
                }// end if




                switch ($tipo_value['id_tipo_enc']) {

                  case 1:
                    
                    foreach ($docentes as $doc_key => $doc_value) {
                     
                       // echo "<pre>".print_r($doc_value)."</pre>";die();


                      foreach ($preguntas as $pregDoc_key => $pregDoc_value) {
                      
                        if($preguntas==0){
                          continue;
                        }// end if
                  
                        $reg_pregDoc = null;
                        
                        if( $tipo_value['id_tipo_enc'] ==1 ) {

                            $reg_pregDoc['id_enc_gral']  = $idEncGral;
                            $reg_pregDoc['id_pregunta']  = $pregDoc_value['id_pregunta'];
                            $reg_pregDoc['id_docente']   = $doc_value['id_docente'];

                            $this->egralpreg_model->insert($reg_pregDoc);
                            // echo "<br>".print_r($reg_pregDoc,false)."<br>";

                        }//end if

                      }// end foreach preguntas

                    }// end foreach docentes

                    break;

                  case 2:
                    
                    foreach ($preguntas as $pregAsig_key => $pregAsig_value) {
                                                  
                      if($preguntas==0){
                        continue;
                      }// end if
                      
                      $reg_pregAsig=null;
                      
                      $reg_pregAsig['id_enc_gral']  = $idEncGral;
                      $reg_pregAsig['id_pregunta']  = $pregAsig_value['id_pregunta'];
                      $reg_pregAsig['id_docente']   = null;

                      $this->egralpreg_model->insert($reg_pregAsig);
                      // echo "<br>".print_r($reg_pregAsig,false)."</br>";
                    }// end foreach preguntas

                    break;

                    case 3:
                    
                    foreach ($preguntas as $pregInf_key => $pregInf_value) {
                                                  
                      if($preguntas==0){
                        continue;
                      }// end if
                      
                      $reg_pregInf=null;
                      
                      $reg_pregInf['id_enc_gral']  = $idEncGral;
                      $reg_pregInf['id_pregunta']  = $pregInf_value['id_pregunta'];
                      $reg_pregInf['id_docente']   = null;

                      $this->egralpreg_model->insert($reg_pregInf);
                      // echo "<br>".print_r($reg_pregInf,false)."<br>";
                    }// end foreach preguntas

                    break;

                    case 4:
                    
                    foreach ($preguntas as $pregAutoEv_key => $pregAutoEv_value) {
                                                  
                      if($preguntas==0){
                        continue;
                      }// end if
                      
                      $reg_pregAutoEv=null;
                      
                      $reg_pregAutoEv['id_enc_gral']  = $idEncGral;
                      $reg_pregAutoEv['id_pregunta']  = $pregAutoEv_value['id_pregunta'];
                      $reg_pregAutoEv['id_docente']   = null;

                      $this->egralpreg_model->insert($reg_pregAutoEv);
                      // echo "<br>".print_r($reg_pregAutoEv,false)."<br>";
                    }// end foreach preguntas

                    break;
                  
                  default:
                    $reg_pregAsig   =0;
                    $reg_pregDoc    =0;
                    $reg_pregInf    =0;
                    $reg_pregAutoEv =0;
                    break;

                }// end switch

              }// end foreach asignaturas

            }// end foreach oe

        }// end foreach ua
        
      }// end foreach sede

    }//end foreach tipo 
    // echo "<pre>".print_r($response,false)."</pre>";
    // $insert=$this->egral_model->insertBatch($response);
    // echo "<pre>".print_r($insert,false)."</pre>";
    // echo "<pre>".print_r($response,false)."</pre>";

  }//end function generarEncGral

}// end generador
// ?>