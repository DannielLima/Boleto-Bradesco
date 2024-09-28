<?php

require 'vendor/autoload.php';

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;

// Dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$valor = $_POST['valor'];
$vencimento = $_POST['vencimento'];

// Criando o pagador (Cliente)
$pagador = new Agente(
    $nome,
    $cpf,
    $endereco,
    $cidade,
    $estado,
    $cep
);

// Criando o beneficiário (Empresa)
$beneficiario = new Agente(
    'Minha Empresa LTDA',
    '12.345.678/0001-00',
    'Rua Exemplo, 123',
    'Cidade',
    'UF',
    '12345-678'
);

// Configuração e geração do boleto do Bradesco
$boleto = new Bradesco(array(
    'dataVencimento' => new DateTime($vencimento),
    'valor' => (float)$valor,
    'sequencial' => 1234567,
    'sacado' => $pagador,
    'cedente' => $beneficiario,
    'agencia' => '1234',
    'carteira' => '09',
    'conta' => '12345',
    'contaDv' => '6',
    'descricaoDemonstrativo' => ['Compra de produtos ou serviços'],
    'instrucoes' => [
        'Após o vencimento, cobrar 2% de multa e 1% de juros ao mês.',
        'Não receber após 30 dias do vencimento.',
    ],
));

echo $boleto->getOutput();
