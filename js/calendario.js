$( function() {
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dayNames: ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior',
		dateFormat: "dd/mm/yy",
	});
} );