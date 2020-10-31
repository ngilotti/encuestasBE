<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_asignatura_model extends CI_Model {

	public function dameAsignaturasPorPlan($id_plan){

		$this->db->select('a.id_asignatura');
		$this->db->select('a.asignatura');
		$this->db->from('grl_asignaturas a');
		$this->db->join('grl_planes p','p.id_plan = a.id_plan');
		$this->db->where('p.id_plan',$id_plan);
		$this->db->where('a.habilitado',1);

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

	}// end dameAsignatura

	public function dameAsignaturasPorPlanCurso($id_plan, $curso){

		$this->db->select('a.id_asignatura');
		$this->db->select('a.asignatura');
		$this->db->from('grl_asignaturas a');
		$this->db->join('grl_planes p','p.id_plan = a.id_plan');
		$this->db->where('p.id_plan',$id_plan);
		$this->db->where('a.curso', $curso);
		$this->db->where('a.habilitado',1);

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

	}// end dameAsignatura


	public function dameAsignaturasHabilitadasPorOfertaCurso($id_oe, $curso){

		$this->db->select('a.id_asignatura');
		$this->db->select('a.asignatura');
		$this->db->from('grl_asignaturas a');
		$this->db->join('grl_planes p','p.id_plan = a.id_plan');

		$this->db->where('p.id_oe',$id_oe);

		$this->db->where('a.curso', $curso);
		$this->db->where('a.habilitado',1);
		$this->db->where('p.habilitado',1);

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

	}// end dameAsignatura
	

	public function dameAsignaturasHabilitadasPorOferta($id_oe){

		$this->db->select('a.id_asignatura');
		$this->db->select('a.asignatura');
		$this->db->from('grl_asignaturas a');
		$this->db->join('grl_planes p','p.id_plan = a.id_plan');
		$this->db->where('p.id_oe',$id_oe);
		$this->db->where('a.habilitado',1);
		$this->db->where('p.habilitado',1);

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
		
	}// end dameAsignatura

}//end class model asignatura

?>