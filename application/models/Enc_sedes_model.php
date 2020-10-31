<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_sedes_model extends CI_Model {

    public function dameSedes(){

            $this->db->select('s.id_sede');
            $this->db->select('s.sede');
            $this->db->from('grl_sedes s');
            $this->db->where('s.habilitado',1);
            $query = $this->db->get();
            $res=$query->result_array();

            if (count($res)>0)
        {
            return $res;               
        }
        else
        {
            return 0;
        }// end if
    }// end dameSedes

}//end class model sedes

?>