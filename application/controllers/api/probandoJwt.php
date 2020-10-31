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
* @author          Phil Sturgeon, Chris Kacerguis
* @license         MIT
* @link            https://github.com/chriskacerguis/codeigniter-restserver
*/
class ProbandoJwt extends REST_Controller {

   function __construct()
   {
       // Construct the parent class
       parent::__construct();

   }
   public function token_get(){
       $tokenData=array();
       $tokenData['id']=2;
       $tokenData['nombre']='nicolas';
       $outpud('token')=AUTHORIZATION::generateToken($tokenData);
       $this->et_response($outpud, 'REST_Controller::HTTP_OK');
   }

   public function token_post(){

   }

   

}