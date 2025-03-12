<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejemplo 2 de POO en php</title>
</head>
<body>
    <?php
    require_once __DIR__.'/menu.php';

    $menu1 = new Menu();
    $menu1->cargar_opcion('http://www.facebook.com','facebook');
    $menu1->cargar_opcion('http://www.twitter.com','twitter');
    $menu1->cargar_opcion('http://www.instagram.com','instagram');
    $menu1->mostrar();





?>

</body>
</html>