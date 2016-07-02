<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_Model extends CI_Model {

	public $Email;
	public $Senha;
	public $Nome;
	public $Sobrenome;
	public $Cpf;
	public $Telefone;




	public function Create($pNovo)
	{
		$confere = $this->validateEmail($pNovo->Email);
		if($confere == true){
			$resp['Log'] = false;
			return False;
		}else{
			$this->db->trans_begin();
			$this->db->set('email', $pNovo->Email);
			$this->db->set('senha', $pNovo->Senha);
			$this->db->set('nome', $pNovo->Nome);
			$this->db->set('sobrenome', $pNovo->Sobrenome);
			$this->db->set('cpf', $pNovo->Cpf);
			$this->db->set('telefone', $pNovo->Telefone);
			$this->db->insert('tb_Usuario');
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$resp['Log'] = false;
			}else{
				$resp['idUsuario'] = $this->db->insert_id();
				$this->db->trans_commit();
				$resp['Log'] = true;
			}
			return $resp;
		}	
	}




	
	public function validateEmail($pEmail)
	{
		$this->db->select(' tb_Usuario.idUsuario as id, tb_Usuario.email, tb_Usuario.senha, tb_Usuario.nome as name');
		$this->db->from('tb_Usuario');
		$this->db->where('tb_Usuario.Email', $pEmail);
		$this->db->limit(1);
		$result = $this->db->get()->Result();
		return $result;
	}


	public function returnData($pEmail)
	{
		$this->db->select('tb_Usuario.idusuario as id, tb_Usuario.email as email, tb_Usuario.nome as name');
		$this->db->from('tb_Usuario');
		$this->db->where('tb_Usuario.email', $pEmail);
		$this->db->limit(1);
		$result = $this->db->get()->Result();
		return $result;
	}

	
	public function validateLogin($pUsuario)
	{
		
		$res = $this->validateEmail($pUsuario->Email);
		if($res){
			//$t_senha = $this->encrypt->decode($result[0]->senha);
			$t_senha = $res[0]->senha;
			if($pUsuario->Senha === $t_senha){
				//$new = $pUsuario->Email."".$pUsuario->Senha;
				//$pToken = $this->encrypt->encode($new);
				//$result = $this->changeToken($pToken, $pUsuario->Email);
				// if($result == True){
					$result = $this->returnData($res[0]->email);
					return $result;
				// }else{
				// 	return False;
				// }
			}else{
				return False;
			}
		}else{
			return False;
		}
	}



	
	public function getAll()
    {
        $this->db->select('idusuario as id, nome as name, sobrenome as lastname, email, cpf, telefone as phone');
        $this->db->from('tb_Usuario');
        // $this->db->where('tb_Usuario.Status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }


   
    public function getOneUser($id)
    {
        $this->db->select('idusuario as id, nome as name, email, sobrenome as lastname, cpf, telefone as phone');
        $this->db->from('tb_Usuario');
        $this->db->where('tb_Usuario.idusuario', $id);
        // $this->db->where('tb_Usuario.Status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }

    public function getOneUserEdit($id)
    {
        $this->db->select('idusuario as id, nome as name, email, senha as password, sobrenome as lastname, cpf, telefone as phone');
        $this->db->from('tb_Usuario');
        $this->db->where('tb_Usuario.idusuario', $id);
        // $this->db->where('tb_Usuario.Status', 1);
        $result = $this->db->get()->Result();
        return $result;
    }




    public function Update($pAltera)
    {
    	$confere = $this->validateEmail($pAltera->Email);
		if($confere == true){
			return False;
		}else{
	    	$this->db->trans_begin();
			$this->db->set('email', $pAltera->Email);
			$this->db->set('nome', $pAltera->Nome);
			$this->db->set('senha', $pAltera->Senha);
			$this->db->set('sobrenome', $pAltera->Sobrenome);
			$this->db->set('cpf', $pAltera->Cpf);
			$this->db->set('telefone', $pAltera->Telefone);
			$this->db->where('idusuario', $pAltera->idUsuario);
	        $this->db->update('tb_Usuario');
	        if($this->db->trans_status() === false){
	            $this->db->trans_rollback();
	            $resp['Log'] = false;
	        }else{ 
	        	$this->db->trans_commit();
	            $resp['Log'] = true;
	        }
        return $resp;
	    }
	}


			
			

    public function Delete($pDeleta)
    {
        $this->db->trans_begin();
        $this->db->where('idUsuario', $pDeleta->idUsuario);
        $this->db->delete('tb_Usuario');
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $resp['Log'] = false;
        }else{ 
            $this->db->trans_commit();
            $resp['Log'] = true;
        }
        return $resp;
    }



}



