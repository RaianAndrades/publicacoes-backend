<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AutoresPub_model extends CI_Model {

	// public $idUsuario;
	public $idAutor;
	public $idPublicacao;
	
	
	public function Create($pIdPublicacao, $pAutores)
	{

        $novo = array();
        foreach ($pAutores as $autor) {
            $montaAutor = array(
                'idPublicacao' => $pIdPublicacao,
                'idAutor' => $autor['id']
                );
            array_push($novo, $montaAutor);
        }
        $this->db->trans_begin();
        $this->db->insert_batch('tb_AutoresPublicacao', $novo);
        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }

	}



	 public function Update($pAltera)
    {
    	
	    	
	}



    public function update($pIdPublicacao, $pAutores)
    {
        $novo = array();
        $confere = array();
        if(!empty($pAutores)){
            foreach ($pAutores as $autor) {
                if(array_key_exists("idautor", $autor)){
                    array_push($confere, $contato['idautor']);
                }else{
                    $montaAutor = array(
                    'idPublicacao' => $pIdPublicacao,
                    'idAutor' => $autor['id']
                    );
                    );
                    array_push($novo, $montaAutor);
                }
            }
           $res = $this->deleteall($pIdPublicacao, $confere);
            if(!empty($novo)){
                $this->db->trans_begin();
                $this->db->insert_batch('tb_AutoresPublicacao', $novo);
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    $res = false;
                }else{
                    $this->db->trans_commit();
                    $res = true;
                }
            }   
        }else{
            $res=$this->deleteall($pIdPublicacao, $confere);
        }   
        return $res;
    }



     public function deleteall($pId, $idAutor)
    {
        $this->db->trans_begin();
        if(isset($idAutor)){
            foreach ($idPhone as $where) {
                $this->db->where('idAutor !=', $where);
            }
        }
        
        $this->db->where('idPublicacao', $pId);
        $this->db->delete('tb_AutoresPublicacao');
        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }


	

 


}