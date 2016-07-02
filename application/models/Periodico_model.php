<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periodico_model extends CI_Model {

	public $idPublicacaoPeriodico;
	public $NomePeriodico;
	public $SiglaPeriodico;
	public $Qualis;
	
	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPublicacaoPeriodico', $pNovo->idPublicacaoPeriodico);
			$this->db->set('nomeperiodico', $pNovo->NomePeriodico);
			$this->db->set('siglaperiodico', $pNovo->SiglaPeriodico);
			$this->db->set('qualis', $pNovo->Qualis);

			
			$this->db->insert('tb_Periodico');
			if($this->db->trans_status() === false){
				// $this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$resp['idPeriodico'] = $this->db->insert_id();
				$resp['Log'] = true;
			}
			return $resp;
	}

	public function getOnePeriodico($id)
    {
    	$this->db->select('idPeriodico, idPublicacaoPeriodico, NomePeriodico as periodicname, 
    		SiglaPeriodico as initialperiodic, qualis');
                $this->db->from('tb_Periodico');
                $this->db->where('idPublicacaoPeriodico', $id);
                $result = $this->db->get()->Result();
        		return $result;
     }

}