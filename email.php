
<!DOCTYPE html>
<html lang="cs">
<head>
     <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Život se stafbulem</title>
        <meta name="description" content="Informace o stafordšírském bulteriérovi, jeho historii, 
        charakteristice a péči.">
        <meta name= "author" content="Lucie Glubišová">
        <meta name= "keywords" content="stafordšírský bulteriér, SBT, péče o psa, historie plemene, 
        výchova psa, výcvik psa, charakteristika plemene">
        <meta property="og:title" content="Stafbul">
        <meta property="og:description" content="Informace o stafordšírském bulteriérovi, jeho historii, 
        charakteristice a péči.">
        <meta property="og:image" content="https://lucieglubisova.github.io/fotky/teddynek.jpg">
        <meta property="og:url" content="https://lucieglubisova.github.io">
        <link rel ="icon" href="/STBlogo.ico">
        <link rel="stylesheet" href="styly.css">
</head>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Zpracování dat z formuláře (předpokládáme POST)
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Kontrola povinných polí
if (empty($name) || empty($email) || empty($message)) {
    die('Vyplňte všechna pole formuláře.');
}

// Nastavení PHPMaileru
$mail = new PHPMailer(true);
$sendermail= new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.seznam.cz'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'lucieglubisovatest@seznam.cz';  
    $mail->Password   = 'N]S}2q1QfRFL$3#';     
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet = 'UTF-8'; // Nastavení kódování na UTF-8
    $mail->Encoding= 'base64'; // Nastavení kódování zprávy na base64

    //Recipients
    $mail->setFrom('lucieglubisovatest@seznam.cz', 'Webový formulář');
    $mail->addAddress('lucieglubisova@seznam.cz', 'Lucie Glubišová'); 

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Nová zpráva z webového formuláře';
    $mail->Body    = "
        <h2>Nová zpráva z formuláře</h2>
        <p><strong>Jméno:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Zpráva:</strong><br>{$message}</p>
    ";
    $mail->AltBody = "Jméno: {$name}\nEmail: {$email}\nZpráva:\n{$message}";

    $mail->send();
    echo '
    <nav class="menu">
        <div class="vodoznak-menu">Život se stafbulem🐾</div>
        <ul>
          <li><a href="index.html">Úvod</a></li>
          <li><a href="historie.html">Historie</a></li>
          <li><a href="charakteristika.html">Charakteristika</a></li>
          <li><a href="pece.html">Péče</a></li>
          <li><a href="vychova a vycvik.html">Výchova a výcvik</a></li>
          <li><a href="fotogalerie.html">Fotogalerie</a></li>
          <li><a href="kontakt.html">Kontakt</a></li>
        </ul>
    </nav>
    <main>
        <h1>Děkujeme za Vaši zprávu!</h1>
        <p>Vaše zpráva byla úspěšně odeslána. Budeme Vás co nejdříve kontaktovat.</p>
    </main>
       <footer>
        <p>Život se stafbulem</p>
    </footer>
    ';
       
} catch (Exception $e) {
    echo "Zprávu se nepodařilo odeslat. Chyba: {$mail->ErrorInfo}";
}
// Odeslání kopie odesílateli
try {
    //Server settings
    $sendermail->isSMTP();
    $sendermail->Host       = 'smtp.seznam.cz'; 
    $sendermail->SMTPAuth   = true;
    $sendermail->Username   = 'lucieglubisovatest@seznam.cz';  
    $sendermail->Password   = 'N]S}2q1QfRFL$3#';     
    $sendermail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $sendermail->Port       = 587;
    $sendermail->CharSet = 'UTF-8'; // Nastavení kódování na UTF-8
    $sendermail->Encoding= 'base64'; // Nastavení kódování zprávy na base64

    //Recipients
    $sendermail->setFrom('lucieglubisovatest@seznam.cz', 'Webový formulář');
   

    $sendermail->addAddress($email, $name); 
    $sendermail->isHTML(true);
    $sendermail->Subject = 'Potvrzení odeslání zprávy';
    $sendermail->Body    = "
        <h2>Potvrzení odeslání zprávy</h2>
        <p>Děkujeme za Vaši zprávu. Vaše zpráva byla úspěšně odeslána.</p>";
    $sendermail->AltBody = "Děkujeme za Vaši zprávu. Vaše zpráva byla úspěšně odeslána.";
    $sendermail->send();
    
} catch (Exception $e) {
    echo "Kopii zprávy se nepodařilo odeslat. Chyba: {$sendermail->ErrorInfo}";
}

?>
</html>