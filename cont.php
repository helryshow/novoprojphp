<?php
// Conectar ao banco de dados (substitua as credenciais conforme necessário)
$host = "localhost";
$usuario = "root";
$senha = "970125";
$banco = "gastos";
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if(isset($_POST['nomeUsuario'])&& isset($_POST['descricao'])&& isset($_POST['data'])&&
 isset($_POST['valor'])&& isset($_POST['tipoDespesa'])&& isset($_POST['transferncia'])){
    // Processar os dados do formulário
$nomeUsuario = $_POST['nomeUsuario'];
$descricao = $_POST['descricao'];
$data = $_POST['data'];
$valor = $_POST['valor'];
$tipoDespesa = $_POST['tipoDespesa'];
$transferencia = $_POST['transferencia']; // Adicionando a variável de transferência

// Inserir dados no banco de dados
$sql = "INSERT INTO despesas (nome_usuario, descricao, data, valor, tipo_despesa, transferencia) VALUES ('$nomeUsuario', '$descricao', '$data', '$valor', '$tipoDespesa', '$transferencia')";
if ($conn->query($sql) === TRUE) {
    echo "Registro de despesa inserido com sucesso!";

    // Calcular a soma da diferença entre transferencia e valor na tabela despesas
    $consultaSoma = "SELECT SUM(transferencia - valor) AS diferenca FROM despesas";
    $resultadoSoma = $conn->query($consultaSoma);

    if ($resultadoSoma->num_rows > 0) {
        $row = $resultadoSoma->fetch_assoc();
        $diferenca = $row['diferenca'];
        echo "<br>Soma total da diferença entre transferencia e valor: $diferenca";
    } else {
        echo "<br>Nenhuma despesa encontrada.";
    }
} else {
    echo "Erro ao inserir o registro de despesa: " . $conn->error;
}
  // Recuperar dados da tabela despesas
  $consultaDespesas = "SELECT * FROM despesas";
  $resultadoDespesas = $conn->query($consultaDespesas);

  if ($resultadoDespesas->num_rows > 0) {
      echo "<br><br>Tabela de Despesas:<br>";
      echo "<table border='1'>";
      echo "<tr><th>ID</th><th>Nome do Usuário</th><th>Descrição</th><th>Data</th><th>Valor</th><th>Tipo de Despesa</th></tr>";

      while ($rowDespesas = $resultadoDespesas->fetch_assoc()) {
          echo "<tr><td>{$rowDespesas['id']}</td><td>{$rowDespesas['nome_usuario']}</td><td>{$rowDespesas['descricao']}</td><td>{$rowDespesas['data']}</td><td>{$rowDespesas['valor']}</td><td>{$rowDespesas['tipo_despesa']}</td></tr>";
      }

      echo "</table>";
  } else {
      echo "Nenhum registro encontrado na tabela despesas.";
  }
 }

/* // Processar os dados do formulário
$nomeUsuario = $_POST['nomeUsuario'];
$descricao = $_POST['descricao'];
$data = $_POST['data'];
$valor = $_POST['valor'];
$tipoDespesa = $_POST['tipoDespesa'];
$transferencia = $_POST['transferencia']; // Adicionando a variável de transferência

// Inserir dados no banco de dados
$sql = "INSERT INTO despesas (nome_usuario, descricao, data, valor, tipo_despesa, transferencia) VALUES ('$nomeUsuario', '$descricao', '$data', '$valor', '$tipoDespesa', '$transferencia')";
if ($conn->query($sql) === TRUE) {
    echo "Registro de despesa inserido com sucesso!";

    // Calcular a soma da diferença entre transferencia e valor na tabela despesas
    $consultaSoma = "SELECT SUM(transferencia - valor) AS diferenca FROM despesas";
    $resultadoSoma = $conn->query($consultaSoma);

    if ($resultadoSoma->num_rows > 0) {
        $row = $resultadoSoma->fetch_assoc();
        $diferenca = $row['diferenca'];
        echo "<br>Soma total da diferença entre transferencia e valor: $diferenca";
    } else {
        echo "<br>Nenhuma despesa encontrada.";
    }
} else {
    echo "Erro ao inserir o registro de despesa: " . $conn->error;
}
  // Recuperar dados da tabela despesas
  $consultaDespesas = "SELECT * FROM despesas";
  $resultadoDespesas = $conn->query($consultaDespesas);

  if ($resultadoDespesas->num_rows > 0) {
      echo "<br><br>Tabela de Despesas:<br>";
      echo "<table border='1'>";
      echo "<tr><th>ID</th><th>Nome do Usuário</th><th>Descrição</th><th>Data</th><th>Valor</th><th>Tipo de Despesa</th></tr>";

      while ($rowDespesas = $resultadoDespesas->fetch_assoc()) {
          echo "<tr><td>{$rowDespesas['id']}</td><td>{$rowDespesas['nome_usuario']}</td><td>{$rowDespesas['descricao']}</td><td>{$rowDespesas['data']}</td><td>{$rowDespesas['valor']}</td><td>{$rowDespesas['tipo_despesa']}</td></tr>";
      }

      echo "</table>";
  } else {
      echo "Nenhum registro encontrado na tabela despesas.";
  } */

 // else {
  //echo "Erro ao inserir registro: " . $conn->error;
 //}

 // Fechar a conexão
 $conn->close();

    echo '<a href="index.html">voltar</a';

 ?>

<!-- Adicione este botão no seu HTML -->
<form action="exportar_pdf.php" method="post">
    <br><input type="submit" name="exportarPDF" value="Exportar para PDF">
</form>
