<?php
require_once('mensagem.php');
?>

<html>
    <head>
        <title>PetSaúde - Bem-vindo!</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
          <div class="login">
            <h1><?php echo $msg;?> - Acesso Restrito</h1>

            <form method="post" action="valida.php">
				<p><input type="text" name="usuario" autofocus placeholder="Usuário"></p>
				<p><input type="password" name="senha" placeholder="Senha"></p>
				<p class="submit"><input type="submit" value="ENTRAR"></p>
            </form>
            <form method="post" action="senha.php">
				<p class="submit"><a href="senha.php">Recuperar Senha</a></p>
			</form>
			
          </div>
        </div>
    </body>
</html>




