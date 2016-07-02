<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    	
require(APPPATH.'/libraries/REST_Controller.php');

class Publicacao extends REST_Controller {
public function __construct($config = 'rest')
{
    header('Access-Control-Allow-Origin: *');
    parent::__construct();
}







    
	public function Create_post()
    { 


				$this->load->model('Publicacao_model');

				
				$publicacao = new Publicacao_model();

				
				if($this->post('title')!=""){
					$publicacao->Titulo = $this->post('title');
				}else{
					$publicacao->Titulo = "";
				}
                if($this->post('year')!=""){
                    $publicacao->Ano = $this->post('year');
                }else{
                    $publicacao->Ano = "";
                }
                if($this->post('type')!=""){
                    $publicacao->Tipo = $this->post('type');
                }else{
                    $publicacao->Tipo = "";
                }
                if($this->post('nationality')!=""){
                    $publicacao->Nacionalidade = $this->post('nationality');
                }else{
                    $publicacao->Nacionalidade = "";
                }
                if($this->post('completeness')!=""){
                    $publicacao->Completude = $this->post('completeness');
                }else{
                    $publicacao->Completude = "";
                }
                
                $publicacao->idUsuario = $this->post('iduser');
                $type = $this->post('type');

                $fbk = $this->Publicacao_model->Create($publicacao); 


               
                 if($fbk == true){
                     $publicacao->idPublicacao = $fbk['idPublicacao'];
                     $authors = $this->post('authors');
                     if(!empty($authors)){
                                $this->load->model('AutoresPub_model');
                                $autores = $this->post('authors');

                                $publicacao->idPublicacao = $fbk['idPublicacao'];
                                
                                $fbk = $this->AutoresPub_model->Create($publicacao->idPublicacao, $autores);
                                if($fbk == true){
                                    $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                    $HttpCode = 201;
                                }else{
                                    $result = array('Error' => 'Erro ao salvar os autores da publicação' );
                                    $HttpCode = 500;
                                } 
                            }else{
                               if($fbk == true){
                                    $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                    $HttpCode = 201;
                                } 
                            }




                            
                                 $this->load->model('Localizacao_model');

                
                                 $localizacao = new Localizacao_model();

                                 $Latitude = $this->post('lat');
                                 if(!empty($Latitude)){
                                     $localizacao->Latitude = $this->post('lat');
                                 }else{
                                     $localizacao->Latitude = "";
                                 }
                                  $Longitude = $this->post('lng');
                                 if(!empty($Latitude)){
                                     $localizacao->Longitude = $this->post('lng');
                                 }else{
                                    $localizacao->Longitude = "";
                                 }
                                 $Endereco = $this->post('endereco');
                                 if(!empty($Endereco)){
                                     $localizacao->Endereco = $this->post('endereco');
                                 }else{
                                     $localizacao->Endereco = "";
                                 }
                                
                                 $localizacao->idPublicacao = $publicacao->idPublicacao;   
                
                                // $localizacao->idPublicacao = $this->post('idPublicacao');
                                 $fbk = $this->Localizacao_model->Create($localizacao); 
                   

                    switch ($type) {
                        //ADICIONANDO PUBLICACÃO EM PERIÓDICO
                        case 'Periódico':
                        $this->load->model('PubPeriodico_model');
                        $novo = new PubPeriodico_model();
                       
                        $startpage = $this->post('startpage');
                        if(!empty($startpage)){
                            $novo->PaginaInicial = $this->post('startpage');
                        }else{
                            $novo->PaginaInicial = "";
                        }
                        $endpage = $this->post('endpage');
                        if(!empty($endpage)){
                            $novo->PaginaFinal = $this->post('endpage');
                        }else{
                            $novo->PaginaFinal = "";
                        }
                        $volume = $this->post('volume');
                        if(!empty($volume)){
                            $novo->Volume = $this->post('volume');
                        }else{
                            $novo->Volume = "";
                        }
                        $number = $this->post('number');
                        if(!empty($number)){
                            $novo->Numero = $this->post('number');
                        }else{
                            $novo->Numero = "";
                        }
                        $name = $this->post('name');
                        if(!empty($name)){
                            $novo->Nome = $this->post('name');
                        }else{
                            $novo->Nome = "";
                        }
                    
                        //$novo->idPublicacao = $this->post('idPublicacao');
                        $novo->idPublicacao = $publicacao->idPublicacao;
                        
                        $fbkPubPer = $this->PubPeriodico_model->Create($novo);



                        //ADICIONANDO PERIÓDICO
                        if($fbkPubPer == true){
                                    $this->load->model('Periodico_model');
                                    $novo = new Periodico_model();
                                    $periodicname = $this->post('periodicname');
                                    if(!empty($periodicname)){
                                        $novo->NomePeriodico = $this->post('periodicname');
                                    }else{
                                        $novo->NomePeriodico = "";
                                    }
                                    $periodicinitials = $this->post('periodicinitials');
                                    if(!empty($periodicinitials)){
                                        $novo->SiglaPeriodico = $this->post('periodicinitials');
                                    }else{
                                        $novo->SiglaPeriodico = "";
                                    }
                                    $qualis = $this->post('qualis');
                                    if(!empty($qualis)){
                                        $novo->Qualis = $this->post('qualis');
                                    }else{
                                        $novo->Qualis = "";
                                    }

                                    $novo->idPublicacaoPeriodico = $fbkPubPer['idPublicacaoPeriodico'];
                        
                                    $fbkPer = $this->Periodico_model->Create($novo);
                                    $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                    $HttpCode = 201;


                                                //ADICIONANDO EDITORA
                                                if($fbkPer == true){
                                                        $this->load->model('Editora_model');
                                                        $novo = new Editora_model();
                                                        $publishingcompanyname = $this->post('publishingcompanyname');
                                                        if(!empty($publishingcompanyname)){
                                                            $novo->NomeEditora = $this->post('publishingcompanyname');
                                                        }else{
                                                            $novo->NomeEditora = "";
                                                        }
                                                        $publishingcompanyaddress = $this->post('publishingcompanyaddress');
                                                        if(!empty($publishingcompanyaddress)){
                                                            $novo->EnderecoEditora = $this->post('publishingcompanyaddress');
                                                        }else{
                                                            $novo->EnderecoEditora = "";
                                                        }

                                                        $novo->idPeriodico = $fbkPer['idPeriodico'];    
                                            
                                                        $fbkEdi = $this->Editora_model->Create($novo);
                                                        $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                                        $HttpCode = 201;


                                                        
                                                    }else{
                                                        $result = array('Error' => 'Erro ao salvar editora. ' );
                                                        $HttpCode = 500;
                                                    } 


                                    
                                }else{
                                    $result = array('Error' => 'Erro ao salvar publicação periódico. ' );
                                    $HttpCode = 500;
                                } 


                        break;



                        case 'Conferência':

                        $this->load->model('PubConferencia_model');
                        $novo = new PubConferencia_model();

                        $eventname = $this->post('eventname');
                        if(!empty($eventname)){
                            $novo->NomeEvento = $this->post('eventname');
                        }else{
                            $novo->NomeEvento = "";
                        }
                        $eventinitials = $this->post('eventinitials');
                        if(!empty($eventinitials)){
                            $novo->SiglaEvento = $this->post('eventinitials');
                        }else{
                            $novo->SiglaEvento = "";
                        }
                        $eventcity = $this->post('eventcity');
                        if(!empty($eventcity)){
                            $novo->CidadeEvento = $this->post('eventcity');
                        }else{
                            $novo->CidadeEvento = "";
                        }
                        $startpage = $this->post('startpage');
                        if(!empty($startpage)){
                            $novo->PaginaInicial = $this->post('startpage');
                        }else{
                            $novo->PaginaInicial = "";
                        }
                        $endpage = $this->post('endpage');
                        if(!empty($endpage)){
                            $novo->PaginaFinal = $this->post('endpage');
                        }else{
                            $novo->PaginaFinal = "";
                        }
                        $publishingcompany = $this->post('publishingcompany');
                        if(!empty($publishingcompany)){
                            $novo->Editora = $this->post('publishingcompany');
                        }else{
                            $novo->Editora = "";
                        }
                     
                        $novo->idPublicacao = $publicacao->idPublicacao;
                        
                        $fbkPubCon = $this->PubConferencia_model->Create($novo);


                                //ADICIONANDO CONFERENCIA
                             if($fbkPubCon == true){
                                    $this->load->model('Conferencia_model');
                                    $novo = new Conferencia_model();

                                    $conferencename = $this->post('conferencename');
                                    if(!empty($conferencename)){
                                        $novo->NomeConferencia = $this->post('conferencename');
                                    }else{
                                        $novo->NomeConferencia = "";
                                    }
                                    $conferenceinitials = $this->post('conferenceinitials');
                                    if(!empty($conferenceinitials)){
                                        $novo->SiglaConferencia = $this->post('conferenceinitials');
                                    }else{
                                        $novo->SiglaConferencia = "";
                                    }
                                    $qualis = $this->post('qualis');
                                    if(!empty($qualis)){
                                        $novo->Qualis = $this->post('qualis');
                                    }else{
                                        $novo->Qualis = "";
                                    }

                                    $novo->idPublicacaoConferencia = $fbkPubCon['idPublicacaoConferencia'];
                        
                                    $fbkCon = $this->Conferencia_model->Create($novo);



                                    // $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                    // $HttpCode = 201;
                                }else{
                                    $result = array('Error' => 'Erro ao salvar publicação conferência. ' );
                                    $HttpCode = 500;
                                } 
                            
                        break;



                        case 'Livro':

                        $this->load->model('PubLivro_model');
                        $novo = new PubLivro_model();

                        $publishingcompany = $this->post('publishingcompany');
                        if(!empty($publishingcompany)){
                            $novo->Editora = $this->post('publishingcompany');
                        }else{
                            $novo->Editora = "";
                        }
                        $editcity = $this->post('editcity');
                        if(!empty($editcity)){
                            $novo->CidadeEdicao = $this->post('editcity');
                        }else{
                            $novo->CidadeEdicao = "";
                        }
                        $totalpage = $this->post('totalpage');
                        if(!empty($totalpage)){
                            $novo->TotalPaginas = $this->post('totalpage');
                        }else{
                            $novo->TotalPaginas = "";
                        }

                        $novo->idPublicacao = $publicacao->idPublicacao;
                        
                        $fbk = $this->PubLivro_model->Create($novo);

                        
                            
                        break;

                    }

                         
                }else{
                    $result = array('Error' => 'Erro ao cadastrar publicação!' );
                    $HttpCode = 500;
                }
		
		
		return $this->response($result);	    
	}


  
    public function Delete_delete()
    {
          
                if($this->delete('id')){
            
                        $this->load->model('Publicacao_model');
                       

                        $publicacao = new Publicacao_model();

                        $publicacao->idPublicacao = $this->delete('id');
                        $res = $this->Publicacao_model->Delete($publicacao);
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
        

                $this->load->model('Publicacao_model');
                
            
                $publicacao = new Publicacao_model();
              
              
               
                if($this->put('title')!=""){
                    $publicacao->Titulo = $this->put('title');
                }else{
                    $publicacao->Titulo = "";
                }
                if($this->put('year')!=""){
                    $publicacao->Ano = $this->put('year');
                }else{
                    $publicacao->Ano = "";
                }
                if($this->put('type')!=""){
                    $publicacao->Tipo = $this->put('type');
                }else{
                    $publicacao->Tipo = "";
                }
                if($this->put('nationality')!=""){
                    $publicacao->Nacionalidade = $this->put('nationality');
                }else{
                    $publicacao->Nacionalidade = "";
                }
                if($this->put('completeness')!=""){
                    $publicacao->Completude = $this->put('completeness');
                }else{
                    $publicacao->Completude = "";
                }
                
                $publicacao->idpublicacao = $this->put('idpublicacao');
                
                $fbk = $this->Publicacao_model->Update($publicacao);
            
                     
                   
                    if($fbk == true){
                     $publicacao->idPublicacao = $fbk['idPublicacao'];
                     $authors = $this->put('authors');
                     if(!empty($authors)){
                                $this->load->model('AutoresPub_model');
                                $autores = $this->put('authors');

                                $publicacao->idPublicacao = $fbk['idPublicacao'];
                                
                                $fbk = $this->AutoresPub_model->Update($publicacao->idPublicacao, $autores);
                                if($fbk == true){
                                    $result = array('Sucess' => 'Alterado com sucesso!' );
                                    $HttpCode = 201;
                                }else{
                                    $result = array('Error' => 'Erro ao salvar os autores da publicação' );
                                    $HttpCode = 500;
                                } 
                            }else{
                               if($fbk == true){
                                    $result = array('Sucess' => 'Alterado com sucesso!' );
                                    $HttpCode = 201;
                                } 
                            }




                            
                                 $this->load->model('Localizacao_model');

                
                                 $localizacao = new Localizacao_model();

                                 $Latitude = $this->put('lat');
                                 if(!empty($Latitude)){
                                     $localizacao->Latitude = $this->put('lat');
                                 }else{
                                     $localizacao->Latitude = "";
                                 }
                                  $Longitude = $this->put('lng');
                                 if(!empty($Latitude)){
                                     $localizacao->Longitude = $this->put('lng');
                                 }else{
                                    $localizacao->Longitude = "";
                                 }
                                 $Endereco = $this->put('endereco');
                                 if(!empty($Endereco)){
                                     $localizacao->Endereco = $this->put('endereco');
                                 }else{
                                     $localizacao->Endereco = "";
                                 }
                                
                                 $localizacao->idPublicacao = $publicacao->idPublicacao;   
                
                                // $localizacao->idPublicacao = $this->post('idPublicacao');
                                 $fbk = $this->Localizacao_model->Update($localizacao); 
                   

                    switch ($type) {
                        //ADICIONANDO PUBLICACÃO EM PERIÓDICO
                        case 'Periódico':
                        $this->load->model('PubPeriodico_model');
                        $novo = new PubPeriodico_model();
                       
                        $startpage = $this->put('startpage');
                        if(!empty($startpage)){
                            $novo->PaginaInicial = $this->put('startpage');
                        }else{
                            $novo->PaginaInicial = "";
                        }
                        $endpage = $this->put('endpage');
                        if(!empty($endpage)){
                            $novo->PaginaFinal = $this->put('endpage');
                        }else{
                            $novo->PaginaFinal = "";
                        }
                        $volume = $this->put('volume');
                        if(!empty($volume)){
                            $novo->Volume = $this->put('volume');
                        }else{
                            $novo->Volume = "";
                        }
                        $number = $this->put('number');
                        if(!empty($number)){
                            $novo->Numero = $this->put('number');
                        }else{
                            $novo->Numero = "";
                        }
                        $name = $this->put('name');
                        if(!empty($name)){
                            $novo->Nome = $this->put('name');
                        }else{
                            $novo->Nome = "";
                        }
                    
                        //$novo->idPublicacao = $this->post('idPublicacao');
                        $novo->idPublicacao = $publicacao->idPublicacao;
                        
                        $fbkPubPer = $this->PubPeriodico_model->Update($novo);



                        //ADICIONANDO PERIÓDICO
                        if($fbkPubPer == true){
                                    $this->load->model('Periodico_model');
                                    $novo = new Periodico_model();
                                    $periodicname = $this->put('periodicname');
                                    if(!empty($periodicname)){
                                        $novo->NomePeriodico = $this->put('periodicname');
                                    }else{
                                        $novo->NomePeriodico = "";
                                    }
                                    $periodicinitials = $this->put('periodicinitials');
                                    if(!empty($periodicinitials)){
                                        $novo->SiglaPeriodico = $this->put('periodicinitials');
                                    }else{
                                        $novo->SiglaPeriodico = "";
                                    }
                                    $qualis = $this->put('qualis');
                                    if(!empty($qualis)){
                                        $novo->Qualis = $this->put('qualis');
                                    }else{
                                        $novo->Qualis = "";
                                    }

                                    $novo->idPublicacaoPeriodico = $fbkPubPer['idPublicacaoPeriodico'];
                        
                                    $fbkPer = $this->Periodico_model->Update($novo);
                                    $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                    $HttpCode = 201;


                                                //ADICIONANDO EDITORA
                                                if($fbkPer == true){
                                                        $this->load->model('Editora_model');
                                                        $novo = new Editora_model();
                                                        $publishingcompanyname = $this->put('publishingcompanyname');
                                                        if(!empty($publishingcompanyname)){
                                                            $novo->NomeEditora = $this->put('publishingcompanyname');
                                                        }else{
                                                            $novo->NomeEditora = "";
                                                        }
                                                        $publishingcompanyaddress = $this->put('publishingcompanyaddress');
                                                        if(!empty($publishingcompanyaddress)){
                                                            $novo->EnderecoEditora = $this->put('publishingcompanyaddress');
                                                        }else{
                                                            $novo->EnderecoEditora = "";
                                                        }

                                                        $novo->idPeriodico = $fbkPer['idPeriodico'];    
                                            
                                                        $fbkEdi = $this->Editora_model->Update($novo);
                                                        $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                                        $HttpCode = 201;


                                                        
                                                    }else{
                                                        $result = array('Error' => 'Erro ao salvar editora. ' );
                                                        $HttpCode = 500;
                                                    } 


                                    
                                }else{
                                    $result = array('Error' => 'Erro ao salvar publicação periódico. ' );
                                    $HttpCode = 500;
                                } 


                        break;



                        case 'Conferência':

                        $this->load->model('PubConferencia_model');
                        $novo = new PubConferencia_model();

                        $eventname = $this->put('eventname');
                        if(!empty($eventname)){
                            $novo->NomeEvento = $this->put('eventname');
                        }else{
                            $novo->NomeEvento = "";
                        }
                        $eventinitials = $this->put('eventinitials');
                        if(!empty($eventinitials)){
                            $novo->SiglaEvento = $this->put('eventinitials');
                        }else{
                            $novo->SiglaEvento = "";
                        }
                        $eventcity = $this->put('eventcity');
                        if(!empty($eventcity)){
                            $novo->CidadeEvento = $this->put('eventcity');
                        }else{
                            $novo->CidadeEvento = "";
                        }
                        $startpage = $this->put('startpage');
                        if(!empty($startpage)){
                            $novo->PaginaInicial = $this->put('startpage');
                        }else{
                            $novo->PaginaInicial = "";
                        }
                        $endpage = $this->put('endpage');
                        if(!empty($endpage)){
                            $novo->PaginaFinal = $this->put('endpage');
                        }else{
                            $novo->PaginaFinal = "";
                        }
                        $publishingcompany = $this->put('publishingcompany');
                        if(!empty($publishingcompany)){
                            $novo->Editora = $this->put('publishingcompany');
                        }else{
                            $novo->Editora = "";
                        }
                     
                        $novo->idPublicacao = $publicacao->idPublicacao;
                        
                        $fbkPubCon = $this->PubConferencia_model->Update($novo);


                                //ADICIONANDO CONFERENCIA
                             if($fbkPubCon == true){
                                    $this->load->model('Conferencia_model');
                                    $novo = new Conferencia_model();

                                    $conferencename = $this->put('conferencename');
                                    if(!empty($conferencename)){
                                        $novo->NomeConferencia = $this->put('conferencename');
                                    }else{
                                        $novo->NomeConferencia = "";
                                    }
                                    $conferenceinitials = $this->put('conferenceinitials');
                                    if(!empty($conferenceinitials)){
                                        $novo->SiglaConferencia = $this->put('conferenceinitials');
                                    }else{
                                        $novo->SiglaConferencia = "";
                                    }
                                    $qualis = $this->put('qualis');
                                    if(!empty($qualis)){
                                        $novo->Qualis = $this->put('qualis');
                                    }else{
                                        $novo->Qualis = "";
                                    }

                                    $novo->idPublicacaoConferencia = $fbkPubCon['idPublicacaoConferencia'];
                        
                                    $fbkCon = $this->Conferencia_model->Update($novo);



                                    // $result = array('Sucess' => 'Cadastrado com sucesso!' );
                                    // $HttpCode = 201;
                                }else{
                                    $result = array('Error' => 'Erro ao salvar publicação conferência. ' );
                                    $HttpCode = 500;
                                } 
                            
                        break;



                        case 'Livro':

                        $this->load->model('PubLivro_model');
                        $novo = new PubLivro_model();

                        $publishingcompany = $this->put('publishingcompany');
                        if(!empty($publishingcompany)){
                            $novo->Editora = $this->put('publishingcompany');
                        }else{
                            $novo->Editora = "";
                        }
                        $editcity = $this->put('editcity');
                        if(!empty($editcity)){
                            $novo->CidadeEdicao = $this->put('editcity');
                        }else{
                            $novo->CidadeEdicao = "";
                        }
                        $totalpage = $this->put('totalpage');
                        if(!empty($totalpage)){
                            $novo->TotalPaginas = $this->put('totalpage');
                        }else{
                            $novo->TotalPaginas = "";
                        }

                        $novo->idPublicacao = $publicacao->idPublicacao;
                        
                        $fbk = $this->PubLivro_model->Update($novo);

                        
                            
                        break;

                    }

                         
                }else{
                    $result = array('Error' => 'Erro ao cadastrar publicação!' );
                    $HttpCode = 500;
                }

        return $this->response($result, $HttpCode); 
    }


    

    public function getAll_get()
    {
        
            $this->load->model('Publicacao_model');
            $res = $this->Publicacao_model->getAll();
            $result['lista'] = array();
            foreach ($res as $publicacao) {
                array_push($result['lista'], $publicacao);
             }
            $HttpCode = 200;
            return $this->response($result, $HttpCode); 
    }

    public function getAllYear_get()
    {
        
            $this->load->model('Publicacao_model');
            $res = $this->Publicacao_model->getAllyear();
            $result['lista'] = array();
            foreach ($res as $publicacao) {
                array_push($result['lista'], $publicacao);
             }
            $HttpCode = 200;
            return $this->response($result, $HttpCode); 
    }



    public function getAutoresPub_get()
    {
            $id = $this->get('id');
            $this->load->model('Publicacao_model');
            $res = $this->Publicacao_model->getAutoresPublicacao($id);

            $result['lista'] = array();
            foreach ($res as $autor) {
                array_push($result['lista'], $autor);
             }
            $HttpCode = 200;

            return $this->response($result, $HttpCode); 
    }


    public function getPubYear_get()
    {
            $ano = $this->get('ano');
            $this->load->model('Publicacao_model');
            $res = $this->Publicacao_model->getPubYear($ano);

            $result['lista'] = array();
            foreach ($res as $autor) {
                array_push($result['lista'], $autor);
             }
            $HttpCode = 200;

            return $this->response($result, $HttpCode); 
    }


    


    public function getPubUsuario_get()
    {
            $id = $this->get('id');
            $this->load->model('Publicacao_model');
            $res = $this->Publicacao_model->getPubUsuario($id);

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
                    $this->load->model('Publicacao_model');
                    $res = $this->Publicacao_model->getOnePublicacao($id);
                    if($res){

                    $emp['id'] = $res[0]->id;
                    $emp['iduser'] = $res[0]->iduser;
                    $emp['title'] = $res[0]->title;
                    $emp['year'] = $res[0]->year;
                    $emp['type'] = $res[0]->type;
                    $emp['nationality'] = $res[0]->nationality;
                    $emp['completeness'] = $res[0]->completeness;


                    $typePub = $emp['type'];
                    $idPub = $emp['id'];


                    $autores = $this->Publicacao_model->getAutoresPublicacao($id);
                    if($autores){
                         $result['lista'] = array();
                        foreach ($res as $publicacao) {
                            array_push($result['lista'], $publicacao);
                         }
                    }

           
                    switch ($typePub) {
                        case 'Periódico':
                                 $this->load->model('PubPeriodico_model');
                            $res = $this->PubPeriodico_model->getOnePublicacaoPeriodico($idPub);

                            if($res){
                                $emp['idPublicacaoPeriodico'] = $res[0]->idPublicacaoPeriodico;
                                $emp['startpage'] = $res[0]->startpage;
                                $emp['endpage'] = $res[0]->endpage;
                                $emp['volume'] = $res[0]->volume;    
                                $emp['number'] = $res[0]->number;
                                $emp['name'] = $res[0]->name;

                                $idPubPer = $emp['idPublicacaoPeriodico'];
                                $this->load->model('Periodico_model');
                                $res = $this->Periodico_model->getOnePeriodico($idPubPer);

                                if($res){
                                    $emp['idPeriodico'] = $res[0]->idPeriodico;
                                    $emp['periodicname'] = $res[0]->periodicname;
                                    $emp['initialperiodic'] = $res[0]->initialperiodic;
                                    $emp['qualis'] = $res[0]->qualis;

                                    $idPer = $emp['idPeriodico'];
                                    $this->load->model('Editora_model');
                                    $res = $this->Editora_model->getOneEditora($idPer);

                                        if($res){
                                            $emp['publishingcompanyname'] = $res[0]->publishingcompanyname;
                                            $emp['publishingcompanyaddress'] = $res[0]->publishingcompanyaddress;
                                                }
                                        }

                                }                                


                            break;

                         case 'Conferência':
                                
                            $this->load->model('PubConferencia_model');
                            $res = $this->PubConferencia_model->getOnePublicacaoConferencia($idPub);

                            if($res){

                                $emp['idPublicacaoConferencia'] = $res[0]->idPublicacaoConferencia;
                                $emp['eventname'] = $res[0]->eventname;
                                $emp['initialsevent'] = $res[0]->initialsevent; 
                                $emp['cityevent'] = $res[0]->cityevent;
                                $emp['startpage'] = $res[0]->startpage;
                                $emp['endpage'] = $res[0]->endpage;
                                $emp['publishingcompany'] = $res[0]->publishingcompany;


                                $idPubCon = $emp['idPublicacaoConferencia'];
                                $this->load->model('Conferencia_model');
                                $res = $this->Conferencia_model->getOneConferencia($idPubCon);

                                if($res){
                                    $emp['idPublicacaoConferencia'] = $res[0]->idPublicacaoConferencia;
                                    $emp['conferencename'] = $res[0]->conferencename;
                                    $emp['initialsconference'] = $res[0]->initialsconference;
                                    $emp['qualis'] = $res[0]->qualis;
                                }  
                            }
                            break;
                            


                            case 'Livro':
                                $this->load->model('PubLivro_model');
                                $res = $this->PubLivro_model->getOnePubLivro($idPub);

                                if($res){

                                    $emp['publishingcompany'] = $res[0]->publishingcompany;
                                    $emp['editcity'] = $res[0]->editcity;
                                    $emp['totalpage'] = $res[0]->totalpage;

                                }
                            break;       
                    
                    }

                        $HttpCode = 200;
                        $result = $emp;
                    }else{
                        $result['error'] = "Publicação não encontrado!";
                        $HttpCode = 404;
                    }
            
            }else{
                $res = array('Error' => 'Falta o ID' );
                $HttpCode = 400;
            }
             return $this->response($result , $HttpCode); 
    }

     public function Buscar_get()
    {

        $titulo = $this->get('title');
        $this->load->model('Publicacao_model');
        
        $res = $this->Publicacao_model->Buscar($titulo);
        if($res != False){
            $result['lista'] = array();
            foreach ($res as $pub) {
                array_push($result['lista'], $pub);
             }
            $HttpCode = 200;
        }else{
             $result['lista'] = array();
             $HttpCode = 200;
        }
        return $this->response($result, $HttpCode); 
    }


	  
    
}