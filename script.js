$(document).ready(() => {
  
  /*Toda a logica contida no http resquest esta encapsulada nessa função load
    nesse caso quando o cliente clicar ela vai puxar o arquivo documentacao.html
    que esta no servidor e substituit todo o conteudo que esta na div #pagina
    por ele.
  */

  $('#documentacao').on('click',() => {

  	// $('#pagina').load('documentacao.html')
  	// uma segunda opção é usar a funçao $.get() que permite 
  	//pegar os dados e depois decidir oque fazer com eles
  	//no primeiro parametro ele recebe a url e no segundo uma função
  	//que captura o conteudo de texto contido no arquivo referenciado

  	$.get('documentacao.html', data => {
  		
  		$('#pagina').html(data)

  	    }) 
     })


   $('#suporte').on('click',() => {

  	$.get('suporte.html', data => {
  		
  	  $('#pagina').html(data)

  	}) 


  })

   /*  AJAX   */


   /*
     Os eventos abaixo vão aocntecer com base na seleção do periodo 
     ao elemento select do index foi atribuido um id para que atraves desse id eu possa saber o valor dele

     no caso abaixo eu pego o id chamo o evento on e verifico se o valor do option muda on('change')/  se ele mudar
     eu atribuo uma arrow function que captura o evento e pega o valor dele e manda pra variavel e. 

     No caso abaixo a função $.ajax() do Jquery recebe como parametro um objeto literal que contem 5 atributos da
     requisição

     type -> eo metodo pelo qual a reuisição vai ser executada GET ou POST
     url  -> e a loacalização do arquivo que ele vai buscar na reuisição
     data -> eo dado de retorno que vai servir como a parametro de execução
     success -> oque será feito se a reuisição der certo 
     error -> oque sera feito se a requisição não der certo


     no parametro dados o resultado que vier da reuisição vai entrar na variavel dados 
     e a propria arrow function vai dar um console.log da variavel dela que no caso vai ser 
     o objeto vindo la do arquivo app.php


   */

   $('#competencia').on('change',e=>{


    /*tornando o vcalor da competencia dinamico*/

   let competencia = $(e.target).val()
   console.log(competencia)





       $.ajax(

       {
          type:'GET',
          url:'app.php',
          data:`competencia=${competencia}`,
          success: dados =>{console.log(dados)},
          error:   erro =>{console.log(erro)}
       }


       )


   })




})