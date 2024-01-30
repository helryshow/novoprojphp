<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Despesas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ffb907;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h1 {
            color: #333;
        }

        button {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #ffb907;
            color: white;
            cursor: pointer;
            font-size: 18px;
        }

        @media print {
            body, .container {
                height: auto;
                margin: 0;
                padding: 0;
                display: block;
            }

            table {
                box-shadow: none;
                margin-bottom: 0;
            }
        }

        /* Aqui os botões com a classe 'botão' não serão exibidos */
        @media dompdf {
        .botao {
            display: none;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Despesas Registradas</h1>
        <?php
        // Conexão com o banco de dados
        $host = "localhost";
        $usuario = "seu usuario";
        $senha = "sua senha";
        $banco = "gastos";
        $conn = new mysqli($host, $usuario, $senha, $banco);

        // Verificar a conexão
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

            
        // Recuperar dados da tabela despesas
        $consultaDespesas = "SELECT * FROM despesas";
        $resultadoDespesas = $conn->query($consultaDespesas);

        if ($resultadoDespesas->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nome do Usuário</th><th>Descrição</th><th>Data</th><th>Valor</th><th>Tipo de Despesa</th></tr>";

            while ($rowDespesas = $resultadoDespesas->fetch_assoc()) {
                echo "<tr><td>{$rowDespesas['id']}</td><td>{$rowDespesas['nome_usuario']}</td><td>{$rowDespesas['descricao']}</td><td>{$rowDespesas['data']}</td><td>{$rowDespesas['valor']}</td><td>{$rowDespesas['tipo_despesa']}</td></tr>";
            }

            echo "</table>";
        } else {
            echo "Nenhum registro encontrado na tabela despesas.";
        }

        // Calcular a soma do credito na tabela despesas
 $consulcredito = "SELECT SUM(transferencia) AS credito FROM despesas";
 $resulcredito = $conn->query($consulcredito);

 if ($resulcredito->num_rows > 0) {
     $row = $resulcredito->fetch_assoc();
     $credito = $row['credito'];
     echo "<b><br>Credito R$: $credito";
 } else {
     echo "<br>Nenhuma despesa encontrada." . $conn->error;
 }
 

// Calcular a soma do valor de saida na tabela despesas
$consulsaida = "SELECT SUM(valor) AS saida FROM despesas";
$resulsaida = $conn->query($consulsaida);

if ($resulsaida->num_rows > 0) {
    $row = $resulsaida->fetch_assoc();
    $saida = $row['saida'];
    echo "<b><br>Saida R$: $saida";
} else {
    echo "<br>Nenhuma despesa encontrada." . $conn->error;
}

// Calcular a soma da diferença entre transferencia e valor na tabela despesas
$consultaSoma = "SELECT SUM(transferencia - valor) AS saldo FROM despesas";
$resultadoSoma = $conn->query($consultaSoma);

if ($resultadoSoma->num_rows > 0) {
    $row = $resultadoSoma->fetch_assoc();
    $saldo = $row['saldo'];
    echo "<b><br>Saldo:R$ $saldo ";
} else {
    echo "<br>Nenhuma despesa encontrada.";
}

        // Fechar a conexão
        $conn->close();
        ?>

        <br><a href="index.html"><button class="botao">Voltar</button></a>
        <form action="exportar_despesas.php" method="post">
            <button class="botao" name="exportarPDF" value="Exportar para PDF">Imprimir</button>
        </form>
    </div>
</body>
</html>

