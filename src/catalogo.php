<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
        
    <!-- CSS -->
    <link rel="stylesheet" href="css/catalogo.css">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include "_header.php"; ?>

    <main>
        <div id="catalogo">
            <div id="catalogo-fs">
                <h1>Catálogo</h1>
                <div id="catalogo-fs-produtos">
                    <?php
                        $sql = "SELECT * FROM produtos";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='produto'>";
                            echo "<img src='img/produtos/" . $row['img'] . "' alt='" . $row['nome'] . "'>";
                            echo "<h2>" . $row['nome'] . "</h2>";
                            echo "<p>" . $row['descricao'] . "</p>";
                            echo "<p>R$ " . $row['preco'] . "</p>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>