<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

require 'autoload.php';
$dt = date('Y-m-d');
$dados = (new Dashboard())->getDiarioBordo($dt);

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
    //$mail->SMTPDebug = 2;

    //smtp.live.com - hotmail / smtp.gmail.com - GMAIL
    $mail->Host = 'mail.megasystemreguladora.com.br'; 
    $mail->SMTPAuth = true;                              
    $mail->Username = EMAIL;                 
    $mail->Password = SENHA; 
    $mail->Port = 587; 
    $mail->SMTPSecure = 'tls';
    //CARREGA A MENSAGEM
    foreach ($dados as $v) {
    	//QUEM ESTA ENVIANDO - EMAIL DA EMPRESA
	    $mail->setFrom($mail->Username);/*opcional*/
	    //AQUI VAI PARA QUEM VOU ENVIAR O EMAIL contato@megareguladora.com.br
	    $mail->addAddress('contato@megareguladora.com.br', 'Mega Reguladora'); 
	    //ENVIANDO COPIA PARA O MESMO OU OUTRO E-MAIL             
	    //$mail->addReplyTo($mail->Username, 'Mega Reguladora');
	    //ATIVANDO HTML NO ENVIO DO EMAIL
	    $mail->isHTML(true);

	    //CARREGA O CONTEUDO DO TITULO
	    $mail->Subject = utf8_decode("Diario de bordo - ".$v['num_processo']);

    	$mail->Body = '
	    <div style="width: 100%; height: 100%; background-color: #c0c0c0; color: red">
	        <div style="width: 90%; margin: auto;">
	            <br>
	            <h3>Processo: '.$v['num_processo'].'</h3>
	            <br>
	            <strong style="color:#000;">Detalhes: </strong>
	            <span style="color:#000;">'.$v['detalhes'].'</span>
	            <br>
	            <strong style="color:#000;">Valor: </strong>
	            <span style="color:#000;">R$'.number_format($v['valor'], 2, '.', '').'<span>
	            <br>
	            <strong style="color:#000;">Data: </strong>
	            <span style="color:#000;">'.date('d/m/Y H:i:s', strtotime($v['dt_hs'])).'<span>
	            <br>
	            <strong style="color:#000;">Link: </strong>
	            <a href="https://www.megasystemreguladora.com.br/admin/diario.php?num_processo='.$v['num_processo'].'">Link</a>	            
	            <br><br><br>
	        </div>
	    </div>';

	    $mail->send();
	    echo "Enviado com sucesso!";
    }
    
    } catch (Exception $e) {
        echo 'Não foi possivel enviar o email.';
        echo 'Error: '.$mail->ErrorInfo;
    }
}