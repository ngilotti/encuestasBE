<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_vista_model extends CI_Model {



	public function dameCabeceras(){

		$this->db->select('vc.id');
		$this->db->select('vc.docentes');
		$this->db->from('vista_cabeceras vc');
		$this->db->group_by('vc.id_sede, vc.id_ua, vc.dni',false);

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

	} // end funcion dameCabeceras

	public function dameCabeceraPorId($id){

		$this->db->select('rc.*');
		$this->db->select('p.periodo');
		$this->db->from('enc_resultados_cabecera rc');
		$this->db->join('grl_periodo p', 'on p.id_periodo=rc.id_periodo', 'inner');
		$this->db->where('id', $id);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		$res=$query->result_array();

		if (count($res)>0)
	    {
	        return $res[0];               
	    }
	    else
	    {
			return 0;
		}// end if

	} // end funcion dameCabeceraPorId
	

	public function dameCabeceraPorDNI($dni){

		$this->db->select('rc.*');
		$this->db->select('p.periodo');
		$this->db->from('enc_resultados_cabecera rc');
		$this->db->join('grl_periodo p', 'on p.id_periodo=rc.id_periodo', 'inner');
		$this->db->where('dni', $dni);

		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		$res=$query->result_array();

		if (count($res)>0)
	    {
	        return $res[0];               
	    }
	    else
	    {
			return 0;
		}// end if

	} // end funcion dameCabeceraPorId




	public function damePreguntas($id_sede,$id_ua,$dni){

		$this->db->select('vr.id_pregunta, vr.pregunta, id_tipo_resp');
		$this->db->from('vista_respuestas vr');
		$this->db->where('vr.id_sede', $id_sede);
		$this->db->where('vr.id_ua', $id_ua);
		$this->db->where('vr.dni', $dni);

		$this->db->group_by('vr.id_pregunta',false);

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

	}// end damePreguntas



	public function dameAtributos($id_sede,$id_ua,$dni,$id_pregunta){

		$this->db->select('era.id_sede as sede,era.id_oe,era.oferta as oe, era.abv as cod,era.id_asignatura,era.asignatura, era.id');
		$this->db->from('enc_resultados_agrupados era');
		$this->db->where('era.id_sede', $id_sede);
		$this->db->where('era.id_ua', $id_ua);
		$this->db->where('era.dni', $dni);
		$this->db->where('era.id_pregunta', $id_pregunta);
		$this->db->group_by('era.sede, era.oferta, era.asignatura');

		$query = $this->db->get();
		// echo $this->db->last_query();
		$res=$query->result_array();

		if (count($res)>0)
	    {
	        return $res;               
	    }
	    else
	    {
			return 0;
		}// end if

	}// end dameResutados

	public function dameValores($id_sede,$id_ua,$dni,$id_pregunta,$id_oe,$id_asignatura,$op){

		$this->db->select('sum(q) as q',false);
		$this->db->from('enc_resultados_agrupados era');
		$this->db->where('era.id_sede', $id_sede);
		$this->db->where('era.id_ua', $id_ua);
		$this->db->where('era.dni', $dni);
		$this->db->where('era.id_pregunta', $id_pregunta);
		$this->db->where('era.id_oe', $id_oe);
		$this->db->where('era.id_asignatura', $id_asignatura);
		$this->db->where('era.valor', $op);

		$query = $this->db->get();
		// echo $this->db->last_query();die();	
		$res=$query->row();

		if (isset($res))
	    {
	        return $res->q;               
	    }
	    else
	    {
			return 0;
		}// end if

	}// end dameResutados

	public function dameCabeceraDocPorId($id){

		$this->db->select('vc.id');
		$this->db->select('p.periodo');
		$this->db->select('vc.docentes');
		$this->db->select('vc.dni');
		$this->db->from('vista_cabeceras vc');
		$this->db->join('grl_periodo p', 'on p.id_periodo=rc.id_periodo', 'inner');
		$this->db->group_by('vc.id_sede, vc.id_ua, vc.dni',false);

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

	} // end funcion dameCabeceras

}//end class model unidades
?>
