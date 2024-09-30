<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto Bradesco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            padding: 20px;
            max-width: 800px;
        }

        label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .error {
            color: red;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(event) {
                if (!validarFormulario()) {
                    event.preventDefault(); // Impede o envio do formulário se houver erros
                }
            });

            function validarFormulario() {
                const cpf = document.getElementById('cpf').value;
                const valor = parseFloat(document.getElementById('valor').value);
                const vencimento = document.getElementById('vencimento').value;
                const dataAtual = new Date().toISOString().split('T')[0];

                if (!validarCPF(cpf)) {
                    alert("CPF/CNPJ inválido!");
                    return false;
                }

                if (valor <= 0) {
                    alert("O valor do boleto deve ser maior que zero!");
                    return false;
                }

                if (vencimento < dataAtual) {
                    alert("A data de vencimento deve ser posterior à data atual!");
                    return false;
                }

                return true;
            }

            function validarCPF(cpf) {
                cpf = cpf.replace(/[^\d]+/g, '');

                if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
                    return false;
                }

                return validarDigitosCPF(cpf);
            }

            function validarDigitosCPF(cpf) {
                const primeiroDigito = calcularDigito(cpf, 9);
                const segundoDigito = calcularDigito(cpf, 10);

                return (
                    primeiroDigito === parseInt(cpf.charAt(9)) &&
                    segundoDigito === parseInt(cpf.charAt(10))
                );
            }

            function calcularDigito(cpf, tamanho) {
                let soma = 0;
                for (let i = 0; i < tamanho; i++) {
                    soma += parseInt(cpf.charAt(i)) * (tamanho + 1 - i);
                }
                let resto = soma % 11;
                return resto < 2 ? 0 : 11 - resto;
            }
        });
    </script>
</head>

<body>
    <h1>Gerar Boleto Bradesco</h1>

    <form action="bradesco_boleto.php" method="post">
        <!-- Dados do Cliente -->
        <?php echo renderInput('Nome do Cliente', 'nome', 'text', true); ?>
        <?php echo renderInput('CPF/CNPJ', 'cpf', 'text', true); ?>
        <?php echo renderInput('Email', 'email', 'email', true); ?>
        <?php echo renderInput('Telefone', 'telefone', 'tel', true); ?>
        <?php echo renderInput('Endereço', 'endereco', 'text', true); ?>
        <?php echo renderInput('Cidade', 'cidade', 'text', true); ?>
        <?php echo renderInput('Estado (UF)', 'estado', 'text', true, 2); ?>
        <?php echo renderInput('CEP', 'cep', 'text', true); ?>

        <!-- Dados do Boleto -->
        <?php echo renderInput('Valor do Boleto (R$)', 'valor', 'number', true, null, 'step="0.01"'); ?>
        <?php echo renderInput('Data de Vencimento', 'vencimento', 'date', true); ?>

        <button type="submit">Gerar Boleto</button>
    </form>
</body>

</html>

<?php
function renderInput($label, $name, $type = 'text', $required = false, $maxlength = null, $additionalAttributes = '')
{
    $requiredAttr = $required ? 'required' : '';
    $maxlengthAttr = $maxlength ? "maxlength=\"$maxlength\"" : '';

    return "
        <div class=\"form-group\">
            <label for=\"$name\">$label:</label>
            <input type=\"$type\" id=\"$name\" name=\"$name\" $requiredAttr $maxlengthAttr $additionalAttributes>
        </div>
    ";
}
?>