<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Gilotti, Nicolas
 * @license         UNSTA
 * @link            
 */
    class Comun extends REST_Controller {

        function __construct(){
            // Construct the parent class
            parent::__construct();

            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        }// end construct

        

        // genera array de sedes
        public function dameSedes_get(){
            $id_periodo=2;
            $this->load->model('enc_gral_model','enc_gral_model');
            $sedes = $this->enc_gral_model->dameSedes($id_periodo);
           // echo "<pre>".print_r($sedes,false)."</pre>";die();

            if($sedes === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la busqueda',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $sedes
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if
        }//end dameSedes



        // genera array de unidades
        public function dameUnidades_post(){
            // $this->load->model('enc_unidad_model','eua_model');
            $this->load->model('enc_gral_model','enc_gral_model');
            $id_periodo=2;

            $params = json_decode(file_get_contents('php://input'), TRUE);
            // echo "<pre>".print_r($params,false)."</pre>";die();
            //$requestpayload=$this->post();
            //$id_sede=$this->post('id');
            $id_sede = (int)$params['id'];
            $unidad = $this->enc_gral_model->dameUnidades($id_sede,$id_periodo);
            // $unidad2 = $this->eua_model->dameUnidades($id_sede);
            // echo "<pre>".print_r($unidad,false)."</pre>";
            // echo "<pre>".print_r($unidad2,false)."</pre>";die();

            if($unidad === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la busqueda',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $unidad
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if
        }//end dameUnidades





        // genera array de ofertas
        public function dameOfertas_post(){
            // $this->load->model('enc_ofertas_model','eoe_model');
            $this->load->model('enc_gral_model','enc_gral_model');
            $id_periodo=2;

            $params = json_decode(file_get_contents('php://input'), TRUE);
            //echo "<pre>".print_r($params,false)."</pre>";die();
            
            $id_sede = (int)$params['idSede'];
            $id_unidad = (int)$params['idUnidad'];
            // $oferta=$this->eoe_model->dameOfertas($id_sede, $id_unidad);
            $oferta=$this->enc_gral_model->dameOfertas($id_sede, $id_unidad,$id_periodo);

            if($oferta === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la busqueda',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $oferta
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if

        }//end dame ofertas




        // genera array de cursos
        public function dameCursos_post(){
            // $this->load->model('enc_comun_model','ec_model');
            $this->load->model('enc_gral_model','enc_gral_model');
            $id_periodo=2;
            $params = json_decode(file_get_contents('php://input'), TRUE); 
            
            $id_sede = (int)$params['idSede'];
            $id_unidad = (int)$params['idUnidad'];
            $id_oferta = (int)$params['idOferta'];
            // $curso=$this->ec_model->dameCursos($id_oferta);
            $cursos=$this->enc_gral_model->dameCursos($id_sede,$id_unidad,$id_oferta,$id_periodo);

            if($cursos === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la busqueda',
                    'data'  => null
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $arrayCursos=array();

                foreach ($cursos as $key => $value) {
                    $arrayCursos[]=(int)$value['curso'];
                }

                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $arrayCursos
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if

        }//end dameCursos





        // genera array de asignaturas
        public function dameAsignaturas_post(){
            // $this->load->model('enc_planes_model','ep_model');
            // $this->load->model('enc_asignatura_model','ea_model');
            $this->load->model('enc_gral_model','enc_gral_model');
            $id_periodo=2;
            
            $params = json_decode(file_get_contents('php://input'), TRUE); 
            $id_sede = (int)$params['idSede'];
            $id_unidad = (int)$params['idUnidad'];
            $id_oferta = (int)$params['idOferta'];
            $curso = (int)$params['curso'];
            //$id_oferta=18;
            //$curso=3;
            // $id_plan = $this->ep_model->dameUltimoPlanPorOferta($id_oferta);
            $asignaturas = $this->enc_gral_model->dameAsignaturas($id_sede, $id_unidad,$id_oferta,$curso,$id_periodo);
            //echo "<pre>".print_r($asignaturas,false)."</pre>";die();

            if($asignaturas === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la busqueda',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $asignaturas
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if

        }// end dameAsignaturas





        // genera encform y la relacion con las encgral de asignatura y docentes, ademas gener encresp
        public function generaEncuesta_post(){

            $params = json_decode(file_get_contents('php://input'), TRUE);
            // echo "<pre>".print_r($params,false)."</pre>";die();
            

            $id_sede        = (int)$params['idSede'];
            $id_ua          = (int)$params['idUa'];
            $id_oe          = (int)$params['idOe'];
            $curso          = (int)$params['curso'];
            $id_asignatura  = (int)$params['idAsignatura'];
            
            $id_periodo     = 2;
            // $id_tipo_enc    = 1;           ESTA LINEA NO SE UTILIZA, OPTIMIZAR A FUTURO

            // $id_sede        = 1;
            // $id_asignatura  = 5248;
            // $id_oe          = 18;
            // $id_ua          = 3;
            // $curso          = 3;                                        // COMENTAR TODOS ESTOS VALORES HARDCOEADOS
            
            
            $this->load->model('enc_gral_model', 'eg_model');
            $checkActiva=$this->eg_model->checkEncGralActiva($id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);
            
            if ($checkActiva)
            {
                if ($id_sede!=null && $id_ua!=null && $id_oe!=null && $curso!=null && $id_asignatura!=null)
                {
                    $this->load->model('enc_encform_model', 'eefc_model');
                    $this->load->model('enc_comun_model','ec_model');
                    $this->load->model('enc_gral_preg_model', 'egp_model');
                    $this->load->model('enc_encresp_model', 'eer_model');
                    $this->load->model('enc_formularios_model', 'ef_model');

                    
                    // llama al metodo cargarEncForm para insertar un registro en la tabla encform
                    $id_encform = $this->eefc_model->insertEncForm($id_sede, $id_ua, $id_oe, $curso, $id_asignatura);

                    // consulta que el resultado no sea vacio
                    if($id_encform==0){

                         $this->response([
                            'status' => FALSE,
                            'message' => 'Error generando Formulario',
                            'data' => $data
                        ], REST_Controller::HTTP_OK);
                    }

                    // llama al metodo dameEncGral
                    $id_encGralDoc = $this->eg_model->dameEncGral(1, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);

                    $id_encGralAsig = $this->eg_model->dameEncGral(2, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);
                    
                    $id_encGralInfra = $this->eg_model->dameEncGral(3, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);
                    
                    $id_encGralAutoEv = $this->eg_model->dameEncGral(4, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);

                    // 1,2,3,4 SON id_tipo_enc OPTIMIZAR A FUTURO


                    // ---------------------------   Genera  Encuestas Docentes        ----------------------

                    // carga en rel_encform_gral el registro para relacionar encform con encuestasGral y devuelve el id.
                    $id_rel = $this->ec_model->cargarEncRel($id_encform, $id_encGralDoc);

                    // llama la funcion dameEncGralPreg la cual trae un array con id, id_docente e id_pregunta
                    $encGralPreguntas = $this->egp_model->dameEncGralPreg($id_encGralDoc);

                    // carga en encResp todas las preguntas
                    foreach ($encGralPreguntas as $key => $value) {

                        $this->eer_model->cargarEncResp($id_rel, $value['id_gpe'], $id_asignatura, $value['id_docente']);

                    }// end foreach encGralPreg



                    // ---------------------------    Genera Encuestas Asignaturas         ----------------------

                    // carga en rel_encform_gral el registro para relacionar encform con encuestasGral y devuelve el id.       
                    $id_rel2 = $this->ec_model->cargarEncRel($id_encform, $id_encGralAsig);

                    // llama la funcion dameEncGralPreg la cual trae un array con id, id_docente y id_pregunta
                    $encGralPreguntas2 = $this->egp_model->dameEncGralPreg($id_encGralAsig);

                    // carga en encResp todas las preguntas
                    foreach ($encGralPreguntas2 as $key => $value) {

                        $this->eer_model->cargarEncResp($id_rel2, $value['id_gpe'], $id_asignatura,null);

                    }// end foreach encGralPreg



                    // ---------------------------    Genera Encuestas Infraestructura        ----------------------

                    // carga en rel_encform_gral el registro para relacionar encform con encuestasGral y devuelve el id.       
                    $id_rel3 = $this->ec_model->cargarEncRel($id_encform, $id_encGralInfra);

                    // llama la funcion dameEncGralPreg la cual trae un array con id, id_docente y id_pregunta
                    $encGralPreguntas3 = $this->egp_model->dameEncGralPreg($id_encGralInfra);

                    // carga en encResp todas las preguntas
                    foreach ($encGralPreguntas3 as $key => $value) {

                        $this->eer_model->cargarEncResp($id_rel3, $value['id_gpe'], $id_asignatura,null);

                    }// end foreach encGralInfra



                    // ---------------------------    Genera Encuestas Autoevaluacion        ----------------------

                    // carga en rel_encform_gral el registro para relacionar encform con encuestasGral y devuelve el id.       
                    $id_rel4 = $this->ec_model->cargarEncRel($id_encform, $id_encGralAutoEv);

                    // llama la funcion dameEncGralPreg la cual trae un array con id, id_docente y id_pregunta
                    $encGralPreguntas4 = $this->egp_model->dameEncGralPreg($id_encGralAutoEv);

                    // carga en encResp todas las preguntas
                    foreach ($encGralPreguntas4 as $key => $value) {

                        $this->eer_model->cargarEncResp($id_rel4, $value['id_gpe'], $id_asignatura,null);

                    }// end foreach encGralAutoEv



                    // --------------------------------------------------------------------------------------------

                    $generate=true;
                    // $data['id_encform']=$id_encform;
                    $data['token']=$this->generaNro().$id_encform.$this->generaNro().$id_encform;


                    if(!$generate){
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Error generando encuesta',
                            'data' => $data
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'OK',
                            'data' => $data
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                    }//end if
                }
                else
                {
                     $this->response([
                        'status' => FALSE,
                        'message' => 'Faltan datos requeridos',
                        'data' => 0
                    ], REST_Controller::HTTP_OK);
                }
            }
            else
            {
                $this->response([
                        'status' => FALSE,
                        'message' => 'Encuesta aún no activada... Por favor reintente en unos minutos, gracias',
                        'data' => ''
                    ], REST_Controller::HTTP_OK);
                
            }
            
        }//end generaEncuesta




        private function generaNro(){
            $min=11111;
            $max=99999;
            $n="";
            for ($i=0; $i<4; $i++)
            {      
                $r = rand($min, $max);
                $n=$n.$r;
            }
            return $n;
        }
        
    }//end Class Comun
    
?>