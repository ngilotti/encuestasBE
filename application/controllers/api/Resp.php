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
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
    class Resp extends REST_Controller {

        function __construct(){
            // Construct the parent class
            parent::__construct();

            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        }// end construct





        public function guardarRespuesta_post(){

            $params = json_decode(file_get_contents('php://input'), TRUE);
            
            // echo "<pre>".print_r($params,false)."</pre>";
            $id_resp=$params['idResp'];
            $valor  =$params['valor'];
            
            $this->load->model('enc_encresp_model', 'eer_model');
            $update=$this->eer_model->updateValor($id_resp,$valor);
             if($update === 0){

                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la busqueda',
                    'data' => $params
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $params
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if
            
        }





        public function dameEncuesta_post() {

            $params=json_decode(file_get_contents('php://input'), TRUE);

            $token      = $params['tkn'];     
            
            $id_encform = $this->checkToken($token);           
            
            if ($id_encform)
            {
                $this->load->model('enc_encform_model', 'eefc_model');
                $this->load->model('enc_gral_model', 'eg_model');
                $this->load->model('enc_formularios_model', 'ef_model');
               // echo "<pre>".print_r($id_encform,false)."</pre>";die();
               // $id_encform=1;
                if ($id_encform>0)
                {
                    $check=$this->eefc_model->checkEncForm($id_encform);
                    //echo "<pre>".print_r($check,false)."</pre>";die();

                    if ($check)
                    {
                        $id_enGral=$this->eefc_model->dameIdEncGralTipoDocente($id_encform);
                       // echo "<pre>".print_r($id_enGral,false)."</pre>";die();
                        $datosEncuestaGrl=$this->eg_model->dameDatosEncGral($id_enGral);
                       // echo "<pre>".print_r($datosEncuestaGrl,false)."</pre>";die();

                        // salgo de ejecucion si el id_encform es 0
                        if($id_encform==0){

                             $res= array(
                            'success' => false,
                            'error'   => 'error al insertar Encuestas Form'
                            );
                            $this->response($res, REST_Controller::HTTP_OK);
                        }

                        // genera array para enviar al formulario
                        $encuestaFormDoc=$this->ef_model->formDocente($id_encform);
                        $encuestaFormAsig=$this->ef_model->formAsig($id_encform);
                        $encuestaFormInf=$this->ef_model->formInf($id_encform);
                        $encuestaFormAutoEv=$this->ef_model->formAutoEv($id_encform);

                        $resFormulario['enc'] = $datosEncuestaGrl;

                        
                        if ($encuestaFormDoc!=0)
                            $resFormulario['doc'] = $this->formatDocArray($encuestaFormDoc);
                        else
                            $resFormulario['doc'] = 0;

                        if ($encuestaFormAsig!=0)
                            $resFormulario['asig'] = $encuestaFormAsig;
                        else
                            $resFormulario['asig'] = 0;

                        if ($encuestaFormInf!=0)
                            $resFormulario['inf'] = $encuestaFormInf;
                        else
                            $resFormulario['inf'] = 0;

                        if ($encuestaFormAutoEv!=0)
                            $resFormulario['autoEv'] = $encuestaFormAutoEv;
                        else
                            $resFormulario['autoEv'] = 0;



                        $resFormulario['idEncForm'] = $id_encform;

                        // echo "<pre>".print_r($resFormulario,false)."</pre>";die();

                        if($resFormulario === 0){
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
                                'data' => $resFormulario
                            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                        }//end if
                    }
                    else
                    {
                        $res= array(
                            'success' => false,
                            'error'   => 'Encuesta no encontrada...'
                        );
                        $this->response($res, REST_Controller::HTTP_OK);
                    }

                }
                else
                {
                    $res= array(
                        'success' => false,
                        'error'   => 'Encuesta inexistente!'
                    );
                    $this->response($res, REST_Controller::HTTP_OK);
                }
                
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error...',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            
            
        }//end dameEncuestas





        // corrige el formato del array de Docente
        public function formatDocArray($docArray){
            // echo "<pre>".print_r($docArray,false)."</pre>";die();
            $n=0;
            $x=count($docArray);
            $id_pregunta=0;
            $pregArray = array();
            foreach ($docArray as $key => $value) {
                if($n==0){
                    $id_pregunta=$value['id_pregunta'];
                    $preg['id_pregunta'] = $value['id_pregunta'];
                    $preg['pregunta'] = $value['pregunta'];
                    $preg['orden'] = $value['orden'];
                    $preg['tipo_resp'] = $value['id_tipo_resp'];

                }// end if

                $n++;

                if($id_pregunta != $value['id_pregunta']){

                    $preg['docente']=$docentes;
                    $pregArray[]=$preg; 
                    $docentes=array();
                    $id_pregunta = $value['id_pregunta'];  
                }

                $doc['nomap'] = $value['docente'];
                $doc['id_resp'] = $value['id_resp'];
                $docentes[] = $doc;
                $preg['id_pregunta'] = $value['id_pregunta'];
                $preg['pregunta'] = $value['pregunta'];
                $preg['orden'] = $value['orden'];
                $preg['tipo_resp'] = $value['id_tipo_resp'];

                
                if($n==$x){
                    $preg['docente']=$docentes;
                    $pregArray[]=$preg; 
                    $docentes=array();
                    $id_pregunta = $value['id_pregunta'];  
                }
            }// end foreach
            return $pregArray;
        }// end docArray

        public function finalizarEncuesta_post(){
            $params = json_decode(file_get_contents('php://input'), TRUE);
            
            $token     = $params['tkn'];     
            $id_encform     = $this->checkToken($token);
            
            if($id_encform){
                $this->load->model('enc_encform_model', 'eefc_model');
                $txt=$params['txt'];
            
            
            $update=$this->eefc_model->updateTxt($id_encform,$txt);
            
            $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $params
                ], REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error...',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if
        }// end finalizarEncuesta

        private function checkToken($token){
            $lenCadena=20;
            $lenToken= strlen($token);
            $lenId= ($lenToken-($lenCadena*2))/2;
            
            $id_1=substr($token,$lenCadena,$lenId);
            $id_2=substr($token,$lenCadena+$lenId+$lenCadena,$lenId);
           
            if($id_1==$id_2)
                return $id_1;
            else
                return false;

        }// end checkToken 


    }//end Class Comun
    
?>