<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        
        <!-- CSS -->
        <link rel="stylesheet" href="css/login.css">
    
        <!-- Fontes -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
        <!-- JavaScript -->
        <script src="js/upload_arq.js" defer></script>
    </head>
    <body>
        <?php include "header.html"; ?>
    
        <main>
            <form enctype="multipart/form-data" action="_tui.php" method="post">
                <h1 id>Login</h1>
                
                <fieldset id="dados-fs">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/> <!-- 1MB -->
                    <input type="file" name="arquivo" accept="image/png, image/jpeg" required>
                </fieldset>
                <fieldset id="botoes">
                    <input type="submit" class="botao" value="Logar">
                </fieldset>
            </form>
        </main>
    </body>
</html>