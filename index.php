<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Boleto Bradesco</title>
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
        function validarFormulario() {
            let cpf = document.getElementById('cpf').value;
            let valor = document.getElementById('valor').value;
            let vencimento = document.getElementById('vencimento').value;
            let dataAtual = new Date().toISOString().split('T')[0];

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
            let soma = 0, resto;
            for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
            resto = (soma * 10) % 11;
            if (resto === 10 || resto === 11) resto = 0;
            if (resto !== parseInt(cpf.substring(9, 10))) return false;

            soma = 0;
            for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
            resto = (soma * 10) % 11;
            if (resto === 10 || resto === 11) resto = 0;
            return resto === parseInt(cpf.substring(10, 11));
        }
    </script>
</head>
<body>
    <h1>Gerar Boleto Bradesco</h1>

    <form action="bradesco_boleto.php" method="post" onsubmit="return validarFormulario();">
        <!-- Dados do Cliente -->
        <div class="form-group">
            <label for="nome">Nome do Cliente:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF/CNPJ:</label>
            <input type="text" id="cpf" name="cpf" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required>
        </div>

        <div class="form-group">
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>
        </div>

        <div class="form-group">
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado (UF):</label>
            <input type="text" id="estado" name="estado" maxlength="2" required>
        </div>

        <div class="form-group">
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required>
        </div>

        <!-- Dados do Boleto -->
        <div class="form-group">
            <label for="valor">Valor do Boleto (R$):</label>
            <input type="number" id="valor" name="valor" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="vencimento">Data de Vencimento:</label>
            <input type="date" id="vencimento" name="vencimento" required>
        </div>

        <button type="submit">Gerar Boleto Bradesco</button>
    </form>
</body>
</html>
