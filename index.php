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
    </style>
</head>

<body>
    <h1>Gerar Boleto Bradesco</h1>

    <form action="bradesco_boleto.php" method="post">
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