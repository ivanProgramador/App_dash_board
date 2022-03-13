<?php

  // classe dashboard

  class Dashboard {

  	public $data_inicio;
  	public $data_fim;
  	public $numeroVendas;
  	public $totalVendas;

  	public function __get($atributo){

  		return $this->$atributo;

  	}

  	public function __set($atributo,$valor){
      
        $this->$atributo = $valor;

  		return $this;
  	}






  }

  // classe coenxao

  class Conexao{

  	private $host ='localhost';
  	private $dbname = 'dashboard';
  	private $user = 'root';
  	private $pass = '';

  	public function conectar(){

  		try{
  			$conexao = new PDO(
  				'mysql:host=$this->host;dbname=$this-> dbname;',
  				'$this->user',
  				'$this->pass'
  			);

  			$conexao->exec('set charset set utf-8');

  		}catch(PDOException $e){

     		echo "<p>".$e->getMessege()."</p>";

  		}
  	}
  }



  //classe Bd(model)


  class Bd{

  	 private $conexao;
  	 private $dashboard;

  	 public function __construct(Conexao $conexao, Dashboard $dashboard){

  	 	$this->conexao = $conexao->conectar();
  	 	$this->dashboard = $dashboard;


  	 }
  }


  //instanciando 

  $dashboard = new Dashboard();
  $conexao = new Conexao();

  //a classe Bd recebe 2 aparametros

  $bd = new Bd($conexao,$dashboard);


  







?>