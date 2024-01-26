<?php
// Conectar ao banco de dados (substitua as credenciais conforme necessário)
$host = "localhost";
$usuario = "root";
$senha = "senac123456789";
$banco = "gastos";
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se os dados do formulário foram enviados
if (isset($_POST['nomeUsuario']) && isset($_POST['descricao']) && isset($_POST['data']) &&
    isset($_POST['valor']) && isset($_POST['tipoDespesa']) && isset($_POST['transferencia'])) {

    // Processar os dados do formulário
    $nomeUsuario = $_POST['nomeUsuario'];
    $descricao = $_POST['descricao'];
    $data = date('Y-m-d', strtotime($_POST['data'])); // Converte a data para o formato do MySQL
    $valor = $_POST['valor'];
    $tipoDespesa = $_POST['tipoDespesa'];
    $transferencia = $_POST['transferencia'];

    // Preparar e executar a consulta SQL
    $sql = "INSERT INTO despesas (nome_usuario, descricao, data, valor, tipo_despesa, transferencia) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparando a declaração
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdid", $nomeUsuario, $descricao, $data, $valor, $tipoDespesa, $transferencia);

    // Executar a declaração preparada
    if ($stmt->execute()) {
        echo "Registro de despesa inserido com sucesso!";
    } else {
        echo "Erro ao inserir o registro de despesa: " . $stmt->error;
    }

    $stmt->close();
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

// Fechar a conexão
$conn->close();
?>

<!-- Adicione este botão no seu HTML -->
<form action="exportar_pdf.php" method="post">
    <br><input type="submit" name="exportarPDF" value="Exportar para PDF">
</form>
