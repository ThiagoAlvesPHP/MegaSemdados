<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

require 'autoload.php';
$dt = date('Y-m-d');
$dados = (new Agenda())->getAgendasDataCron();

if (count($dados) > 0) {
	define('EMAIL', 'system@megasystemreguladora.com.br');
	define('SENHA', 'Mega#2018');

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

    /*Debug*/
    $mail->SMTPDebug = 2;

    //smtp.live.com - hotmail / smtp.gmail.com - GMAIL
    $mail->Host = 'megasystemreguladora.com.br'; 
    $mail->SMTPAuth = true;                              
    $mail->Username = EMAIL;                 
    $mail->Password = SENHA;  
    $mail->Port = 587; 
    $mail->SMTPSecure = 'tls';
    //CARREGA A MENSAGEM
    foreach ($dados as $v) {
    	//QUEM ESTA ENVIANDO - EMAIL DA EMPRESA
	    $mail->setFrom($mail->Username);/*opcional*/
	    //AQUI VAI PARA QUEM VOU ENVIAR O EMAIL
	    $mail->addAddress($v['email'], 'Mega Reguladora'); 
	    //ENVIANDO COPIA PARA O MESMO OU OUTRO E-MAIL             
	    $mail->addReplyTo('financeiro@megareguladora.com.br', 'Mega Reguladora');

	    //ATIVANDO HTML NO ENVIO DO EMAIL
	    $mail->isHTML(true);

	    //CARREGA O CONTEUDO DO TITULO
	    $mail->Subject = utf8_decode("Lembrete Mega");
		$mail->Body = '<div style="width: 100%; height: 100%; background-color: #7B68EE; color: #fff;">
	        <div style="width: 90%; margin: auto;">
	            <br>
	            <h3>Usuario: '.$v['nome'].'
	            <br>
	            Ultimo Acesso: '.date('d/m/Y H:i:s', strtotime($v['ult_acesso'])).'
	            </h3>
	            <strong>Lembrete: </strong><hr>
	            <div style="width:100%; height:100px; background-color:#fff; color:#000;">'.$v['lembrete'].'</div>
	            <br>
	            <strong">Data: </strong>
	            <span">'.date('d/m/Y H:i:s', strtotime($v['data'])).'<span>
	            <hr>
	            <center>
	            	<a style="color:#fff;" target="_blank" href="www.megasystemreguladora.com.br/"><h2>www.megasystemreguladora.com.br</h2></a>
	            </center
	            <br><br><br>
	        </div>
	    </div>';

	    $mail->send();
	}
    
    } catch (Exception $e) {
        echo 'Não foi possivel enviar o email.';
        echo 'Error: '.$mail->ErrorInfo;
    }
}

