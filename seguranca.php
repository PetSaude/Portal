<?php
/**
* Sistema de segurança com acesso restrito
*/
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
$_SG['servidor'] = 'mysql04.labsolucoes.hospedagemdesites.ws';    // Servidor MySQL
$_SG['usuario'] = 'labsolucoes3';          // Usuário MySQL
$_SG['senha'] = 'pet2015bd';                // Senha MySQL
$_SG['banco'] = 'labsolucoes3';        // Banco de dados MySQL
//$_SG['servidor'] = 'localhost';    // Servidor MySQL
//$_SG['usuario'] = 'root';          // Usuário MySQL
//$_SG['senha'] = '';                // Senha MySQL
//$_SG['banco'] = 'petsaude';        // Banco de dados MySQL
$_SG['paginaLogin'] = 'index.php'; // Página de login
$_SG['paginaHome'] = 'home.php';   // Página de após login
$_SG['tabelaUsuarios'] = 'usuario';  
$_SG['tabelaAnimais'] = 'animal';
$_SG['tabelaProntuarios'] = 'prontuario';
$_SG['tabelaVagas'] = 'vaga';
$_SG['tabelaConsultas'] = 'consulta';
$_SG['tabelaConsultasVeterinario'] = 'consulta_veterinario';
// ==============================
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
  $_SG['link'] = mysql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
  mysql_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
  session_start();
/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha, $tipo) {
  global $_SG;
  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);
  // Monta uma consulta SQL (query) para procurar um usuário
  $sql = "SELECT `id_usuario`, `nome`, `tipo` FROM `".$_SG['tabelaUsuarios']."` WHERE ".$cS." `usuario` = '".$nusuario."' AND ".$cS." `senha` = '".md5($nsenha)."' LIMIT 1";
  $query = mysql_query($sql);
  $resultado = mysql_fetch_assoc($query);
  // Verifica se encontrou algum registro
  if (empty($resultado)) {
    // Nenhum registro foi encontrado => o usuário é inválido
    return false;
  } else {
    // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioID'] = $resultado['id_usuario']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
	$_SESSION['usuarioTipo'] = $resultado['tipo']; // Pega o tipo da conta do usuário (Se é admin, vet, atendente ou padrao)
    // Verifica a opção se sempre validar o login
    if ($_SG['validaSempre'] == true) {
      // Definimos dois valores na sessão com os dados do login
      $_SESSION['usuarioLogin'] = $usuario;
      $_SESSION['usuarioSenha'] = $senha;
    }
    return true;
  }
}
/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;
  if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}

function acesso() {
	global $_SG;
	if (!$_SESSION['usuarioTipo'] == "ADMIN"){
		header("Location: ".$_SG['paginaHome']);
	}
	else if (!$_SESSION['usuarioTipo'] == "Gestor"){
		header("Location: ".$_SG['paginaHome']);
	}
	else if (!$_SESSION['usuarioTipo'] == "Veterinário"){
		header("Location: ".$_SG['paginaHome']);
	}
	else if (!$_SESSION['usuarioTipo'] == "Atendente"){
		header("Location: ".$_SG['paginaHome']);
	}
	else if (!$_SESSION['usuarioTipo'] == "Tutor"){
		header("Location: ".$_SG['paginaHome']);
	}
}



/**
function admin() {
	global $_SG;
	if (!($_SESSION['usuarioTipo'] == "Admin" or "Gestor" or "Veterinário" or "Atendente" or "Tutor")){
		header("Location: ".$_SG['paginaHome']);
	}
}

function gestor() {
	global $_SG;
	if (!($_SESSION['usuarioTipo'] == "Gestor")){
		header("Location: ".$_SG['paginaHome']);
	}
}


function veterinario() {
	global $_SG;
	if (!($_SESSION['usuarioTipo'] == "Veterinário")){
		header("Location: ".$_SG['paginaHome']);
	}
}


function atendente() {
	global $_SG;
	if (!($_SESSION['usuarioTipo'] == "Atendente")){
		header("Location: ".$_SG['paginaHome']);
	}
}

function tutor() {
	global $_SG;
	if (!($_SESSION['usuarioTipo'] == "Tutor")){
		header("Location: ".$_SG['paginaHome']);
	}
}
*/



/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  // Manda pra tela de login
  header("Location: ".$_SG['paginaLogin']);
}


function listaUsuarios() {
	global $_SG;
	$sql = "SELECT DISTINCT u.id_usuario, u.nome, u.usuario, u.cpf, u.email, u.telefone, u.celular FROM usuario u, animal a WHERE u.id_usuario = a.id_usuario";
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum cliente encontrado na base de dados.";
	}


	echo "<table><tr> <th>ID</th> <th>Nome</th> <th>Usuário</th> <th>CPF</th> <th>Email</th> <th>Telefone</th> <th>Celular</th></tr>";
		while ($row = mysql_fetch_assoc($resultado)){
			echo '<form method="POST" id='.$row['id_usuario'].'><tr data-href="info.php?id=' . $row['id_usuario'] . '">';
			echo '<td>'. $row['id_usuario'] . '</td>';
			echo utf8_encode('<td>'. $row['nome'] . '</td>');
			echo '<td>'. $row['usuario'] . '</td>';
			echo '<td>'. $row['cpf'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['telefone'] . '</td>';
			echo '<td>'. $row['celular'] . '</td></tr></form>';
		}
	echo "</table>";
}

