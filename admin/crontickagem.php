<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require 'autoload.php';

$dados = (new Processos())->getAllTickDocs();
if (!empty($dados)) {
	define('EMAIL', 'system@megasystemreguladora.com.br');
	define('SENHA', 'Mega#2018');
	//instanciando class do phpmailer
	$mail = new PHPMailer(true); 
	try {
	    $mail->SMTPOptions = [
	        'ssl' => [
	            'verify_peer' => false,
	            'verify_peer_name' => false,
	            'allow_self_signed' => true
	            ]
	        ];
	    //Ativa o SMTP
	    $mail->isSMTP();
	    //smtp.live.com - hotmail / smtp.gmail.com - GMAIL
	    $mail->Host = 'mail.megasystemreguladora.com.br'; 
	    $mail->SMTPAuth = true;                              
	    $mail->Username = EMAIL;                 
	    $mail->Password = SENHA; 
	    $mail->Port = 587; 
	    $mail->SMTPSecure = 'tls';

	    $body = '';
	    //CARREGA A MENSAGEM
	    foreach ($dados as $key => $v) {
	    	$dt = date('Y-m-d');
	    	$dt_verificacao = date('Y-m-d', strtotime('+10 days', strtotime($v['dt_cadastro'])));
	    	//verificar se tem 10 dias ou mais de aberto processo
	    	if ($dt >= $dt_verificacao) {
	    		// QUEM ESTA ENVIANDO - EMAIL DA EMPRESA
		   		$mail->setFrom($mail->Username);/*opcional*/
		   		//AQUI VAI PARA QUEM VOU ENVIAR O EMAIL documentos@megareguladora.com.br
		    	$mail->addAddress('documentos@megareguladora.com.br', 'Mega Reguladora - Tickagem Documentos');
		    	//ATIVANDO HTML NO ENVIO DO EMAIL
		    	$mail->isHTML(true); 
		    	//CARREGA O CONTEUDO DO TITULO
		   		$mail->Subject = utf8_decode("Mega Reguladora - Tickagem Documentos");

		   		if (in_array(2, $v)) {
		   			$body .= '<div style="width: 100%; height: 100%; background-color: orange; color: #000">';
			   		$body .= '<div style="width: 90%; margin: auto;">';
			   		$body .= '<br><h3>Processo: '.$v['num_processo'].'</h3><br>';
			   		$body .= '<strong style="color:#000;">Detalhes: Processo com 10 dias ou mais faltando documentos!</strong><hr>';

			   		$body .= ($v['nfdanfe'] == 2)?'NF/Danfe: Falta Documento <br>':'';
			   		$body .= ($v['dacte'] == 2)?'Dacte/Conhecimento: Falta Documento <br>':'';
			   		$body .= ($v['cnh_sinitrado'] == 2)?'CNH Motorista Sinistrado: Falta Documento <br>':'';
			   		$body .= ($v['crvl_sinistrado'] == 2)?utf8_decode('CRLV Veículo Sinistrado: Falta Documento <br>'):'';
			   		$body .= ($v['tacografo'] == 2)?utf8_decode('Diagrama Tacógrafo: Falta Documento <br>'):'';
			   		$body .= ($v['declaracao'] == 2)?utf8_decode('Declaração Condutor Sinistrado: Falta Documento <br>'):'';
			   		$body .= ($v['bo_acidente'] == 2)?'BO Acidente: Falta Documento <br>':'';
			   		$body .= ($v['bo_saque'] == 2)?'BO saque: Falta Documento <br>':'';
			   		$body .= ($v['cnh_transbordo'] == 2)?'CNH Transbordo: Falta Documento <br>':'';
			   		$body .= ($v['crvl_transbordo'] == 2)?'CRLV Transbordo: Falta Documento <br>':'';
			   		$body .= ($v['ticket'] == 2)?'Ticket Descarga: Falta Documento <br>':'';

			   		$body .= ($v['comprovante'] == 2)?'Comprovante de Entrega: Falta Documento <br>':'';
			   		$body .= ($v['envolvido'] == 2)?'3º Envolvido/Culpado: Falta Documento <br>':'';
			   		$body .= ($v['chapa'] == 2)?'Recibo Chapa: Falta Documento <br>':'';
			   		$body .= ($v['recibo_transbordo'] == 2)?'Recibo Transbordo: Falta Documento <br>':'';
			   		$body .= ($v['recibo_vigilancia'] == 2)?utf8_decode('Recibo Vigilância: Falta Documento <br>'):'';
			   		$body .= ($v['recibo_munk'] == 2)?'Recibo Munck: Falta Documento <br>':'';
			   		$body .= ($v['recibo_materiais'] == 2)?utf8_decode('Recibo Matérias: Falta Documento <br>'):'';
			   		$body .= '<br></div></div><br>';
		   		}
	    	}
	    }
	    $mail->Body = $body;
	    $mail->send();
    } catch (Exception $e) {
        echo 'Não foi possivel enviar o email.';
        echo 'Error: '.$mail->ErrorInfo;
    }
}