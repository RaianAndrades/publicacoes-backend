<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autor_model extends CI_Model {

	// public $idUsuario;
	public $NomeAutor;
	public $EmailAutor;
	public $ProfissaoAutor;
	
	
	

	public function Create($pNovo)
	{
			
			$this->db->set('NomeAutor', $pNovo->NomeAutor);
			$this->db->set('EmailAutor', $pNovo->EmailAutor);
			$this->db->set('ProfissaoAutor', $pNovo->ProfissaoAutor);

			
			$this->db->insert('tb_Autor');
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
	}

	 public function Update($pAltera)
    {
    	
	    	$this->db->trans_begin();
			$this->db->set('NomeAutor', $pAltera->NomeAutor);
			$this->db->set('EmailAutor', $pAltera->EmailAutor);
			$this->db->set('ProfissaoAutor', $pAltera->ProfissaoAutor);

			$this->db->where('idAutor', $pAltera->idAutor);
	        $this->db->update('tb_Autor');
	        if($this->db->trans_status() === false){
	            $this->db->trans_rollback();
	            $resp['Log'] = false;
	        }else{ 
	        	$this->db->trans_commit();
	            $resp['Log'] = true;
	        }
        return $resp;
	}


	public function Delete($pDeleta)
    {
        $this->db->trans_begin();
        // $this->db->set('Status', 0);
        $this->db->where('idAutor', $pDeleta->idAutor);
        $this->db->delete('tb_Autor');
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $resp['Log'] = false;
        }else{ 
            $this->db->trans_commit();
            $resp['Log'] = true;
        }
        return $resp;
    }


    public function getOneAutor($id)
    {
        $this->db->select('idAutor as id, NomeAutor as name, EmailAutor as email, ProfissaoAutor as profession');
        $this->db->from('tb_Autor');
        $this->db->where('tb_Autor.idAutor', $id);
        $result = $this->db->get()->Result();
        return $result;
    }

    public function getPubAutor($id)
    {
         $this->db->select('tb_AutoresPublicacao.idpublicacao as id, idUsuario as iduser, titulo as title, ano as year, tipo as type, 
            nacionalidade as nationality, completude as completeness');
        $this->db->from('tb_AutoresPublicacao');
        $this->db->join('tb_Publicacao', 'tb_Publicacao.idpublicacao = tb_AutoresPublicacao.idpublicacao');
        $this->db->join('tb_Autor', 'tb_Autor.idautor = tb_AutoresPublicacao.idautor');
        $this->db->where('tb_AutoresPublicacao.idAutor', $id);
        $this->db->where('tb_Publicacao.Status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }





    public function getOneEdit($id)
    {
        $this->db->select('idautor as id, nomeautor as name, emailautor as email, profissaoautor as profession');
        $this->db->from('tb_Autor');
        $this->db->where('tb_Autor.idautor', $id);
        // $this->db->where('tb_Usuario.Status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }


    public function getAll()
    {
        $this->db->select('idAutor as id, NomeAutor as authorname, EmailAutor as authoremail, 
        	ProfissaoAutor as authorprofession');
        $this->db->from('tb_Autor');
        $this->db->order_by("NomeAutor");
        $result = $this->db->get()->Result();
        return $result;
    }


    public function getAutoresPubMenu()
    {
        $this->db->select('idAutor as id, NomeAutor as authorname, EmailAutor as authoremail, 
            ProfissaoAutor as authorprofession');
        $this->db->from('tb_Autor');
        $this->db->limit('5');
        $result = $this->db->get()->Result();
        return $result;
    }

    public function Buscar($nome)
    {
        $this->db->select('idAutor as id, NomeAutor as name, EmailAutor as email, ProfissaoAutor as profession');
        $this->db->from('tb_Autor');
        $this->db->like('NomeAutor', $nome);
        $result = $this->db->get()->Result();
        return $result;
    }



}