<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class enc_gral_model extends CI_Model {

    public function checkEncGralActiva($id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo){

        $this->db->select('id_enc_gral');
        $this->db->from('enc_gral');
        $this->db->where('id_sede',$id_sede);
        $this->db->where('id_asignatura',$id_asignatura);
        $this->db->where('id_ua',$id_ua);
        $this->db->where('id_oe',$id_oe);
        $this->db->where('id_periodo',$id_periodo);
        $this->db->where('habilitado',1);
        $this->db->where('activa',1);

        $query = $this->db->get();
        //echo $this->db->last_query();

        //	Obtiene los valores de las encuestasGral cuyos valores coincidan
        $res=$query->result_array();

        if (count($res)==4)
        {
            return true;
        }
        else
        {
            return false;
        }// end if

    }// end dameEncGral
    public function dameEncGral($id_tipo_enc, $id_sede, $id_asignatura , $id_ua, $id_oe, $id_periodo){

        $this->db->select('id_enc_gral');
        $this->db->from('enc_gral');
        $this->db->where('id_tipo_enc',$id_tipo_enc);
        $this->db->where('id_sede',$id_sede);
        $this->db->where('id_asignatura',$id_asignatura);
        $this->db->where('id_ua',$id_ua);
        $this->db->where('id_oe',$id_oe);
        $this->db->where('id_periodo',$id_periodo);
        $this->db->where('habilitado',1);
        $this->db->where('activa',1);

        $query = $this->db->get();
        //echo $this->db->last_query();

        //	Obtiene los valores de las encuestasGral cuyos valores coincidan
        $res=$query->row();

        if (isset($res))
        {
            return $res->id_enc_gral;
        }
        else
        {
                return 0;
        }// end if

    }// end dameEncGral

    public function dameDatosEncGral($id_enGral){

        $this->db->select('eg.id_enc_gral');
        $this->db->select('a.asignatura');
        $this->db->select('oe.oe as oferta');
        $this->db->from('enc_gral eg');
        $this->db->join('grl_asignaturas a','a.id_asignatura = eg.id_asignatura');
        $this->db->join('grl_ooee oe','oe.id_oe = eg.id_oe');
        $this->db->where('id_enc_gral',$id_enGral);
        $this->db->where('eg.habilitado',1);
        $query = $this->db->get();
        //echo $this->db->last_query();

        $res=$query->result_array();

        if (count($res)>0)
        {
            return $res[0];               
        }
        else
        {
            return 0;
        }

    }// end dameEncGral
//    public function dameDatosEncGralPorIdEncForm($id_encForm){
//
//        $this->db->select('eg.id_enc_gral');
//        $this->db->select('a.asignatura');
//        $this->db->select('oe.oe');
//        $this->db->from('enc_gral eg');
//        $this->db->join('grl_asignaturas a','a.id_asignatura = eg.id_asignatura');
//        $this->db->join('rel_encform_gral r_ef_eg',"eg.id_enc_gral = r_ef_eg.id_enc_gral and r_ef_eg.id_encform=$id_encForm");
//        $this->db->join('grl_ooee oe','oe.id_oe = eg.id_oe');
//        $this->db->where('id_tipo_enc',$id_tipo_enc);
//        $this->db->where('eg.id_sede',$id_sede);
//        $this->db->where('eg.id_asignatura',$id_asignatura);
//        $this->db->where('eg.id_ua',$id_ua);
//        $this->db->where('eg.id_oe',$id_oe);
//        $this->db->where('eg.id_periodo',$id_periodo);
//        $this->db->where('eg.habilitado',1);
//        $query = $this->db->get();
//        //echo $this->db->last_query();
//
//        $res=$query->result_array();
//
//        if (count($res)>0)
//            return $res[0];               
//        else
//            return 0;
//
//    }// end dameEncGral


    public function insertBatch($arrayData){

        // Inserta los valores del arreglo en la tabla enc_form
        $insert=$this->db->insert_batch('enc_gral',$arrayData);

        if (!$insert)
        {
            return 0;
        }
        else
        {
                    return true;
        }// end if

    }// end function insert


    public function insert($data){

        // Inserta los valores del arreglo en la tabla enc_form
        $this->db->insert('enc_gral',$data);

        // obtiene el id de la enc_form que se inserto al ultimo
        $last_id=$this->db->insert_id();

        if (is_null($last_id))
        {
            return 0;
        }
        else
        {
            return $last_id;
        }// end if

    }// end cargarEncForm
     public function dameSedes($id_periodo){

            $this->db->select('distinct(eg.id_sede)');
            $this->db->select('s.sede');
            $this->db->from('enc_gral eg');
            $this->db->join('grl_sedes s','s.id_sede = eg.id_sede','inner');
            $this->db->where('eg.id_periodo',$id_periodo);
            $this->db->order_by('s.sede','asc');
            $query = $this->db->get();
            $res=$query->result_array();

            if (count($res)>0)
                return $res;               
            else
                return 0;
    }// end dameSedes
     public function dameUnidades($id_sede,$id_periodo){

        $this->db->select('distinct(eg.id_ua)');
        $this->db->select('ua.ua');
        $this->db->from('enc_gral eg');
        //$this->db->join('grl_sedes s','s.id_sede = eg.id_sede','inner');
        $this->db->join('grl_uuaa ua','ua.id_ua = eg.id_ua','inner');
        $this->db->where('eg.id_periodo',$id_periodo);
        $this->db->where('eg.id_sede',$id_sede);
        $this->db->order_by('ua.ua','asc');
        $query = $this->db->get();
        $res=$query->result_array();

        if (count($res)>0)
        return $res;               
        else
            return 0;
    }// end dameSedes
    public function dameOfertas($id_sede, $id_ua,$id_periodo){

        $this->db->select('DISTINCT(eg.id_oe)');
        $this->db->select('oe.oe');
        $this->db->from('enc_gral eg');
        $this->db->join('grl_ooee oe','oe.id_oe = eg.id_oe');		
        $this->db->where('eg.id_sede',$id_sede); 
        $this->db->where('eg.id_ua',$id_ua); 
        $this->db->where('eg.id_periodo',$id_periodo);
        $this->db->order_by('oe.oe','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }// end dameOfertas
    public function dameCursos($id_sede, $id_ua,$id_oferta,$id_periodo){

        $this->db->select('DISTINCT(a.curso)');
        $this->db->from('enc_gral eg');
        $this->db->join('grl_asignaturas a','a.id_asignatura = eg.id_asignatura');		
        $this->db->where('eg.id_sede',$id_sede); 
        $this->db->where('eg.id_oe',$id_oferta); 
        $this->db->where('eg.id_ua',$id_ua); 
        $this->db->where('eg.id_periodo',$id_periodo);
        $this->db->where('a.habilitado',1);
        $this->db->order_by('a.curso','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }
    public function dameAsignaturas($id_sede, $id_ua,$id_oferta,$curso,$id_periodo){

        $this->db->select('DISTINCT(eg.id_asignatura)');
        $this->db->select('a.asignatura');
        $this->db->from('enc_gral eg');
        $this->db->join('grl_asignaturas a','a.id_asignatura = eg.id_asignatura');		
        $this->db->where('eg.id_sede',$id_sede); 
        $this->db->where('eg.id_ua',$id_ua); 
        $this->db->where('eg.id_oe',$id_oferta); 
        $this->db->where('a.curso',$curso); 
        $this->db->where('eg.id_periodo',$id_periodo);
        $this->db->order_by('a.asignatura','asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }// end dameOfertas

       public function actDesactEnc($encgralDoc, $encgralAsig, $id_periodo, $activado){

        $ids=array(
                'encgralDoc'       => $encgralDoc,
                'encgralAsig'      => $encgralAsig,
                
        );

        $this->db->set('activa', $activado);
        $this->db->from('enc_gral');
        $this->db->where_in('id_enc_gral',$ids);
        $this->db->where('habilitado',1);
        $this->db->where('id_periodo',$id_periodo);
        $this->db->update('enc_gral');

        $res = $this->db->affected_rows();
        

        if ($res==0)
        {
            return 0;
        }
        else
        {
            return $res;
        }// end if
    }

}//end model class enc_gral



?>