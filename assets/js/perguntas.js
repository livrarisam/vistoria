$(document).on( "change", "div.obtencao_renovacao input[type=radio]", function(){
	var option = $(this).val();

	if (option == 'R') {
		$("div.numero_avcb").show();
	} else {
		$("div.numero_avcb").hide();
	}

	$("div.projeto_aprovado").hide();
	$("div.projeto_aprovado input[type=radio]").prop('checked', false);
	$("div.pavimentos").hide();
	$("div.pavimentos input[type=radio]").prop('checked', false);
	$("div.areas_frias").hide();
	$("div.areas_frias input[type=radio]").prop('checked', false);
	$("div.pavimentos").hide();
	$("div.pavimentos input[type=radio]").prop('checked', false);
	$("div.subsolo").hide();
	$("div.subsolo input[type=radio]").prop('checked', false);
	$("div.subsolo_estacionamento").hide();
	$("div.subsolo_estacionamento input[type=radio]").prop('checked', false);
	$("div.ativ_grupof").hide();
	$("div.ativ_grupof input[type=radio]").prop('checked', false);
	$("div.comercio_gas").hide();
	$("div.comercio_gas input[type=radio]").prop('checked', false);
	$("div.liq_inflamaveis").hide();
	$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
	$("div.gas_inflamaveis").hide();
	$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
	$("div.produtos_perigosos").hide();
	$("div.produtos_perigosos input[type=radio]").prop('checked', false);
	
	
} );

$(document).on( "keyup", "div.numero_avcb input[type=text]", function(){
	var nro = $(this).val();
	if(nro.length >= 3) {
		$("div.projeto_aprovado").show();
	} else {
		$("div.projeto_aprovado").hide();
	}
} );

$(document).on( "change", "div.projeto_aprovado input[type=radio]", function(){
	var option = $(this).val();

	if (option == 'N') {
		alert("Verifique no documento AVCB se existe numero de projeto");
		$("#classificacao").val("pts");
	} else {
		$("#classificacao").val("pt");
		
	}
} );

$(document).on( "keyup", "#area_construida.avcb", function(){
	var total = parseInt($(this).val());
	if(total <= 750) {
		$("#classificacao").val("pts");
		$("div.pavimentos").show();
	} else {
		$("#classificacao").val("pt");
		$("div.pavimentos").hide();
		$("div.pavimentos input[type=radio]").prop('checked', false);
		$("div.areas_frias").hide();
		$("div.areas_frias input[type=radio]").prop('checked', false);
		$("div.pavimentos").hide();
		$("div.pavimentos input[type=radio]").prop('checked', false);
		$("div.subsolo").hide();
		$("div.subsolo input[type=radio]").prop('checked', false);
		$("div.subsolo_estacionamento").hide();
		$("div.subsolo_estacionamento input[type=radio]").prop('checked', false);
		$("div.ativ_grupof").hide();
		$("div.ativ_grupof input[type=radio]").prop('checked', false);
		$("div.comercio_gas").hide();
		$("div.comercio_gas input[type=radio]").prop('checked', false);
		$("div.liq_inflamaveis").hide();
		$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);
	}
} );

$(document).on( "change", "div.areas_frias input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		
	} else {
		
		
	}

	$("div.pavimentos").hide();
	$("div.pavimentos input[type=radio]").prop('checked', false);
	$("div.subsolo").hide();
	$("div.subsolo input[type=radio]").prop('checked', false);
	$("div.subsolo_estacionamento").hide();
	$("div.subsolo_estacionamento input[type=radio]").prop('checked', false);
	$("div.ativ_grupof").hide();
	$("div.ativ_grupof input[type=radio]").prop('checked', false);
	$("div.comercio_gas").hide();
	$("div.comercio_gas input[type=radio]").prop('checked', false);
	$("div.liq_inflamaveis").hide();
	$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
	$("div.gas_inflamaveis").hide();
	$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
	$("div.produtos_perigosos").hide();
	$("div.produtos_perigosos input[type=radio]").prop('checked', false);
} );

