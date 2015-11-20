<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
//acesso();
?>

<html>
    <head>
        <title>PetSaúde - Prontuário | <?php dataProntuario($_GET['id']); ?></title>
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
				<h1>Prontuário | <?php dataProntuario($_GET['id']); ?></h1>
				
				<?php 
					
				?>
				

				<div class="botoes">
					<a href=""><input type="submit" onClick="history.go(-1)" value="CANCELAR"></a>
				</div>	
				<div class="botoesDireita">
					<a href=""><input type="submit" onClick="salvarEdicaoProntuario()" value="SALVAR"></a>				
				</div>
			</div>
        </div>
    </body>
</html>