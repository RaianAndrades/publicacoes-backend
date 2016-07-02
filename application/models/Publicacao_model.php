<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicacao_Model extends CI_Model {

	public $idPublicacao;
	public $idUsuario;
	public $Titulo;
	public $Ano;
	public $Tipo;
	public $Nacionalidade;
	public $Completude;
	




	public function Create($pNovo)
	{
		
			$this->db->trans_begin();

			$this->db->set('idUsuario', $pNovo->idUsuario);
			$this->db->set('titulo', $pNovo->Titulo);
			$this->db->set('ano', $pNovo->Ano);
			$this->db->set('tipo', $pNovo->Tipo);
			$this->db->set('nacionalidade', $pNovo->Nacionalidade);
			$this->db->set('completude', $pNovo->Completude);
			$this->db->set('status', 1);
			
			$this->db->insert('tb_Publicacao');
			if($this->db->trans_status() === false){
				$resp['Log'] = false;
				// $this->db->trans_rollback();
			}else{
				$resp['idPublicacao'] = $this->db->insert_id();
				$resp['Log'] = true;
				// $this->db->trans_commit();
			}
			return $resp;
		
	}



	
	public function getAll()
    {
        $this->db->select('idpublicacao as id, idUsuario as iduser, titulo as title, ano as year, tipo as type, 
        	nacionalidade as nationality, completude as completeness');
        $this->db->from('tb_Publicacao');
        $this->db->where('tb_Publicacao.Status', 1);
        $this->db->order_by("idpublicacao","desc");
        $result = $this->db->get()->Result();
        return $result;
    }


    public function getAllYear()
    {
        $this->db->select('idpublicacao as id, ano as year');
        $this->db->from('tb_Publicacao');
        $this->db->where('tb_Publicacao.Status', 1);
        $this->db->group_by("ano");
        $this->db->order_by("ano","desc");
        $this->db->limit('5');
        $result = $this->db->get()->Result();
        return $result;
    }

    

    public function getPubUsuario($id)
    {
        $this->db->select('idpublicacao as id, idUsuario as iduser, titulo as title, ano as year, tipo as type, 
            nacionalidade as nationality, completude as completeness');
        $this->db->from('tb_Publicacao');
        $this->db->where('tb_Publicacao.Status', 1);
        $this->db->where('idUsuario', $id);
        $result = $this->db->get()->Result();
        return $result;
    }


     public function getPubYear($ano)
    {
        $this->db->select('idpublicacao as id, idUsuario as iduser, titulo as title, ano as year, tipo as type, 
            nacionalidade as nationality, completude as completeness');
        $this->db->from('tb_Publicacao');
        $this->db->where('tb_Publicacao.Status', 1);
        $this->db->where('ano', $ano);
        $result = $this->db->get()->Result();
        return $result;
    }
    

    public function getAutoresPublicacao($id)
    {
        $this->db->select('tb_Autor.idAutor as id, tb_Autor.nomeautor as name');
        $this->db->from('tb_AutoresPublicacao');
        $this->db->join('tb_Publicacao', 'tb_Publicacao.idpublicacao = tb_AutoresPublicacao.idpublicacao');
        $this->db->join('tb_Autor', 'tb_Autor.idautor = tb_AutoresPublicacao.idautor');
        $this->db->where('tb_AutoresPublicacao.idPublicacao', $id);
        $this->db->where('tb_Publicacao.Status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }




   
    public function getOnePublicacao($id)
    {
        $this->db->select('idpublicacao as id, idUsuario as iduser, titulo as title, ano as year, tipo as type, 
        	nacionalidade as nationality, completude as completeness');
        $this->db->from('tb_Publicacao');
        $this->db->where('tb_Publicacao.idpublicacao', $id);
        $this->db->where('tb_Publicacao.Status', 1);
        $result = $this->db->get()->Result();
        return $result;

        
    }




    public function Update($pAltera)
    {
    	
	    	$this->db->trans_begin();
			$this->db->set('idUsuario', $pAltera->idUsuario);
			$this->db->set('titulo', $pAltera->Titulo);
			$this->db->set('ano', $pAltera->Ano);
			$this->db->set('tipo', $pAltera->Tipo);
			$this->db->set('nacionalidade', $pAltera->Nacionalidade);
			$this->db->set('completude', $pAltera->Completude);

			$this->db->where('idpublicacao', $pAltera->idPublicacao);
	        $this->db->update('tb_Publicacao');
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
        $this->db->set('Status', 0);
        $this->db->where('idPublicacao', $pDeleta->idPublicacao);
        $this->db->update('tb_Publicacao');
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $resp['Log'] = false;
        }else{ 
            $this->db->trans_commit();
            $resp['Log'] = true;
        }
        return $resp;
    }

    public function Buscar($title)
    {
        $this->db->select('idpublicacao as id, titulo as title, ano as year, tipo as type, status');
        $this->db->from('tb_Publicacao');
        $this->db->like('titulo', $title);
        $this->db->where('status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }




}



