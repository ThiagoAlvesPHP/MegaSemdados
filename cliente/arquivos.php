<?php
set_time_limit(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'autoload.php';
//PHPMAILER
require '../admin/vendor/autoload.php';
$sql = new Processos();

if (isset($_SESSION['cLoginCliente']) && !empty($_SESSION['cLoginCliente'])) {
	$id_user = addslashes($_SESSION['cLoginCliente']);
} else {
	header('Location: login.php');
}
//DADOS DO CLIENTE LOGADO
$dados = $sql->getClienteId($_SESSION['cLoginCliente']);
//ENVIAR PARA E-MAIL
if (isset($_POST['e']) && !empty($_POST['e'])) {
    if (!empty($_POST['select'])) {
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
        //HOST: megasystemreguladora.com.br
        $mail->Host = 'megasystemreguladora.com.br'; 
        $mail->SMTPAuth = true;                              
        $mail->Username = EMAIL;                 
        $mail->Password = SENHA;  
        $mail->Port = 587; 
        $mail->SMTPSecure = 'tls';
        
        //QUEM ESTA ENVIANDO - EMAIL DA EMPRESA
        $mail->setFrom($mail->Username, 'Mega Reguladora');/*opcional*/
        //AQUI VAI PARA QUEM VOU ENVIAR O EMAIL
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $mail->addAddress($_POST['email'], 'Mega Reguladora'); 
        } else {
            $mail->addAddress($dados['email'], 'Mega Reguladora'); 
        }
        //ENVIANDO COPIA PARA O MESMO OU OUTRO E-MAIL             
        //$mail->addReplyTo($dados_form['email'], 'E-mail Cliente');
        //ATIVANDO HTML NO ENVIO DO EMAIL
        $mail->isHTML(true);
        //CARREGA O CONTEUDO DO TITULO
        $mail->Subject = "Arquivos Mega Reguladora - Processo: ".str_replace('/', '', $_POST['n_pro']);
        //CARREGA A MENSAGEM
        foreach ($_POST['select'] as $img) {
            $d = $sql->getImg($img);
            $arquivos = '../admin/'.$d['url'].'/'.$d['img'];

            if (file_exists($arquivos)) {
                $mail->addAttachment($arquivos);
                $mail->Body = 'Arquivos enviados pelo Sistema Mega Reguladora';
            } else {
                echo '<h1 style="text-align:center;">Um ou mais arquivos não foram encontrados</h1>';
                ?>
                <script>
                    function temp(){
                        window.close(); 
                    }
                    setTimeout(temp,3000);
                </script>
                <?php
            }
            
        }

        $mail->send();
        ?>
        <script> window.close(); </script>
        <?php
        } catch (Exception $e) {
            echo 'Não foi possivel enviar o email.<br>';
            echo 'Error: '.$mail->ErrorInfo;
        }
    } else {
        echo '<h1 style="text-align:center;">Nenhum arquivo foi selecionado</h1>';
        ?>
        <script>
            function temp(){
                window.close(); 
            }
            setTimeout(temp,3000);
        </script>
        <?php
    }
}

//FAZER DOWNLOAD
if (isset($_POST['b']) && !empty($_POST['b'])) {
	if (!empty($_POST['select'])) {
        $zip = new ZipArchive;
        $zipname = md5(date('dmYsHis')).'.zip';
        $zip->open($zipname, ZipArchive::CREATE);

        foreach ($_POST['select'] as $img) {
            $d = $sql->getImg($img);

            $arquivos = '../admin/'.$d['url'].'/'.$d['img'];
            $zip->addFile($arquivos);
        }
        $zip->close();
        
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);
        unlink($zipname);
    } else {
        echo '<h1 style="text-align:center;">Nenhum arquivo foi selecionado</h1>';
        ?>
        <script>
            function temp(){
                window.close(); 
            }
            setTimeout(temp,3000);
        </script>
        <?php
    }
	
}
