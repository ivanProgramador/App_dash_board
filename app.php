<?php

   //classe dashboard

   class Dashboard{
        
        public $data_inicio;
        public $data_fim;
        public $numeroVendas;
        public $totalVendas;

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

   
   class Bd{

   	   private $conexao;
   	   private $dashboard;

   	   function __construct(Conexao $conexao, Dashboard $dashboard){
            
            $this->conexao = $conexao->conectar();
            $this->dashboard = $dashboard;

   	   } 



   	   public function getNumeroVendas(){

   	   	 $query = 'SELECT 
   	   	             COUNT(*) AS numero_vendas
   	   	           FROM 
   	   	                 tb_vendas 
   	   	           WHERE
   	   	                 data_venda BETWEEN :data_inicio AND :data_fim';



   	   	 $stmt  = $this->conexao->prepare($query);
   	   	 $stmt->bindValue('data_inicio','2018-10-01');
   	   	 $stmt->bindValue('data_fim','2018-10-31');
   	   	 $stmt->execute();

   	   	 return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;

   	   }


   }



   $dashboard =  new Dashboard();
   $conexao   =  new Conexao();
   $bd        =  new Bd($conexao,$dashboard);


   $dashboard->__set('numeroVendas',$bd->getNumeroVendas());

   print_r($bd->getNumeroVendas());


   //parei quando a classe ja estava recuperando o numero de vendas 
   




?>