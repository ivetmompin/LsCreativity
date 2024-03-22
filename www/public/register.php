<?php

use Ivet\Ac1\Objects\CredentialLogics;
use Ivet\Ac1\Objects\User;

require_once 'Objects/CredentialLogics.php';
require_once 'Objects/User.php';

$user = 'pw2user';
$pass = 'pw2pass';

$passwordErrors = [];
$emailErrors = [];
$userError="";
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkCredentials = new CredentialLogics($email,$password);
    $errors = $checkCredentials->getInputFormatErrors();
    if($errors!=null){
        foreach ($errors as $error){
            if(strpos($error,"email")){
                $emailErrors[] = $error;
            }else if(strpos($error,"password")){
                $passwordErrors[] = $error;
            }
        }
    }else {
        if($checkCredentials->checkIfUserExists($email,$password)){
           $userError = "Email '" . $email . "' already exists in database. Enter a different user";
        }else{
            $user = new User($email,$password);
            $checkCredentials -> registerUser($user->email,$user->password);
            header("Location: login.php");
            exit;
        }
    }
}
?>

<head>
    <title>LsCreativity - Register</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
<div class="registration-form">
    <h1> WELCOME TO LSCREATIVITY</h1>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <p class="label">Email:</p>
        <input type="text" name="email" placeholder="Email">
        <?php foreach($emailErrors as $emailError): ?>
            <p class="error"><?php echo $emailError?></p>
        <?php endforeach; ?>
        <p class="label">Password:</p>
        <input type="password" name="password" placeholder="Password">
        <?php foreach($passwordErrors as $passwordError): ?>
            <p class="error"><?php echo $passwordError?></p>
        <?php endforeach; ?>
        <p class="error"><?php echo $userError?></p>
        <button type="submit"> Register </button>
    </form>
</div>
</body>