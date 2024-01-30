<?php
$host = "localhost";
$usuario = "seu usuario";
$senha = "sua senha";
$banco = "gastos";
$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (isset($_POST['nomeUsuario']) && isset($_POST['descricao']) && isset($_POST['data']) &&
    isset($_POST['valor']) && isset($_POST['tipoDespesa']) && isset($_POST['transferencia'])) {

    $nomeUsuario = $_POST['nomeUsuario'];
    $descricao = $_POST['descricao'];
    $data = date('Y-m-d', strtotime($_POST['data']));
    $valor = $_POST['valor'];
    $transferencia = $_POST['transferencia'];
    $tipoDespesa = $_POST['tipoDespesa'];

    $sql = "INSERT INTO despesas (nome_usuario, descricao, data, valor, transferencia, tipo_despesa) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdds", $nomeUsuario, $descricao, $data, $valor, $transferencia, $tipoDespesa);

    if ($stmt->execute()) {
        echo "Registro de despesa inserido com sucesso!";
    } else {
        echo "Erro ao inserir o registro de despesa: " . $stmt->error;
    }

    $stmt->close();
}

$consultaDespesas = "SELECT * FROM despesas";
$resultadoDespesas = $conn->query($consultaDespesas);

if ($resultadoDespesas->num_rows > 0) {
    echo "<br><br>Tabela de Despesas:<br>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nome do Usuário</th><th>Descrição</th><th>Data</th><th>Valor</th><th>Tipo de Despesa</th></tr>";

    $somaTransferenciaValor = 0;

    while ($rowDespesas = $resultadoDespesas->fetch_assoc()) {
        echo "<tr><td>{$rowDespesas['id']}</td><td>{$rowDespesas['nome_usuario']}</td><td>{$rowDespesas['descricao']}</td><td>{$rowDespesas['data']}</td><td>{$rowDespesas['valor']}</td><td>{$rowDespesas['tipo_despesa']}</td></tr>";

        // Calcula a soma de transferencia - valor
        $somaTransferenciaValor += $rowDespesas['transferencia'] - $rowDespesas['valor'];
    }

    echo "</table>";

    // Exibe a soma no final da tabela
    echo "<p><b> Saldo R$: $somaTransferenciaValor</b></p>";

} else {
    echo "Nenhum registro encontrado na tabela despesas.";
}
 // Calcular a soma do credito na tabela despesas
 $consulcredito = "SELECT SUM(transferencia) AS credito FROM despesas";
 $resulcredito = $conn->query($consulcredito);

 if ($resulcredito->num_rows > 0) {
     $row = $resulcredito->fetch_assoc();
     $credito = $row['credito'];
     echo "<br>Credito R$: $credito";
 } else {
     echo "<br>Nenhuma despesa encontrada." . $conn->error;
 }

// Calcular a soma do valor de saida na tabela despesas
$consulsaida = "SELECT SUM(valor) AS saida FROM despesas";
$resulsaida = $conn->query($consulsaida);

if ($resulsaida->num_rows > 0) {
    $row = $resulsaida->fetch_assoc();
    $saida = $row['saida'];
    echo "<br>Saida R$: $saida";
} else {
    echo "<br>Nenhuma despesa encontrada." . $conn->error;
}

$conn->close();

echo '<br><a href="index.html">voltar</a';

?>

<!-- Adicione este botão no seu HTML -->
<form action="exportar_pdf.php" method="post">
    <br><input type="submit" name="exportarPDF" value="Exportar para PDF">
</form>
