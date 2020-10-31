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
    class Gestion extends REST_Controller {

        function __construct(){
            // Construct the parent class
            parent::__construct();

            // Configure limits on our controller methods
            // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
            $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
            $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
            $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        }// end construct

        // activa enc_gral
        public function activarEnc_post(){
            
            $this->load->model('enc_gral_model', 'eg_model'); 
            $this->load->model('enc_encform_model', 'ef_model'); 

            $params = json_decode(file_get_contents('php://input'), TRUE);


            $id_sede        = (isset($params['idSede']))?(int)$params['idSede']:null;
            $id_ua          = (isset($params['idUa']))?(int)$params['idUa']:null;
            $id_oe          = (isset($params['idOe']))?(int)$params['idOe']:null;
            $id_asignatura  = (isset($params['idAsignatura']))?(int)$params['idAsignatura']:null;
            $id_periodo     = 1;
            $activado       = 1;
            // $id_sede        = 1;
            // $id_ua          = 3;
            // $id_oe          = 18;
            // $id_asignatura  = 5265;
            
            if ($id_sede==null || $id_ua==null || $id_oe==null || $id_asignatura==null)
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Seleccione todos los campos',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }

            $id_encGralDoc = $this->eg_model->dameEncGral(1, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);
            $id_encGralAsig = $this->eg_model->dameEncGral(2, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo);

            $query=$this->eg_model->actDesactEnc($id_encGralDoc, $id_encGralAsig, $id_periodo, $activado);

             if($query === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la activacion',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                
                $estado=$this->ef_model->dameEstados($id_encGralDoc);
            
                $res=array();
                $res['id_encGralDoc']=$id_encGralDoc;
                $res['id_encGralAsig']=$id_encGralAsig;
                $res['total']=$estado['total'];
                $res['fin']=$estado['fin'];

                // echo "<pre>".print_r($res,false)."</pre>";die();

                if($estado === 0){
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error al actualizar',
                        'data' => null
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }
                else{
                    $this->response([
                        'status' => TRUE,
                        'message' => 'OK',
                        'data' => $res
                    ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
                }//end if

            }//end if

            
           
        }// end activarEnc



        //  actualizar las encuestas totales y finalizadas en la pantalla de encuestador
        public function actualizarEncuestador_post(){

            $this->load->model('enc_encform_model', 'ef_model');

            $params = json_decode(file_get_contents('php://input'), TRUE);
            
            $id_encgral = (int)$params['idEncGral'];
            // $encgral  = 357;

            $estado=$this->ef_model->dameEstados($id_encgral);
            // echo "<pre>".print_r($estado,false)."</pre>"; die();

             if($estado === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error al actualizar',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $estado
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if

        }// end actualizarEncuestador

        // desactiva enc_gral
        public function desactivarEnc_post(){
            
            $this->load->model('enc_gral_model','eg_model');

            $params = json_decode(file_get_contents('php://input'), TRUE);

            $id_encGralDoc  = (int)$params['idEncGralDoc'];
            $id_encGralAsig = (int)$params['idEncGralAsig'];
            $activado       = 0;
            $id_periodo     = 1;
            // $id_encGralDoc  = 357;
            // $id_encGralAsig = 2223;

            $estado=$this->eg_model->actDesactEnc($id_encGralDoc, $id_encGralAsig, $id_periodo, $activado);

            if($estado === 0){
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error en la desactivacion',
                    'data' => null
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
            else{
                $this->response([
                    'status' => TRUE,
                    'message' => 'OK',
                    'data' => $estado
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }//end if
            
        }// end desactivarEnc
    }//end Class Comun
    
?>