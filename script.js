$(document).ready(() => {


	/*O codigo abaixo seleciona a div pelo id
	  depois ele usa a função on que recebe 2 parametros 
	  o primeiro eo evento que vai acionar a função eo 
	  segundo e a função em si que seleciona o elemento pagina
	  e dentro dele insere o conteudo html dentro da div docuementação
	  isso acontece porque a div doeumntação é filha da div pagina
	  por isso que a filha e selecionada para receber o evento
	  mas a função precisa informar o elemento principal 
	  pra atingir o elemento filho.

	  exteno elemento pai , interno elemento filho

	  a função load ja incorpora a requisiçao ajax dentro dela
	  mas a função que sera mantida e a $.get() que rebe dois parametros
	  1 e a url do recurso que sera carregado 
	  2 e  função que vai dizer oque será feito com o recurso que foi trazido por ela


	  e tambem existe a opção de $.post('','') que funciona da mesma forma então basicamente 
	  para tratar requisições o jquery possui esses 3 metodos load('','') , get('','') , post('','') 


	*/

	$('#documentacao').on('click',()=>{

	  //$('#pagina').load('documentacao.html')

	  $.post('documentacao.html',data=>{

	  	$('#pagina').html(data)
	  })


	})


	$('#suporte').on('click',()=>{

	  //$('#pagina').load('suporte.html')

	  $.post('suporte.html',data=>{

	  	$('#pagina').html(data)
	  })



		
	})



	
})