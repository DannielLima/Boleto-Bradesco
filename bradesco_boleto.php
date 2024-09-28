<?php

require 'vendor/autoload.php';

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;
use Dompdf\Dompdf;

// Validações para garantir que os dados sejam válidos
function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

// Dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$valor = $_POST['valor'];
$vencimento = $_POST['vencimento'];

// Validação dos campos em PHP
if (!validarCPF($cpf)) {
    die("CPF inválido.");
}

if ($valor <= 0) {
    die("O valor do boleto deve ser maior que zero.");
}

if ($vencimento < date('Y-m-d')) {
    die("A data de vencimento deve ser posterior à data atual.");
}

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
    'agencia' => 1234,
    'carteira' => 06,
    'conta' => 56789,
    'convenio' => 123456,
));

// Gerar HTML do boleto
$htmlBoleto = '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto Bradesco</title>
</head>
<body>' . $boleto->getOutput() . '</body>
</html>';

// Geração do PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($htmlBoleto);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("boleto_bradesco.pdf", array("Attachment" => false));
