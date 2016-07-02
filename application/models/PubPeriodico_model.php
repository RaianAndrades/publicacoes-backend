<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PubPeriodico_model extends CI_Model {

	public $idPublicacao;
	public $PaginaInicial;
	public $PaginaFinal;
	public $Volume;
	public $Numero;
	public $Nome;

	
	

	public function Create($pNovo)
	{
		
			
			$this->db->set('idPublicacao', $pNovo->idPublicacao);
			$this->db->set('paginainicial', $pNovo->PaginaInicial);
			$this->db->set('paginafinal', $pNovo->PaginaFinal);
			$this->db->set('volume', $pNovo->Volume);
			$this->db->set('numero', $pNovo->Numero);
			$this->db->set('nome', $pNovo->Nome);
			
			$this->db->insert('tb_PublicacaoPeriodico');
			if($this->db->trans_status() === false){
				// $this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$resp['idPublicacaoPeriodico'] = $this->db->insert_id();
				// $this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
	}

	public function getOnePublicacaoPeriodico($id)
    {
        $this->db->select('idPublicacaoPeriodico, PaginaInicial as startpage, PaginaFinal as endpage,
                	volume, Numero as number, Nome as name');
        $this->db->from('tb_PublicacaoPeriodico');
        $this->db->where('idpublicacao', $id);
        $result = $this->db->get()->Result();
        return $result;
     }

}
