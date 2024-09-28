<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Boleto Bradesco</title>
</head>
<body>
    <h1>Gerar Boleto Bradesco</h1>
    
    <!-- Botão para gerar o boleto -->
    <form action="bradesco_boleto.php" method="post">
        <input type="hidden" name="id" value="12345"> <!-- ID do lançamento -->
        <button type="submit">Gerar Boleto Bradesco</button>
    </form>
</body>
</html>
