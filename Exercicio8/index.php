<?php
require_once 'conexao.php';

$status_conexao = $pdo ? "Conectado ao PostgreSQL com sucesso!" : "Falha na conexão.";

$imc = null;
$classificacao = '';
$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $peso = isset($_POST['peso']) ? str_replace(',', '.', $_POST['peso']) : 0;
    $altura = isset($_POST['altura']) ? str_replace(',', '.', $_POST['altura']) : 0;

    if (is_numeric($peso) && is_numeric($altura) && $peso > 0 && $altura > 0) {
        
        $imc_calculado = $peso / ($altura * $altura);
        
        $imc = number_format($imc_calculado, 2, ',', '.');

        if ($imc_calculado < 18.5) {
            $classificacao = "Abaixo do peso";
        } elseif ($imc_calculado >= 18.5 && $imc_calculado <= 24.9) {
            $classificacao = "Peso normal";
        } elseif ($imc_calculado >= 25 && $imc_calculado <= 29.9) {
            $classificacao = "Sobrepeso";
        } elseif ($imc_calculado >= 30 && $imc_calculado <= 34.9) {
            $classificacao = "Obesidade Grau I";
        } elseif ($imc_calculado >= 35 && $imc_calculado <= 39.9) {
            $classificacao = "Obesidade Grau II";
        } else {
            $classificacao = "Obesidade Grau III";
        }

        try {
            $sql = "INSERT INTO calculos_imc (peso, altura, imc, classificacao) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$peso, $altura, $imc_calculado, $classificacao]);
        } catch (PDOException $e) {
            $erro = "Erro ao salvar os dados: " . $e->getMessage();
        }

    } else {
        $erro = "Por favor, insira valores válidos e positivos para peso e altura.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC</title>
    <style>
    
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #1e3a8a; 
            margin-bottom: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .input-group {
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input[type="text"] {
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        button {
            padding: 0.8rem;
            font-size: 1.1rem;
            font-weight: bold;
            color: #ffffff;
            background-color: #1e3a8a;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #2563eb; 
        }
        #resultado {
            margin-top: 2rem;
            padding: 1.5rem;
            border-radius: 5px;
            background-color: #eef2ff; 
            border: 1px solid #c7d2fe;
        }
        #resultado p {
            margin: 0.5rem 0;
            font-size: 1.2rem;
        }
        #resultado .valor-imc {
            font-weight: bold;
            font-size: 1.5rem;
            color: #1e3a8a;
        }
        .erro {
            color: #dc2626;
            font-weight: bold;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Calculadora de IMC</h1>
        <p>Índice de Massa Corporal</p>

        <form action="index.php" method="POST">
            <div class="input-group">
                <label for="peso">Seu Peso (kg)</label>
                <input type="text" id="peso" name="peso" placeholder="Ex: 70,5" required value="<?php echo isset($_POST['peso']) ? htmlspecialchars($_POST['peso']) : ''; ?>">
            </div>
            
            <div class="input-group">
                <label for="altura">Sua Altura (m)</label>
                <input type="text" id="altura" name="altura" placeholder="Ex: 1,75" required value="<?php echo isset($_POST['altura']) ? htmlspecialchars($_POST['altura']) : ''; ?>">
            </div>
            
            <button type="submit">Calcular</button>
        </form>

        <?php
      
        if (!empty($erro)) {
            echo "<p class='erro'>$erro</p>";
        }

        if ($imc !== null) {
            echo "<div id='resultado'>";
            echo "<p>Seu IMC é:</p>";
            echo "<p class='valor-imc'>$imc</p>";
            echo "<p>Classificação: <strong>$classificacao</strong></p>";
            echo "</div>";
        }
        ?>
    </div>

</body>
</html>