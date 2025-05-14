<?php
include '../config/conexao.php';

$nome = $_POST['nome'];
$preco = $_POST['preco'];
$variacao = $_POST['variacao'];
$quantidade = $_POST['quantidade'];

// Inserir produto
$stmt = $conn->prepare("INSERT INTO produtos (nome, preco) VALUES (?, ?)");
$stmt->bind_param("sd", $nome, $preco);
$stmt->execute();
$produto_id = $stmt->insert_id;

// Inserir estoque
$stmt2 = $conn->prepare("INSERT INTO estoque (produto_id, variacao, quantidade) VALUES (?, ?, ?)");
$stmt2->bind_param("isi", $produto_id, $variacao, $quantidade);
$stmt2->execute();

$conn->close();
header("Location: index.php");
exit();
