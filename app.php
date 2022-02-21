<?php

   //classe dashboard

   class Dashboard{
        
        public $data_inicio;
        public $data_fim;
        public $numerovendas;
        public $totalvendas;

        public function __get($atributo){
           return $this -> $atributo;
        }

        public function __set($atributo,$valor){
           $this->$atributo = $valor;
           return $this;
        }

   }

   //classe de conexao com banco de dados

   class Conexao{

   	  private $host   = 'localhost';
   	  private $dbname = 'dashboard';
   	  private $user   = 'root';
   	  private $pass   = '';


   	  public function conectar(){

   	  	try{

   	        $conexao = new PDO("mysql:host = $this->host;dbname=$this->dbname",
   	  		"$this->user",
   	  		"$this->pass");

   	  		$conexao -> exec('set charset set utf8');

   	  		return $conexao;





   	  	}catch(PDOException $e){

   	  		echo '<p>'.$e->getMessege().'</p>';
   	  	}
   	  }
   }

   //parei nos 7:44 quando ia criar a classe de model que permite a manipulação



?>