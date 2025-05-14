<?php
session_start();

$produto_id = $_POST['produto_id'];
$estoque_id = $_POST['estoque_id'];
$nome = $_POST['nome'];
$variacao = $_POST['variacao'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];

$item = [
    'produto_id' => $produto_id,
    'estoque_id' => $estoque_id,
    'nome' => $nome,
    'variacao' => $variacao,
    'preco' => $preco,
    'quantidade' => $quantidade
];

// Iniciar carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona ao carrinho (poderia melhorar para somar quantidades se for o mesmo item)
$_SESSION['carrinho'][] = $item;

header("Location: index.php");
exit();
