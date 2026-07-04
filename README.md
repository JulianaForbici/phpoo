# phpoo

![PHP Programando com Orientação a Objetos](https://m.media-amazon.com/images/I/61v7DQ6hY7L._AC_UF1000,1000_QL80_.jpg)

## Sobre o projeto

Esse repositório contém uma aplicação desenvolvida com base no livro **PHP Programando com Orientação a Objetos - 4ª edição**, de **Pablo Dall'Oglio**.

O objetivo do projeto é estudar e aplicar conceitos de **Programação Orientada a Objetos em PHP**, incluindo organização de classes, conexão com banco de dados, persistência de dados, camadas da aplicação e boas práticas de estruturação de código.

## Tecnologias utilizadas

* PHP
* PostgreSQL
* Composer
* HTML
* CSS
* Bootstrap
* PhpStorm

## Objetivo de estudo

Este projeto foi criado com fins de aprendizado, acompanhando os exemplos e conceitos apresentados no livro.

Durante o desenvolvimento, são praticados conceitos como:

* Classes e objetos
* Encapsulamento
* Herança
* Métodos mágicos
* Active Record
* Repository
* Transactions
* Conexão com banco de dados via PDO
* Organização de diretórios
* Separação entre camadas da aplicação

## Estrutura do projeto

```text
phpoo/
├── App/
│   ├── Config/
│   ├── Control/
│   ├── Database/
│   ├── Model/
│   ├── Resources/
│   ├── Services/
│   └── Templates/
├── Lib/
│   └── Livro/
├── vendor/
├── composer.json
├── command-line.php
├── index.php
└── README.md
```

## Configuração do banco de dados

O projeto utiliza PostgreSQL.

Exemplo de configuração no arquivo:

```text
App/Config/livro.ini
```

```ini
host = localhost
name = livro
user = postgres
pass = postgres
type = pgsql
port = 5432
```

## Instalação

Clone o repositório:

```bash
git clone <url-do-repositorio>
```

Acesse a pasta do projeto:

```bash
cd phpoo
```

Instale as dependências com Composer:

```bash
composer install
```

## Executando o projeto

Para testar pelo terminal:

```bash
php command-line.php
```

Para rodar a aplicação no navegador:

```bash
php -S localhost:8000
```

Depois acesse:

```text
http://localhost:8000
```

## Dependências

O projeto utiliza algumas bibliotecas instaladas via Composer, como:

* `dompdf/dompdf`
* `bacon/bacon-qr-code`
* `picqer/php-barcode-generator`
* `twig/twig`

## Observação

Este projeto é voltado para estudo e prática dos conceitos apresentados no livro. Algumas implementações podem seguir o padrão didático da obra, com foco em aprendizado e compreensão da base da orientação a objetos em PHP.

## Referência

Livro: **PHP Programando com Orientação a Objetos - 4ª edição**
Autor: **Pablo Dall'Oglio**
