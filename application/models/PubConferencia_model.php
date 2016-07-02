<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PubConferencia_model extends CI_Model {

	public $idPublicacao;
	public $NomeEvento;
	public $SiglaEvento;
	public $CidadeEvento;
	public $PaginaInicial;
	public $PaginaFinal;
	public $Editora;
	

	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPublicacao', $pNovo->idPublicacao);
			$this->db->set('nomeevento', $pNovo->NomeEvento);
			$this->db->set('siglaevento', $pNovo->SiglaEvento);
			$this->db->set('cidadeevento', $pNovo->CidadeEvento);
			$this->db->set('paginainicial', $pNovo->PaginaInicial);
			$this->db->set('paginafinal', $pNovo->PaginaFinal);
			$this->db->set('editora', $pNovo->Editora);

		
			
			$this->db->insert('tb_PublicacaoConferencia');
			if($this->db->trans_status() === false){
				// $this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$resp['idPublicacaoConferencia'] = $this->db->insert_id();
				// $this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
	}


	public function getOnePublicacaoConferencia($id)
    {
    	$this->db->select('idPublicacao, idPublicacaoConferencia, NomeEvento as eventname, SiglaEvento as initialsevent, CidadeEvento as cityevent, 
                	PaginaInicial as startpage, PaginaFinal as endpage, Editora as publishingcompany');
                $this->db->from('tb_PublicacaoConferencia');
                $this->db->where('idPublicacao', $id);
                $result = $this->db->get()->Result();
        		return $result;
     }


	

}
