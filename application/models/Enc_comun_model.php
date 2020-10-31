<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_comun_model extends CI_Model {

	public function dameCursos($id_oferta){

		$this->db->select('MAX(a.curso) as cursos');				// SELECT max(a.curso) 
		$this->db->from('grl_asignaturas a');						// from grl_asignaturas a
		$this->db->join('grl_planes p', 'p.id_plan = a.id_plan');// JOIN grl_planes p on p.id_plan = a.id_plan
		$this->db->join('grl_ooee oe', 'oe.id_oe = p.id_oe');		// join grl_ooee oe on oe.id_oe = p.id_oe
		$this->db->where('oe.id_oe', $id_oferta);					// where oe.id_oe = 18
		$this->db->where('a.habilitado',1);							// and a.habilitado = 1

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

	}// end function dameCursos


	public function cargarEncRel($id_encform, $id_enc_gral){

		$data=array(
			'id_encform'=> $id_encform,
			'id_enc_gral'=> $id_enc_gral,
		);

		// Inserta los valores del arreglo en la tabla rel_encform_gral
		$this->db->insert('rel_encform_gral',$data);		

		// obtiene el id de la relacion que se inserto al ultimo
		$res=$this->db->insert_id();

		if (is_null($res))
        {
            return 0;
        }
        else
        {
			return $res;
		}// end function CargarEncRel
	}

}// end model class comun

?>