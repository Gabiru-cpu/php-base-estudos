<?php
session_start();
include '../config/conexao.php';

$codigo = strtoupper(trim($_POST['codigo_cupom']));
$hoje = date('Y-m-d');

// Buscar cupom
$stmt = $conn->prepare("SELECT * FROM cupons WHERE UPPER(codigo) = ?");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();
$cupom = $result->fetch_assoc();

if (!$cupom) {
    $_SESSION['mensagem_cupom'] = "Cupom inválido.";
} elseif ($cupom['validade'] < $hoje) {
    $_SESSION['mensagem_cupom'] = "Cupom expirado.";
} else {
    // Calcular subtotal do carrinho
    $subtotal = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
    }

    if ($subtotal < $cupom['subtotal_minimo']) {
        $faltando = $cupom['subtotal_minimo'] - $subtotal;
        $_SESSION['mensagem_cupom'] = "Você precisa comprar mais R$" . number_format($faltando, 2, ',', '.') . " para usar este cupom.";
    } else {
        $_SESSION['desconto_aplicado'] = $cupom['desconto_percentual'];
        $_SESSION['mensagem_cupom'] = "Cupom aplicado com sucesso!";
    }
}

header("Location: index.php");
exit;
