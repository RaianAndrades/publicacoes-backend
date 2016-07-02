<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PubLivro_model extends CI_Model {

	public $idPublicacao;
	public $Editora;
	public $CidadeEdicao;
	public $TotalPaginas;
	

	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPublicacao', $pNovo->idPublicacao);
			$this->db->set('editora', $pNovo->Editora);
			$this->db->set('cidadeedicao', $pNovo->CidadeEdicao);
			$this->db->set('totalpaginas', $pNovo->TotalPaginas);

		
			
			$this->db->insert('tb_PublicacaoLivro');
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
		
	}


	public function getOnePubLivro($id)
    {
    		$this->db->select('idPublicacao, Editora as publishingcompany, CidadeEdicao as editcity, TotalPaginas as totalpage');
            $this->db->from('tb_PublicacaoLivro');
            $this->db->where('idPublicacao', $id);
            $result = $this->db->get()->Result();
    		return $result;
     }


	

}
