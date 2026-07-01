<?php

$pdo = new PDO(
    'pgsql:host=localhost;port=5432;dbname=livro',
    'postgres',
    'postgres'
);

echo 'teste de conexão';