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
  				"mysql:host=$this->host;dbname=$this->dbname",
  				"$this->user",
  				"$this->pass"
  			);

  			$conexao->exec('set charset set utf-8');

  			return $conexao;

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


  	 public function getNumeroVendas(){

  	 	$query='select count(*) as numero_vendas 
  	 	        from
  	 	          tb_vendas
  	 	        where
  	 	          data_venda between :data_inicio and :data_fim';

  	 	$stmt= $this->conexao->prepare($query);
  	 	$stmt->bindValue(':data_inicio',$this->dashboard->__get('data_inicio'));
  	 	$stmt->bindValue(':data_fim',$this->dashboard->__get('data_fim'));
  	 	$stmt->execute();


  	 	return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;

  	 }
  }




  //instanciando 

  $dashboard = new Dashboard();
  $conexao   = new Conexao();


  // datas

  $dashboard->__set('data_inicio','2018-08-01'); 
  $dashboard->__set('data_fim','2018-08-31');
  


  //a classe Bd recebe 2 aparametros que são os objetos dashboard e conexao

 $bd = new Bd($conexao,$dashboard);

  // atribuindo o numero de vendas ao objeto dashboard

 $dashboard->__set('numeroVendas',$bd->getNumeroVendas());
 
 echo "<pre>";
 
 print_r($dashboard);

 echo "</pre>";











  







?>