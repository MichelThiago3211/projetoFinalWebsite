<?php

include_once "env.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("phpmailer\src\PHPMailer.php");
require_once("phpmailer\src\SMTP.php");
require_once("phpmailer\src\Exception.php");

try {
    $email = new PHPMailer(true);
    $email->SMTPDebug = SMTP::DEBUG_SERVER;
    $email->IsSMTP();
    $email->Port = 587;
    $email->SMTPAuth = true;
    $email->Username = "projetoms.instituto@gmail.com";
    $email->Password = $_ENV["SENHA_EMAIL"];
    $email->From = "projetoms.instituto@gmail.com";
    $email->FromName = "NOME";
	$email->addAddress("thiago.michel@institutoivoti.com.br");
    $email->addAddress("nicolas.spaniol@institutoivoti.com.br");
	$email->Host = "smtp.gmail.com";


    $email->oauthUserEmail = "projetoms.instituto@gmail.com";
    $email->oauthClientId = "735774943877-ndh7dncfe43i3uv02e3tt2t2o5b9sk12.apps.googleusercontent.com";
    $email->oauthClientSecret = "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";
    $email->oauthRefreshToken = "[Redacted]";
    
    // Conteúdo
    $email->IsHTML = true;
    $email->Subject = "ASSUNTO";
    $email->Body = "MSG";
    $email->AltBody = "MSG";

	if($email->Send()) {
		echo "Eemail enviado com sucesso";
	} else {
		echo "Eemail não enviado";
	}
} catch (Exception $e) {
	echo "Erro ao enviar mensagem: {$email->ErrorInfo}";
}