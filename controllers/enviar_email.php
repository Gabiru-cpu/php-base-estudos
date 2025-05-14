<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclui os arquivos necessários do PHPMailer
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

// Instância do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuração UTF-8 para acentuação correta
    $mail->CharSet = 'UTF-8';

    // Configurações do servidor SMTP do Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'gabriel.profevolutime@gmail.com'; // Seu e-mail Gmail
    $mail->Password = 'hixh fcfk mckj xrmj'; // Sua senha de app gerada no Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Remetente
    $mail->setFrom('gabriel.profevolutime@gmail.com', 'Loja Temos');

    // Destinatário (recebido via POST do formulário)
    $emailDestino = $_POST['email'];
    $mail->addAddress($emailDestino);

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Bem-vindo à nossa loja!';
    $mail->Body    = '<h1>Olá!</h1><p>Seja bem-vindo à nossa loja. Esperamos que aproveite sua experiência!</p>';
    $mail->AltBody = 'Olá! Seja bem-vindo à nossa loja. Esperamos que aproveite sua experiência!';

    // Envia o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>
<head>
    <meta charset="UTF-8">
    <title>Envio de e-mail</title>
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
    <br><br>
    <a href="../views/index.php" style="text-decoration: none;"><button type="button">Voltar</button></a>
</body>