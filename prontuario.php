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
		function textAreaAdjust(o) {
				o.style.height = "1px";
				o.style.height = (25+o.scrollHeight)+"px";
}
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
					prontuario($_GET['id']);
				?>
				

				<div class="botoes">
					<a href=""><input type="submit" onClick="history.go(0)" value="ATUALIZAR"></a>
					<a><input type="submit" onClick="history.go(-1)" value="VOLTAR"></a>
					<a href="sair.php"><input type="submit" value="SAIR"></a>
				</div>	
				<div class="botoesDireita">
					
					<a href=""><input type="submit" onClick="editarProntuario('1');" value="EDITAR"></a>
					
				</div>
			</div>
        </div>
    </body>
</html>