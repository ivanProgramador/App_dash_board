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

})