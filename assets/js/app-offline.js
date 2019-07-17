var historico = "";

$(document).ready(function(){
	prepareFileSystem();

	swal({
		title: "",
		text: "Modo offline ativado.",
		type: "info",
		confirmButtonClass: "btn-info btn-round btn-fill",
		confirmButtonText: 'Ok',
		closeOnConfirm: true
	});	

	$('body').on('click', "a.internal", function(e) {
		e.preventDefault();

		var href = $(this).attr("href");
		navigate(href);

	});

	$('body').on('click', "a.link-detalhe", function(e) {
		e.preventDefault();

		var href = $(this).attr("href");
		
		swal({
			title: "",
			text: "Você já está com todos os EPIs necessários?",
			type: "info",
			showCancelButton: true,
			confirmButtonClass: "btn-info btn-round btn-fill",
			confirmButtonText: 'Sim, prosseguir',
			cancelButtonText: 'Não estou certo',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: false
		},
		function(isConfirm){
			if (isConfirm) {
				swal({
					title: "",
					text: "Realmente está certo que possui TODOS os EPIs necessários??",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-rose btn-round btn-fill",
					confirmButtonText: 'Sim, tenho certeza!',
					cancelButtonText: 'Não, voltar',
					cancelButtonClass: "btn-default btn-round btn-fill",
					closeOnConfirm: true
				},
				function(isConfirm){
					if (isConfirm) {
						navigate(href);
					}
				});
			}
		});
	});

	$('body').on('click', "a.navbar-voltar", function(e) {
		e.preventDefault();

		if (historico) {
			navigate(historico, false);
			$(this).hide();
			if (historico != "#page-lista") {
				$("a.navbar-inicio").show();
			}
		} else {
			console.log("não há histórico");
		}

	});

	$('body').on('click', "a.navbar-inicio", function(e) {
		e.preventDefault();

		navigate("#page-lista", false);
		$(this).hide();

	});

	$('body').on('click', "a.menu-link", function(e) {
		e.preventDefault();

		var href = $(this).attr("href");
		parentPage = $(".content.active");
		historico = "#" + parentPage.attr("id");

		$(href).addClass("active");
		parentPage.removeClass("active");

		$(".nav-item").removeClass("active");
		$(this).parents(".nav-item").addClass("active");

		$("a.navbar-voltar").show();
		parentPage.hide();
		$(href).fadeIn(400);
		window.scrollTo(0, 0);

		setTimeout(function() { $(".navbar-toggler").click(); }, 500);


	});
	
	$('body').on('click', ".lista-produtos tr", function(e) {
		$(this).find(".check-produto").click();
	});

	$('body').on('change', ".check-produto", function(e) {
		e.preventDefault();
		var clicked = this;
		if (clicked.checked) {
			$(".check-produto").each(function(el) { 
				if (this != clicked) {
					this.checked = false; 
				}
			});
			
			var idproduto = $(clicked).data("produto");
			$("fieldset.form-produtos").hide();
			$("#produtos-"+idproduto).fadeIn(400);

		} else {
			clicked.checked = true;
		}

		return false;
	});

	$("body").on("change.bs.fileinput", ".panel-fotos .fileinput", function(ev){
		ev.stopPropagation();
		ev.stopImmediatePropagation();

		var input = $(this).find("input[type='file']");
		preview = $(this).find(".fileinput-preview");
		botao = $(this).find(".btn-remove");

		if (input.val()) {
			$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").removeClass("btn-default");
			$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").addClass("btn-success");
			$(".assuntoselect").attr("disabled", true);

			botao.removeClass("confirm");

			if ($(this).parent().is(':last-child')) {
				var newelement = $(this).parent().clone();
				newelement.appendTo($(this).parent().parent());
				newelement.find(".btn-remove").click();
			}
		}

		$(".panel-fotos .fileinput").unbind("change.bs.fileinput");

		return false;

	});

	$("body").on("click", ".btn-remove", function(ev){
		ev.preventDefault();

		var botao = $(this)
		parent = botao.parent().parent().parent();

		if (!parent.is(':last-child')) {
			parent.remove();
		}

	});

	$("body").on("click", ".btn-confirm", function(ev){
		ev.preventDefault();
		ev.stopPropagation();
		return false;
		var botao = $(this);

		swal({
			title: "",
			text: "A foto já foi enviada, deseja remover?",
			type: "info",
			showCancelButton: true,
			confirmButtonClass: "btn-info btn-round btn-fill",
			confirmButtonText: 'Sim, excluir',
			cancelButtonText: 'Não, manter',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				botao.removeClass("btn-confirm");
				botao.addClass("btn-remove");
				botao.click();
			}
		});

		return false;

	});

	$('body').on('change', ".assuntoselect", function(e) {
		$(".assuntoselect").removeClass("selected");
		$(".record-audio").hide();

		var fotos = $(this).val();
				tprodutos  = $(this).parent().parent().parent().parent().find(".table-produtos tbody");
				tservicos  = $(this).parent().parent().parent().parent().find(".table-servicos tbody");
				tmaodeobra = $(this).parent().parent().parent().parent().find(".table-maodeobra tbody");
				audiorec 	 = $(this).parent().parent().parent().parent().find(".record-audio");
				observacao = $(this).parent().parent().parent().parent().find(".obscompras");

		if (fotos) {
			$(this).addClass("selected");
			$(".panel-fotos").removeClass("visible");
			$("#panel-"+fotos).addClass("visible");

			tprodutos.html("");
			tservicos.html("");
			tmaodeobra.html("");
			audiorec.text("");
			observacao.text("");
		}

	});

	$('body').on('change', ".select-produtos", function(e) {
		var idequipamento = $(this).val();
				cat  					= $(this).data("cat");
				nome 					= $(this).find("option:selected").text();
				ambiente 			= $(this).data("amb");
				assunto 			= $(this).data("assunto");

		icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
		field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+cat+'][equip]['+idequipamento+']" placeholder="Qtd"></div></td>';

		$(this).parent().find(".table-produtos tbody").append("<tr>"+icon+"<td>"+nome+"</td><td>"+field+"</td></tr>");

		$(this).val("");
	});

	$('body').on('change', ".select-servicos", function(e) {
		var idservico = $(this).val();
				cat  			= $(this).data("cat");
				nome 			= $(this).find("option:selected").text();
				ambiente 	= $(this).data("amb");
				assunto 	= $(this).data("assunto");

		icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
		field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+cat+'][servico]['+idservico+']" placeholder="Qtd" value="1"></div></td>';

		$(this).parent().find(".table-servicos tbody").append("<tr>"+icon+"<td>"+nome+"</td><td>"+field+"</td></tr>");

		$(this).val("");


	});

	$('body').on('change', ".select-maodeobra", function(e) {
		var idmaodeobra = $(this).val();
				cat  				= $(this).data("cat");
				nome 				= $(this).find("option:selected").text();
				ambiente 		= $(this).data("amb");
				assunto 		= $(this).data("assunto");

		icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
		field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+cat+'][maodeobra]['+idmaodeobra+']" placeholder="Períodos"></div></td>';

		$(this).parent().find(".table-maodeobra tbody").append("<tr>"+icon+"<td>"+nome+"</td><td>"+field+"</td></tr>");

		$(this).val("");


	});

	$('body').on('submit', "#form-assuntos", function(e) {
		e.preventDefault();

		var form 			 = $(this);
			  params 		 = parseData(form);
				id_assunto = $(".panel-fotos.visible").attr("id").replace("panel-", "");
				date 			 = new Date();
				timestamp  = date.getTime();	      	
	      save_sinc  = {};

	  files = form.find("input[type='file']");
		
		var saved = localStorage.getItem('save_sinc');
		if (saved) {
			sincs = JSON.parse(saved);
		} else {
			sincs = {};
		}

		save_sinc['params'] = {};
    $.each(params, function(key, value) {
    	save_sinc['params'][key] = value;
    });
  	save_sinc['params']["id_assunto"] = id_assunto;

	  if (files.length) {
			save_sinc['img'] = {};
    	var imgindex = 0;
	    files.each(function( index ) {
	    	save_sinc['img'][imgindex] = {};
	      file_data = $(this).prop("files")[0];
	      file_name = $(this).attr("name");

	      if (file_name && file_data) {
    			filename = timestamp + "_" + file_data.name;

    			// salva no filesystem
		      (function(f) {
		        window.fs.root.getFile(filename, {create: true, exclusive: true}, function(fileEntry) {
		          fileEntry.createWriter(function(fileWriter) {
		            fileWriter.write(f); 
		          }, errorHandler);
		        }, errorHandler);
		      })(file_data);

					save_sinc['img'][imgindex]["name"] = file_name;
					save_sinc['img'][imgindex]["file"] = filename;
					imgindex++;
		    }
	    });  
	  }

    sincs[timestamp] = save_sinc;
		localStorage.setItem('save_sinc', JSON.stringify(sincs));

		if ($(".demanda-"+id_assunto).length) {
			$(".demanda-"+id_assunto).remove();
		}

		var tprodutos  = $(".panel-fotos.visible").parent().parent().parent().find(".table-produtos tbody");
				tservicos  = $(".panel-fotos.visible").parent().parent().parent().find(".table-servicos tbody");
				tmaodeobra = $(".panel-fotos.visible").parent().parent().parent().find(".table-maodeobra tbody");
				txassunto  = $(".panel-fotos.visible").parent().parent().find("option:selected").text();
				audiolist  = $(".panel-fotos.visible").parent().parent().parent().find("#recordingslist");
				textobs  	 = $(".panel-fotos.visible").parent().parent().parent().find(".obscompras");

		assunto = txassunto.split(" - ");

		var qtd_produto = tprodutos.find("tr").length;
		var qtd_maoobra = tmaodeobra.find("tr").length;

		var html =  "<tr class='demanda-"+id_assunto+"'><td>" + id_assunto + "</td>";
				html += "<td><a href='#' class='show-demanda' data-id='"+id_assunto+"'>"+assunto[0]+"</a></td>";
				html += "<td>"+qtd_produto+"</td>";
				html += "<td>"+qtd_maoobra+"</td>";
                  
		$(".panel-fotos.visible").parent().parent().find(".table-demandas").append(html);

		$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").removeClass("btn-success");
		$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").addClass("btn-default");
		$(".assuntoselect").val("");				
		$(".assuntoselect").attr("disabled", false);
		$(".panel-fotos.visible").removeClass("visible");
		tprodutos.text("");
		tservicos.text("");
		tmaodeobra.text("");
		audiolist.text("");
		textobs.text("");

	});

	$('body').on('submit', "#form-perguntas", function(e) {
		e.preventDefault();

		swal({
			title: "",
			text: "Impossível salvar em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

	});

	$('body').on('submit', "#form-infoart", function(e) {
		e.preventDefault();
		return false;
	});

	$('body').on('submit', "#form-infoassuntos", function(e) {
		e.preventDefault();

		swal({
			title: "",
			text: "Impossível salvar em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

	});

	$('body').on('submit', "#form-ambientes", function(e) {
		e.preventDefault();
		var form = $(this);
				params = parseData(form);

		var newrow = $(".lista-ambientes").find("tr:first-child").clone();
		var newid = newrow.data("id");
		newrow.attr("data-id", newid + 1);
		newrow.find("td").eq(1).text(params['nome']);
		newrow.find("td").eq(2).text("0 fotos");
		newrow.find("td").eq(3).text("0 equipamentos");
		newrow.appendTo($(".lista-ambientes"));	
			
		idagenda = $("#id_vistoria").val();
		// localStorage.setItem('ambientes['+idagenda+']', $("#page-ambientes").html());

		form.find("input").val("");

		return false;

      $.each(params, function(key, value) {
        form_data.append(key, value);
      }); 


      $.ajax({
        url: "/vistoria/main.php?action=salvaAmbientes",
        type: 'POST',
        data: form_data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(resposta, textStatus, jqXHR) { 
          if (resposta.result) {
						swal({
							title: "",
							text: "Dados salvos com sucesso",
							type: "success",
							showCancelButton: false,
							confirmButtonClass: "btn-success btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						},
						function(isConfirm){
							if (isConfirm) {
								getAmbientes(resposta.id_agenda, false);
								setTimeout(function(){ assinatura(); }, 1000);
							}
						});
          }
        }
      });
	});

	$('body').on('submit', "#form-nomeambiente", function(e) {
		e.preventDefault();

		// localStorage.setItem('ambiente['+ambiente+']', $("#page-ambiente").html());

		var form = $(this);
				params = parseData(form);

      var form_data = new FormData();

      $.each(params, function(key, value) {
        form_data.append(key, value);
      }); 

      $.ajax({
        url: "/vistoria/main.php?action=salvaAmbiente",
        type: 'POST',
        data: form_data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(resposta, textStatus, jqXHR) { 
          if (resposta.result) {
						swal({
							title: "",
							text: "Dados salvos com sucesso",
							type: "success",
							showCancelButton: false,
							confirmButtonClass: "btn-success btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						},
						function(isConfirm){
							if (isConfirm) {
								getAmbiente(resposta.id_ambiente, false);
							}
						});
          }
        }
      });
	});

	$('body').on('change', ".chk-riscos", function(e) {
		e.preventDefault();
		$("#form-riscos").submit();
	});

	$('body').on('submit', "#form-riscos", function(e) {
		e.preventDefault();
		var form = $(this);
				params = parseData(form);

      var form_data = new FormData();

      $.each(params, function(key, value) {
        form_data.append(key, value);
      }); 

      $.ajax({
        url: "/vistoria/main.php?action=salvaRiscos",
        type: 'POST',
        data: form_data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(resposta, textStatus, jqXHR) { 
          if (resposta.result) {
          	// does nothing
          }
        }
      });
	});

	$('body').on('click', ".navigate-infos", function(e) {
		e.preventDefault();
		var idagenda = $(this).data("id");
    		infos 	 = localStorage.getItem('infos['+idagenda+']');

		if (infos) {
	    $("#page-infos").html(infos);
	    navigate("#page-infos");
		} else {
			swal({
				title: "Erro",
				text: "A informação solicitada não está disponível offline",
				type: "error",
				showCancelButton: false,
				confirmButtonClass: "btn-rose btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
		}
	});

	$('body').on('click', ".lista-ambientes tr", function(e) {
		e.preventDefault();
		var idambiente = $(this).attr("data-id");
				nome 			 = $(this).find("td").eq(1).text();

		getAmbiente(idambiente, true, nome);

	});

	$('body').on('click', ".navigate-ambientes", function(e) {
		e.preventDefault();
		var idagenda = $(this).data("id");
		getAmbientes(idagenda);

	});

	$('body').on('click', ".clear-signature", function(e) {
		if ($("#assinatura-cliente").length) {
			$("#assinatura-cliente").remove();
			$("#signature").show();
		}
		$("#signature").jSignature("reset");

		// Trigger resize porque por algum motivo a assinatura só funciona depois do resize ¬¬ 
		setTimeout(function(){ $(window).trigger('resize'); }, 500);
	});
	
	$('body').on('click', ".btn-sinc", function(e) {
		$(this).text("Sincronizando...");
		$(this).attr("disabled", true);
		setTimeout(function(){
			swal({
				title: "",
				text: "Erro, sem dados para sincronizar",
				type: "warning",
				showCancelButton: false,
				confirmButtonClass: "btn-warning btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			},
			function(isConfirm){
				if (isConfirm) {
					location.reload()
				}
			});
		}, 2000);
	});

  $('body').on('click', ".btn-novoambiente", function(e) {
		e.preventDefault();

		swal({
			title: "",
			text: "Função bloqueada em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

  });	

	$('body').on('submit', "#form-infoambientes", function(e) {
		e.preventDefault();

		swal({
			title: "",
			text: "Impossível salvar em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

	});

	$('body').on('click', ".btn-descartait", function(e) {
		var botao = $(this);
		var id_categoria = $(this).data("id");
		$("#descartarIt").find(".select-motivo").val("");
		$("#descartarIt").find("#descarta_categoria").val(id_categoria);

		$("#descartarIt").modal("show");

		return false;

	});

	$('body').on('submit', "#form-descartait", function(e) {
		e.preventDefault();
		$("#descartarIt").modal("hide");

		var form = $(this);
				params = parseData(form);

    var form_data = new FormData();

    $.each(params, function(key, value) {
      form_data.append(key, value);
    });

	  $.ajax({
	    url: "/vistoria/main.php?action=descartaIt",
	    type: 'POST',
	    data: form_data,
	    dataType: 'json',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(resposta, textStatus, jqXHR) { 
        if (resposta.result) {
					swal({
						title: "",
						text: "It descartada com sucesso",
						type: "success",
						showCancelButton: false,
						confirmButtonClass: "btn-success btn-round btn-fill",
						confirmButtonText: 'Ok',
						closeOnConfirm: true
					},
					function(isConfirm){
						if (isConfirm) {
							$(".panel-descarta"+resposta.id_categoria).remove();
							// botao.parent().parent().parent().remove();
						}
					});
				}
	    }
	  });	 
	});

	$('body').on('click', ".btn-concluirform", function(e) {
		
		swal({
			title: "",
			text: "Função bloqueada em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

	});

	$("body").on("click", ".btn-duplicate", function(ev){
		ev.preventDefault();
		setTimeout(function(){
			$("#form-infoambientes").find("input[name='id_ambiente']").val("");
		}, 2000);

	});

	$("body").on("click", ".btn-rowits", function(ev){
		ev.preventDefault();
		$(".row-its").toggle(400);
	});

	$("body").on("click", ".save-demanda", function(ev){
		ev.preventDefault();
			if ($(".panel-fotos.visible").find(".fileinput-exists.thumbnail img").length == 0) {
			swal({
				title: "",
				text: "Selecione pelo menos uma foto",
				type: "error",
				confirmButtonClass: "btn-rose btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
			return;
		}

		var container = $(this).parentsUntil(".col-md-6");
		if ($(container[2]).parent().find("input[type='number']").length == 0) {
			swal({
				title: "",
				text: "Selecione pelo menos um produto ou mão de obra",
				type: "error",
				confirmButtonClass: "btn-rose btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
			return;
		}

		$(container[2]).parent().find("input[type='number']").each(function(el) {
			if (isNaN($(this).val())) {
				swal({
					title: "",
					text: "Selecione pelo menos um produto ou mão de obra",
					type: "error",
					confirmButtonClass: "btn-rose btn-round btn-fill",
					confirmButtonText: 'Ok',
					closeOnConfirm: true
				});

				return;
			}
		});


		swal({
			title: "",
			text: "Confirmar finalização da demanda?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Sim!',
			cancelButtonText: 'Não, voltar',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				$("#form-assuntos").submit();
			}
		});
	});

	$("body").on("click", ".show-demanda", function(ev){
		ev.preventDefault();

		var id_assunto = $(this).data("id");
				select  	 = $(this).parent().parent().parent().parent().parent().parent().parent().find(".assuntoselect");
				idambiente = $("#id_ambiente").val();
				tprodutos  = select.parent().parent().parent().parent().find(".table-produtos tbody");
				tservicos  = select.parent().parent().parent().parent().find(".table-servicos tbody");
				tmaodeobra = select.parent().parent().parent().parent().find(".table-maodeobra tbody");
				audiolist  = select.parent().parent().parent().parent().find("#recordingslist");
				textobs  	 = select.parent().parent().parent().parent().find(".obscompras");
				demandaspr = localStorage.getItem('demandasprod['+idambiente+']['+id_assunto+']');
				demandasse = localStorage.getItem('demandasserv['+idambiente+']['+id_assunto+']');
				demandasma = localStorage.getItem('demandasmao['+idambiente+']['+id_assunto+']');
				demandaobs = localStorage.getItem('demandasobs['+idambiente+']['+id_assunto+']');
				demandaud  = localStorage.getItem('demandaud['+idambiente+']['+id_assunto+']');

		select.val(id_assunto);
		select.change();

		if (demandaspr)
			tprodutos.append(demandaspr);

		if (demandasse)
			tservicos.append(demandasse);

		if (demandaobs)
			textobs.text(demandaobs);

		if (demandaud)
			audiolist.append(demandaud);

	});

	$('body').on('click', ".navigate-analise", function(e) {
		e.preventDefault();

		swal({
			title: "",
			text: "Página bloqueada em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

	});

	$("body").on("click", ".btn-filtervistoria", function(ev){
    $(this).removeClass("btn-filtervistoria");
    $(this).removeClass("btn-info");
    $(this).addClass("btn-nonfiltervistoria");
    $(this).addClass("btn-rose");

    filtrar();
  });

	$("body").on("click", ".btn-nonfiltervistoria", function(ev){
    $(this).removeClass("btn-nonfiltervistoria");
    $(this).removeClass("btn-rose");
    $(this).addClass("btn-filtervistoria");
    $(this).addClass("btn-info");

    filtrar();
  });

	$("body").on("click", ".btn-filteranalise", function(ev){
    $(this).removeClass("btn-filteranalise");
    $(this).removeClass("btn-info");
    $(this).addClass("btn-nonfilteranalise");
    $(this).addClass("btn-rose");

    filtrar();
  });

	$("body").on("click", ".btn-nonfilteranalise", function(ev){
    $(this).removeClass("btn-nonfilteranalise");
    $(this).removeClass("btn-rose");
    $(this).addClass("btn-filteranalise");
    $(this).addClass("btn-info");

    filtrar();
  });
  
});

function filtrar() {
  $(".card-servico").each(function(el){
    var card = $(this);

    if ($('.btn-nonfilteranalise').length && $(this).find(".navigate-analise").length) {
    	$(this).parent().show();
    } else if ($('.btn-nonfiltervistoria').length && $(this).find(".navigate-ambientes").length) {
    	$(this).parent().show();
    } else if ($('.btn-nonfiltervistoria').length == 0 && $('.btn-nonfilteranalise').length == 0) {
    	$(this).parent().show();
    } else {
    	$(this).parent().hide();
    }

  });

}

function getAmbientes(idagenda, hist = true) {

	navigate("#page-start", hist);

	var pagina = localStorage.getItem('ambientes['+idagenda+']');
	if (pagina) {
    $("#page-ambientes").html(pagina);
    setTimeout(function(){
    	navigate("#page-ambientes", false);
			setTimeout(function(){ assinatura(); }, 500);
  	}, 500);

	} else {
		swal({
			title: "Erro",
			text: "A informação solicitada não está disponível offline",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});
	}
}

function getAmbiente(idambiente, hist = true, nome = "") {

	navigate("#page-start", hist);

	var pagina = localStorage.getItem('ambiente['+idambiente+']');
	if (pagina) {
    $("#page-ambiente").html(pagina);
    setTimeout(function(){
    	navigate("#page-ambiente", false);
  	}, 500);

	} else {
		swal({
			title: "Erro",
			text: "A informação solicitada não está disponível offline",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});	
	}
}

function navigate (href, hist = true) {

	window.scrollTo(0, 0);
	setTimeout(function(){
		parentPage = $(".content.active");
		if (hist)
			historico = "#" + parentPage.attr("id");
		
		$(href).addClass("active");
		parentPage.removeClass("active");

		if (hist)
			$("a.navbar-voltar").show();
		
		parentPage.hide();
		$(href).fadeIn(400);
	}, 600);
}


function parseData(form) {
	var data = form.serializeArray();
	var params = {};

	$.each(data, function( index, value ) {
    if (value.name && value.value) {
      params[value.name] = value.value;
    }
	});

	return params;
}

function assinatura() {
	
	// This is the part where jSignature is initialized.
	$("#signature").empty();
	var $sigdiv = $("#signature").jSignature({'UndoButton':false});

	// Trigger redize porque por algum motivo a assinatura só funciona depois do resize ¬¬ 
	setTimeout(function(){ $(window).trigger('resize'); }, 800);

	$('body').on('click', ".btn-concluir", function(e) {

		swal({
			title: "",
			text: "Não é possível concluir a vistoria em modo offline.",
			type: "error",
			showCancelButton: false,
			confirmButtonClass: "btn-rose btn-round btn-fill",
			confirmButtonText: 'Ok',
			closeOnConfirm: true
		});

	});

	$('body').on('click', ".btn-salvavistoria", function(e) {
		e.preventDefault();
		var idagenda = $("#id_vistoria").val();

		if ($(".card-fachada").find(".fileinput-exists.thumbnail img").length == 0) {
			swal({
				title: "",
				text: "Inclua a foto da fachada",
				type: "error",
				confirmButtonClass: "btn-rose btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
			return;
		}

		if ($(".row-cliente").find(".fileinput-exists.thumbnail img").length == 0) {
			swal({
				title: "",
				text: "Inclua a foto do cliente",
				type: "error",
				confirmButtonClass: "btn-rose btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
			return;
		}

		if ($("#nome-cliente").val() == "" || $("#rg-cliente").val() == "") {
			swal({
				title: "",
				text: "Inclua os dados do cliente",
				type: "error",
				confirmButtonClass: "btn-rose btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
			return;
		}

		if ($("#assinatura-cliente").length == 0) {
	  	var strokeData = $sigdiv.jSignature('getData', 'native');
			if( strokeData.length == 0 ) {
				swal({
					title: "",
					text: "Favor coletar a assinatura do cliente",
					type: "error",
					confirmButtonClass: "btn-rose btn-round btn-fill",
					confirmButtonText: 'Ok',
					closeOnConfirm: true
				});
				return;
			}
			if (strokeData[strokeData.length - 1]['x'].length < 1) {
				swal({
					title: "",
					text: "Favor coletar a assinatura do cliente",
					type: "error",
					confirmButtonClass: "btn-rose btn-round btn-fill",
					confirmButtonText: 'Ok',
					closeOnConfirm: true
				});
			}

	  	// https://ourcodeworld.com/articles/read/322/how-to-convert-a-base64-image-into-a-image-file-and-upload-it-with-an-asynchronous-form-using-jquery
	    var imgdata  = $sigdiv.jSignature('getData', 'image');
	    		realData = imgdata[1];

	    var blob = b64toBlob(realData);

		  var form_data = new FormData();
					form_data.append("assinatura", blob);
		} else {
		  var form_data = new FormData();
		}
				form_data.append("id_agenda", idagenda);		
				form_data.append("nome", $("#nome-cliente").val());		
				form_data.append("rg", $("#rg-cliente").val());		

	  files = $("#page-ambientes").find("input[type='file']");

	  if (files.length) {
	    files.each(function( index ) {
	      file_data = $(this).prop("files")[0];
	      file_name = $(this).attr("name");
	      if (file_name && file_data) {
		      form_data.append(file_name, file_data);
	      }
	    });  
	  }

		$.ajax({
		    url:"/vistoria/main.php?action=salvaVistoria",
		    data: form_data,
		    type:"POST",
		    contentType:false,
		    processData:false,
		    cache:false,
		    dataType:"json",
		    success:function(resposta){

          if (resposta.result) {
						swal({
							title: "",
							text: "Dados salvos com sucesso",
							type: "success",
							showCancelButton: false,
							confirmButtonClass: "btn-success btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						});
          } else {
						swal({
							title: "",
							text: resposta.message,
							type: "error",
							showCancelButton: false,
							confirmButtonClass: "btn-rose btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						});
          }

		    }
		});
		return true;	

	});
	
}

function b64toBlob(b64Data) {

  contentType = 'image/png';
  sliceSize = 512;

  var byteCharacters = atob(b64Data);
  var byteArrays = [];

  for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
      var slice = byteCharacters.slice(offset, offset + sliceSize);

      var byteNumbers = new Array(slice.length);
      for (var i = 0; i < slice.length; i++) {
          byteNumbers[i] = slice.charCodeAt(i);
      }

      var byteArray = new Uint8Array(byteNumbers);

      byteArrays.push(byteArray);
  }

  var blob = new Blob(byteArrays, {type: contentType});
  return blob;
}

var audio_context;
var recorder;

function startUserMedia(stream) {
  var input = audio_context.createMediaStreamSource(stream);
  console.log('Media stream created.');
  
  recorder = new Recorder(input);
  console.log('Recorder initialised.');
}

function startRecording(button) {
  initContext();
  $(".record-audio").attr("disabled", true);
  $(".record-audio").html("<i class='material-icons'>mic</i> Espere...");
  setTimeout(function(){
    recorder && recorder.record();
    console.log('Recording...');
	  $(".save-audio").show();
	  $(".cancel-audio").show();
  	$(".record-audio").html("<i class='material-icons'>mic</i> Gravando");
  }, 1500);
}

function stopRecording(button) {
  recorder && recorder.stop();
  $(".record-audio").attr("disabled", false);
  $(".record-audio").html("<i class='material-icons'>mic</i> Gravar");
  $(".save-audio").hide();
  $(".cancel-audio").hide();
  console.log('Stopped recording.');
  
  // create WAV download link using audio data blob
  createDownloadLink(button);
  
  recorder.clear();
  audio_context.close();
}

function cancelRecording(button) {
  recorder && recorder.stop();
  $(".record-audio").attr("disabled", false);
  $(".record-audio").html("<i class='material-icons'>mic</i> Gravar");
  $(".save-audio").hide();
  $(".cancel-audio").hide();
  console.log('Cancelled recording.');
  
  recorder.clear();
  audio_context.close();
}

function createDownloadLink(button) {
  recorder && recorder.exportWAV(function(blob) {
    var url = URL.createObjectURL(blob);
    var li = document.createElement('li');
    var au = document.createElement('audio');
    var hf = document.createElement('a');
    var idassunto = $(".assuntoselect.selected").val();
    var idcategoria = $(button).data("cat");
    var idambiente = $(button).data("amb");
    
    var data = new FormData();
    data.append('idassunto', idassunto);
    data.append('idcategoria', idcategoria);
    data.append('idambiente', idambiente);
    data.append('record', blob);

    $.ajax({
	    url: "/vistoria/main.php?action=uploadAudio",
      type: 'POST',
      data: data,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: function(data) {
				var icon 	= '<button type="button" class="btn btn-rose btn-round btn-link remove-audio" data-id="'+data.idaudio+'"><i class="material-icons">close</i></button>';
				au.controls = true;
				au.src = url;
				hf.href = url;
				hf.download = new Date().toISOString() + '.wav';
				hf.innerHTML = hf.download;
				$(li).prepend(icon);
				li.appendChild(au);
				$("#recordingslist").append(li);
      }
    });    
  });
}

function initContext() {
  try {
    // webkit shim
    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
    window.URL = window.URL || window.webkitURL;
    
    audio_context = new AudioContext;
    console.log('Audio context set up.');
    console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
  } catch (e) {
    alert('No web audio support in this browser!');
  }
  
  navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
    console.log('No live audio input: ' + e);
  });
}

function prepareFileSystem(){
	navigator.webkitPersistentStorage.requestQuota(5*1024*1024*1024, function(grantedBytes) {
	  window.webkitRequestFileSystem(PERSISTENT, grantedBytes, function(fs){
			window.fs = fs;
	  }, errorHandler);
	}, function(e) {
	  console.log('Error', e);
	});	

}

function errorHandler(e) {
  var msg = '';

  switch (e.code) {
    case 10:
      msg = 'QUOTA_EXCEEDED_ERR';
      break;
    case 1:
      msg = 'NOT_FOUND_ERR';
      break;
    case 2:
      msg = 'SECURITY_ERR';
      break;
    case 9:
      msg = 'INVALID_MODIFICATION_ERR';
      break;
    case 7:
      msg = 'INVALID_STATE_ERR';
      break;
    default:
      msg = 'Unknown Error';
      break;
  };

  console.log('Error: ' + msg);
}