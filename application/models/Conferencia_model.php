<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conferencia_model extends CI_Model {

	public $idPublicacao;
	public $NomeConferencia;
	public $SiglaConferencia;
	public $Qualis;
	
	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPublicacaoConferencia', $pNovo->idPublicacaoConferencia);
			$this->db->set('nomeconferencia', $pNovo->NomeConferencia);
			$this->db->set('siglaconferencia', $pNovo->SiglaConferencia);
			$this->db->set('qualis', $pNovo->Qualis);

			
			$this->db->insert('tb_Conferencia');
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
		
	}


	public function getOneConferencia($id)
    {
    		$this->db->select('idPublicacaoConferencia, NomeConferencia as conferencename, 
    			SiglaConferencia as initialsconference, qualis');
            $this->db->from('tb_Conferencia');
            $this->db->where('idPublicacaoConferencia', $id);
            $result = $this->db->get()->Result();
    		return $result;
     }



 
			

}