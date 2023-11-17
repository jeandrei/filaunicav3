
/* para usar a função de validação de cpf basta colocar na classe cpf */
jQuery.validator.addMethod("cpf", function(value, element) {
  value = jQuery.trim(value);

   value = value.replace('.','');
   value = value.replace('.','');
   cpf = value.replace('-','');
   while(cpf.length < 11) cpf = "0"+ cpf;
   var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
   var a = [];
   var b = new Number;
   var c = 11;
   for (i=0; i<11; i++){
       a[i] = cpf.charAt(i);
       if (i < 9) b += (a[i] * --c);
   }
   if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
   b = 0;
   c = 11;
   for (y=0; y<10; y++) b += (a[y] * c--);
   if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

   var retorno = true;
   if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

   return this.optional(element) || retorno;

}, "CPF inválido");


/* para usar a função de validação de email basta colocar na classe email */
jQuery.validator.addMethod("email", 
    function(value, element) {
		//se quiser tornar opcional a validação coloque esse if sempre antes da validação
		if (this.optional(element)) {
			return true;
		}

        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }, 
    "Email inválido"
);


/* para usar a função de validação de celular basta colocar na classe validacelular */
jQuery.validator.addMethod('validacelular', function (value, element) {
    value = value.replace("(","");
    value = value.replace(")", "");
    value = value.replace("-", "");
    value = value.replace(" ", "").trim();
    if (value == '0000000000') {
        return (this.optional(element) || false);
    } else if (value == '00000000000') {
        return (this.optional(element) || false);
    }
    if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"]
    .indexOf(value.substring(0, 2)) != -1) {
        return (this.optional(element) || false);
    }
    if (value.length < 10 || value.length > 11) {
        return (this.optional(element) || false);
    }
    if (["6", "7", "8", "9"].indexOf(value.substring(2, 3)) == -1) {
        return (this.optional(element) || false);
    }
    return (this.optional(element) || true);
}, 'Celular inválido!');




/* para usar a função de validação de email basta colocar na classe email */
jQuery.validator.addMethod("validatel", 
    function(value, element) {
		//se quiser tornar opcional a validação coloque esse if sempre antes da validação
		if (this.optional(element)) {
			return true;
		}

        return /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(value);
    }, 
    "Telefone inválido"
);

/**SELECT
 * Validação de select field
 * O primeiro options do select o default tem que estar como null
 * <option value="null">Selecione o Bairro</option>
 * a validação é adicionada no rules e messages do jqueryvalidation 
 */
$.validator.addMethod("selectone", function(value, element, arg){
    return arg !== value;
}, "Value must not equal arg.");
  



// FUNÇÃO PARA ADICIONAR CLASSE
// função para adicionar nova classe a objetos
// exemplo para adicionar a classe cpf que tem a mascara do cpf
// no final do formulário basta colocar
// <script>  addclass('cpf','cpf'); </script>
// onde id é o id do campo e new class é a nova classe a ser adicionada neste caso cpfmask que coloca mascara no cpf
function addclass(id,newclass){
  var element = document.getElementById(id);
  var addclass = newclass;
  element.classList.add(addclass);
}

// FUNÇÃO PARA COLOCAR TUDO EM MAIÚSCULO
// onkeydown="upperCaseF(this)" 
function upperCaseF(a){
  setTimeout(function(){
      a.value = a.value.toUpperCase();
  }, 1);
}

function alerta(){
	alert('oi');
}

//FUNÇÃO PARA PERMITIR APENAS NÚMEROS
//PARA USAR BASTA COLOCAR O CAMPO COMO CLASSE onlynumbers
//E PARA EXIBIR A MENSAGEM COLOCAR UM <span id="errmsg"></span>
//USE TAMBÉM O TIPO NUMBER NO INPUT type="number" 
$(document).ready(function () {
	//called when key is pressed in textbox
	$(".onlynumbers").keypress(function (e) {
	   //if the letter is not digit then display error and don't type anything
	   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		  //display error message
		  alert("Ops! Apenas números são permitidos.");
				 return false;
	  }
	 });
  });




//mascaras para os formulários todas se aplicam a classe
// no caso de aplicar mascara a telefone é só 
//fazer <input type="tel" class="telefone"
//vai aplicar somente depois de carregar o documento 
//por isso esta dentro da (document).ready()
//tem que colocar o footer que está neste projeto para lincar com maskedinput.min.js
$(document).ready(function() {
	$('.cpf').mask('000.000.000-00', {reverse: true});
	$(".celular").mask("(00) 00000-0009");
	$(".telefone").mask("(00) 0000-0009");
	});
//********************fim mascaras**************** */


function CheckForm(id){
	var checked=false;
	var elements = document.getElementsByName(id);
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		checked = false;
	}
	return checked;
}


function checkedRadioBtn(sGroupName)
    {   
        var group = document.getElementsByName(sGroupName);

        for ( var i = 0; i < group.length; i++) {
            if (group.item(i).checked) {
                return group.item(i).id;
            } else if (group[0].type !== 'radio') {
                //if you find any in the group not a radio button return null
                return null;
            }
        }
		}
		
	function focofield(field)
	{
		document.getElementById(field).focus();
	}


//função para o botão avançar do formulário
$(document).ready(function () {
	//Initialize tooltips
	$('.nav-tabs > li a[title]').tooltip();
	
	//Wizard
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

		var $target = $(e.target);
	
		if ($target.parent().hasClass('disabled')) {
			return false;
		}
	});

	$(".next-step").click(function (e) {

		var $active = $('.nav-tabs li>a.active');
		$active.parent().next().removeClass('disabled');
		nextTab($active);

	});
	$(".prev-step").click(function (e) {

		var $active = $('.nav-tabs li>a.active');
		prevTab($active);

	});
});

function nextTab(elem) {
	$(elem).parent().next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
	$(elem).parent().prev().find('a[data-toggle="tab"]').click();
}


//mostrar o nome do arquivo no file custom - no selecionar arquivo
$('.custom-file input').change(function (e) {
	$(this).next('.custom-file-label').html(e.target.files[0].name);
});



//fileValidation(campo tipo field,id do span para apresentar o erro);"
// onchange="return fileValidation('comprovante_residencia','res_erro');"
function fileValidation(myfiel,span)
{
	var fileInput = document.getElementById(myfiel);
	var filePath = fileInput.value;
	var errorspan = span;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
    if(!allowedExtensions.exec(filePath)){				
		document.getElementById(errorspan).textContent="Apenas arquivo do tipo JPEG, PNG ou PDF são permitidos!";
		fileInput.value = '';			
        return false;
    }else{
		document.getElementById(errorspan).textContent="";
        return true;
    }
}

/* POPUP MENSAGEM */
const types = ['info', 'success', 'error']

document.addEventListener('DOMContentLoaded', function (e) {
    //esse toasts vem lá do inc/header
    const toasts = document.getElementById('toasts')
})

function createNotification(message = null, type = null) {
  const notif = document.createElement('div')
  notif.classList.add('msg')
  notif.classList.add(type ? type : getRandomType())

  notif.innerText = message ? message : getRandomMessage()

  toasts.appendChild(notif)

  setTimeout(() => {
    notif.remove()
  }, 3000)
}


