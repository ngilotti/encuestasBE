<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_ofertas_model extends CI_Model {

public function dameOfertas($id_sede, $id_ua){

	$this->db->select('DISTINCT(oe.id_oe)');
	$this->db->select('oe.oe');						//SELECT DISTINCT oe.id_oe,oe.oe Ofertas,ua.id_ua,ua.ua Unidades,s.id_sede,s.sede Sedes  
	$this->db->from('grl_ooee oe');								// from grl_ooee oe
	$this->db->join('grl_uuaa ua','oe.id_ua = ua.id_ua');		// INNER JOIN grl_uuaa ua on oe.id_ua = ua.id_ua 
	$this->db->join('rel_ooee_sedes r','r.id_oe = oe.id_oe');	//INNER JOIN rel_ooee_sedes r on r.id_oe=oe.id_oe 
	$this->db->join('grl_sedes s','s.id_sede = r.id_sede');		// INNER JOIN grl_sedes s on s.id_sede=r.id_sede
	$this->db->where('s.id_sede',$id_sede);						// where s.id_sede=2 
	$this->db->where('ua.id_ua',$id_ua);						// and ua.id_ua=4
	$this->db->where('oe.habilitado',1);						// and oe.habilitado=1

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

	}// end dameOfertas

}//end class model ofertas
?>