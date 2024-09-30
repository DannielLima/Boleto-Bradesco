<?php

require 'vendor/autoload.php';

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;
use Dompdf\Dompdf;

/**
 * Valida o CPF
 * 
 * @param string $cpf CPF a ser validado
 * @return bool Retorna true se o CPF for válido, caso contrário, false
 */
function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica o tamanho e se é uma sequência repetida
    if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Valida os dois dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;

        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

/**
 * Valida os dados do formulário
 * 
 * @param array $dados Dados do formulário
 * @return void Retorna erro e finaliza o script caso algum dado seja inválido
 */
function validarFormulario($dados)
{
    if (!validarCPF($dados['cpf'])) {
        die("CPF inválido.");
    }

    if ($dados['valor'] <= 0) {
        die("O valor do boleto deve ser maior que zero.");
    }

    if ($dados['vencimento'] < date('Y-m-d')) {
        die("A data de vencimento deve ser posterior à data atual.");
    }
}

/**
 * Cria um objeto do tipo Agente (cliente ou beneficiário)
 * 
 * @param array $dados Dados para a criação do agente
 * @return Agente
 */
function criarAgente($dados)
{
    return new Agente(
        $dados['nome'],
        $dados['cpf'],
        $dados['endereco'],
        $dados['cidade'],
        $dados['estado'],
        $dados['cep']
    );
}

/**
 * Gera o HTML do boleto
 * 
 * @param Bradesco $boleto Instância do boleto
 * @return string HTML do boleto
 */
function gerarHtmlBoleto($boleto)
{
    return '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto Bradesco</title>
</head>
<body>' . $boleto->getOutput() . '</body>
</html>';
}

/**
 * Gera o PDF do boleto e o exibe no navegador
 * 
 * @param string $html HTML do boleto
 * @return void
 */
function gerarPdfBoleto($html)
{
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("boleto_bradesco.pdf", array("Attachment" => false));
}

// Dados do formulário
$dadosFormulario = [
    'nome'       => $_POST['nome'],
    'cpf'        => $_POST['cpf'],
    'email'      => $_POST['email'],
    'telefone'   => $_POST['telefone'],
    'endereco'   => $_POST['endereco'],
    'cidade'     => $_POST['cidade'],
    'estado'     => $_POST['estado'],
    'cep'        => $_POST['cep'],
    'valor'      => $_POST['valor'],
    'vencimento' => $_POST['vencimento']
];

// Validação dos campos em PHP
validarFormulario($dadosFormulario);

// Criando o pagador (Cliente)
$pagador = criarAgente($dadosFormulario);

// Criando o beneficiário (Empresa)
$beneficiario = criarAgente([
    'nome'     => 'Minha Empresa LTDA',
    'cpf'      => '12.345.678/0001-00',
    'endereco' => 'Rua Exemplo, 123',
    'cidade'   => 'Cidade',
    'estado'   => 'UF',
    'cep'      => '12345-678'
]);

// Configuração e geração do boleto do Bradesco
$boleto = new Bradesco([
    'dataVencimento' => new DateTime($dadosFormulario['vencimento']),
    'valor'          => (float) $dadosFormulario['valor'],
    'sequencial'     => 1234567,
    'sacado'         => $pagador,
    'cedente'        => $beneficiario,
    'agencia'        => 1234,
    'carteira'       => 06,
    'conta'          => 56789,
    'convenio'       => 123456,
]);

// Gerar HTML do boleto
$htmlBoleto = gerarHtmlBoleto($boleto);

// Geração do PDF
gerarPdfBoleto($htmlBoleto);
