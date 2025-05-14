<?php
include '../config/conexao.php';

$produto_id = $_POST['produto_id'];
$estoque_id = $_POST['estoque_id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$variacao = $_POST['variacao'];
$quantidade = $_POST['quantidade'];

// Atualizar produto
$stmt = $conn->prepare("UPDATE produtos SET nome = ?, preco = ? WHERE id = ?");
$stmt->bind_param("sdi", $nome, $preco, $produto_id);
$stmt->execute();

// Atualizar estoque
$stmt2 = $conn->prepare("UPDATE estoque SET variacao = ?, quantidade = ? WHERE id = ?");
$stmt2->bind_param("sii", $variacao, $quantidade, $estoque_id);
$stmt2->execute();

$conn->close();
header("Location: index.php");
exit();
