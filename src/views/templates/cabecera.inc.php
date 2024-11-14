<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoofScout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="/src/styles/global.css" rel="stylesheet" media="screen">

    <?php if (isset($_SESSION["tema"])): ?>

        <?php
        switch ($_SESSION["tema"]) {
            case 0:
                echo '<link rel="stylesheet" href="/src/styles/global.css" media="screen">';
                break;
            case 1:
                echo '<link rel="stylesheet" href="/src/styles/darktheme.css" media="screen">';
                break;
            case 2:
                echo '<link rel="stylesheet" href="/src/styles/bigtext.css" media="screen">';
                break;
            case 3:
                echo '<link rel="stylesheet" href="/src/styles/darkbigtext.css" media="screen">';
                break;
            case 4:
                echo '<link rel="stylesheet" href="/src/styles/highcontrast.css" media="screen">';
                break;
            case 5:
                echo '<link rel="stylesheet" href="/src/styles/darkhighcontrast.css" media="screen">';
                break;
            case 6:
                echo '<link rel="stylesheet" href="/src/styles/bigtexthighcontrast.css" media="screen">';
                break;
            case 7:
                echo '<link rel="stylesheet" href="/src/styles/darkbigtexthighcontrast.css" media="screen">';
                break;
            default:
                echo '<link rel="stylesheet" href="/src/styles/global.css" media="screen">';
                break;
        }
        ?>

    <?php endif; ?>

    <link title="Modo Oscuro" rel="alternate stylesheet" href="/src/styles/darktheme.css" media="screen">
    <link title="Texto Grande Claro" rel="alternate stylesheet" href="/src/styles/bigtext.css" media="screen">
    <link title="Texto Grande Oscuro" rel="alternate stylesheet" href="/src/styles/darkbigtext.css" media="screen">
    <link title="Alto Contraste Claro" rel="alternate stylesheet" href="/src/styles/highcontrast.css" media="screen">
    <link title="Alto Contraste Oscuro" rel="alternate stylesheet" href="/src/styles/darkhighcontrast.css"
        media="screen">
    <link title="Alto Contraste Texto Grande Claro" rel="alternate stylesheet"
        href="/src/styles/bigtexthighcontrast.css" media="screen">
    <link title="Alto Contraste Texto Grande Oscuro" rel="alternate stylesheet"
        href="/src/styles/darkbigtexthighcontrast.css" media="screen">
    <link title="Modo de Impresion" rel="alternate stylesheet" href="/src/styles/print.css" media="screen">
    <link title="Accesible" rel="alternate stylesheet" href="/src/styles/nostyle.css" media="screen">
    <link rel="stylesheet" href="/src/styles/print.css" media="print">
</head>

<body class="inter">