$(function (){
	$('#dt_hs_comunicado').datetimepicker({format:'d/m/Y H:i:s',formatDate:'Y-m-d H:i:s'});
    $('.dt_hs').datetimepicker({format:'d/m/Y H:i:s',formatDate:'Y-m-d H:i:s'});

    $('.money').mask('##0.00', {reverse: true});
    $('.money2').mask('##0.000000000', {reverse: true});
    $('.taxas').mask('##0.00000', {reverse: true});
    $('.cep').mask('00000-000', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});

    $('.money3').mask('#.##0,00', {reverse: true});
    $('.money4').mask('#.##0,000000000', {reverse: true});
    $('.money5').mask('#.##0,00000', {reverse: true});
    
    $('#seachProcesso').mask('##/##');
    $('.seachProcesso').mask('##/##');

    //EFEITO EM MENU
    $('#menu1').bind('mouseenter', function(){
        $('#submenu1').show();
    });
    $('#menu1').bind('mouseleave', function(){
        $('#submenu1').fadeOut();
    });
    $('#menu2').bind('mouseenter', function(){
        $('#submenu2').show();
    });
    $('#menu2').bind('mouseleave', function(){
        $('#submenu2').fadeOut();
    });
    $('#menu3').bind('mouseenter', function(){
        $('#submenu3').show();
    });
    $('#menu3').bind('mouseleave', function(){
        $('#submenu3').fadeOut();
    });
    $('#menu4').bind('mouseenter', function(){
        $('#submenu4').show();
    });
    $('#menu4').bind('mouseleave', function(){
        $('#submenu4').fadeOut();
    });
    $('#menu5').bind('mouseenter', function(){
        $('#submenu5').show();
    });
    $('#menu5').bind('mouseleave', function(){
        $('#submenu5').fadeOut();
    });

    $(function(){
        let value = true;

        var horario = function(){
            $.ajax({
                url:'ajax.php',
                type:'POST',
                dataType:'json',
                data:{value:value},
                success:function(data){
                    let hora = data['hora']+':'+data['minutos']+':'+data['segundos'];

                    $('#horario').html(hora);
                }
            });
        };

        setInterval(horario, 800);
        
    });

    //consultar motorista
    $(document).on('keyup', '#search-motorista', function(){
        var motorista = $(this).val();
        var id_ramo = $('#id-ramo').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data:{ motorista:motorista, id_ramo:id_ramo },
            success:function(data){
                html = '<table class="table table-hover resultado">';
                html += '<thead><tr>';

                html += '<th>Processo</th>';
                html += '<th>Motorista</th>';
                html += '<th>Data de Nascimento</th>';
                html += '<th>Tempo de Profissão</th>';
                html += '<th>CNH</th>';
                html += '<th>Categoria</th>';
                html += '<th>Validade</th>';
                html += '<th>Veículo</th>';
                html += '<th>Placa Cavalo Mecânico</th>';
                html += '<th>Placa Carreta 1º Semi Reboque</th>';
                html += '<th>Placa Carreta 2º Semi Reboque</th>';
                html += '<th>Ano do Caminhão - Cavalo Mecânico</th>';
                html += '<th>Ano do Caminhão - Carreta 1º Semi Reboque</th>';
                html += '<th>Ano do Caminhão - Carreta 2º Semi Reboque</th>';
                html += '<th>Causa/Tipo</th>';
                html += '<th>Local do Acidente</th>';
                html += '<th>Segurado</th>';
                html += '<th>Data e Hora do acidentes</th>';
                html += '<th>Número do Sinistro</th>';
                html += '</tr></thead>';

                for(line in data){
                    user = data[line];

                    var a = user.p17.split('-');
                    var b = user.dt_nascimento.split('-');
                    var c = user.dt_hs.split('-');
                    var h = c[2].split(' ');
                    
                    html += '<tbody style="font-size: 13px;">';
                    html += '<tr>';
                    html += '<td>'+user.num_processo+'</td>';
                    html += '<td>'+user.p3+'</td>';
                    html += '<td>'+b[2]+'/'+b[1]+'/'+b[0]+'</td>';
                    html += '<td>'+user.p4+'</td>';
                    html += '<td>'+user.p15+'</td>';
                    html += '<td>'+user.p16+'</td>';
                    html += '<td>'+a[2]+'/'+a[1]+'/'+a[0]+'</td>';
                    html += '<td>'+user.p9+'</td>';
                    html += '<td>'+user.placa1+'</td>';
                    html += '<td>'+user.placa2+'</td>';
                    html += '<td>'+user.placa3+'</td>';
                    html += '<td>'+user.ano1+'</td>';
                    html += '<td>'+user.ano2+'</td>';
                    html += '<td>'+user.ano3+'</td>';
                    html += '<td>'+user.nat_evento.nat_evento+'</td>';
                    html += '<td>'+user.cidade.nome+' - '+user.cidade.uf+'</td>';
                    html += '<td>'+user.segurado+'</td>';
                    html += '<td>'+h[0]+'/'+c[1]+'/'+c[0]+' - '+h[1]+'</td>';
                    html += '<td>'+user.num_sinistro.num_sinistro+'</td>';

                    html += '</tr></tbody>';
                }
                html += '</table>';
                $('.resultado').html(html);
            }
        });
    });

    //AJAX INDEX PARA AGENDA
    $(document).on('change', '.mes', function(){
        var mes = $('.mes').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data:{ mes:mes },
            success:function(data){
                $('#resultado').html(data);

                var d = new Date();
                var ano  = d.getFullYear();
                if (mes == 1) {
                    var name = 'Janeiro de '+ano;
                }
                if (mes == 2) {
                    var name = 'Fevereiro de '+ano;
                }
                if (mes == 3) {
                    var name = 'Março de '+ano;
                }
                if (mes == 4) {
                    var name = 'Abril de '+ano;
                }
                if (mes == 5) {
                    var name = 'Maio de '+ano;
                }
                if (mes == 6) {
                    var name = 'Junho de '+ano;
                }
                if (mes == 7) {
                    var name = 'Julho de '+ano;
                }
                if (mes == 8) {
                    var name = 'Agosto de '+ano;
                }
                if (mes == 9) {
                    var name = 'Setembro de '+ano;
                }
                if (mes == 10) {
                    var name = 'Outubro de '+ano;
                }
                if (mes == 11) {
                    var name = 'Novembro de '+ano;
                }
                if (mes == 12) {
                    var name = 'Dezembro de '+ano;
                }

                $('#sel').html(name);
            }
        });
    });

    //CONSULTA DE FUNCIONARIO
    $(document).on('click', '.cad', function(event){
        event.preventDefault();

        var func = $(this).attr("title").split('/');

        /*ADICIONAR REGISTRO*/
        if(func[2] == 'Bloqueado'){
            $(this).removeClass();
            $(this).removeAttr("title");
            $(this).addClass('far fa-thumbs-up cad');

            var id_doc = func[0];
            var id_func = func[1];

            $(this).prop('title', id_doc+'/'+id_func+'/Liberado');

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                dataType:'json',
                data:{ id_doc:id_doc, id_func:id_func },
                success:function(data){
                    
                }
            });
        } 
        /*REMOVER REGISTRO*/
        else {
            $(this).removeClass();
            $(this).removeAttr("title");
            $(this).addClass('far fa-thumbs-down cad');

            var id_docDel = func[0];
            var id_funcDel = func[1];

            $(this).prop('title', id_doc+'/'+id_func+'/Bloqueado');

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                dataType:'json',
                data:{ id_docDel:id_docDel, id_funcDel:id_funcDel },
                success:function(data){
                    
                }
            });
        }

    });

    //AJAX EM PROCESSO02 SEGURADORA
	$('.seg').on('click', function(){
		var id_empresa = $('.seg').val();
        var id_ramo = $('#id_ramo').val();

		$.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ id_empresa:id_empresa[0] },
            success:function(data){
            	html = '<label><span style="color: red;">*</span> Apólice Numero:</label>';
            	html += '<select class="form-control" name="num_apolice">';
            	for(line in data){
                    user = data[line];
                    if (user['id_ramo'] === id_ramo) {
                        html += '<option value="'+user.id+'">'+user.num_apolice+'</option>';
                    }
                }
                html += '</select>';
                $('#num_apolice').html(html);
                if(data.length > 0){
                    $('#cnpj').val(user.cnpj); 
                }
                
            }
        });
	});

    //AJAX EM PROCESSO03 TRANSPORTADORA
    $('.trasp').on('click', function(){
        var id_transportadora = $('.trasp').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ id_transportadora:id_transportadora[0] },
            success:function(data){
                $('#cnpjT').val(data['cnpj']);  
            }
        });
    });

    //AJAX EM PROCESSO04 CORRETORA
    $('.corretora').on('click', function(){
        var id_corretora = $('.corretora').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ id_corretora:id_corretora[0] },
            success:function(data){
                $('#cnpjC').val(data['cnpj']);  
            }
        });
    });

    //AJAX EM PROCESSO05 CIDADE
    $('#city1').bind('keyup', function(){
        var city1 = $('#city1').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ city1:city1 },
            success:function(data){

                var html = '';
                for(line in data){
                    user = data[line];
                    html += '<option value="'+user['id']+'">'+user['nome']+' - '+user['uf']+' - '+user['sigla']+'</option>';
                }
                $('#cidades1').html(html);
            }
        });
    });
    $('#city2').bind('keyup', function(){
        var city2 = $('#city2').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ city2:city2 },
            success:function(data){

                var html = '';
                for(line in data){
                    user = data[line];
                    html += '<option value="'+user['id']+'">'+user['nome']+' - '+user['uf']+' - '+user['sigla']+'</option>';
                }
                $('#cidades2').html(html);
            }
        });
    });
    $('#city3').bind('keyup', function(){
        var city3 = $('#city3').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ city3:city3 },
            success:function(data){

                var html = '';
                for(line in data){
                    user = data[line];
                    html += '<option value="'+user['id']+'">'+user['nome']+' - '+user['uf']+' - '+user['sigla']+'</option>';
                }
                $('#cidades3').html(html);
            }
        });
    });
    $('#city4').bind('keyup', function(){
        var city4 = $('#city4').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ city4:city4 },
            success:function(data){

                var html = '';
                for(line in data){
                    user = data[line];
                    html += '<option value="'+user['id']+'">'+user['nome']+' - '+user['uf']+' - '+user['sigla']+'</option>';
                }
                $('#cidades4').html(html);
            }
        });
    });

    //PAGINA PROCESSO09.PHP
    $('#active1').on('click', function(){
        $(".res1").removeAttr("readonly");
    });
    $('#active2').on('click', function(){
        $(".res2").removeAttr("readonly");
    });

    //CALCULOS PAGINA PROCESSO25.PHP
    $('#danos').on('keyup', function(){
        var danos = $('#danos').val();
        if (parseFloat(danos) > 0) {
            $('#res01').val(danos);
        }
    });
    $('#danos, #dispersao').on('keyup', function(){
        var a = $('#danos').val();
        var b = $('#dispersao').val();
        var total = parseFloat(a)+parseFloat(b);
        if (parseFloat(total) > 0) {
            $('#res01').val(total.toFixed(2));
        }
    });
    $('#danos, #dispersao, #fsr').on('keyup', function(){
        var a = $('#danos').val();
        var b = $('#dispersao').val();
        var c = $('#fsr').val();
        var total = parseFloat(a)+parseFloat(b)+parseFloat(c);
        if (parseFloat(total) > 0) {
            $('#res01').val(total.toFixed(2));
        }
    });
    
    //PROCESSO15.PHP
    $('#rastreamento').on('change', function(){
        var v = $('#rastreamento').val();
        if (v == 1) {
            $('.value').removeAttr("readonly", "readonly");
        } 
        if (v == 2) {
            $('.value').attr("readonly", "readonly");
        }
    });
    $('#rastreamento2').on('change', function(){
        var v = $('#rastreamento2').val();
        if (v == 1) {
            $('.value2').removeAttr("readonly", "readonly");
        } 
        if (v == 2) {
            $('.value2').attr("readonly", "readonly");
        }
    });
    
    //BSCA DE PROCESSOS
    $('#seachProcesso').on('keyup', function(){
        var seachProcesso = $('#seachProcesso').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ seachProcesso:seachProcesso },
            success:function(data){
                var html = '<table id="resposta" class="table table-hover" style="font-size: 12px;">';
                html += '<thead style="background: #000; color: #fff;">';
                html += '<tr>';
                html += '<th>Ação</th>';
                html += '<th>Nº Processo</th>';
                html += '<th>Nº Sinistro</th>';
                for(line in data){
                    user = data[line];

                    html += '<tbody>';
                    html += '<tr>';
                    html += '<td><a href="processo.php?num_processo='+user['num_processo']+'" class="fa fa-edit" title="Editar Processo"></a></td>';

                    html += '<td>'+user['num_processo']+'</td>';
                    html += '<td>'+user['num_sinistro']+'</td>';
                    html += '</tr>';
                    html += '</tbody>';
                }
                html += '</table>';
                $('#resposta').html(html);
            }
        });
    });

    //search processos
    $('.seach_proc').on('keyup', function(){
        var seachProcesso = $('.seach_proc').val();
        let type = $('.type').val();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ seachProcesso:seachProcesso },
            success:function(data){
                let html = '<div class="resposta">';
                html += '<div class="row">';
                for(line in data){
                    user = data[line];

                    html += '<div class="col-sm-2"><b>Processo: </b><br>'+user['num_processo']+'</div>';
                    html += '<div class="col-sm-2"><b>Sinistro: </b><br>'+user['num_sinistro']+'</div>';

                    html += '<div class="col-sm-2"><b>Segurado: </b><br>'+user['segurado']+'</div>';
                    html += '<div class="col-sm-2"><b>Seguradora: </b><br>'+user['seguradora']+'</div>';
                    html += '<div class="col-sm-2"><b>Transportadora: </b><br>'+user['transportadora']+'</div>';

                    html += '<div class="col-sm-2"><a href="contas_despesas.php?type='+type+'&num_processo='+user['num_processo']+'" class="btn btn-primary" title="Editar Processo"><i class="far fa-eye"></i></a></div>';
                }
                html += '</div></div>';
                $('.resposta').html(html);
            }
        });
    });

    $('.formQ1').on('click', function(event){
        event.preventDefault();
        let select = ['km Ida', 'km Deslocamento Interno', 'km Retorno', 'Refeição', 'Hospedagem', 'Pedágios', 'Xerox', 'Sedex', 'Outros'];

        let form = '<div class="row">';

        form += '<div class="col-sm-2"><label>Tipo</label>';
        form += '<select class="form-control" name="type[]">';
        for(line in select){
            user = select[line];
            form += '<option>'+user+'</option>';
        }
        form += '</select>';
        form += '</div>';

        form += '<div class="col-sm-1"><label>Quantidade</label><input type="number" name="qt[]" min="1" value="1" class="form-control qt_form" required=""></div>';

        form += '<div class="col-sm-3"><label>Descrição</label><input type="text" name="descricao[]" class="form-control" required=""></div>';
        form += '<div class="col-sm-3"><label>Valor Unitario</label><input type="text" name="valor[]" class="money form-control v_uni" required=""></div>';
        form += '<div class="col-sm-3"><label>Total</label><input type="text" name="total[]" class="money form-control total" required="" readonly=""></div></div><br>';

        $('.form_area').append(form);
    });

    $(document).on('keyup', '.v_uni', function(){
        let v_uni = $(this).val();
        let qt_form = $('.qt_form').val();
    });

    /*$(document).on('click', '.btn-action', function(e){
        e.preventDefault();


    });*/


    $(document).on('keyup', '.seachProcesso', function(){

        let processo = $(this).val();

        if (processo.length == 7) {
            window.location.href="processo.php?num_processo="+processo;
        }

    });

    //CALCULOS processo30.nfe.php
    $('#qt, #valor_uni, #icms, #ipi, #valor_desc').on('keyup', function(){

        var icms = 0;
        var ipi = 0;

        var qt = $('#qt').val();
        var a = $('#valor_uni').val().replace(/[.]+/g, '');
        var valor_uni = a.replace(/[,]+/g, '.');
        icms = $('#icms').val();
        ipi = $('#ipi').val();
        var b = $('#valor_desc').val().replace(/[.]+/g, '');
        var valor_desc = b.replace(/[,]+/g, '.');

        if (qt.length > 0) {
            $('#total').val(0);
            if (valor_uni.length > 0) {
                var prej = parseFloat(qt)*parseFloat(valor_uni);
                $('#total').val(prej);
                if (icms.length > 0) {
                    var v1 = parseFloat(prej)/100;
                    var v2 = parseFloat(v1)*parseFloat(icms);
                    var v3 = parseFloat(v2)+parseFloat(prej);
                    $('#total').val(v3);
                }
                if (ipi.length > 0) {
                    var v1 = parseFloat(prej)/100;
                    var v2 = parseFloat(v1)*parseFloat(ipi);
                    var v4 = parseFloat(v2)+parseFloat(v3);
                    $('#total').val(v4);
                }
                if (valor_desc.length > 0) {
                    var vF = parseFloat(v4)-parseFloat(valor_desc);
                    $('#total').val(vF);
                }
            }
        }
    });

    $('#qtUP, #valor_uniUP, #icmsUP, #ipiUP, #valor_descUP').on('keyup', function(){
        
        var icms = 0;
        var ipi = 0;

        var qt = $('#qtUP').val();
        var a = $('#valor_uniUP').val().replace(/[.]+/g, '');
        var valor_uni = a.replace(/[,]+/g, '.');
        icms = $('#icmsUP').val();
        ipi = $('#ipiUP').val();
        var b = $('#valor_descUP').val().replace(/[.]+/g, '');
        var valor_desc = b.replace(/[,]+/g, '.');

        if (qt.length > 0) {
            $('#totalUP').val(0);
            if (valor_uni.length > 0) {
                var prej = parseFloat(qt)*parseFloat(valor_uni);
                $('#totalUP').val(prej);
                if (icms.length > 0) {
                    var v1 = parseFloat(prej)/100;
                    var v2 = parseFloat(v1)*parseFloat(icms);
                    var v3 = parseFloat(v2)+parseFloat(prej);
                    $('#totalUP').val(v3);
                }
                if (ipi.length > 0) {
                    var v1 = parseFloat(prej)/100;
                    var v2 = parseFloat(v1)*parseFloat(ipi);
                    var v4 = parseFloat(v2)+parseFloat(v3);
                    $('#totalUP').val(v4);
                }
                if (valor_desc.length > 0) {
                    var vF = parseFloat(v4)-parseFloat(valor_desc);
                    $('#totalUP').val(vF);
                }
            }
        }
    });


    $('#qtIn, #valueIn').on('keyup', function(){
        var a = $('#qtIn').val().replace(/[.]+/g, '');
        var qt = a.replace(/[,]+/g, '.');

        var b = $('#valueIn').val().replace(/[.]+/g, '');
        var value = b.replace(/[,]+/g, '.');

        if (qt.length > 0) {
            $('#totIn').val(qt);
            if (value.length > 0) {
                var total = parseFloat(qt) * parseFloat(value);
                $('#totIn').val(total.toFixed(2));
            }
        }
    });

    $('#qtInUp, #valueInUp').on('keyup', function(){
        var a = $('#qtInUp').val().replace(/[.]+/g, '');
        var qt = a.replace(/[,]+/g, '.');

        var b = $('#valueInUp').val().replace(/[.]+/g, '');
        var value = b.replace(/[,]+/g, '.');

        if (qt.length > 0) {
            $('#totInUp').val(qt);
            if (value.length > 0) {
                var total = parseFloat(qt) * parseFloat(value);
                $('#totInUp').val(total.toFixed(2));
            }
        }
    });


    $('#nt').on('mouseover', function(){
        $('#not').removeAttr("hidden");

        $.ajax({
            type: 'POST',
            url: 'notificacoes.php',
            success:function(data){
                $('#not').html(data);
            }
        });

    });
    $('#not').on('mouseleave', function(){
        $('#not').attr("hidden","hidden");
    });

    $('.txt').on('change', function(){
        var txt = $(this).val();
        var id = $(this).attr('id');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ txt:txt, id:id },
            success:function(data){
                $('#divCarregando').removeAttr("hidden");
                function txt() {
                  $('#divCarregando').attr("hidden", "hidden");
                }
                setTimeout(txt,1000);
            }
        });
        
    });
    
    $('.txtP21').on('change', function(){
        var txtP21 = $(this).val();
        var id = $(this).attr('id');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ txtP21:txtP21, id:id },
            success:function(data){
                $('#divCarregando').removeAttr("hidden");
                function txt() {
                  $('#divCarregando').attr("hidden", "hidden");
                }
                setTimeout(txt,1000);
            }
        });
        
    });

    $('.txtftSin').on('change', function(){
        var txtftSin = $(this).val();
        var id = $(this).attr('id');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ txtftSin:txtftSin, id:id },
            success:function(data){
                $('#divCarregando').removeAttr("hidden");
                function txt() {
                  $('#divCarregando').attr("hidden", "hidden");
                }
                setTimeout(txt,1000);
            }
        });
        
    });

    $('.txtftSal').on('change', function(){
        var txtftSal = $(this).val();
        var id = $(this).attr('id');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ txtftSal:txtftSal, id:id },
            success:function(data){
                $('#divCarregando').removeAttr("hidden");
                function txt() {
                  $('#divCarregando').attr("hidden", "hidden");
                }
                setTimeout(txt,1000);
            }
        });
    });

    $('.txtVist').on('change', function(){
        var txtVist = $(this).val();
        var id = $(this).attr('id');

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ txtVist:txtVist, id:id },
            success:function(data){
                $('#divCarregando').removeAttr("hidden");
                function txt() {
                  $('#divCarregando').attr("hidden", "hidden");
                }
                setTimeout(txt,1000);
            }
        });
    });

    //BUSCA DE PESSOA JURUDICA
    $('#seachPJ').on('keyup', function(){
        var seachPJ = $('#seachPJ').val();

        $.ajax({
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ seachPJ:seachPJ },
            success:function(data){
                var html = '<table id="resposta" class="table table-hover" style="font-size: 12px;">';
                html += '<thead style="background: #000; color: #fff;">';
                html += '<tr>';
                html += '<th>Ação</th>';
                html += '<th>Razão Social</th>';
                html += '<th>CNPJ</th>';
                html += '<th>Ativo</th>';
                html += '<th>Segurado</th>';
                html += '<th>Seguradora</th>';
                html += '<th>Transportadora</th>';
                html += '<th>Corretora</th>';
                html += '<th>Criando em</th>';
                html += '<th>Criando por</th>';
                html += '</tr>';
                html += '</thead>';
                for(line in data){
                    user = data[line];

                    html += '<tbody>';
                    html += '<tr>';
                    html += '<td><a href="pessoaPJForm.php?id='+user['id']+'" class="fa fa-edit" title="Editar Pessoa Juridica"></a></td>';
                    html += '<td>'+user['razao_social']+'</td>';
                    html += '<td>'+user['cnpj']+'</td>';

                    if (user['status'] == 1) {
                        html += '<td>Ativo</td>';
                    } else {
                        html += '<td>Inativo</td>';
                    }
                    if (user['segurado'] == 1) {
                        html += '<td>Sim</td>';
                    } else {
                        html += '<td>Não</td>';
                    }
                    if (user['seguradora'] == 1) {
                        html += '<td>Sim</td>';
                    } else {
                        html += '<td>Não</td>';
                    }
                    if (user['transportadora'] == 1) {
                        html += '<td>Sim</td>';
                    } else {
                        html += '<td>Não</td>';
                    }
                    if (user['corretora'] == 1) {
                        html += '<td>Sim</td>';
                    } else {
                        html += '<td>Não</td>';
                    }

                    html += '<td>'+user['dt_cadastro']+'</td>';
                    html += '<td>'+user['nome']+'</td>';
                    html += '</tr>';
                    html += '</tbody>';
                }
                html += '</table>';
                $('#seachPJResultado').html(html);
            }
        });
    });

    $('#seachPF').on('keyup', function(){
        var seachPF = $('#seachPF').val();

        $.ajax({
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ seachPF:seachPF },
            success:function(data){
                var html = '<table id="respostaF" class="table table-hover" style="font-size: 12px;">';
                html += '<thead style="background: #000; color: #fff;">';
                html += '<tr>';
                html += '<th>Ação</th>';
                html += '<th>Empresa</th>';
                html += '<th>Apelido</th>';
                html += '<th>Nome</th>';
                html += '<th>Sobrenome</th>';
                html += '<th>CPF</th>';
                html += '<th>RG</th>';
                html += '<th>Ativo</th>';
                html += '<th>Criando em</th>';
                html += '<th>Criando por</th>';
                html += '</tr>';
                html += '</thead>';
                for(line in data){
                    user = data[line];

                    html += '<tbody>';
                    html += '<tr>';
                    html += '<td><a href="pessoaPFForm.php?id_usuario='+user['id']+'" class="fa fa-edit" title="Editar Pessoa Fisica"></a></td>';
                    html += '<td>'+user['razao_social']+'</td>';
                    html += '<td>'+user['apelido']+'</td>';
                    html += '<td>'+user['nome']+'</td>';
                    html += '<td>'+user['sobrenome']+'</td>';
                    html += '<td>'+user['cpf']+'</td>';
                    html += '<td>'+user['rg']+'</td>';
                    if (user['status'] == 1) {
                        html += '<td>Ativo</td>';
                    } else {
                        html += '<td>Inativo</td>';
                    }
                    

                    html += '<td>'+user['dt_cadastro']+'</td>';
                    html += '<td>'+user['n']+'</td>';
                    html += '</tr>';
                    html += '</tbody>';
                }
                html += '</table>';
                $('#respostaF').html(html);
            }
        });

    });


    $('#seachAp').on('keyup', function(){
        var seachAp = $(this).val();

        /*INICIO AJAX*/
        $.ajax({
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            type: 'POST',
            url: 'ajax.php',
            dataType:'json',
            data:{ seachAp:seachAp },
            success:function(data){
                var html = '<table id="respostaF" class="table table-hover" style="font-size: 12px;">';
                html += '<thead style="background: #000; color: #fff;">';
                html += '<tr>';
                html += '<th>Ação</th>';
                html += '<th>Empresa</th>';
                html += '<th>CNPJ</th>';
                html += '<th>Apolice</th>';
                html += '<th>De</th>';
                html += '<th>Até</th>';
                html += '<th>Criado em</th>';
                html += '<th>Criado por</th>';
                html += '<th>Ativo</th>';
                html += '</tr>';
                html += '</thead>';
                for(line in data){
                    user = data[line];

                    html += '<tbody>';
                    html += '<tr>';
                    html += '<td><a href="apoliceForm.php?id_apolice='+user['id']+'" class="fa fa-edit" title="Editar Pessoa Fisica"></a></td>';
                    html += '<td>'+user['razao_social']+'</td>';
                    html += '<td>'+user['cnpj']+'</td>';
                    html += '<td>'+user['num_apolice']+'</td>';
                    html += '<td>'+user['de']+'</td>';
                    html += '<td>'+user['ate']+'</td>';
                    html += '<td>'+user['dt_cadastro']+'</td>';
                    html += '<td>'+user['nome']+'</td>';
                    if (user['status'] == 1) {
                        html += '<td>Ativo</td>';
                    } else {
                        html += '<td>Inativo</td>';
                    }
                    html += '</tr>';
                    html += '</tbody>';
                }
                html += '</table>';
                $('#respostaA').html(html);
            }
        });
        /*FIM AJAX*/
    });



});

function Export2Doc(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById(element).innerHTML+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.doc':'document.doc';
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}