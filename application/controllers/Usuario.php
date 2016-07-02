<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    	
require(APPPATH.'/libraries/REST_Controller.php');

class Usuario extends REST_Controller {
public function __construct($config = 'rest')
{
    header('Access-Control-Allow-Origin: *');
    parent::__construct();
}




    
	public function Create_post()
    { 
	    
		
				$this->load->model('Usuario_model');

				
				$usuario = new Usuario_model();

				
				if($this->post('email')!=""){
					$usuario->Email = $this->post('email');
				}else{
					$usuario->Email = "";
				}
                if($this->post('password')!=""){
                    $usuario->Senha = $this->post('password');
                }else{
                    $usuario->Senha = "";
                }
				if($this->post('name')!=""){
					$usuario->Nome = $this->post('name');
				}else{
					$usuario->Nome = "";
				}
                if($this->post('lastname')!=""){
                    $usuario->Sobrenome = $this->post('lastname');
                }else{
                    $usuario->Sobrenome = "";
                }
                if($this->post('cpf')!=""){
                    $usuario->Cpf = $this->post('cpf');
                }else{
                    $usuario->Cpf = "";
                }
                if($this->post('phone')!=""){
                    $usuario->Telefone = $this->post('phone');
                }else{
                    $usuario->Telefone = "";
                }

			
				
				$fbk = $this->Usuario_model->Create($usuario); 

                if($fbk == true){
                      $result = array('Sucess' => 'Cadastrado com sucesso!' );
                      $HttpCode = 201;           
                              
                         
                }else if($fbk == false){
                    $result = array('Error' => 'Erro, e-mail já cadastrado!' );
                    $HttpCode = 500;
                }
		
		return $this->response($result);	    
	}


  
    public function Delete_delete()
    {
           
                if($this->delete('id')){

                $this->load->model('Usuario_model');
               

                $usuario = new Usuario_model();

                $usuario->idUsuario = $this->delete('id');
                $res = $this->Usuario_model->Delete($usuario);
                    if($res == true){
                        $result = array('Success' => 'Deletado com sucesso!' );
                        $HttpCode = 200;
                    }else{
                        $result = array('Error' => 'Erro ao Deletar!' );
                        $HttpCode = 200;
                    }

                }else{
                    $result = array('Error' => 'Falta o ID' );
                    $HttpCode = 400;
                }
            return $this->response($result, $HttpCode); 
    }



 
    public function Update_put()
    {
        
                $this->load->model('Usuario_model');
                
            
                $usuario = new Usuario_model();
              
              
               
                if($this->put('email')!=""){
                    $usuario->Email = $this->put('email');
                }else{
                    $usuario->Email = "";
                }
                if($this->put('name')!=""){
                    $usuario->Nome = $this->put('name');
                }else{
                    $usuario->Nome = "";
                }
                 if($this->put('lastname')!=""){
                    $usuario->Sobrenome = $this->put('lastname');
                }else{
                    $usuario->Sobrenome = "";
                }
                if($this->put('cpf')!=""){
                    $usuario->Cpf = $this->put('cpf');
                }else{
                    $usuario->Cpf = "";
                }
                if($this->put('phone')!=""){
                    $usuario->Telefone = $this->put('phone');
                }else{
                    $usuario->Telefone = "";
                }
                if($this->put('password')!=""){
                    $usuario->Senha = $this->put('password');
                }else{
                    $usuario->Senha = "";
                }
                
                $usuario->idUsuario = $this->put('id');
                
                $fbk = $this->Usuario_model->Update($usuario);
            
                     
                        if($fbk == true){
                            $result = array('Sucess' => 'Alterado com sucesso!' );
                            $HttpCode = 200;
                        }else{
                            $result = array('Error' => 'Erro ao alterar usuário.' );
                            $HttpCode = 500;
                        }

            
        return $this->response($result, $HttpCode); 
    }


    

    public function getAll_get()
    {
            

            $this->load->model('Usuario_model');
            $res = $this->Usuario_model->getAll();
            $result['lista'] = array();
            foreach ($res as $usuario) {
                array_push($result['lista'], $usuario);
             }
            $HttpCode = 200;
                    
        
            return $this->response($result, $HttpCode); 
    }


  
    public function getOne_get()
    {
        
            if($this->get('id')){
      
                $id = $this->get('id');
                $this->load->model('Usuario_model');
                $res = $this->Usuario_model->getOneUser($id);
                if($res != False){
                    $emp['id'] = $res[0]->id;
                    $emp['email'] = $res[0]->email;
                    $emp['name'] = $res[0]->name;
                    $emp['lastname'] = $res[0]->lastname;
                    $emp['cpf'] = $res[0]->cpf;
                    $emp['phone'] = $res[0]->phone;
        
                    $result = $emp;
                     
                    $HttpCode = 200;
                }else{
                    $result['error'] = "Usuário não encontrado!";
                    $HttpCode = 404;
                }
                    
            
            }else{
                $result = array('Error' => 'Falta o ID' );
                $HttpCode = 400;
            }
     
        return $this->response($result, $HttpCode); 
    }

    public function getOneEdit_get()
    {
       
            if($this->get('id')){
       
                    $id = $this->get('id');
                    $this->load->model('Usuario_model');
                    $res = $this->Usuario_model->getOneUserEdit($id);
                    if($res != False){
                        $emp['id'] = $res[0]->id;
                        $emp['email'] = $res[0]->email;
                        $emp['password'] = $res[0]->password;
                        $emp['name'] = $res[0]->name;
                        $emp['lastname'] = $res[0]->lastname;
                        $emp['cpf'] = $res[0]->cpf;
                        $emp['phone'] = $res[0]->phone;
            
                        $result = $emp;
                         
                        $HttpCode = 200;
                    }else{
                        $result['error'] = "Usuário não encontrado!";
                        $HttpCode = 404;
                    }
                    
            
            }else{
                $result = array('Error' => 'Falta o ID' );
                $HttpCode = 400;
            }
      
        return $this->response($result, $HttpCode); 
    }


  

    public function Login_post()
    {
        $result = "";
        $HttpCode = "";
        if(($this->post('email')!="")&&($this->post('password')!="")){
            $this->load->model('usuario_model');
            $usuario = new Usuario_model();
            $usuario->Email = $this->post('email');
            $usuario->Senha = $this->post('password');
            $dados = $this->usuario_model->validateLogin($usuario);
            if($dados != False){

                $result = array('Sucess' => 'Login efetuado com sucesso' );
                $result['Usuario'] = $dados[0];
                $HttpCode = 200;
                
            }else{
                //$access = False;
                $result = array('Error' => 'Dados incorretos!' );
                $HttpCode = 406;
            }
           
              
        }else{
            $result = array('Error' => 'Preencha os campos!' );
            $HttpCode = 406;
        }
        return $this->response($result, $HttpCode);

    }


	  
    
}