$(document).on( "change", "div.pavimentos input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.subsolo_estacionamento").show();
		$("#classificacao").val("pts");

		
		
	} else {
		$("#classificacao").val("pt");
		$("div.subsolo").hide();
		$("div.subsolo input[type=radio]").prop('checked', false);
		$("div.subsolo_estacionamento").hide();
		$("div.subsolo_estacionamento input[type=radio]").prop('checked', false);
		$("div.ativ_grupof").hide();
		$("div.ativ_grupof input[type=radio]").prop('checked', false);
		$("div.comercio_gas").hide();
		$("div.comercio_gas input[type=radio]").prop('checked', false);
		$("div.liq_inflamaveis").hide();
		$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);

		
	}
} );

$(document).on( "change", "div.subsolo_estacionamento input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'S') {
		$("div.ativ_grupof").hide();
		$("div.ativ_grupof input[type=radio]").prop('checked', false);
		$("div.subsolo").show();

		
		
	} else {
		$("div.ativ_grupof").show();
		$("div.subsolo").hide();
		$("div.subsolo input[type=radio]").prop('checked', false);
		$("div.comercio_gas").hide();
		$("div.comercio_gas input[type=radio]").prop('checked', false);
		$("div.liq_inflamaveis").hide();
		$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);
	}
} );

$(document).on( "change", "div.subsolo input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.ativ_grupof").show();
		$("#classificacao").val("pts");
	} else {
		$("#classificacao").val("pt");
		$("div.ativ_grupof").hide();
		$("div.ativ_grupof input[type=radio]").prop('checked', false);
		$("div.comercio_gas").hide();
		$("div.comercio_gas input[type=radio]").prop('checked', false);
		$("div.liq_inflamaveis").hide();
		$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);

		
	}
} );

$(document).on( "change", "div.ativ_grupof input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.comercio_gas").show();
		$("#classificacao").val("pts");
	} else {
		$("#classificacao").val("pt");
		$("div.comercio_gas").hide();
		$("div.comercio_gas input[type=radio]").prop('checked', false);
		$("div.liq_inflamaveis").hide();
		$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);

		
	}
} );

$(document).on( "change", "div.comercio_gas input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.liq_inflamaveis").show();
		$("#classificacao").val("pts");

		
		
	} else {
		$("#classificacao").val("pt");
		$("div.liq_inflamaveis").hide();
		$("div.liq_inflamaveis input[type=radio]").prop('checked', false);
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);

		
	}
} );

$(document).on( "change", "div.liq_inflamaveis input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.gas_inflamaveis").show();
		$("#classificacao").val("pts");

		
		
	} else {
		$("#classificacao").val("pt");
		$("div.gas_inflamaveis").hide();
		$("div.gas_inflamaveis input[type=radio]").prop('checked', false);
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);

		
	}
} );

$(document).on( "change", "div.gas_inflamaveis input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.produtos_perigosos").show();
		$("#classificacao").val("pts");

		
		
	} else {
		$("#classificacao").val("pt");
		$("div.produtos_perigosos").hide();
		$("div.produtos_perigosos input[type=radio]").prop('checked', false);

		
	}
} );

$(document).on( "change", "div.produtos_perigosos input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.vistoria_clcb").show();
		$("#classificacao").val("pts");
	} else {
		$("#classificacao").val("pt");
	}
} );

$(document).on( "change", "div.vistoria_clcb input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		$("div.local_vistoria").hide();
	} else {
		$("div.local_vistoria").show();
	}
} );

function get_atividades() {
	$.get(
		'/tipoatividades/', {},
		function(response){
			var resposta = JSON.parse(response);
			var html = "";
			$.each(resposta, function( index, data ) {
				var text = data.divisao+' - ' +data.ocupacao+' - ' + data.descricao;
				html = '<option value="'+data.divisao+'" title="'+text+'">'+text+'</option>';
				$("select#tipo_atividade").append(html);
			});
		}
	);	
}

$(document).on( "change", "#11 input.chkatestado", function(){
		if ($("#11 div.engenheiro input.chkatestado:checked").length > 0) {
			$("#11 div.incluir_vistoria").hide();
  		$("#11 #incluir_vistoria-0").attr("checked", true);
		} else {
			$("#11 div.incluir_vistoria").show();
  		$("#11 #incluir_vistoria-0").attr("checked", false);
		}
});

$(document).on( "change", "#14 div.possui_licenca input[type=radio]", function(){
	var option = $(this).val();
	if (option == 'N') {
		alert("Verifique a possibilidade de vender a licença ambiental para o cliente.");
	}
});