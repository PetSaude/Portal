<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<html>
    <head>
        <title>PetSaúde - Admin</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
          <div class="login">
            <h1><?php echo "Olá " . utf8_encode($_SESSION['usuarioNome']); ?></h1>
			
			<?php if($_SESSION['usuarioTipo'] == "Admin" and "Gestor"){ ?>
				<form method="post" action="cliente.php">
				  <p class="submit"><input type="submit" value="Cliente"></p>
				</form>
			<?php } ?>
            
			<?php if($_SESSION['usuarioTipo'] == "Admin" and "Gestor"){ ?>
				<form method="post" action="animal.php">
				  <p class="submit"><input disabled type="submit" value="Animal"></p>
				</form>
            <?php } ?>
			
			
            <form method="post" action="sair.php">
              <p class="submit"><input type="submit" value="SAIR"></p>
            </form>
          </div>
        </div>
    </body>
</html>




