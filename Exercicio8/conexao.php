<?php
$env = parse_ini_file('.env');

$host = $env['DB_HOST'];
$port = $env['DB_PORT'];
$dbname = $env['DB_DATABASE'];
$user = $env['DB_USERNAME'];
$password = $env['DB_PASSWORD'];

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_create_table = "
    CREATE TABLE IF NOT EXISTS calculos_imc (
        id SERIAL PRIMARY KEY,
        peso NUMERIC(5, 2) NOT NULL,
        altura NUMERIC(3, 2) NOT NULL,
        imc NUMERIC(5, 2) NOT NULL,
        classificacao VARCHAR(50) NOT NULL,
        data_calculo TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
    );";

    $pdo->exec($sql_create_table);

} catch (PDOException $e) {

    die("Erro de banco de dados: " . $e->getMessage());
}
?>