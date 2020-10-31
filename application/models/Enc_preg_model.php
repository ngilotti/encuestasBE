<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

class enc_preg_model extends CI_Model {

	public function damePreguntas($tipo, $periodo){
				
		$this->db->select('p.id_pregunta');
		$this->db->from('enc_preguntas p');
		$this->db->where('id_tipo_enc', $tipo);
		$this->db->where('id_periodo', $periodo);
		$this->db->where('p.habilitado', 1);

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

	}//end damePreguntas

	public function dameTxtPreg($tipo, $periodo){
				
		$this->db->select('p.id_pregunta, p.pregunta, p.orden');
		$this->db->select('p.pregunta as txt');
		$this->db->select('etr.tipo_resp');
		$this->db->select('sg.id_tipo_resp');
		$this->db->select('sg.id_tipo_resp as tipo');
		$this->db->from('enc_preguntas p');
		$this->db->where('id_tipo_enc', $tipo);
		$this->db->where('id_periodo', $periodo);
		$this->db->where('p.habilitado', 1);
		$this->db->join('enc_subgrupos sg', 'on sg.id_subgrupo=p.id_subgrupo', 'inner');
		$this->db->join('enc_tipo_resp etr', 'on etr.id_tipo_resp=sg.id_tipo_resp', 'inner');
		$this->db->order_by('p.orden', 'asc');

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

	}//end damePreguntas

}// end class enc_preg_model
?>