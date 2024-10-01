
# Gerador de Boletos Bradesco

Este projeto é um gerador de boletos bancários para o Bradesco, utilizando a biblioteca OpenBoleto e o DomPDF para gerar boletos em PDF a partir de dados fornecidos pelo usuário via formulário. O projeto valida o CPF e os dados de pagamento antes de gerar o boleto.
## Funcionalidades

- **Validação de CPF.**
- **Geração de boletos bancários no formato Bradesco.**
- **Geração de PDFs de boletos com DomPDF.**
- **Validação de campos como valor e data de vencimento.**
## Tecnologias Utilizadas

- **PHP**: Linguagem principal do projeto.
- **OpenBoleto**: Biblioteca para geração de boletos bancários.
- **Dompdf**: Biblioteca para conversão de HTML em PDFs.
- **Composer**: Gerenciador de dependências para PHP.
## Instalação

#### Pré-requisitos

- **PHP** (versão 7.4 ou superior)
- **Composer** (para gerenciar dependências)

#### Passos

1. Clone este repositório para sua máquina local:

```bash
git clone https://github.com/DannielLima/Boleto-Bradesco.git
```

2. Navegue até o diretório do projeto:
```bash
cd gerador-boleto-bradesco
```

3. Instale as dependências do projeto:
```bash
composer install
```

4. Garanta que você tenha um servidor local configurado para rodar o PHP (ex: XAMPP, WAMP, Laragon, etc.).
## Utilização

1. Acesse a página do formulário onde os dados do boleto são fornecidos.

2. Preencha os campos obrigatórios:
- Nome
- CPF
- E-mail
- Telefone
- Endereço
- Cidade
- Estado
- CEP
- Valor
- Data de Vencimento

3. Clique em "Gerar Boleto".

4. O boleto será gerado e exibido no navegador em formato PDF.
## Exemplo de Formulário

```bash
<form action="bradesco_boleto.php" method="POST">
  <input type="text" name="nome" placeholder="Nome Completo" required />
  <input type="text" name="cpf" placeholder="CPF" required />
  <input type="text" name="endereco" placeholder="Endereço" required />
  <input type="text" name="cidade" placeholder="Cidade" required />
  <input type="text" name="estado" placeholder="Estado" required />
  <input type="text" name="cep" placeholder="CEP" required />
  <input type="number" name="valor" placeholder="Valor do Boleto" required />
  <input type="date" name="vencimento" placeholder="Data de Vencimento" required />
  <button type="submit">Gerar Boleto</button>
</form>
```


## Contribuindo

Sinta-se à vontade para abrir issues e pull requests para sugerir melhorias ou reportar problemas.