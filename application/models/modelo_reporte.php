<?php
class modelo_reporte extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
  		
    }


    public function loadrepop1($id){
        $this->db->select('act.Nombre, objetivo_general, descripcion, monto_propio, monto_otro, fecha_inicio,
        fecha_fin, elaboro, autorizo, (monto_propio + monto_otro) as monto_total, pob.nombre as poblacion, orfu.nombre as origen, nombre_ff, numero_ubp, nombre_ubp, num_pp, nombre_pp');
        $this->db->from('s0_actividad_estrategica as act'); 
        $this->db->join('s0_poblacion_objetivo as pob', 'poblacion_objetivo_id_poblacion = pob.id_poblacion');
        $this->db->join('s0_origen_fuente as orfu', 'origen_fuente_id_origen = id_origen');
        $this->db->join('s0_fuente_financiamiento as fufi', 'fuente_financiamiento_id_ff = id_ff');
        $this->db->join('s0_ubp as ubp', 'ubp_id_ubp = id_ubp');
        $this->db->join('s0_programa_presupuestal', 'programa_presupuestal_id_pp = id_pp');
        $this->db->where('id_actividad_estrategica',$id); 
          $query = $this->db->get();
          
              foreach ($query->result() as $row) {
                 $datos[] = [
                    'Nombre'                             => $row->Nombre, 
                    'objetivo_general'                   => $row->objetivo_general, 
                    'descripcion'                        => $row->descripcion, 
                    'monto_propio'                       => $row->monto_propio, 
                    'monto_otro'                         => $row->monto_otro,
                    'monto_total'                        => $row->monto_total,
                    'fecha_inicio'                       => $row->fecha_inicio, 
                    'fecha_fin'                          => $row->fecha_fin,  
                    'elaboro'                            => $row->elaboro, 
                    'autorizo'                           => $row->autorizo,
                    'poblacion'                          => $row->poblacion,
                    'origen'                             => $row->origen,
                    'nombre_ff'                          => $row->nombre_ff,
                    'numero_ubp'                         => $row->numero_ubp,
                    'nombre_ubp'                         => $row->nombre_ubp,
                    'num_pp'                             => $row->num_pp,
                    'nombre_pp'                          => $row->nombre_pp
      
                  ];
              }
              return $datos;
      
    }


    public function recuperarcombobox($idactividad){
        $this->db->select('eje, tema, objetivo, estrategia, lineaaccion, nombre_ods');
        $this->db->from('s0_actividad_estrategica');
        $this->db->join('s0_cat_lineaaccion_ped', 's0_actividad_estrategica.cat_lineaaccion_ped_lineaaccionid=s0_cat_lineaaccion_ped.lineaaccionid');
        $this->db->join('s0_cat_estrategias_ped', 's0_cat_lineaaccion_ped.cat_estrategias_ped_estrategiaid=s0_cat_estrategias_ped.estrategiaid');
        $this->db->join('s0_cat_objetivos', 's0_cat_estrategias_ped.cat_objetivos_objetivoid=s0_cat_objetivos.objetivoid');
        $this->db->join('s0_cat_temas', 's0_cat_objetivos.cat_temas_temaid=s0_cat_temas.temaid');
        $this->db->join('s0_cat_ejes', 's0_cat_temas.cat_ejes_ejeid=s0_cat_ejes.ejeid');
        $this->db->join('s0_ods', 'id_ods = ods_id_ods');
         $this->db->where('s0_actividad_estrategica.id_actividad_estrategica',$idactividad);
           
          $query = $this->db->get();
          
              foreach ($query->result() as $row) {
                 $datos[] = [
                    'eje' => $row->eje,
                    'tema' => $row->tema,
                    'objetivo' => $row->objetivo,
                    'estrategia' => $row->estrategia,
                    'lineaaccion' => $row->lineaaccion,
                    'nombre_ods' => $row->nombre_ods
                 ];
              }
              return $datos;
      
        }

    public function entregables($id){
        $this->db->select('s0_entregables.nombre as entregable, nombre_temp, s0_unidad_medida.nombre as unidad, mismo_benef, municipalizable, presenta_alineacion, meta_Anual, avace_acumulado, monto_ejercido');
        $this->db->from('s0_entregables');
        $this->db->join('s0_temporalidad', 'temporalidad_id_temp = id_temp');
        $this->db->join('s0_unidad_medida', 'Unidad_medida_id_unidad = id_unidad');
        $this->db->where('actividad_estrategica_id_f2', $id);
        $query = $this->db->get();
          
              foreach ($query->result() as $row) {
                 $datos[] = [
                    'entregable' => $row->entregable,
                    'nombre_temp' => $row->nombre_temp,
                    'unidad' => $row->unidad,
                    'mismo_benef' => $row->mismo_benef,
                    'municipalizable' => $row->municipalizable,
                    'presenta_alineacion' => $row->presenta_alineacion,
                    'meta_Anual' => $row->meta_Anual,
                    'avace_acumulado' => $row->avace_acumulado, 
                    'monto_ejercido' => $row->monto_ejercido
                 ];
              }
              return $datos;
    }

    public function compromiso($id){

    }


    public function eje($id){
        $this->db->select('eje');
        $this->db->from('s0_cat_ejes');
        $this->db->where('ejeid', $id);

        $query = $this->db->get();

        foreach($query->result() as $row){
            $datos[] = [
                'eje' => $row->eje
            ];
        }
        return $datos;
    }

    public function tema($id){
        $this->db->select('tema');
        $this->db->from('s0_cat_temas');
        $this->db->where('temaid', $id);

        $query = $this->db->get();

        foreach($query->result() as $row){
            $datos[] = [
                'tema' => $row->tema
            ];
        }
        return $datos;
    }
}