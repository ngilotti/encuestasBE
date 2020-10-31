<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_doc_model extends CI_Model {

	public function dameIdsDocentesPorAsig($id_asignatura,$id_sede){

		$this->db->select('d.id_docente');
		$this->db->from('grl_docentes d');
		$this->db->join('rel_asig_doc r','r.id_docente = d.id_docente');
		$this->db->join('grl_asignaturas a','a.id_asignatura = r.id_asignatura');
		$this->db->where('a.id_asignatura',$id_asignatura);
		$this->db->where('r.id_sede',$id_sede);
		$this->db->where('d.habilitado',1);
		
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

	}// end dameDocentes

}//end class model docentes
?>