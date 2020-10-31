<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class enc_formularios_model extends CI_Model {
    

    public function formDocente($id_encform){
        $this->db->select('r.id_resp');
        $this->db->select('a.id_asignatura,a.asignatura');
        $this->db->select('concat(d.apellido,", ",d.nombre) as docente',false);
        $this->db->select('d.dni');
        $this->db->select('p.id_pregunta, p.pregunta');
        $this->db->select('p.orden');
        $this->db->select('sg.id_subgrupo, sg.subgrupo');
        $this->db->select('g.id_grupo, g.grupo');
        $this->db->select('tr.id_tipo_resp, tr.tipo_resp');
        $this->db->from('enc_resp r');
        $this->db->join('grl_asignaturas a','a.id_asignatura = r.id_asignatura');
        $this->db->join('grl_docentes d','d.id_docente = r.id_docente');
        $this->db->join('enc_grl_preguntas gp','gp.id_gpe = r.id_gpe');
        $this->db->join('enc_preguntas p','p.id_pregunta = gp.id_pregunta');
        $this->db->join('enc_subgrupos sg','sg.id_subgrupo = p.id_subgrupo');
        $this->db->join('enc_grupos g','g.id_grupo = sg.id_grupo');
        $this->db->join('enc_tipo_resp tr', 'tr.id_tipo_resp = sg.id_tipo_resp');
        $this->db->join('rel_encform_gral rel','rel.id_rel = r.id_rel');
        $this->db->join('enc_encform f','f.id_encform = rel.id_encform');
        $this->db->where('f.id_encform',$id_encform);
        $this->db->where('p.id_tipo_enc',1);
        $this->db->order_by('p.orden', 'asc');
        $this->db->order_by('d.apellido', 'asc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }//end function formDocente



    public function formAsig($id_encform){
        $this->db->select('r.id_resp');
        $this->db->select('a.id_asignatura, a.asignatura');
        $this->db->select('p.id_pregunta, p.pregunta');
        $this->db->select('p.orden');
        $this->db->select('sg.id_subgrupo, sg.subgrupo');
        $this->db->select('g.id_grupo, g.grupo');
        $this->db->select('tr.id_tipo_resp, tr.tipo_resp');
        $this->db->from('enc_resp r');
        $this->db->join('grl_asignaturas a','a.id_asignatura = r.id_asignatura');
        $this->db->join('enc_grl_preguntas gp','gp.id_gpe = r.id_gpe');
        $this->db->join('enc_preguntas p','p.id_pregunta = gp.id_pregunta');
        $this->db->join('enc_subgrupos sg','sg.id_subgrupo = p.id_subgrupo');
        $this->db->join('enc_grupos g','g.id_grupo = sg.id_grupo');
        $this->db->join('enc_tipo_resp tr', 'tr.id_tipo_resp = sg.id_tipo_resp');
        $this->db->join('rel_encform_gral rel','rel.id_rel = r.id_rel');
        $this->db->join('enc_encform f','f.id_encform = rel.id_encform');
        $this->db->where('f.id_encform',$id_encform);
        $this->db->where('p.id_tipo_enc',2);
        $this->db->order_by('p.orden', 'asc');

        $query = $this->db->get();
        // echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }//end function formDocente



    public function formInf($id_encform){
        $this->db->select('er.id_resp');
        $this->db->select('ep.id_pregunta, ep.pregunta, ep.orden');
        $this->db->select('esg.id_subgrupo, esg.subgrupo');
        $this->db->select('eg.id_grupo, eg.grupo');
        $this->db->select('etr.id_tipo_resp, etr.tipo_resp');
        $this->db->from('enc_resp er');
        $this->db->join('enc_grl_preguntas egp','egp.id_gpe = er.id_gpe');
        $this->db->join('enc_preguntas ep','ep.id_pregunta = egp.id_pregunta');
        $this->db->join('enc_subgrupos esg','esg.id_subgrupo = ep.id_subgrupo');
        $this->db->join('enc_grupos eg','eg.id_grupo = esg.id_grupo');
        $this->db->join('enc_tipo_resp etr','etr.id_tipo_resp = esg.id_tipo_resp');
        $this->db->join('rel_encform_gral reg','reg.id_rel = er.id_rel');
        $this->db->join('enc_encform ef','ef.id_encform = reg.id_encform');
        $this->db->where('ef.id_encform',$id_encform);
        $this->db->where('ep.id_tipo_enc',3);
        $this->db->order_by('ep.orden', 'asc');

        $query = $this->db->get();
        // echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }//end function formDocente



    public function formAutoEv($id_encform){
        $this->db->select('er.id_resp');
        $this->db->select('ep.id_pregunta, ep.pregunta, ep.orden');
        $this->db->select('esg.id_subgrupo, esg.subgrupo');
        $this->db->select('eg.id_grupo, eg.grupo');
        $this->db->select('etr.id_tipo_resp, etr.tipo_resp');
        $this->db->from('enc_resp er');
        $this->db->join('enc_grl_preguntas egp','egp.id_gpe = er.id_gpe');
        $this->db->join('enc_preguntas ep','ep.id_pregunta = egp.id_pregunta');
        $this->db->join('enc_subgrupos esg','esg.id_subgrupo = ep.id_subgrupo');
        $this->db->join('enc_grupos eg','eg.id_grupo = esg.id_grupo');
        $this->db->join('enc_tipo_resp etr','etr.id_tipo_resp = esg.id_tipo_resp');
        $this->db->join('rel_encform_gral reg','reg.id_rel = er.id_rel');
        $this->db->join('enc_encform ef','ef.id_encform = reg.id_encform');
        $this->db->where('ef.id_encform',$id_encform);
        $this->db->where('ep.id_tipo_enc',4);
        $this->db->order_by('ep.orden', 'asc');

        $query = $this->db->get();
        // echo $this->db->last_query();
        $res=$query->result_array();

        if (count($res)>0)
            return $res;               
        else
            return 0;
    }//end function formDocente

    
}// end model class enc_formularios_model

?>