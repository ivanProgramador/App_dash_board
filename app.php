<?php

   /*

   Oque está acontecendo aqui

   Aqui estão sendo criadas 3  classes a primeira representa a dashboard a segunda representa
   a conexao com a abse de dados e a terceira representa o banco de dados em si como se fosse
   uma classe de execução de sql.

   A relação entre as 3 

   Como as 3 ja estão dentro do mesmo arquivo fazer um require é desnecessario então no caso
   a classe Dashboard e a classe conexão estão sendo unidas na classe Bd, A classe Bd possuyi dois atributos privados sendo eles $dashboard e $conexao a classe Bd possui um metodo construtor que recebe esses dois parametros só que ao inves de enviar os dois parametros
   puros como se fossem variaveis vazias para preenchimento, essas variaveis são colocadas 
   como parametros no metodo construtor e apontadas como instancias das classes Dashboard e Conexao, fazendo com que cada parametro desses possa chamar qualquer metodo de cada uma das classes correspondentes.


   No caso abaixo ele usa o metodo conectar do objeto conexão e na segunda linha ele atribui a classes dashboard a o seu atributo interno $dasboard trazendo assim a classe para dentro do seu construtor. 



    function __construct(Conexao $conexao, Dashboard $dashboard){
            
            $this->conexao = $conexao->conectar();
            $this->dashboard = $dashboard;

    }

  na terceira etapa são construidos 3 objetos um com base em acad uma das classes existentes
  so que no caso do Objeto que pertence a classe Bd como jafoi dito antes ele recebe os objetos 
  $dashboard da classe Dashboard();  e  recebe $conexao da classe Conexao(); fazendo assima união
  de ambas as classes no mesmo contexto. 



   $dashboard =  new Dashboard();
   $conexao   =  new Conexao();
   $bd        =  new Bd($conexao,$dashboard);
















   */

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



       /*Esse metodo da classes Bd serve para pegar o numero de vendas com base em um periodo de tempo especifico(data) primeiro esse metodo tesm um varivel que tem como conteudo a query sql que tem um select o select conta as vendas que tem na tabela e retorna usado uma ALIAS
       (numero_vendas) depois ele einforma que tabela vai receber a consulta tb_vendas e depois
       informa as condições de retorno como base no na coluna data_venda as vendas que serão retornadas por essa consulta são vendas entre data_inicio e data_fim as condições de retorno aão determinadas pelo bindValue() que recebe os valores e preenche as variaveis
       da consulta.

       query = 'SELECT 
                     COUNT(*) AS numero_vendas
                   FROM 
                         tb_vendas 
                   WHERE
                         data_venda BETWEEN :data_inicio AND :data_fim';


      $stmt->bindValue('data_inicio','2018-10-01');
      $stmt->bindValue('data_fim','2018-10-31');.


      Mas antes de executar a consulta ele chama $stmt e atribui a ele o atributo conexao
      que pertence a classe Conexão e é um instancia tamebm da classe PDO() que por sua vez 
      tem o metodo prepare que preapara as queries SQL para serem compreendidas e executadas
      depois ele preenche os BindValues(); para completar a querie 

      $stmt->bindValue('data_inicio','2018-10-01');
      $stmt->bindValue('data_fim','2018-10-31');

      e chama o metodo execute() que pértence ao objeto $stmt

      $stmt->execute();

      ele vai retornar um resultado e esse resultado precisa que um forma de retorno seja definida. no caso abaixo ele vai retornar o objeto $stmt com o metodo fetch que chama a classe PDO com o seu metodo FETCH_OBJ que como o nome ja diz retorna um objeto para cada 
      uma das vendas encontradas.e depois joga esse resultado para dentro da variavel numero_vendas  

      return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;




        */

        /*esse metodo conta quantas vendas foram feitas*/

   	   public function getNumeroVendas(){

   	   	 $query = 'SELECT 
   	   	             COUNT(*) AS numero_vendas
   	   	           FROM 
   	   	                 tb_vendas 
   	   	           WHERE
   	   	                 data_venda BETWEEN :data_inicio AND :data_fim';



   	   	 $stmt  = $this->conexao->prepare($query);
   	   	 $stmt->bindValue('data_inicio',$this->dashboard->__get('data_inicio'));
   	   	 $stmt->bindValue('data_fim',$this->dashboard->__get('data_fim'));
   	   	 $stmt->execute();

   	   	 return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;

   	   }

       /*esse metodo soma os valores das vendas so muda o sql eo Alias */


       public function getTotalVendas(){

         $query = 'SELECT 
                     SUM(total) AS total_vendas
                   FROM 
                         tb_vendas 
                   WHERE
                         data_venda BETWEEN :data_inicio AND :data_fim';



         $stmt  = $this->conexao->prepare($query);
         $stmt->bindValue('data_inicio',$this->dashboard->__get('data_inicio'));
         $stmt->bindValue('data_fim',$this->dashboard->__get('data_fim'));
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;

       }









   }















   $dashboard =  new Dashboard();
   $conexao   =  new Conexao();
   $bd        =  new Bd($conexao,$dashboard);

   /*
    Montando o objeto dashboard 

    no caso abaixo eu pego o objeto $dasboard e chamo o metodo __set()
    que recebe 2 parametros o primeiro eo atributo e ioe segundo eo valor que
    vai ser adicionado a o atributo em questão como ja foi visto o metodo

    getNumeroVendas() que pernce a classe Bd(); retorna o nnumero de vendas

    então nesse caso se eu chamo $bd->getNumeroVendas()  eu tenho esse resultado
    pronto so que eu preciso fazer e chamar o metodo $bd->getNumeroVendas() como o segundo parametro do metodo __set('numeroVendas', ) e ele vai preencher o atributo numeroVendas

    $dashboard->__set('numeroVendas',$bd->getNumeroVendas());




   */

    /*Configurando data_nicio e data fim usando os metodos __set() da classe Dashboard*/

    /*Quando os dados da competencia são retornados o mes eo ano vem na mesma
    variavel sendo que pode ser necessario trabalhar com esses dados de forma
    separada por isso vai ser usada a função explode que separa o retorno em um array
    usando como base um caractere especifico no caso e o '-'

    explode('-', $_GET['competencia']);

    separados pelo - cada um assume uma posição dentro do array

    posição 0 assume o ano e posição 1 assume o mes


     */
    $competencia = explode('-', $_GET['competencia']);
    $ano = $competencia[0];
    $mes = $competencia[1];


    /*usando um função php para contar os dias exitentes no mes e no ano que 
      vamos especificar a função cal_days_in_month(CALL_GREGORIAN,$mes,$ano);
      recebe 3 parametros

      1 - o tipode calendario que estamos usando(no meu casop eo gregoriano)
      2 - mes
      3 - ano

    */

    $dias_do_mes = cal_days_in_month(CAL_GREGORIAN,$mes,$ano);



   /*quando for concatenar dados de data atenção a sempre dividir os valores com - porque e assim que o banco de dados 
     exige 
   */

   $dashboard->__set('data_inicio',$ano.'-'.$mes.'-01');
   $dashboard->__set('data_fim',$ano.'/'.$mes.'/'.$dias_do_mes);


   $dashboard->__set('numeroVendas',$bd->getNumeroVendas());
   $dashboard->__set('totalVendas',$bd->getTotalVendas());
  


   /*fazendo o php transformar um objeto de uma classe em um objeto literal JSON*/

   echo json_encode($dashboard);

  /*
  print_r($ano.'/'.$mes.'/'.$dias_do_mes);
  */


   //puxando o numero de vendas usadno o metodo da classe bd
   /*print_r($bd->getNumeroVendas());*/


   
   




?>