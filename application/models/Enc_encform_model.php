<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_encform_model extends CI_Model {

    public function insertEncForm($id_sede, $id_ua, $id_oe, $curso, $id_asignatura){

        $data=array(
                'id_sede'		=> $id_sede,
                'id_ua'			=> $id_ua,
                'id_oe'			=> $id_oe,
                'curso'			=> $curso,
                'id_asignatura'	=> $id_asignatura,
        );

        // Inserta los valores del arreglo en la tabla enc_form
        $this->db->insert('enc_encform',$data);

        // obtiene el id de la enc_form que se inserto al ultimo
        $res=$this->db->insert_id();

        if (is_null($res))
        {
            return 0;
        }
        else
        {
            return $res;
        }// end if

    }// end cargarEncForm

    public function verificaFin($id_encForm){

        $this->db->select('ef.fin');
        $this->db->from('enc_encform ef');
        $this->db->where('ef.id_encform',$id_encForm);
        $this->db->where('ef.habilitado',1);
        $query = $this->db->get();
        // echo $this->db->last_query();
        
        $res=$query->row();
        // $num=$this->db->num_rows();

        if (isset($res))
            return $res->fin;               
        else
            return 0;

    }// end dameEncGral
    
    public function checkEncForm($id_encForm){

        $this->db->select('ef.id_encform');
        $this->db->from('enc_encform ef');
        $this->db->join('rel_encform_gral r',"ef.id_encform = r.id_encform");
        $this->db->join('enc_gral g',"g.id_enc_gral = r.id_enc_gral and g.id_tipo_enc = 1");
        $this->db->where('ef.id_encform',$id_encForm);
        $this->db->where('ef.habilitado',1);
        $this->db->where('g.activa',1);
        $this->db->where('ef.fin',0);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res=$query->result_array();
        $num=$query->num_rows();

        if ($num==1)
            return true;               
        else
            return false;

    }// end dameEncGral

    public function dameIdEncGralTipoDocente($id_encForm){

        $this->db->select('r.id_enc_gral');
        $this->db->from('enc_encform ef');
        $this->db->join('rel_encform_gral r',"ef.id_encform = r.id_encform");
        $this->db->join('enc_gral g',"g.id_enc_gral = r.id_enc_gral");
        $this->db->where('ef.id_encform',$id_encForm);
        $this->db->where('ef.habilitado',1);
        $this->db->where('ef.fin',0);
        $this->db->where('g.id_tipo_enc',1);
        $query = $this->db->get();
        //  echo $this->db->last_query();

        $res=$query->row();

        if (isset($res))
            return $res->id_enc_gral;               
        else
            return 0;

    }// end dameEncGral

    public function dameEncFormTotal($id_sede, $id_ua, $id_oe, $curso, $id_asignatura){

        $this->db->select('id_encform');
        $this->db->from('enc_encform');
        $this->db->where('id_sede',$id_sede);
        $this->db->where('id_ua',$id_ua);
        $this->db->where('id_oe',$id_oe);
        $this->db->where('curso',$curso);
        $this->db->where('id_asignatura',$id_asignatura);
        $query = $this->db->get();
        // echo $this->db->last_query();

        $res=$query->num_rows();
        if (isset($res))
            return $res;               
        else
            return 0;
    }// end dameTotalEncForm
    
    public function dameEstados($id_enc_gral){

        $this->db->select('count(ef.id_encform) as total');
        $this->db->select('sum(ef.fin) as fin');
        $this->db->from('enc_encform ef');
        $this->db->join('rel_encform_gral rel', 'rel.id_encform = ef.id_encform', 'inner');
        $this->db->where('rel.id_enc_gral',$id_enc_gral);

        $query = $this->db->get();
        // echo $this->db->last_query();

        $res=$query->result_array();

        if (count($res)>0)
            return $res[0];               
        else
            return 0;
    }// end dameTotalEncForm
    public function updateTxt($id, $txt)
    {
        $date = date('Y-m-d H:i:s');
        $datos['texto_libre']=$txt;
        $datos['fin']=1;
        $datos['fecha_fin']=$date;
        $this->db->where("id_encform",$id);
        if ($this->db->update('enc_encform',$datos))
            return true;
        else
            return false;
    }

}// end class model encform
?>