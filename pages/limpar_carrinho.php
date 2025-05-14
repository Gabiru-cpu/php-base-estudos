<?php
session_start();

// Esvaziar carrinho
unset($_SESSION['carrinho']);

// Remover cupom e mensagem
unset($_SESSION['desconto_aplicado']);
unset($_SESSION['mensagem_cupom']);

header('Location: index.php');
exit;
