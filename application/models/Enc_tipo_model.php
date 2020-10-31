<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_tipo_model extends CI_Model {

	public function dameTipo(){

		$this->db->select('t.id_tipo_enc');
		$this->db->select('t.tipo_enc ');
		$this->db->from('enc_tipos t');
		$this->db->where('t.habilitado',1);

		$query = $this->db->get();
		//echo $this->db->last_query();
		$res=$query->result_array();

		if (count($res)>0)
        {
            return $res;               
        }
        else
        {
			return 0;
		}// end if
		
	}// end dameTipo

}//end class model tipo

?>