<?php

  // classe dashboard

  class Dashboard {

  	public $data_inicio;
  	public $data_fim;
  	public $numeroVendas;
  	public $totalVendas;
  	public $clientesAtivos;
  	public $clientesInativos;
  	public $reclamacoes;
  	public $elogios;
  	public $sugestoes;
  	public $despesas;


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



  	 public function getNumeroTotalVendas(){

  	 	$query='select
  	 	          sum(total) as total_vendas
  	 	        from 
  	 	          tb_vendas
  	 	         where
  	 	          data_venda between :data_inicio and :data_fim';

  	 	$stmt= $this->conexao->prepare($query);
  	 	$stmt->bindValue(':data_inicio',$this->dashboard->__get('data_inicio'));
  	 	$stmt->bindValue(':data_fim',$this->dashboard->__get('data_fim'));
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;



  	 }




  	 public function getNumeroDeClientesAtivos(){

  	 	$query='select
  	 	          count(*) as clientes_ativos
  	 	        from
  	 	          tb_clientes 
  	 	        where
  	 	          cliente_ativo = 1';


  	 	$stmt = $this->conexao->prepare($query);
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->clientes_ativos;


  	 }


  	 public function getNumeroDeClientesInativos(){

  	 	$query='select
  	 	          count(*) as clientes_ativos
  	 	        from
  	 	          tb_clientes 
  	 	        where
  	 	          cliente_ativo = 0';


  	 	$stmt = $this->conexao->prepare($query);
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->clientes_ativos;


  	 }


  	 public function getNumeroDeReclamacoes(){

  	 	$query='select
  	 	          count(*) as reclamacoes
  	 	        from 
  	 	          opiniao
  	 	        where
  	 	          positiva = 0';

  	 	$stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data_inicio',$this->dashboard->__get('data_inicio'));
  	 	$stmt->bindValue(':data_fim',$this->dashboard->__get('data_fim'));
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->reclamacoes;


  	 }


  	 public function getNumeroDeElogios(){

  	 	$query='select
  	 	          count(*) as reclamacoes
  	 	        from 
  	 	          opiniao
  	 	        where
  	 	          positiva = 1';

  	 	$stmt = $this->conexao->prepare($query);
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->reclamacoes;


  	 }



  	 public function getNumeroDeSujestoes(){

  	 	$query='select
  	 	          count(*) as sujestoes
  	 	        from
  	 	          tb_sugestoes
  	 	        ';

  	 	$stmt= $this->conexao->prepare($query);
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->sujestoes;

  	 }


  	 public function getTotalDespesas(){

  	 	$query='select 
  	 	          sum(total) as valor_despesas
  	 	        from
  	 	          tb_despesas
  	 	        where
  	 	        data_despesa between :data_inicio and :data_fim';

  	 	$stmt= $this->conexao->prepare($query);
  	 	$stmt->bindValue(':data_inicio',$this->dashboard->__get('data_inicio'));
  	 	$stmt->bindValue(':data_fim',$this->dashboard->__get('data_fim'));
  	 	$stmt->execute();
  	 	return $stmt->fetch(PDO::FETCH_OBJ)->valor_despesas;
  	 }






  }




  //instanciando 

  $dashboard = new Dashboard();
  $conexao   = new Conexao();


  $competencia = explode('-',$_GET['competencia']);
  $ano = $competencia[0];
  $mes = $competencia[1];

  $dias_do_mes = cal_days_in_month(CAL_GREGORIAN,$mes,$ano);




  // datas

  $dashboard->__set('data_inicio',$ano.'-'.$mes.'-01'); 
  $dashboard->__set('data_fim',$ano.'-'.$mes.'-'.$dias_do_mes);
  


  //a classe Bd recebe 2 aparametros que são os objetos dashboard e conexao

 $bd = new Bd($conexao,$dashboard);

  // atribuindo o numero de vendas ao objeto dashboard

 $dashboard->__set('numeroVendas',$bd->getNumeroVendas());
 $dashboard->__set('totalVendas',$bd->getNumeroTotalVendas());
 $dashboard->__set('clientesAtivos',$bd->getNumeroDeClientesAtivos());
 $dashboard->__set('clientesInativos',$bd->getNumeroDeClientesInativos());
 $dashboard->__set('reclamacoes',$bd->getNumeroDeReclamacoes());
 $dashboard->__set('elogios',$bd->getNumeroDeElogios());
 $dashboard->__set('sugestoes',$bd->getNumeroDeSujestoes());
 $dashboard->__set('despesas',$bd->getTotalDespesas());




//fazendo o php retornar um json
 
 echo json_encode($dashboard);

 









  







?>