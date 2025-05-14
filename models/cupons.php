<?php
include '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $desconto = $_POST['desconto_percentual'];
    $validade = $_POST['validade'];
    $subtotal_minimo = $_POST['subtotal_minimo'];

    $stmt = $conn->prepare("INSERT INTO cupons (codigo, desconto_percentual, validade, subtotal_minimo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsd", $codigo, $desconto, $validade, $subtotal_minimo);
    $stmt->execute();
    echo "<p>Cupom cadastrado com sucesso!</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
    <h2 style="margin: 0;">Cadastrar Cupom</h2>
    <form method="post">
        Código: <input type="text" name="codigo" required><br>
        Desconto (%): <input type="number" name="desconto_percentual" step="0.01" required><br>
        Validade: <input type="date" name="validade" required><br>
        Subtotal Mínimo: <input type="number" name="subtotal_minimo" step="0.01" required><br>
        <button type="submit">Salvar Cupom</button>
    </form>
    <a href="../views/index.php" style="text-decoration: none;"><button type="button">Voltar</button></a>


    

    <!-- lista com os cupons -->
    <?php
    $cupons = $conn->query("SELECT * FROM cupons ORDER BY validade ASC");
    ?>
    
    <h3>Cupons Cadastrados</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Código</th>
            <th>Desconto (%)</th>
            <th>Validade</th>
            <th>Subtotal Mínimo</th>
        </tr>
        <?php while ($c = $cupons->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($c['codigo']) ?></td>
                <td><?= $c['desconto_percentual'] ?>%</td>
                <td><?= date('d/m/Y', strtotime($c['validade'])) ?></td>
                <td>R$<?= number_format($c['subtotal_minimo'], 2, ',', '.') ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
