<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localizacao_model extends CI_Model {

	public $idPublicacao;
	public $Latitude;
	public $Longitude;
	public $Endereco;
	
	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPublicacao', $pNovo->idPublicacao);
			$this->db->set('latitude', $pNovo->Latitude);
			$this->db->set('longitude', $pNovo->Longitude);
			$this->db->set('endereco', $pNovo->Endereco);

			
			$this->db->insert('tb_Localizacao');
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
		
	}



	public function getOne($id)
    {
    	$this->db->select('endereco as address');
                $this->db->from('tb_Localizacao');
                $this->db->where('idPublicacao', $id);
                $result = $this->db->get()->Result();
        		return $result;
     }




    




	

}