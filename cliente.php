<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
//acesso();
?>

<html>
    <head>
        <title>PetSaúde - Clientes</title>
        <link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>

		$(document).ready(function(){
			$('table tr').click(function(){
				window.location = $(this).data('href');
				return false;
			});
		});
		  
		</script>
    </head>
    <body>
        <div class="page-wrap">
          <div class="cliente">
            <h1>Lista de Clientes</h1>
			
			
				<?php 
					listaUsuarios();
				?>
			<div class="botoes">
				<div class="botoesEsquerda">
					<a href=""><input type="submit" onClick="history.go(0)" value="ATUALIZAR"></a>
					<a href=""><input type="submit" onClick="history.go(-1)" value="VOLTAR"></a>
					<a href="sair.php"><input type="submit" value="SAIR"></a>
				</div>	
			</div>
        </div>
		  
		  
		  
        </div>
    </body>
</html>