<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    	
require(APPPATH.'/libraries/REST_Controller.php');

class Autor extends REST_Controller {
public function __construct($config = 'rest')
{
    header('Access-Control-Allow-Origin: *');
    parent::__construct();
}




    
	public function Create_post()
    { 


				$this->load->model('Autor_model');

				
				$autor = new Autor_model();

				
				if($this->post('authorname')!=""){
					$autor->NomeAutor = $this->post('authorname');
				}else{
					$autor->NomeAutor = "";
				}
                if($this->post('authoremail')!=""){
                    $autor->EmailAutor = $this->post('authoremail');
                }else{
                    $autor->EmailAutor = "";
                }
                if($this->post('authorprofession')!=""){
                    $autor->ProfissaoAutor = $this->post('authorprofession');
                }else{
                    $autor->ProfissaoAutor = "";
                }
               
                
                $autor->idUsuario = $this->post('iduser');

                $fbk = $this->Autor_model->Create($autor); 

                
                 if($fbk == true){

                  $result = array('Sucess' => 'Autor cadastrado com sucesso!' );
                    $HttpCode = 200;
                         
                }else{
                    $result = array('Error' => 'Erro ao cadastrar publicação!' );
                    $HttpCode = 500;
                }
		
				
			
		return $this->response($result);	    
	}


  
    public function Delete_delete()
    {
           
                if($this->delete('id')){
                    
                        $this->load->model('Autor_model');
                       

                        $autor = new Autor_model();

                        $autor->idAutor = $this->delete('id');
                        $res = $this->Autor_model->Delete($autor);
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
       
                $this->load->model('Autor_model');
                
            
                $autor = new Autor_model();
              
              
               
                if($this->put('name')!=""){
                    $autor->NomeAutor = $this->put('name');
                }else{
                    $autor->NomeAutor = "";
                }
                if($this->put('email')!=""){
                    $autor->EmailAutor = $this->put('email');
                }else{
                    $autor->EmailAutor = "";
                }
                if($this->put('profession')!=""){
                    $autor->ProfissaoAutor = $this->put('profession');
                }else{
                    $autor->ProfissaoAutor = "";
                }
                
                $autor->idAutor = $this->put('id');
                $fbk = $this->Autor_model->Update($autor);
            
                     
                        if($fbk == true){
                            $result = array('Sucess' => 'Alterado com sucesso!' );
                            $HttpCode = 200;
                        }else{
                            $result = array('Error' => 'Erro ao editar autor.' );
                            $HttpCode = 500;
                        }

        return $this->response($result, $HttpCode); 
    }


    

    public function getAll_get()
    {
       
            $this->load->model('Autor_model');
            $res = $this->Autor_model->getAll();
            $result['lista'] = array();
            foreach ($res as $autor) {
                array_push($result['lista'], $autor);
             }
            $HttpCode = 200;
            
            return $this->response($result, $HttpCode); 
    }


    public function getAutoresPubMenu_get()
    {

            $this->load->model('Autor_model');
            $res = $this->Autor_model->getAutoresPubMenu();
            $result['lista'] = array();
            foreach ($res as $autor) {
                array_push($result['lista'], $autor);
             }
            $HttpCode = 200;
                    
             
            return $this->response($result, $HttpCode); 
    }


    public function getPubAutor_get()
    {
            $id = $this->get('id');
            $this->load->model('Autor_model');
            $res = $this->Autor_model->getPubAutor($id);

            $result['lista'] = array();
            foreach ($res as $autor) {
                array_push($result['lista'], $autor);
             }
            $HttpCode = 200;

            return $this->response($result, $HttpCode); 
    }


  
    public function getOne_get()
    {
       
            if($this->get('id')){
       
                    $id = $this->get('id');
                    $this->load->model('Autor_model');
                    $res = $this->Autor_model->getOneAutor($id);

                    if($res != False){
                        $emp['id'] = $res[0]->id;
                        $emp['name'] = $res[0]->name;
                        $emp['email'] = $res[0]->email;
                        $emp['profession'] = $res[0]->profession;
            
                        $result = $emp;
                         
                        $HttpCode = 200;
                    }else{
                        $result['error'] = "Autor não encontrado!";
                        $HttpCode = 404;
                    }
                    
            }else{
                $res = array('Error' => 'Falta o ID' );
                $HttpCode = 400;
            }
       
        return $this->response($result, $HttpCode); 
    }

     public function getOneEdit_get()
        {
           
                if($this->get('id')){
         
                        $id = $this->get('id');
                        $this->load->model('Autor_model');
                        $res = $this->Autor_model->getOneEdit($id);
                        if($res != False){
                            $emp['id'] = $res[0]->id;
                            $emp['email'] = $res[0]->email;
                            $emp['profession'] = $res[0]->profession;
                            $emp['name'] = $res[0]->name;
                
                            $result = $emp;
                             
                            $HttpCode = 200;
                        }else{
                            $result['error'] = "Autor não encontrado!";
                            $HttpCode = 404;
                        }
                        
               
                }else{
                    $result = array('Error' => 'Falta o ID' );
                    $HttpCode = 400;
                }
           
            return $this->response($result, $HttpCode); 
        }




    public function Buscar_get()
    {
       
        $nome = $this->get('name');
        $this->load->model('Autor_model');
        //$result['employee'] = array();
        $res = $this->Autor_model->Buscar($nome);
        if($res != False){
            $result['lista'] = array();
            foreach ($res as $autor) {
                array_push($result['lista'], $autor);
             }
            $HttpCode = 200;
        }else{
             $result['lista'] = array();
             $HttpCode = 200;
        }
        
        return $this->response($result, $HttpCode); 
    }


	  
    
}