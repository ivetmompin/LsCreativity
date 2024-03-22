<?php

use Ivet\Ac1\Objects\CredentialLogics;

session_start();
require_once 'Objects/CredentialLogics.php';
require_once 'Objects/User.php';

$passwordErrors = [];
$emailErrors = [];
$userError="";
$user=null;
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
        }else{
            $userId = $checkCredentials->checkIfUserExists($email,$password);
            if($userId != null){
                $_SESSION['user_id'] = $userId;
                header("Location: search.php");
                exit;
            }else{
                $userError="This username does not exist!";
            }
        }
    }
session_write_close();
?>
<head>
    <title>LsCreativity - Login</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="registration-form">
        <h1> WELCOME TO LSCREATIVITY</h1>
        <h2>Login</h2>
        <form action="login.php" method="POST">
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
            <button type="submit"> Login </button>
        </form>
    </div>
</body>