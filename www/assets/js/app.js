var historico = "";

$(document).ready(function(){

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

		$(".navbar-toggler").click();


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
			$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").attr("disabled", false);
			$(".panel-fotos.visible").parent().parent().parent().find(".cancel-demanda").show();
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


	$("body").on("click", "#page-analise .add-analise", function(ev){
		var botao = $(this);
				panel = $(this).parent().parent().parent();
	  		files = panel.find("input[type='file']");

	  if (files.length) {
	    files.each(function( index ) {
	      file_data = $(this).prop("files")[0];
	      file_name = $(this).attr("name");
	      if (file_name && file_data) {
	      	if (file_data.type.match(/image.*/)) {
		      	resizePhotoAnalise(file_data, file_name, $(this));
	      	}
	      }
	    });  
	  }

	});

	$("body").on("submit", ".form-gerais", function(ev){
		ev.preventDefault();

		var form 			  = $(this);
			  params 		  = parseData(form);
			  filecount		= 0;

	  files = form.find("input[type='file']");

	  if (files.length) {
	    files.each(function( index ) {
	      file_data = $(this).prop("files")[0];
	      file_name = $(this).attr("name");
	      if (file_name && file_data) {
	      	if (file_data.type.match(/image.*/)) {
		      	resizePhotoGerais(file_data, file_name, params);
		      	filecount++;
	      	}
	      }
	    });  
	  } 

	  if (filecount == 0) {
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

		return false;

	});

	$("body").on("click", ".btn-remove", function(ev){
		ev.preventDefault();

		var botao = $(this)
				id_image = botao.data("id");
				parent = botao.parent().parent().parent()
	  		form_data  = new FormData();

		if (!parent.is(':last-child')) { 
    
			swal({
				title: "",
				text: "A foto já foi enviada, deseja remover?",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-info btn-round btn-fill",
				confirmButtonText: 'Sim, excluir',
				cancelButtonText: 'Não, manter',
				cancelButtonClass: "btn-default btn-round btn-fill",
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			},
			function(isConfirm){
				if (isConfirm) {

			    form_data.append("id_image", id_image);
			    
				  $.ajax({
				    url: "/vistoria/main.php?action=deleteImage",
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
									text: "Foto excluída com sucesso!",
									type: "success",
									confirmButtonClass: "btn-success btn-round btn-fill",
									confirmButtonText: 'Ok',
									closeOnConfirm: true
								},
								function(isConfirm){
									if (isConfirm) {
										parent.remove();
									}
								});								
							}
						}
					});
				}
			});
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

	$('body').on('change', ".select-produtos", function(e) {
		if (!$(this).val()) return;

		var idequipamento = $(this).val();
				cat  					= $(this).data("cat");
				nome 					= $(this).find("option:selected").text();
				ambiente 			= $(this).data("amb");
				assunto 			= $(this).data("assunto");

		$(this).parent().find(".save-demanda").removeClass("btn-default");
		$(this).parent().find(".save-demanda").addClass("btn-success");
		$(this).parent().find(".save-demanda").attr("disabled", false);
		$(this).parent().find(".cancel-demanda").show();				

		icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
		field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+cat+'][equip]['+idequipamento+']" placeholder="Qtd" value="1"></div></td>';

		var lista = $(this).parent().parent().parent().find(".lista-equips");
		if (lista.length != 0) {
			var item =  '<div class="form-group"><button type="button" class="btn btn-rose btn-round btn-link remove-lista" data-original-title="" title=""><i class="material-icons">close</i></button>';
					item += '<div>'+nome+':</div><div class="col-md-2"><input type="number" name="demanda['+cat+']['+ambiente+']['+assunto+'][servico]['+idequipamento+']" class="form-control input-sm" value="1" required></div></div>';
			lista.append(item);
		} else {
			$(this).parent().find(".table-produtos tbody").append("<tr>"+icon+"<td>"+nome+"</td><td>"+field+"</td></tr>");
		}
		$(this).val("");
	});

	$('body').on('change', ".select-servicos", function(e) {
		if (!$(this).val()) return;

		var idservico = $(this).val();
				cat  			= $(this).data("cat");
				nome 			= $(this).find("option:selected").text();
				ambiente 	= $(this).data("amb");
				assunto 	= $(this).data("assunto");

		$(this).parent().find(".save-demanda").removeClass("btn-default");
		$(this).parent().find(".save-demanda").addClass("btn-success");
		$(this).parent().find(".save-demanda").attr("disabled", false);
		$(this).parent().find(".cancel-demanda").show();

		icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
		field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+cat+'][servico]['+idservico+']" placeholder="Qtd" value="1"></div></td>';

		var lista = $(this).parent().parent().parent().find(".lista-equips");
		if (lista.length != 0) {
			var item =  '<div class="form-group"><button type="button" class="btn btn-rose btn-round btn-link remove-lista" data-original-title="" title=""><i class="material-icons">close</i></button>';
					item += 'Serviço: '+nome+' <input type="hidden" name="demanda['+cat+']['+ambiente+']['+assunto+'][servico]['+idservico+']" class="form-control input-sm" value="1" required></div>';
			lista.append(item);
		} else {
			$(this).parent().find(".table-servicos tbody").append("<tr>"+icon+"<td>"+nome+"</td><td>"+field+"</td></tr>");
		}
		$(this).val("");


	});

	$('body').on('change', ".select-maodeobra", function(e) {
		if (!$(this).val()) return;
		
		var idmaodeobra = $(this).val();
				cat  				= $(this).data("cat");
				nome 				= $(this).find("option:selected").text();
				ambiente 		= $(this).data("amb");
				assunto 		= $(this).data("assunto");

		$(this).parent().find(".save-demanda").removeClass("btn-default");
		$(this).parent().find(".save-demanda").addClass("btn-success");
		$(this).parent().find(".save-demanda").attr("disabled", false);
		$(this).parent().find(".cancel-demanda").show();

		icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
		field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+cat+'][maodeobra]['+idmaodeobra+']" placeholder="Períodos" value="1"></div></td>';

		var lista = $(this).parent().parent().parent().find(".lista-equips");
		if (lista.length != 0) {
			var item =  '<div class="form-group"><button type="button" class="btn btn-rose btn-round btn-link remove-lista" data-original-title="" title=""><i class="material-icons">close</i></button>';
					item += '<div>'+nome+':</div><div class="col-md-6"><input type="number" name="demanda['+cat+']['+ambiente+']['+assunto+'][servico]['+idmaodeobra+']" class="form-control input-sm" value="1" required> Períodos</div></div>';
			lista.append(item);
		} else {
			$(this).parent().find(".table-maodeobra tbody").append("<tr>"+icon+"<td>"+nome+"</td><td>"+field+"</td></tr>");
		}
		$(this).val("");


	});

	$('body').on('click', ".remove-equip", function(e) {
		$(this).parent().parent().remove();
	});

	$('body').on('click', ".remove-lista", function(e) {
		$(this).parent().remove();
	});

	$('body').on('blur', ".qtd-equip", function(e) {
		e.stopPropagation();
		var ambiente = $("#id_ambiente").val();

	});

	$('body').on('submit', "#form-assuntos", function(e) {
		e.preventDefault();

	  var form_data  = new FormData();
			  form 			 = $(this);
			  params 		 = parseData(form);
			  id_fotos	 = $(".panel-fotos.visible").attr("id");
				id_assunto = id_fotos.replace("panel-", "");

	  files = form.find("input[type='file']");

	  if (files.length) {
	    files.each(function( index ) {
	      file_data = $(this).prop("files")[0];
	      file_name = $(this).attr("name");
	      if (file_name && file_data) {
	      	if (file_data.type.match(/image.*/)) {
		      	resizePhoto(file_data, file_name, id_assunto);
	      	} else {
			      form_data.append(file_name, file_real);
	      	}
	      }
	    });  
	  }

    $.each(params, function(key, value) {
      form_data.append(key, value);
    }); 
    
    form_data.append("id_assunto", id_assunto);
    
	  $.ajax({
	    url: "/vistoria/main.php?action=salvaAssuntos",
	    type: 'POST',
	    data: form_data,
	    dataType: 'json',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(resposta, textStatus, jqXHR) { 
				if (resposta.result) {
	    		setTimeout(function(){
						swal({
							title: "",
							text: "Demanda salva com sucesso!",
							type: "success",
							confirmButtonClass: "btn-success btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						},
						function(isConfirm){
							if (isConfirm) {
								getAmbiente(resposta.id_ambiente, false, false, true, id_fotos);
							}
						});
					}, 1000);

					return;					
				}
			}
		});

	});

	$('body').on('submit', "#form-perguntas", function(e) {
		e.preventDefault();

		var form = $(this);
				conclui = $("#concluir").val();
				params = parseData(form);

		if (conclui == "1")	{
			if ($(".info-ambientes").find("tr").length == 0) {
				swal({
					title: "",
					text: "Inclua pelo menos um ambiente para concluir o formulário.",
					type: "error",
					confirmButtonClass: "btn-rose btn-round btn-fill",
					confirmButtonText: 'Ok',
					closeOnConfirm: true
				});	

				return false;				
			} 
		}


    var form_data = new FormData();

    $.each(params, function(key, value) {
      form_data.append(key, value);
    }); 

    $.ajax({
      url: "/vistoria/main.php?action=salvaInfos",
      type: 'POST',
      data: form_data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function(resposta, textStatus, jqXHR) { 
        if (resposta.result) {
					if (conclui == "1")	{
						var mensagem = "Formulário concluído com sucesso!";
					} else {
						var mensagem = "Dados salvos com sucesso!";
					}

					swal({
						title: "",
						text: mensagem,
						type: "success",
						showCancelButton: false,
						confirmButtonClass: "btn-success btn-round btn-fill",
						confirmButtonText: 'Ok',
						closeOnConfirm: true
					},
					function(isConfirm){
						var idagenda = $("#id_agenda").val();
							// localStorage.setItem('infos['+idagenda+']', $("#page-infos").html());
							// localStorage.setItem('ambientes['+idagenda+']', resposta.ambientes);

						if (isConfirm) {
							location.reload()
						}
					});
        }
      }
    });
	});

	$('body').on('submit', "#form-infoart", function(e) {
		e.preventDefault();

		var form = $(this)
				params = parseData(form)
				idagenda = $("#id_agenda").val();

      var form_data = new FormData();

      $.each(params, function(key, value) {
        form_data.append(key, value);
      }); 
      
      form_data.append("id_agenda", idagenda);


      $.ajax({
        url: "/vistoria/main.php?action=salvaInfosArts",
        type: 'POST',
        data: form_data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
      });
	});

	$('body').on('submit', "#form-infoassuntos", function(e) {
		e.preventDefault();

		var form = $(this)
				params = parseData(form)
				idagenda = $("#id_agenda").val();

      var form_data = new FormData();

      $.each(params, function(key, value) {
        form_data.append(key, value);
      }); 
      
      form_data.append("id_agenda", idagenda);


      $.ajax({
        url: "/vistoria/main.php?action=salvaInfosAssuntos",
        type: 'POST',
        data: form_data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
      });
	});

	$('body').on('submit', "#form-ambientes", function(e) {
		e.preventDefault();
		var form = $(this);
				params = parseData(form);

		/*var newrow = $(".lista-ambientes").find("tr:first-child").clone();
		var newid = newrow.data("id");
		newrow.attr("data-id", newid + 1);
		newrow.find("td").eq(1).text(params['nome']);
		newrow.find("td").eq(2).text("0 fotos");
		newrow.find("td").eq(3).text("0 equipamentos");
		newrow.appendTo($(".lista-ambientes"));	*/
			
		idagenda = $("#id_vistoria").val();
		// localStorage.setItem('ambientes['+idagenda+']', $("#page-ambientes").html());

		form.find("input").val("");

		// return false;

    var form_data = new FormData();

    $.each(params, function(key, value) {
      form_data.append(key, value);
    }); 

    form_data.append("id_vistoria", idagenda);

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
							var newrow = $(".lista-ambientes").find("tr:last-child").clone();
							var newid = resposta.id_ambiente;
							newrow.attr("data-id", newid);
							newrow.find("td").eq(1).html('<a href="#" style="text-decoration: underline;">'+params['nome']+'</a>');
							newrow.find("td").eq(2).text("0 fotos");
							newrow.find("td").eq(3).text("0 equipamentos");
							newrow.appendTo($(".lista-ambientes"));
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

		getInfos(idagenda);
	});

	$('body').on('click', ".lista-ambientes tr", function(e) {
		e.preventDefault();
		var idambiente = $(this).attr("data-id");

		getAmbiente(idambiente, true);

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

		setTimeout(function(){ $("#signature").jSignature("reset"); }, 500);

		// Trigger resize porque por algum motivo a assinatura só funciona depois do resize ¬¬ 
		setTimeout(function(){ $(window).trigger('resize'); }, 1000);
	});
	
	$('body').on('change', ".select-decreto", function(e) {
		if(!$(this).val()) {
			$(".group-categorias").hide();
		} else {
			$(".group-categorias").show();

			setTimeout(function(){

				swal({
					title: "",
					text: "Todas as ITs referentes a esse projeto correspondem ao decreto selecionado?",
					type: "info",
					showCancelButton: true,
					confirmButtonClass: "btn-info btn-round btn-fill",
					confirmButtonText: 'Sim',
					cancelButtonClass: "btn-warning btn-round btn-fill",
					cancelButtonText: 'Não',
					closeOnConfirm: true
				},
				function(isConfirm){
					if (isConfirm) {
						$(".it-decreto").each(function(i){
							$(this).remove();
						});
					}
				});
			}, 500);
		}
	});

	$('body').on('click', ".art-check", function(e) {

		$("#form-infoart").submit();

	});

	$('body').on('click', ".it-check", function(e) {
		var clicked = this;
				container = $(clicked).parent().find('.it-decreto');

		if (clicked.checked) {
			container.show();
		} else {
			container.hide();
		}

		$("#form-infoassuntos").submit();

	});

	$('body').on('click', ".decreto-check", function(e) {
		var clicked = this;
				select  = $(clicked).parent().find('.select-decretoit');

		if (clicked.checked) {
			select.show();
		} else {
			select.hide();
		}
	});

	$('body').on('change', ".select-decretoit", function(e) {
		$("#form-infoassuntos").submit();
	});

  $('body').on('click', ".btn-novoambiente", function(e) {
		e.preventDefault();
		var idagenda   = $("#id_agenda").val()
				pavimentos = $("#pavimentos").val()
	  		form_data = new FormData();
	  
	  form_data.append("id_vistoria", idagenda);

    $("#edit-ambiente").hide();

	  $.ajax({
	    url: "/vistoria/main.php?action=getInfoAmbiente",
	    type: 'POST',
	    data: form_data,
	    dataType: 'html',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(resposta, textStatus, jqXHR) {
		    $("#edit-ambiente").html(resposta);
		    $("#edit-ambiente").show();
	    	if (!isNaN(pavimentos) && pavimentos > 0) {
	    		for(var i = 1; i <= pavimentos; i++) {
	    			if (i == 1) {
	    				$(".select-pavimentos").append("<option>Térreo</option>");
	    			} else {
	    				var andar = i - 1;
	    				$(".select-pavimentos").append("<option>"+andar+"º andar</option>");
	    			}
	    		}
	    	} else {
    			$(".select-pavimentos").append("<option>Térreo</option>");
	    	}
	    }
	  });	
  });	

	$('body').on('click', ".info-ambientes tr", function(e) {
		e.preventDefault();
		var idambiente = $(this).attr("data-id")
				idagenda = $("#id_agenda").val()
				pavimentos = $("#pavimentos").val()
	  		form_data = new FormData();
	  
	  form_data.append("id_vistoria", idagenda);
	  form_data.append("id_ambiente", idambiente);

    $("#edit-ambiente").hide();

	  $.ajax({
	    url: "/vistoria/main.php?action=getInfoAmbiente",
	    type: 'POST',
	    data: form_data,
	    dataType: 'html',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(resposta, textStatus, jqXHR) { 
		    $("#edit-ambiente").html(resposta);
		    $("#edit-ambiente").show();
	    	if (!isNaN(pavimentos)) {
	    		for(var i = 1; i < pavimentos; i++) {
	    			$(".select-pavimentos").append("<option>"+i+"º andar</option>");
	    		}
	    	} else {
    			$(".select-pavimentos").append("<option>1º andar</option>");
	    	}
	    }
	  });	

	});	

  $('body').on('click', "#ambiente_it_decreto", function(e) {
		var clicked = this;
				select  = $("#ambiente-decreto");

		if (clicked.checked) {
			select.show();
		} else {
			select.hide();
		}
		
  });	

	$('body').on('submit', "#form-infoambientes", function(e) {
		e.preventDefault();
		var idagenda = $("#id_agenda").val();

		var form = $(this);
				params = parseData(form);

    var form_data = new FormData();
	  form_data.append("id_agenda", idagenda);

    $.each(params, function(key, value) {
      form_data.append(key, value);
    });

	  $.ajax({
	    url: "/vistoria/main.php?action=salvaInfoAmbiente",
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
							getInfos(idagenda, false, true);
						}
					});
				}
	    }
	  });	 

	});

	$('body').on('click', ".btn-descartait", function(e) {
		var botao = $(this);
		var id_categoria = $(this).data("id");
		var id_ambiente = $(this).data("amb");

		$("#descartarIt").find(".select-motivo").val("");
		$("#descartarIt").find("#descarta_categoria").val(id_categoria);
		$("#descartarIt").find("#descarta_ambiente").val(id_ambiente);

		$("#descartarIt").modal("show");

		return false;

	});

	$('body').on('click', ".btn-descartafotoit", function(e) {
		var botao = $(this);
		var id_categoria = $(this).data("id");
		var id_ambiente = $(this).data("amb");

		$("#descartarfotosIt").find(".select-motivo").val("");
		$("#descartarfotosIt").find("#descarta_categoria").val(id_categoria);
		$("#descartarfotosIt").find("#descarta_ambiente").val(id_ambiente);

		$("#descartarfotosIt").modal("show");

		return false;

	});

	$('body').on('submit', "#form-descartait", function(e) {
		e.preventDefault();
		$("#descartarIt").modal("hide");
		$("#descartarfotosIt").modal("hide");

		var form = $(this);
				params = parseData(form);

		var id_ambiente = form.find("#descarta_ambiente").val();

		if (id_ambiente == "novo") {
			var id_categoria = form.find("#descarta_categoria").val();
			$("#form-infoambientes").find(".pancat-"+id_categoria).remove();
			swal({
				title: "",
				text: "It descartada com sucesso",
				type: "success",
				showCancelButton: false,
				confirmButtonClass: "btn-success btn-round btn-fill",
				confirmButtonText: 'Ok',
				closeOnConfirm: true
			});
			return false;
		}

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
							if (id_ambiente) {
								$(".trambi-"+id_ambiente).click();
							}
						}
					});
				}
	    }
	  });	 
	});

	$('body').on('click', ".btn-salvaform", function(e) {
		$("#concluir").val("0");
		$("#form-perguntas").submit();
	});

	$('body').on('click', ".btn-concluirform", function(e) {

		swal({
			title: "",
			text: "Tem certeza que deseja concluir o formulário?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-warning btn-round btn-fill",
			confirmButtonText: 'Sim',
			cancelButtonText: 'Não, voltar',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				$("#concluir").val("1");
				$("#form-perguntas").submit();
			}
		});

	});

	$("body").on("click", ".btn-duplicate", function(ev){
		ev.preventDefault();
		setTimeout(function(){
			$("#form-infoambientes").find("input[name='id_ambiente']").val("");
		}, 2000);

	});

	$("body").on("click", ".btn-removeamb", function(ev){
		ev.preventDefault();
		var botao = $(this);
				id_ambiente = botao.parent().parent().data('id');
				id_agenda = $("#id_agenda").val();

		swal({
			title: "",
			text: "Tem certeza que deseja excluir o ambiente?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-warning btn-round btn-fill",
			confirmButtonText: 'Sim, excluir',
			cancelButtonText: 'Não, manter',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				setTimeout(function(){
			    var form_data = new FormData();
			    form_data.append("id_ambiente", id_ambiente);				

				  $.ajax({
				    url: "/vistoria/main.php?action=deleteAmbiente",
				    type: 'POST',
				    data: form_data,
				    dataType: 'json',
				    cache: false,
				    contentType: false,
				    processData: false,
				    success: function(resposta, textStatus, jqXHR) {
				    	if(resposta.result) {
								swal({
									title: "",
									text: "Ambiente excluído com sucesso!",
									type: "success",
									confirmButtonClass: "btn-round btn-success btn-fill",
									confirmButtonText: 'Ok',
									closeOnConfirm: true
								},
								function(isConfirm){
									if (isConfirm) {
										getInfos(id_agenda, false, true);
									}
								});

				    	} else {
								swal({
									title: "",
									text: "Não foi possível excluir o ambiente pois existem itens relacionados.",
									type: "error",
									confirmButtonClass: "btn-rose btn-round btn-fill",
									confirmButtonText: 'Ok',
									closeOnConfirm: true
								});	
				    	}
				    }
				  });
				}, 1500);
			}
		});

	});

	$("body").on("click", ".btn-rowits", function(ev){
		ev.preventDefault();
		$(".row-its").toggle(400);
	});

	$("body").on("click", ".cancel-demanda", function(ev){
		ev.preventDefault();
		$(this).hide();
		$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").removeClass("btn-success");
		$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").addClass("btn-default");
		$(".panel-fotos.visible").parent().parent().parent().find(".save-demanda").attr("disabled", false);
		$(".assuntoselect").attr("disabled", false);		
		$(".table-produtos tbody").text("");
		$(".table-servicos tbody").text("");
		$(".table-maodeobra tbody").text("");

		$(".fileinput.fileinput-exists").parent().remove();

	});

	$("body").on("click", ".save-demanda", function(ev){
		var botao = $(this);
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
				botao.attr("disabled", true);
				botao.text("Aguarde...");
				$(".record-audio").hide();
				$(".cancel-demanda").hide();
				$("#form-assuntos").submit();
			}
		});
	});

	$("body").on("click", ".show-demanda", function(ev){
		ev.preventDefault();
		$(".assuntoselect").removeClass("selected");

		var id_assunto = $(this).data("id");
				select  	 = $(this).parent().parent().parent().parent().parent().parent().parent().find(".assuntoselect");
				idvistoria = $("#id_vistoria").val();
				idambiente = $("#id_ambiente").val();
				tprodutos  = select.parent().parent().parent().parent().find(".table-produtos tbody");
				tservicos  = select.parent().parent().parent().parent().find(".table-servicos tbody");
				tmaodeobra = select.parent().parent().parent().parent().find(".table-maodeobra tbody");
				audiolist  = select.parent().parent().parent().parent().find("#recordingslist");
				textobs  	 = select.parent().parent().parent().parent().find(".obscompras");

		$(".panel-fotos").removeClass("visible");
		$("#panel-"+id_assunto).addClass("visible");

		select.val(id_assunto);

    var form_data = new FormData();

    form_data.append("id_assunto", id_assunto);
    form_data.append("id_vistoria", idvistoria);
    form_data.append("id_ambiente", idambiente);
		audiolist.html("");
		textobs.text("");
		
	  $.ajax({
	    url: "/vistoria/main.php?action=getDemanda",
	    type: 'POST',
	    data: form_data,
	    dataType: 'json',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(resposta, textStatus, jqXHR) { 
				var icon 	= '<td width="10%" class="td-actions text-right"><button type="button" class="btn btn-rose btn-round btn-link remove-equip" data-original-title="" title=""><i class="material-icons">close</i></button></td>';
        if (resposta.produtos) {
        	tprodutos.html("");
        	$.each(resposta.produtos, function(index, produto) {
						field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+produto.cat+'][equip]['+produto.id+']" value="'+produto.qtd+'" placeholder="Qtd"></div></td>';
						tprodutos.append("<tr><td>"+icon+"</td><td>"+produto.produto+"</td><td>"+field+"</td></tr>");
        	});
				}
        if (resposta.servicos) {
        	tservicos.html("");
        	$.each(resposta.servicos, function(index, servico) {
						field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+servico.cat+'][servico]['+servico.id+']" placeholder="Qtd" value="1"></div></td>';
						tservicos.append("<tr><td>"+icon+"</td><td>"+servico.servico+"</td><td>"+field+"</td></tr>");        		
        	});
				}
        if (resposta.maodeobras) {
        	tmaodeobra.html("");
        	$.each(resposta.maodeobras, function(index, maodeobra) {
						field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+maodeobra.cat+'][maodeobra]['+maodeobra.maodeobra+']" value="'+maodeobra.qtd+'" placeholder="Períodos"></div></td>';
						tmaodeobra.append("<tr><td>"+icon+"</td><td>"+maodeobra.maodeobra+"</td><td>"+field+"</td></tr>");
        	});
				}
        if (resposta.audios) {
        	$.each(resposta.audios, function(index, audio) {
				    var li = document.createElement('li');
				    var au = document.createElement('audio');
    				var url = audio.arquivo;
						var icon 	= '<button type="button" class="btn btn-rose btn-round btn-link remove-audio" data-id="'+audio.id+'"><i class="material-icons">close</i></button>';
				    au.controls = true;
				    au.src = url; 
				    $(li).append(icon);
				    li.appendChild(au);
				    audiolist.append(li);   				
        	});
				}
        if (resposta.observacao) {
					textobs.text(resposta.observacao);
				}
	    }
	  });	

	});

	$('body').on('click', ".remove-audio", function(e) {
		e.preventDefault();
		var botao = $(this);

		swal({
			title: "",
			text: "Confirma exclusão do áudio?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-warning btn-round btn-fill",
			confirmButtonText: 'Sim, excluir',
			cancelButtonText: 'Não, manter',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var idaudio = botao.data("id");
		    var form_data = new FormData();
		    form_data.append("idaudio", idaudio);

			  $.ajax({
			    url: "/vistoria/main.php?action=deleteAudio",
			    type: 'POST',
			    data: form_data,
			    dataType: 'json',
			    cache: false,
			    contentType: false,
			    processData: false,
			    success: function(resposta, textStatus, jqXHR) { 
			    	if (resposta.result) {
							botao.parent().remove();
			    	}
			    }
			  });
			}
		});

	});

	$('body').on('click', ".navigate-analise", function(e) {
		e.preventDefault();
		var idagenda = $(this).data("id");

		getAnalise(idagenda);

	});

	$('body').on('submit', "#form-analise", function(e) {
		e.preventDefault();

		var form = $(this);
				params = parseData(form);
				revisao = form.find('input[name="revisao"]').val();
				idvistoria = form.find('input[name="id_vistoria"]').val();

		var form_data = new FormData();

    $.each(params, function(key, value) {
      form_data.append(key, value);
    }); 

    $.ajax({
      url: "/vistoria/main.php?action=salvaAnalise",
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
						text: "Revisão "+revisao+" salva com sucesso.",
						type: "success",
						showCancelButton: false,
						confirmButtonClass: "btn-success btn-round btn-fill",
						confirmButtonText: 'Ok',
						closeOnConfirm: true
					},
					function(isConfirm){
						if (isConfirm) {
							getAnalise(idvistoria, false);
						}
					});
        }
      }
    });
	});

	$("body").on("click", ".btn-revisao", function(ev){
		$("#form-analise").submit();
	});

	$("body").on("click", ".btn-unificar", function(ev){
		ev.preventDefault();

		var cat = $(this).data("cat");
				idvistoria = $(this).data("vistoria");
				revisao = $('input[name="revisao"]').val();
				demandas = [];

		if (revisao == 1) {
			$("#form-analise").submit();
			revisao = 2;
		}

		$(".demanda-"+cat+":checked").each(function(el) {
			var assunto = $(this).data("assunto");
			demandas.push(assunto);
		});

    var form_data = new FormData();

    form_data.append("id_categoria", cat);
    form_data.append("id_vistoria", idvistoria);
    form_data.append("idvistoria", idvistoria);
    form_data.append("demandas", demandas);
    form_data.append("revisao", revisao);

    $.ajax({
      url: "/vistoria/main.php?action=mergeDemanda",
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
						text: "Demandas unificadas com sucesso.",
						type: "success",
						showCancelButton: false,
						confirmButtonClass: "btn-success btn-round btn-fill",
						confirmButtonText: 'Ok',
						closeOnConfirm: true
					},
					function(isConfirm){
						if (isConfirm) {
							getAnalise(idvistoria, false);
						}
					});
        }
      }
    });

	});

	$("body").on("click", ".btn-sendrelatorio", function(ev){	
		var	idagenda = $("#form-analise").find('input[name="id_vistoria"]').val();
				revisao = $("#form-analise").find('input[name="revisao"]').val();
				params = parseData($("#form-analise"));
				form_data = new FormData();
				check = false;
				botao = $(this);


	  $(".input-mobra").each(function(el){
	    var input = $(this);
	    if (!input.val()) {
				swal({
					title: "",
					text: "Preencha o resumo de mão de obra da vistoria.",
					type: "error",
					confirmButtonClass: "btn-rose btn-round btn-fill",
					confirmButtonText: 'Ok',
					closeOnConfirm: true
				},
				function(isConfirm){
					if (isConfirm) {
						setTimeout(function(){
							input.focus();
						}, 500);
					}
				});	    	

				return false;
	    } else {
	    	check = true;
	    }
	  });

	  if (check == false) {
	  	return false;
	  }

		form_data.append("id_agenda", idagenda);

    $.each(params, function(key, value) {
      form_data.append(key, value);
    }); 

		swal({
			title: "",
			text: "Confirmar finalização da análise?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-warning btn-round btn-fill",
			confirmButtonText: 'Sim!',
			cancelButtonText: 'Não, voltar',
			cancelButtonClass: "btn-default btn-round btn-fill",
			closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {

				botao.html('Aguarde...');	
				botao.attr('disabled', true);	

				setTimeout(function() {
					swal({
						title: "",
						text: "A vistoria foi concluída com sucesso, o laudo será gerado em segundo plano.",
						type: "success",
						showCancelButton: false,
						confirmButtonClass: "btn-success btn-round btn-fill",
						confirmButtonText: 'Ok',
						closeOnConfirm: true
					},
					function(isConfirm){
						if (isConfirm) {
							// $("#page-lista").find(".card-servico."+idagenda).remove();
							// $(".btn-nonfilteranalise").click();
							// $(".btn-nonfiltervistoria").click();
							// navigate("#page-lista", false);

							if (revisao == 1) {
								$("#form-analise").submit();
							}
							setTimeout(function(){
								$.ajax({
							    url:"/vistoria/main.php?action=concluiAnalise",
							    data: form_data,
							    type:"POST",
							    contentType:false,
							    processData:false,
							    cache:false,
							    dataType:"json",
							    success:function(resposta){
							    	// does nothing
							    }
								});
							}, 1000);
						}
					});
				}, 2000);

			}
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

	$("body").on("input", "#filter-name", function(ev){
		filtrar();
	});

	$("body").on("click", "img.unloaded", function(ev){
		var realhref = $(this).data("src");

		$(this).attr("src", realhref);
		$(this).removeClass("unloaded");

	});

	$("body").on("click", "#tirarFoto", function(ev){

    var srcType = Camera.PictureSourceType.CAMERA;
    var options = setOptions(srcType);
    var func = createNewFileEntry;

    navigator.camera.getPicture(function cameraSuccess(imageUri) {

        displayImage(imageUri);
        // You may choose to copy the picture, save it somewhere, or upload.
        func(imageUri);

    }, function cameraError(error) {
        alert("Unable to obtain picture: " + error);

    }, options);
	});	

});

// start functions
function filtrar() {
  $(".card-servico").each(function(el){
    var card = $(this);
    		titulo = card.find(".card-title").text().toUpperCase();
    		name = $("#filter-name").val().toUpperCase();

    if ($('.btn-nonfilteranalise').length && $(this).find(".navigate-analise").length) {
    	$(this).parent().show();
    } else if ($('.btn-nonfiltervistoria').length && $(this).find(".navigate-ambientes").length) {
    	$(this).parent().show();
    } else if ($('.btn-nonfiltervistoria').length == 0 && $('.btn-nonfilteranalise').length == 0) {
    	$(this).parent().show();
    } else {
    	$(this).parent().hide();
    }

    if (name.length >= 3) {
    	if (titulo.indexOf(name) == -1) {
	    	$(this).parent().hide();
    	}
    }

  });

}


function assuntoCreate(value, el) {
	var select = el.parent().find(".assuntoselect");
			id_categoria = select.data("cat");
			id_ambiente	 = $("#id_ambiente").val();
			index = select.index();
			selected = window.selectize[index].selectize;

	swal({
		title: "",
		text: "Deseja criar o assunto: '"+value+"'?",
		type: "info",
		showCancelButton: true,
		confirmButtonClass: "btn-info btn-round btn-fill",
		confirmButtonText: 'Sim',
		cancelButtonText: 'Não, voltar',
		cancelButtonClass: "btn-default btn-round btn-fill",
		closeOnConfirm: true
	},
	function(isConfirm){
		if (isConfirm) {

  		var form_data = new FormData();

		  form_data.append("id_categoria", id_categoria);
		  form_data.append("assunto", value);			

		  $.ajax({
		    url: "/vistoria/main.php?action=criaAssuntos",
		    type: 'POST',
		    data: form_data,
		    dataType: 'json',
		    cache: false,
		    contentType: false,
		    processData: false,
		    success: function(resposta, textStatus, jqXHR) { 
		    	if (resposta.result && resposta.id_assunto) {

						getAmbiente(id_ambiente, false, false);
						setTimeout(function(){
							index = select.index();
							selected = window.selectize[index].selectize;
							selected.setValue(resposta.id_assunto);

						}, 2000);
		    	} else {
						swal({
							title: "",
							text: "Não foi possível criar um novo assunto",
							type: "error",
							confirmButtonClass: "btn-rose btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						});
						return;
		    	}
		    }
		  });
		} else {
			selected.setValue("");
			selected.removeOption(value);
		}
	});

}

function assuntoChange(value, el) {
	if (!value) return;

	$(".record-audio").hide();
	$(el).parent().parent().find(".assuntoselect").addClass("selected");

	var fotos = value;
			tprodutos  = $(el).parent().parent().parent().parent().find(".table-produtos tbody");
			tservicos  = $(el).parent().parent().parent().parent().find(".table-servicos tbody");
			tmaodeobra = $(el).parent().parent().parent().parent().find(".table-maodeobra tbody");
			audiorec 	 = $(el).parent().parent().parent().parent().find(".record-audio");
			observacao = $(el).parent().parent().parent().parent().find(".obscompras");

	$(".panel-fotos").removeClass("visible");
	$("#panel-"+fotos).addClass("visible");

	tprodutos.html("");
	tservicos.html("");
	tmaodeobra.html("");
	audiorec.show();
	observacao.show();

}

function sincronizar() {
	var save_sinc = localStorage.getItem("save_sinc");
	
	if (save_sinc) {
		var save = JSON.parse(save_sinc);
		sincDemandas(save);
	}
	return true;

	setTimeout(function(){
		localStorage.clear();
		// localStorage.removeItem("save_sinc");
	  localStorage.setItem('lista-servicos', $("#page-lista").html());
	  var timeinfos = 1000;
	  $(".card-servico").each(function(el){
	  	var card = $(this);

	  	sincInfos(card, timeinfos);
	  	timeinfos += 500;
		});

	  $(".navigate-ambientes").each(function(el){
			var id = $(this).data("id");
			setTimeout(function(){
				getAmbientes(id, false, true);
  		}, 2000);

	  });

	  $(".navigate-analise").each(function(el){
			var id = $(this).data("id");
			setTimeout(function(){
				getAnalise(id, false, false, true);  	
  		}, 2000);
	  });
  }, 1000);
	
}

function sincInfos(card, delay) {
	setTimeout(function(){
		var id = card.attr('class').split(' ').pop();

  	getInfos(id, false, false, true);

  }, delay);
}

function sincDemandas(save) {
	$.each(save, function(index, demanda) {
		console.log("sincando demandas"); 

	  if (demanda.img) {
	    $.each(demanda.img, function(key, img) {
	    	if (img.name && img.file) {
				  window.fs.root.getFile(img.file, {}, function(fileEntry) {
				    // Get the File for this FileEntry.
				    fileEntry.file(function(file) {
			    		console.log(img.name);
			    		console.log(file);
						  var form_data = new FormData();
					    $.each(demanda.params, function(key, value) {
					      form_data.append(key, value);
					    });

	      			form_data.append(img.name, file);
						  $.ajax({
						    url: "/vistoria/main.php?action=salvaAssuntos",
						    type: 'POST',
						    data: form_data,
						    dataType: 'json',
						    cache: false,
						    contentType: false,
						    processData: false
						  });
				    });
				  }, errorHandler);
	    	}
	    });  
	  }

	});
}

function getInfos(idagenda, hist = true, amb = false, ret = false) {
	if (!ret) {
		navigate("#page-start", hist);
	}
  var form_data = new FormData();
  form_data.append("id_vistoria", idagenda);

  $.ajax({
    url: "/vistoria/main.php?action=getInfos",
    type: 'POST',
    data: form_data,
    dataType: 'html',
    cache: false,
    contentType: false,
    processData: false,
    success: function(resposta, textStatus, jqXHR) { 
      if (ret) {
				localStorage.setItem('infos['+idagenda+']', resposta);
      } else {
	      $("#page-infos").html(resposta);

      	navigate("#page-infos", false);

	    	if (amb) {
	      	setTimeout(function(){
						$(".container-element")[0].scrollIntoView();
	    		}, 1800);
	    	}
      }
    }
  });	
}

function getAmbientes(idagenda, hist = true, ret = false) {

	if (!ret) {
		navigate("#page-start", hist);
	}

  var form_data = new FormData();
  form_data.append("id_vistoria", idagenda);

  $.ajax({
    url: "/vistoria/main.php?action=getAmbientes",
    type: 'POST',
    data: form_data,
    dataType: 'html',
    cache: false,
    contentType: false,
    processData: false,
    success: function(resposta, textStatus, jqXHR) { 
      $("#page-ambientes").html(resposta);
    	if (ret) {
    		localStorage.setItem('ambientes['+idagenda+']', resposta);
	  		// console.log('ambientes['+idagenda+']');
				setTimeout(function(){
		  		$(resposta).find(".lista-ambientes tr").each(function(ele){
						var idambiente = $(this).data("id");

						setTimeout(function(){
							getAmbiente(idambiente, false, true);
		  			}, 1000);
					});
		  	}, 1000);

    	} else {

      	navigate("#page-ambientes", false);
				setTimeout(function(){ assinatura(); }, 1000);

    	}
    }
  });		
}

function getAmbiente(idambiente, hist = true, ret = false, start = true, cat = null) {

	if (!ret && start) {
		navigate("#page-start", hist);
	}

  var form_data = new FormData();
  form_data.append("id_ambiente", idambiente);

  $.ajax({
    url: "/vistoria/main.php?action=getAmbiente",
    type: 'POST',
    data: form_data,
    dataType: 'html',
    cache: false,
    contentType: false,
    processData: false,
    success: function(resposta, textStatus, jqXHR) { 
      $("#page-ambiente").html(resposta);

      window.selectize = $(".assuntoselect").selectize({
      	create: true,
	    	onItemAdd: function(value, item) {
	    		var item = $(item).parent().parent();
	    		if (isNaN(value)) {
	      		assuntoCreate(value, item);
	    		} else {
	      		assuntoChange(value, item);
	    		}
	    	}
	    });

      if (ret) {
      	localStorage.setItem('ambiente['+idambiente+']', $("#page-ambiente").html());
	  		// console.log('ambiente['+idambiente+']');
				setTimeout(function(){
		  		$(resposta).find(".show-demanda").each(function(ele){
						var iddemanda = $(this).data("id");
								idambiente = $(resposta).find("#id_ambiente").val();

						setTimeout(function(){
							getDemanda(iddemanda, idambiente);
		  			}, 1000);
					});
		  	}, 1000);
      } else {
      	navigate("#page-ambiente", false);
      	if (cat) {
					setTimeout(function(){
						$("#"+cat).parent().parent().parent().parent().parent().get(0).scrollIntoView();
					}, 1000);      	
      	}
      }
    }
  });	
}

function getAnalise(idagenda, hist = true, amb = false, ret = false) {

	if (!ret) {
		navigate("#page-start", hist);
	}

  var form_data = new FormData();
  form_data.append("id_vistoria", idagenda);

  $.ajax({
    url: "/vistoria/main.php?action=getAnalise",
    type: 'POST',
    data: form_data,
    dataType: 'html',
    cache: false,
    contentType: false,
    processData: false,
    success: function(resposta, textStatus, jqXHR) { 
      $("#page-analise").html(resposta);
    	if (ret) {
    		localStorage.setItem('analise['+idagenda+']', resposta);
	  		// console.log('analise['+idagenda+']');
    	} else {
	      setTimeout(function(){
	      	navigate("#page-analise", false);
	    	}, 500);
	    }
    }
  });	
}

function getDemanda(id_assunto, idambiente) {

  var form_data = new FormData();

  form_data.append("id_assunto", id_assunto);
  form_data.append("id_ambiente", idambiente);

  $.ajax({
    url: "/vistoria/main.php?action=getDemanda",
    type: 'POST',
    data: form_data,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function(resposta, textStatus, jqXHR) { 
      if (resposta.produtos) {
      	var htmlprodutos = "";
      	$.each(resposta.produtos, function(index, produto) {
					field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+produto.cat+'][equip]['+produto.id+']" value="'+produto.qtd+'" placeholder="Qtd"></div></td>';
					htmlprodutos += "<tr><td>"+produto.produto+"</td><td>"+field+"</td></tr>";
					localStorage.setItem('demandasprod['+idambiente+']['+id_assunto+']', htmlprodutos);
	  			// console.log('demandasprod['+idambiente+']['+id_assunto+']');
      	});
			}
      if (resposta.servicos) {
      	var htmlservicos = "";
      	$.each(resposta.servicos, function(index, servico) {
					field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+servico.cat+'][servico]['+servico.id+']" placeholder="Qtd" value="1"></div></td>';
					htmlservicos += "<tr><td>"+servico.servico+"</td><td>"+field+"</td></tr>";
					localStorage.setItem('demandasserv['+idambiente+']['+id_assunto+']', htmlservicos);
	  			// console.log('demandasserv['+idambiente+']['+id_assunto+']');
      	});
			}
      if (resposta.maodeobras) {
      	var htmlmaodeobras = "";
      	$.each(resposta.maodeobras, function(index, maodeobra) {
					field = '<td width="30%"><div class="form-group has-info"><input type="number" class="form-control borders qtd-equip" name="categoria['+maodeobra.cat+'][maodeobra]['+maodeobra.maodeobra+']" value="'+maodeobra.qtd+'" placeholder="Períodos"></div></td>';
					htmlmaodeobras += "<tr><td>"+maodeobra.maodeobra+"</td><td>"+field+"</td></tr>";
					localStorage.setItem('demandasmao['+idambiente+']['+id_assunto+']', htmlmaodeobras);
	  			// console.log('demandasmao['+idambiente+']['+id_assunto+']');
      	});
			}
      if (resposta.audios) {
      	var htmlaudios = "";
      	$.each(resposta.audios, function(index, audio) {
					htmlaudios += '<li><button type="button" class="btn btn-rose btn-round btn-link remove-audio" data-id="'+audio.id+'"><i class="material-icons">close</i></button><audio controls="" src="'+audio.arquivo+'"></audio></li>';
					localStorage.setItem('demandaud['+idambiente+']['+id_assunto+']', htmlaudios);
	  			// console.log('demandaud['+idambiente+']['+id_assunto+']');
      	});
			}
      if (resposta.observacao) {
				localStorage.setItem('demandasobs['+idambiente+']['+id_assunto+']', resposta.observacao);
  			// console.log('demandasobs['+idambiente+']['+id_assunto+']');
      }
    }
  });	
}

function navigate (href, hist = true) {

	parentPage = $(".content.active");
	if (hist)
		historico = "#" + parentPage.attr("id");
	
	$(href).addClass("active");
	parentPage.removeClass("active");

	if (hist)
		$("a.navbar-voltar").show();
	
	parentPage.hide();
	$(href).fadeIn(400);

	setTimeout(function(){
		$(href).get(0).scrollIntoView();
	}, 500);

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

	if ($("#assinatura-cliente").length == 0) {
		// Trigger resize porque por algum motivo a assinatura só funciona depois do resize ¬¬ 
		setTimeout(function(){ $(window).trigger('resize'); }, 800);
	}

	$('body').on('click', ".btn-concluir", function(e) {

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
		  var imgdata  = $sigdiv.jSignature('getData', 'image');
		  if (imgdata[1].length == 0) {
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
		}

		var prevtext = $(this).html();
		$(this).html("Aguarde...");

		var idagenda = $("#id_vistoria").val();
	  		form_data = new FormData();

		form_data.append("id_agenda", idagenda);

		salvaVistoria(idagenda, false);

		setTimeout(function(){
			$.ajax({
			    url:"/vistoria/main.php?action=concluiVistoria",
			    data: form_data,
			    type:"POST",
			    contentType:false,
			    processData:false,
			    cache:false,
			    dataType:"json",
			    success:function(resposta){
						$(".btn-concluir").html(prevtext);

	          if (resposta.result) {
							swal({
								title: "",
								text: "Vistoria concluída com sucesso!",
								type: "success",
								showCancelButton: false,
								confirmButtonClass: "btn-success btn-round btn-fill",
								confirmButtonText: 'Ok',
								closeOnConfirm: true
							},
							function(isConfirm){
								if (isConfirm) {
									location.reload();
								}
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
		}, 1000);
		return true;

	});

	$('body').on('click', ".btn-salvavistoria", function(e) {
		e.preventDefault();
		var idagenda = $("#id_vistoria").val();
		$(this).text("Aguarde...");
		salvaVistoria(idagenda, true, $sigdiv);

		return true;	

	});
	
}

function salvaVistoria(idagenda, popup, $sigdiv){
  var form_data = new FormData();

	if ($("#assinatura-cliente").length == 0) {
		// https://ourcodeworld.com/articles/read/322/how-to-convert-a-base64-image-into-a-image-file-and-upload-it-with-an-asynchronous-form-using-jquery
	  var imgdata  = $sigdiv.jSignature('getData', 'image');
	  if (imgdata[1]) {
  		realData = imgdata[1];

	  	var blob = b64toBlob(realData);

			form_data.append("assinatura", blob);
	  }
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
        	if (popup) {
        		$(".btn-salvavistoria").html('<i class="material-icons">save</i> Salvar vistoria');
						swal({
							title: "",
							text: "Dados salvos com sucesso",
							type: "success",
							showCancelButton: false,
							confirmButtonClass: "btn-success btn-round btn-fill",
							confirmButtonText: 'Ok',
							closeOnConfirm: true
						});
        	}
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
  
  recorder = new Recorder(input);
}

function startRecording(button) {
  initContext();
  $(".record-audio").attr("disabled", true);
  $(".record-audio").html("<i class='material-icons'>mic</i> Espere...");
  setTimeout(function(){
    recorder && recorder.record();
	  $(".save-audio").show();
	  $(".cancel-audio").show();
  	$(".record-audio").html("<i class='material-icons'>mic</i> Gravando");
  }, 2000);
}

function stopRecording(button) {
  recorder && recorder.stop();
  $(".record-audio").html("<i class='material-icons'>mic</i> Salvando...");
  $(".save-audio").hide();
  $(".cancel-audio").hide();
  
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
  
  recorder.clear();
  audio_context.close();
}

function createDownloadLink(button) {
	console.log(recorder);
  recorder && recorder.exportWAV(function(blob) {
    var url = URL.createObjectURL(blob);
    var li = document.createElement('li');
    var au = document.createElement('audio');
    var hf = document.createElement('a');
    var idassunto 	= $(".assuntoselect.selected").val();
    var idcategoria = $(button).data("cat");
    var idambiente 	= $(button).data("amb");
    var audiolist 	= $(".assuntoselect.selected").parent().parent().parent().parent().find("#recordingslist");
    
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
			  $(".record-audio").attr("disabled", false);
			  $(".record-audio").html("<i class='material-icons'>mic</i> Gravar");

				var icon 	= '<button type="button" class="btn btn-rose btn-round btn-link remove-audio" data-id="'+data.idaudio+'"><i class="material-icons">close</i></button>';
				au.controls = true;
				au.src = url;
				hf.href = url;
				hf.download = new Date().toISOString() + '.wav';
				hf.innerHTML = hf.download;
				$(li).prepend(icon);
				li.appendChild(au);
				audiolist.append(li);
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

function dataURLToBlob(dataURL) {
  var BASE64_MARKER = ';base64,';
  if (dataURL.indexOf(BASE64_MARKER) == -1) {
      var parts = dataURL.split(',');
      var contentType = parts[0].split(':')[1];
      var raw = parts[1];

      return new Blob([raw], {type: contentType});
  }

  var parts = dataURL.split(BASE64_MARKER);
  var contentType = parts[0].split(':')[1];
  var raw = window.atob(parts[1]);
  var rawLength = raw.length;

  var uInt8Array = new Uint8Array(rawLength);

  for (var i = 0; i < rawLength; ++i) {
      uInt8Array[i] = raw.charCodeAt(i);
  }

  return new Blob([uInt8Array], {type: contentType});
}
 	
function resizePhoto(file, file_name, id_assunto){
	var id_ambiente = $("#id_ambiente").val();
  var resizedImage;

  // Load the image
  var reader = new FileReader();
  reader.onload = function (readerEvent) {

  	var image = new Image();
  	image.onload = function (imageEvent) {

	    // Resize the image
	    var canvas = document.createElement('canvas'),
	        max_size = 512,// TODO : pull max size from a site config
	        width = image.width,
	        height = image.height;
	    if (width > height) {
	    	if (width > max_size) {
	    		height *= max_size / width;
	    		width = max_size;
	    	}
	    } else {
	    	if (height > max_size) {
	    		width *= max_size / height;
	    		height = max_size;
	    	}
	    }
	    canvas.width 	= width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(image, 0, 0, width, height);
	    var dataUrl 	= canvas.toDataURL('image/jpeg');
	    resizedImage 	= dataURLToBlob(dataUrl);

	  	var form_data = new FormData();
	    form_data.append(file_name, resizedImage);
    	form_data.append("id_assunto", id_assunto);
    	form_data.append("id_ambiente", id_ambiente);
	    
		  $.ajax({
		    url: "/vistoria/main.php?action=salvaAssuntos",
		    type: 'POST',
		    data: form_data,
		    dataType: 'json',
		    cache: false,
		    contentType: false,
		    processData: false,
		  });

	  }
	  image.src = readerEvent.target.result;
	}
	reader.readAsDataURL(file);

}
 	
function resizePhotoGerais(file, file_name, params){
  var resizedImage;
			id_vistoria = $("#id_vistoria").val();
		  newform 		= $(".form-gerais:last-child").clone();
	  	form_data 	= new FormData();

  // Load the image
  var reader = new FileReader();
  reader.onload = function (readerEvent) {

  	var image = new Image();
  	image.onload = function (imageEvent) {

	    // Resize the image
	    var canvas = document.createElement('canvas'),
	        max_size = 512,// TODO : pull max size from a site config
	        width = image.width,
	        height = image.height;
	    if (width > height) {
	    	if (width > max_size) {
	    		height *= max_size / width;
	    		width = max_size;
	    	}
	    } else {
	    	if (height > max_size) {
	    		width *= max_size / height;
	    		height = max_size;
	    	}
	    }
	    canvas.width 	= width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(image, 0, 0, width, height);
	    var dataUrl 	= canvas.toDataURL('image/jpeg');
	    resizedImage 	= dataURLToBlob(dataUrl);

	    form_data.append(file_name, resizedImage);

	    $.each(params, function(key, value) {
	      form_data.append(key, value);
	    }); 
	    
	    form_data.append("id_vistoria", id_vistoria);
	    
    	$(".form-gerais:last-child").find("button").text("Salvando...");
    	$(".form-gerais:last-child").find("button").attr("disabled", true);

		  $.ajax({
		    url: "/vistoria/main.php?action=salvaGerais",
		    type: 'POST',
		    data: form_data,
		    dataType: 'json',
		    cache: false,
		    contentType: false,
		    processData: false,
		    success: function(resposta, textStatus, jqXHR) { 
		    	$(".form-gerais:last-child").find("button").remove();
		    	$(".form-gerais:last-child").find("a").remove();
		    	$(".form-gerais:last-child").find("span.btn").remove();

		    	$(".form-gerais:last-child").parent().append(newform);
					newform.find(".btn-remove").click();
					newform.find('input[name="geral_titulo"]').val("");
					newform.find('textarea').val("");
		    }
		  });

	  }
	  image.src = readerEvent.target.result;
	}
	reader.readAsDataURL(file);

}
 	
function resizePhotoAnalise(file, file_name, input){
  var resizedImage;
			id_vistoria  = $('input[name="id_vistoria"]').val();
	    id_ambiente  = input.data("amb");
	    id_categoria = input.data("cat");
	    id_assunto   = input.data("assunto");
	  	form_data 	 = new FormData();

  // Load the image
  var reader = new FileReader();
  reader.onload = function (readerEvent) {

  	var image = new Image();
  	image.onload = function (imageEvent) {

	    // Resize the image
	    var canvas = document.createElement('canvas'),
	        max_size = 512,// TODO : pull max size from a site config
	        width = image.width,
	        height = image.height;
	    if (width > height) {
	    	if (width > max_size) {
	    		height *= max_size / width;
	    		width = max_size;
	    	}
	    } else {
	    	if (height > max_size) {
	    		width *= max_size / height;
	    		height = max_size;
	    	}
	    }
	    canvas.width 	= width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(image, 0, 0, width, height);
	    var dataUrl 	= canvas.toDataURL('image/jpeg');
	    resizedImage 	= dataURLToBlob(dataUrl);

	    form_data.append(file_name, resizedImage);
	    form_data.append("id_ambiente", id_ambiente);
	    form_data.append("id_categoria", id_categoria);
	    form_data.append("id_assunto", id_assunto);

		  $.ajax({
		    url: "/vistoria/main.php?action=addAnalise",
		    type: 'POST',
		    data: form_data,
		    dataType: 'json',
		    cache: false,
		    contentType: false,
		    processData: false,
		    success: function(resposta, textStatus, jqXHR) { 

		    	var html = '<input type="hidden" name="demanda['+id_categoria+']['+id_ambiente+']['+id_assunto+'][foto]['+resposta.idfoto+']" value="'+resposta.urlfoto+'">';
					input.parent().append(html);
					setTimeout(function(){
						$("#form-analise").submit();
					}, 500);

		    }
		  });

	  }
	  image.src = readerEvent.target.result;
	}
	reader.readAsDataURL(file);

}

function setOptions(srcType) {
    var options = {
        // Some common settings are 20, 50, and 100
        quality: 50,
        destinationType: Camera.DestinationType.FILE_URI,
        // In this app, dynamically set the picture source, Camera or photo gallery
        sourceType: srcType,
        encodingType: Camera.EncodingType.JPEG,
        mediaType: Camera.MediaType.PICTURE,
        allowEdit: true,
        correctOrientation: true  //Corrects Android orientation quirks
    }
    return options;
}

function displayImage(imgUri) {

    var elem = document.getElementById('imageFile');
    elem.src = imgUri;
    $("#imageFile").show();

}