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
    $id_periodo = 1;

    $tipo_enc = $this->et_model->dameTipo();

    //echo "<pre>".print_r($tipo_enc,false)."</pre>";

    foreach ($tipo_enc as $tipo_key => $tipo_value) {
      
      $preguntas = $this->epreg_model->damePreguntas($tipo_value['id_tipo_enc'],$id_periodo);
      //echo "<pre>".print_r($preguntas,false)."</pre>";die();
      
      $oe_value['id_oe'] = 31;

      $asignaturas = $this->ea_model->dameAsignaturasHabilitadasPorOferta($oe_value['id_oe']);

      if ($asignaturas==0){
        echo "<pre>".print_r("No asignatura")."</pre>";
        die();               
      }//end if

      foreach ($asignaturas as $asig_key => $asig_value) {
      
        // echo "<br> + + + + + + (".$asig_value['asignatura'].") - ".$asig_value['id_asignatura']."<br><br>";
      
        $res['id_tipo_enc']   = $tipo_value['id_tipo_enc'];
        $res['id_sede']       = 1;
        $res['id_asignatura'] = $asig_value['id_asignatura'];
        $res['id_ua']         = 5;
        $res['id_oe']         = $oe_value['id_oe'];
        $res['id_periodo']    = $id_periodo;


        //$response[]=$res;
        $idEncGral = $this->egral_model->insert($res);
        // echo "<pre>".print_r($insert,false)."</pre>";

        $docentes = $this->edoc_model->dameIdsDocentesPorAsig($asig_value['id_asignatura'], $sede_value['id_sede']);
        
        if($docentes==0){
          echo "<pre>".print_r("No docentes")."</pre>";
          die();
        }// end if


        switch ($tipo_value['id_tipo_enc']) {

          case 1:
            
            foreach ($docentes as $doc_key => $doc_value) {
          
              //echo "<br> * * * * * * * * * * * * * * * * * * * (".$doc_value['apellido']." ".$doc_value['nombre'].") - ".$doc_value['id_docente']."<br><br>";

              foreach ($preguntas as $pregDoc_key => $pregDoc_value) {
              
                if($preguntas==0){
                  echo "<pre>".print_r("No pregunta Docente")."</pre>";
                  die();
                }// end if
          
                $reg_pregDoc=null;
                
                if($tipo_value['id_tipo_enc']==1){

                    $reg_pregDoc['id_enc_gral']  = $idEncGral;
                    $reg_pregDoc['id_pregunta']  = $pregDoc_value['id_pregunta'];
                    $reg_pregDoc['id_docente']   = $doc_value['id_docente'];

                    $this->egralpreg_model->insert($reg_pregDoc);
                }//end if

              }// end foreach preguntas

            }// end foreach docentes

            break;

          case 2:
            
            foreach ($preguntas as $pregAsig_key => $pregAsig_value) {
                                          
              if($preguntas==0){
                echo "<pre>".print_r("No pregunta asignatura")."</pre>";
                die();
              }// end if
              
              $reg_pregAsig=null;
              
              $reg_pregAsig['id_enc_gral']  = $idEncGral;
              $reg_pregAsig['id_pregunta']  = $pregAsig_value['id_pregunta'];
              $reg_pregAsig['id_docente']   = null;

              $this->egralpreg_model->insert($reg_pregAsig);
            }// end foreach preguntas

            break;
          
          default:
            $reg_pregAsig =0;
            $reg_pregDoc  =0;
            break;

        }// end switch

      }// end foreach asignaturas

    }//end foreach tipo 

    //$insert=$this->egral_model->insertBatch($response);
    // echo "<pre>".print_r($insert,false)."</pre>";
    //echo "<pre>".print_r($response,false)."</pre>";

  }//end function generarEncGral

}// end generador
?>