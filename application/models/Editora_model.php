<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editora_model extends CI_Model {

	public $idPublicacao;
	public $NomeEditora;
	public $EnderecoEditora;
	
	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPeriodico', $pNovo->idPeriodico);
			$this->db->set('nomeeditora', $pNovo->NomeEditora);
			$this->db->set('enderecoeditora', $pNovo->EnderecoEditora);

			
			$this->db->insert('tb_Editora');
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
		
	}



	public function getOneEditora($id)
    {
    	$this->db->select('NomeEditora as publishingcompanyname, EnderecoEditora as publishingcompanyaddress');
                $this->db->from('tb_Editora');
                $this->db->where('idPeriodico', $id);
                $result = $this->db->get()->Result();
        		return $result;
     }




	

}