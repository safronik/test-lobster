<html lang="ru">
    <head>
        <title><?php echo $title ?></title>
        <script src="js/jquery.js"></script>
        <script>
            const ajax_url = '/ajax/';
        </script>
        <script src="js/script.js"></script>
        <link href="css/normalize.css" type="text/css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <?php echo $content ?>
        <?php echo $script ?? ''; ?>
    </body>
</html>
