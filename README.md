# Projeto Final - Website 
Implementação de uma plataforma de doações online, realizada para o Projeto Final do Curso Técnico em Informática do Instituto Ivoti, no ano de 2022.

Com essa plataforma, buscamos permitir com que instituições de caridade ou brechós locais tenham um contato mais direto com pessoas em necessidade, facilitando com que estas tenham acesso à peças de roupa e tenham uma maior variedade de peças para escolher. Queremos dar a esse grupo a possibilidade de encontrar as peças que se adequem melhor a eles, removendo a ideia presente na mente de muitos brasileiros de que "qualquer coisa" é suficiente para os grupos mais necessitados.

## Tecnologias utilizadas
### Back end
- MySQL v8.0.29
- PHP v8.1.6
- XAMPP v3.3.0 / Apache Server
### Front end
- Javascript (vanilla)
- Sass (compilado por meio do [Live Sass Compiler](https://github.com/glenn2223/vscode-live-sass-compiler))
- HTML5

## Execução local
### Requisitos
- Apache server (XAMPP ou outro)
- MySQL (instalado separadamente, pelo XAMPP ou outro)
- Compilador Sass (por meio de extensões de IDEs como Live Sass Compiler ou outro método*)

\* Nesse caso, os arquivos podem ser compilados executando `sass --update src/sass:src/css` na raiz do repositório

### Instalação
O banco de dados pode ser inicializado executando o script `criar_database.sql`. As informações de acesso do MySQL (usuário, senha, host e banco), assim como uma chave da [API do Google Maps Embed](https://console.cloud.google.com/marketplace/product/google/maps-embed-backend.googleapis.com) devem ser armazenadas em um arquivo nomeado `.env` na raiz do repositório:
```
DB_ENDERECO="localhost"
DB_USUARIO="<USUARIO>"
DB_SENHA="<SENHA>"
DB_BANCO="projeto_ms"
MAPS_API="<CHAVE>"
```

Caso o XAMPP seja utilizado para a execução do servidor, o repositório poderá ser clonado diretamente para a pasta `htdocs/` dentro da instalação do XAMPP, e o site poderá ser acessado em `localhost:8000/projetoFinalWebsite/` (a porta deve estar livre e configurada corretamente).

Os arquivos Sass devem ser compilados pelos métodos descritos acima antes do site ser acessado.

## Funcionalidades ainda não implementadas
- Edição do perfil do fornecedor
- Modo responsivo para usuários mobile
- Opções de acessibilidade
- Ativação de contas de fornecedores via E-mail
- Reporte de fornecedores e/ou peças
- Limitação no número de reservas por dispositivo, CPF ou endereço IP
- Invalidação de reservas após um período de tempo
- Confirmação de que a peça foi entregue
