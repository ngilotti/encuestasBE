<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Enc_encresp_model extends CI_Model {

    public function cargarEncResp($id_rel, $id_gpe, $id_asignatura, $id_docente){

        $data=array(
                'id_rel'	    => $id_rel,
                'id_gpe'	    => $id_gpe,
                'id_asignatura'	=> $id_asignatura,
                'id_docente'	=> $id_docente,
        );

        // Inserta los valores del arreglo en la tabla enc_form
        $this->db->insert('enc_resp',$data);

        // obtiene el id de la enc_form que se inserto al ultimo
        $res=$this->db->insert_id();

        if (is_null($res))
        {
            return 0;
        }
        else
        {
            return true;
        }// end if

    }//end function cargarEncResp

        
    public function updateValor($id, $valor)
    {
        $date = date('Y-m-d H:i:s');
        $datos['valor']=$valor;
        $datos['fecha_resp']=$date;
        $this->db->where("id_resp",$id);
        if ($this->db->update('enc_resp',$datos))
            return true;
        else
            return false;
    }

}// end model class encResp
?>