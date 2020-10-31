<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_unidad_model extends CI_Model {

	public function dameUnidades($id_sede){

		$this->db->select('distinct(ua.id_ua)');
		$this->db->select('ua.ua');
		$this->db->from('grl_uuaa ua');
		$this->db->join('grl_ooee oe','ua.id_ua = oe.id_ua');
		$this->db->join('rel_ooee_sedes r','r.id_oe = oe.id_oe');
		$this->db->where('r.id_sede',$id_sede);
		$this->db->where('ua.habilitado',1);
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

	}// end dameUnidades


	public function dameUnidadesTotal(){

		$this->db->select('distinct(ua.id_ua)');
		$this->db->select('ua.ua');
		$this->db->from('grl_uuaa ua');
		$this->db->join('grl_ooee oe','ua.id_ua = oe.id_ua');
		$this->db->join('rel_ooee_sedes r','r.id_oe = oe.id_oe');
		$this->db->where('ua.habilitado',1);
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
	}

}//end class model unidades

?>