<?php

require 'vendor/autoload.php';

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;

// Dados do pagador (Cliente)
$pagador = new Agente(
    'Nome do Cliente',
    '123.456.789-00',
    'Endereço do Cliente',
    'Cidade',
    'UF',
    '12345-678'
);

// Dados do beneficiário (Empresa)
$beneficiario = new Agente(
    'Minha Empresa LTDA',
    '12.345.678/0001-00',
    'Endereço da Empresa',
    'Cidade',
    'UF',
    '12345-678'
);

// Gerar o boleto do Bradesco
$boleto = new Bradesco(array(
    // Número de identificação do boleto
    'dataVencimento' => new DateTime('2024-10-01'),
    'valor' => 150.00,
    'sequencial' => 1234567,
    'sacado' => $pagador,
    'cedente' => $beneficiario,
    'agencia' => '1234',
    'carteira' => '09',
    'conta' => '12345',
    'contaDv' => '6',
    'descricaoDemonstrativo' => ['Compra de produtos'],
    'instrucoes' => [
        'Após o vencimento, cobrar 2% de multa e 1% de juros ao mês.',
        'Não receber após 30 dias do vencimento.',
    ],
));

echo $boleto->getOutput();