function listaAnimais($id){
	global $_SG;
	$sql = "SELECT * FROM `".$_SG['tabelaUsuarios']."` WHERE id_usuario = $id";
	$resultado = mysql_query($sql);
	
	$sqla = "SELECT * FROM `".$_SG['tabelaAnimais']."` WHERE id_usuario = $id";
	$resultadoAnimais = mysql_query($sqla);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum cliente encontrado na base de dados.";
	}	
	
	echo "<table><tr> <th>ID</th> <th>Nome</th> <th>Data de Nascimento</th> <th>Peso</th> <th>Raça</th></tr>";
	while ($row = mysql_fetch_assoc($resultadoAnimais)){
		echo '<tr data-href="animal.php?id=' . $row['id_animal'] . '">';
		echo '<td>'. $row['id_animal'] . '</td>';
		echo utf8_encode('<td>'. $row['nome'] . '</td>');
		echo '<td>'. $row['data_nascimento'] . '</td>';
		echo '<td>'. $row['peso'] . '</td>';
		echo utf8_encode('<td>'. $row['raca'] . '</td></tr>');
	}
	echo "</table>";


	

}
	
/*
BUSCA PRONTUARIO DO ANIMAL SELECIONADO
*/

function listaProntuarios($id){
	global $_SG;
	$sql = "SELECT DISTINCT p.id_prontuario, c.data, c.hora, u.nome, c.status FROM usuario u, animal a, prontuario p, vaga v, consulta c, consulta_veterinario cv 
	WHERE p.id_animal = $id 
	and p.id_consulta = c.id_consulta 
	and p.id_consulta = cv.id_consulta
	and cv.id_veterinario = u.id_usuario
	and v.id_vaga = c.id_vaga
	";
	
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo '<table><th data-href="">Informação</th>';
		echo '<tr data-href=""><td>Nenhum histórico de consultas encontrado na base de dados.</td></tr>';
		echo '</table>';
	}
	if (mysql_num_rows($resultado) > 0){
	echo "<table><tr> <th>Data</th> <th>Hora</th> <th>Veterinário</th> <th>Status</th></tr>";
		while ($row = mysql_fetch_assoc($resultado)){
			echo '<tr data-href="prontuario.php?id=' . $row['id_prontuario'] . '">';
			echo '<td>'. $row['data'] . '</td>';
			echo '<td>'. $row['hora'] . '</td>';
			echo utf8_encode('<td>'. $row['nome'] . '</td>');
			echo utf8_encode('<td>'. $row['status'] . '</td></tr>');
		}
	echo "</table>";
	}
}

/*
EXIBE INFORMAÇÕES DA CONSULTA SELECIONADA NO PRONTUÁRIO
*/

function prontuario($id){
	global $_SG;
	$sql = "SELECT DISTINCT p.historico_clinico FROM usuario u, animal a, prontuario p, vaga v, consulta c, consulta_veterinario cv 
	WHERE p.id_prontuario = $id 
	and p.id_consulta = c.id_consulta 
	and p.id_consulta = cv.id_consulta
	and cv.id_veterinario = u.id_usuario
	and v.id_vaga = c.id_vaga
	";
	
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum prontuário encontrado na base de dados.";
	}

	echo "<table><tr> <th>Histórico Veterinário</th> </tr></table> <form><textarea readonly>";
		while ($row = mysql_fetch_assoc($resultado)){
			echo utf8_encode($row['historico_clinico']);
		}
	echo "</textarea></form>";
}

/*
BUSCA NOME DO USUARIO
*/

function nome($id){
	global $_SG;
	$sql = "SELECT * FROM `".$_SG['tabelaUsuarios']."` WHERE id_usuario = $id";
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum cliente encontrado na base de dados.";
	}

	
	while ($row = mysql_fetch_assoc($resultado)){
		echo utf8_encode($row['nome']);
	}

}

/*
BUSCA NOME DO ANIMAL
*/


function nomeAnimal($id){
	global $_SG;
	$sql = "SELECT * FROM `".$_SG['tabelaAnimais']."` WHERE id_animal = $id";
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum cliente encontrado na base de dados.";
	}

	
	while ($row = mysql_fetch_assoc($resultado)){
		echo utf8_encode($row['nome']);
	}

}


/*
BUSCA DATA DO PRONTUARIO
*/


function dataProntuario($id){
	global $_SG;
	$sql = "SELECT c.data, c.hora FROM consulta c, prontuario p WHERE p.id_prontuario = $id and p.id_consulta = c.id_consulta";
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum cliente encontrado na base de dados.";
	}

	
	while ($row = mysql_fetch_assoc($resultado)){
		$data = $row['data'];
		$transformaData = date("d/m/Y", strtotime($data));	
		echo $transformaData;
		
		echo " às ";
		
		$hora = $row['hora'];
		$transformaHora = date("h:i", strtotime($hora));	
		echo $transformaHora;
	}

}

function editarProntuario($id){
	global $_SG;
	$sql = "SELECT p.id_prontuario, p.historico_clinico FROM usuario u, animal a, prontuario p, vaga v, consulta c, consulta_veterinario cv 
	WHERE p.id_prontuario = $id 
	and p.id_consulta = c.id_consulta 
	and p.id_consulta = cv.id_consulta
	and cv.id_veterinario = u.id_usuario
	and v.id_vaga = c.id_vaga
	";
	
	$resultado = mysql_query($sql);
	
	if (!$resultado) {
		echo "Erro de SQL: " . mysql_error();

	} 
	
	if (mysql_num_rows($resultado) == 0){
		echo "Nenhum cliente encontrado na base de dados.";
	}

	echo "<table><tr> <th>Histórico Veterinário</th> </tr></table> <form><textarea>";
		while ($row = mysql_fetch_assoc($resultado)){
			echo 'data-href="editarProntuario.php?id=' . $row['id_prontuario'] . '"';
			echo utf8_encode($row['historico_clinico']);
		}
	echo "</textarea></form>";
}