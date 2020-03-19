$(function (){
	$('#seachProcesso').mask('##/##');
    //BUSCA DE PROCESSOS
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
                    html += '<td><a href="viewProcesso.php?num_processo='+user['num_processo']+'" class="fa fa-edit" title="Editar Processo"></a></td>';

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

    var checkTodos = $("#select"); 
    checkTodos.click(function () { 
        if ( $(this).is(':checked') ){ 
            $('.sel').prop("checked", true); 
        }else{ 
            $('.sel').prop("checked", false); 
        } 
    });

});