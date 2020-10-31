<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class res_cabecera_model extends CI_Model {

	public function checkCabecera($id_cabecera)
	{
	    $this->db->set('generado',1);
	    $this->db->where('id',$id_cabecera);
	    $this->db->update('enc_resultados_cabecera');
	}// end checkCabecera()


	public function dameCabeceraNoCheck()
	{
		$this->db->select('id');
		$this->db->from('enc_resultados_cabecera');
		$this->db->where('generado',0);
		$this->db->limit(100);

		$query = $this->db->get();
        // echo $this->db->last_query();

        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;

	}// end checkCabecera()


	public function dameCabeceraNoCheckDoc()
	{
		$this->db->select('id');
		$this->db->select('dni');
		$this->db->from('enc_resultados_cabecera');
		$this->db->where('check_doc',0);
		// $this->db->limit(1);

		$query = $this->db->get();
        // echo $this->db->last_query(); die();

        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;

	}// end checkCabecera()


}

?>