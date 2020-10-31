<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enc_planes_model extends CI_Model {

	public function dameUltimoPlanPorOferta($id_oferta){

		$this->db->select('p.id_plan');
		$this->db->from('grl_planes p');
		$this->db->join('grl_ooee oe','oe.id_oe = p.id_oe');
		$this->db->where('oe.id_oe',$id_oferta);
		$this->db->where('p.habilitado',1);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$res=$query->row();

		if (isset($res))
        {
            return $res->id_plan;
        }
        else
        {
			return 0;
		}// end if

	}// end damePlanPorOferta

}// end class model planes

?>