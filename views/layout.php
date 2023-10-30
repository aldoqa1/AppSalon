<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="6 proyecto de prueba">
    <link rel="preload" href="/build/css/app.css" as="style">
    <link rel="stylesheet" href="/build/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <title>BarberShop</title>

</head>
<body>

    <div class="container-app">

        <div class="image"></div>

        <div class="app">
            <?php echo $content; ?>
        </div>

    </div>

    <?php
        echo $script ?? '';
    ?>

</body>
</html>