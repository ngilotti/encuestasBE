<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_gral_preg_model extends CI_Model {

	public function dameEncGralPreg($id_encGral){

		$this->db->select('id_gpe');
		$this->db->select('id_docente');
		$this->db->from('enc_grl_preguntas gp');
		$this->db->join('enc_gral g','g.id_enc_gral = gp.id_enc_gral');
		$this->db->where('g.id_enc_gral',$id_encGral);
		$this->db->where('gp.habilitado',1);

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

	}// end dameEncGralPreg

	

	public function insert($data){

		// Inserta los valores del arreglo en la tabla enc_form
		$this->db->insert('enc_grl_preguntas',$data);

		// obtiene el id de la enc_form que se inserto al ultimo
		$last_id=$this->db->insert_id();

		if (is_null($last_id))
        {
            return 0;
        }
        else
        {
			return $last_id;
		}// end if

	}// end insert

}//end model class enc_gralPreg_model

?>