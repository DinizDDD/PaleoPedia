<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paleopedia - Homepage</title>
    <link rel="stylesheet" href="assets/css/navbar.css">
</head>
<body>
    <?php require 'includes/navbar.php';

        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        switch($page){
            case 'home':
                include('pages/home.php');
                break;

            case 'species':
                include('pages/species.php');
                break;

            case 'period':
                include('pages/period.php');
                break;
        }
    ?>
</body>
</html>