<?php
session_start();
include '../config/conexao.php';

// Buscar produtos e estoques
$produtos = $conn->query("SELECT * FROM produtos");
$estoques = $conn->query("SELECT * FROM estoque");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home | Cadastro de Produtos</title>
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
    <p><a href="cupons.php">➕ Cadastrar novo cupom</a></p>

    <h2>Cadastrar Produto</h2>
    <form action="salvar_produto.php" method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Preço:</label><br>
        <input type="number" step="0.01" name="preco" required><br><br>

        <label>Variação (ex: tamanho M, cor azul):</label><br>
        <input type="text" name="variacao"><br><br>

        <label>Quantidade em estoque:</label><br>
        <input type="number" name="quantidade" required><br><br>

        <button type="submit">Salvar</button>
    </form>

    <hr>

    <h2>Produtos Cadastrados</h2>
    <ul>
        <?php while ($p = $produtos->fetch_assoc()): ?>
            <li>
                <strong><?= $p['nome'] ?></strong> — R$<?= number_format($p['preco'], 2, ',', '.') ?>
                <ul>
                    <?php
                    $id = $p['id'];
                    $subestoque = $conn->query("SELECT * FROM estoque WHERE produto_id = $id");
                    while ($e = $subestoque->fetch_assoc()):
                    ?>
                        <li>
                            Variação: <?= $e['variacao'] ?> | Quantidade: <?= $e['quantidade'] ?>
                            <form action="atualizar_produto.php" method="post" style="margin-top: 5px;">
                                <input type="hidden" name="produto_id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="estoque_id" value="<?= $e['id'] ?>">

                                Nome: <input type="text" name="nome" value="<?= $p['nome'] ?>" required>
                                Preço: <input type="number" step="0.01" name="preco" value="<?= $p['preco'] ?>" required>
                                Variação: <input type="text" name="variacao" value="<?= $e['variacao'] ?>">
                                Quantidade: <input type="number" name="quantidade" value="<?= $e['quantidade'] ?>" required>
                                <button type="submit">Atualizar</button>
                            </form>

                            <!-- Formulário de Compra -->
                            <form action="adicionar_carrinho.php" method="post" style="margin-top: 5px;">
                                <input type="hidden" name="produto_id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="estoque_id" value="<?= $e['id'] ?>">
                                <input type="hidden" name="nome" value="<?= $p['nome'] ?>">
                                <input type="hidden" name="variacao" value="<?= $e['variacao'] ?>">
                                <input type="hidden" name="preco" value="<?= $p['preco'] ?>">

                                <label>Qtd:</label>
                                <input type="number" name="quantidade" value="1" min="1" max="<?= $e['quantidade'] ?>" required>
                                <button type="submit">Comprar</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>
        <?php endwhile; ?>
    </ul>

    <hr>

    <h2>Carrinho</h2>
    <?php
    $total = 0;

    if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
        <ul>
            <?php foreach ($_SESSION['carrinho'] as $item): 
                $subtotal = $item['preco'] * $item['quantidade'];
                $total += $subtotal;
            ?>
                <li>
                    <?= $item['nome'] ?> (<?= $item['variacao'] ?>) - <?= $item['quantidade'] ?> x R$<?= number_format($item['preco'], 2, ',', '.') ?>
                    = R$<?= number_format($subtotal, 2, ',', '.') ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <form action="aplicar_cupom.php" method="post">
            <label>Cupom de Desconto:</label>
            <input type="text" name="codigo_cupom" required>
            <button type="submit">Aplicar Cupom</button>
        </form>

        <?php
        if (isset($_SESSION['mensagem_cupom'])) {
            echo "<p style='color: red;'>{$_SESSION['mensagem_cupom']}</p>";
            unset($_SESSION['mensagem_cupom']);
        }

        if (isset($_SESSION['desconto_aplicado'])) {
            $desconto = $_SESSION['desconto_aplicado'];
            $desconto_valor = ($total * $desconto) / 100;
            $total -= $desconto_valor;
            echo "<p><strong>Desconto aplicado:</strong> -R$" . number_format($desconto_valor, 2, ',', '.') . "</p>";
        }

        // Calcular frete
        if ($total > 200) {
            $frete = 0;
        } elseif ($total >= 52 && $total <= 166.59) {
            $frete = 15;
        } else {
            $frete = 20;
        }

        $total_com_frete = $total + $frete;
        ?>

        <p><strong>Subtotal:</strong> R$<?= number_format($total, 2, ',', '.') ?></p>
        <p><strong>Frete:</strong> R$<?= number_format($frete, 2, ',', '.') ?></p>
        <p><strong>Total com frete:</strong> R$<?= number_format($total_com_frete, 2, ',', '.') ?></p>

        <form action="limpar_carrinho.php" method="post">
            <button type="submit">Esvaziar Carrinho</button>
        </form>
    <?php else: ?>
        <p>Carrinho vazio.</p>
    <?php endif; ?>

    <hr>

    <h2>Verificar Endereço pelo CEP</h2>
    <form onsubmit="event.preventDefault(); buscarEndereco();">
        <label>CEP:</label>
        <input type="text" id="cep" placeholder="Digite o CEP" required>
        <button type="submit">Buscar</button>
    </form>

    <div id="resultado-cep" style="margin-top: 15px;"></div>

    <form action="enviar_email.php" method="post">
        <label>Seu e-mail:</label>
        <input type="email" name="email" required>
        <button type="submit">Receber Boas-vindas</button>
    </form>

    <script>
    function buscarEndereco() {
        const cep = document.getElementById('cep').value.replace(/\D/g, '');

        if (cep.length !== 8) {
            alert('CEP inválido. Deve ter 8 dígitos.');
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    document.getElementById('resultado-cep').innerHTML = '<p style="color: red;">CEP não encontrado.</p>';
                } else {
                    document.getElementById('resultado-cep').innerHTML = `
                        <p><strong>Endereço:</strong> ${data.logradouro}</p>
                        <p><strong>Bairro:</strong> ${data.bairro}</p>
                        <p><strong>Cidade:</strong> ${data.localidade} - ${data.uf}</p>
                    `;
                }
            })
            .catch(error => {
                console.error('Erro ao buscar o CEP:', error);
                document.getElementById('resultado-cep').innerHTML = '<p style="color: red;">Erro ao buscar o CEP.</p>';
            });
    }
    </script>
</body>
</html>
