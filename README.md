# 🛒 Sistema de Loja Virtual com Cupons e Carrinho

Este projeto é um sistema de loja virtual desenvolvido em PHP com estrutura de pastas organizada por **MVC** (Model-View-Controller). O sistema simula a compra de produtos com carrinho de compras, aplicação de cupons de desconto, cálculo de frete por CEP e envio de email com confirmação da compra.

## 📁 Estrutura de Pastas
```
/loja
├── assets/ # Arquivos estáticos (CSS, JS, imagens)
├── config/ # Configurações e conexões com o banco de dados
│ └── conexao.php
├── controllers/ # Controladores (em breve)
├── models/ # Lógica de negócio (funções PHP)
│ └── cupons.php
├── pages/ # Telas (interfaces) do sistema)
│ ├── index.php
│ ├── cupons.php
│ ├── produtos.php
│ ├── cliente.php
│ └── compra.php
└── SQL/ # Scripts de banco de dados
```
## 🖥️ Telas do Sistema

### • Tela de Cupons
- 📄 **Arquivo:** `pages/cupons.php`
- 🔧 Funções:
  - Criar cupons com validade e valor de desconto
  - Listar todos os cupons cadastrados

### • Tela de Produtos
- 📄 **Arquivo:** `pages/produtos.php`
- 🔧 Funções:
  - Cadastro de novos produtos
  - Edição de produtos existentes

### • Tela do Cliente
- 📄 **Arquivo:** `pages/cliente.php`
- 🔧 Funções:
  - Exibição dos produtos disponíveis
  - Adição ao carrinho de compras

### • Tela de Compra
- 📄 **Arquivo:** `pages/compra.php`
- 🔧 Funções:
  - Confirmação do pedido
  - Formulário com:
    - CEP (para verificar endereço)
    - Email (para envio da confirmação)
    - Campo para aplicar cupom de desconto
  - Envio de email com:
    - Lista dos produtos comprados
    - Valor total da compra
    - Agradecimento pela preferência

## 🔧 Tecnologias Utilizadas

- **PHP 8.2**
- **Apache (XAMPP)**
- **MySQL**
- **HTML5 & CSS3**
- **JavaScript (em breve)**
- **PHPMailer** (para envio de email)

## 📬 Funcionalidade Extra

- Integração com API de CEP (ex: ViaCEP) para buscar o endereço
- Sistema de cupons com validade e valor de desconto
- Envio de email de confirmação usando PHPMailer

## 🚧 Melhorias Futuras

- Autenticação de usuário
- Painel administrativo
- Histórico de compras
- Upload de imagens para produtos
