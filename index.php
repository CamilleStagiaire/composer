<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="script.js"></script>

<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Gregwar\Captcha\CaptchaBuilder;

require 'vendor/autoload.php';

$builder = new CaptchaBuilder;
$distortion = null;
$builder->setDistortion($distortion);

if (isset($_POST['robot'])) {

    $mail = new PHPMailer(True);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $objet = $_POST['objet'];
    $message = stripslashes(trim($_POST['message']));
    $userInput = $_POST['robot'];
    if ($_SESSION['phrase'] == $_POST['robot']) {

        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;
        $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
        $mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
        $mail->SMTPAuth = true; // Activer authentication SMTP
        $mail->Username = 'camille.dwwm@gmail.com'; // Votre adresse email d'envoi
        $mail->Password = '******'; // Le mot de passe de cette adresse email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Accepter SSL
        $mail->Port = 465; // 587

        $mail->Charset = "utf-8";

        $mail->setFrom($email, $name); // Personnaliser l'envoyeur
        $mail->addAddress('camille.dwwm@gmail.com', 'Administrateur'); // Ajouter le destinataire
        $mail->addReplyTo($email, $name); // L'adresse de réponse
        $mail->isHTML(true); // Paramétrer le format des emails en HTML ou non

        $mail->Subject = $objet;
        $mail->Body = $message;
        $mail->AltBody = $message;

        $mail->send();
        echo '<script>success()</script>';
        $_POST = [];
    } else {
        echo '<script>failed()</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Composer</title>
</head>

<body>
    <main class="container-fluid mt-5">

        <h1 class="text-center">Formulaire de contact</h1>
        <div class="text-center col-md-4 offset-4">

            <form action="" method="post">
                <div class="md-3">
                    <label class="form-label">Nom</label>
                    <input class="form-control" type="text" name="name" placeholder="Entrez votre nom" value="<?= htmlentities($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="md-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Entrez votre email" value="<?= htmlentities($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="md-3">
                    <label class="form-label">Objet</label>
                    <input class="form-control" type="text" name="objet" placeholder="Objet de votre demande" value="<?= htmlentities($_POST['objet'] ?? '') ?>" required>
                </div>
                <div class="md-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" name="message" placeholder="Votre message" rows="5" value="<?= htmlentities($_POST['message'] ?? '') ?>" required></textarea>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <input class="form-control" placeholder="Entrez le captcha" type="text" name="robot" value="<?= $_POST['robot'] ?? '' ?>" required>
                        <?php
                        $builder->build();
                        $_SESSION['phrase'] = $builder->getPhrase();
                        ?>
                    </div>
                    <div class="col-md-6">
                        <img src="<?php echo $builder->inline(); ?>" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
            </form>
        </div>
    </main>
</body>