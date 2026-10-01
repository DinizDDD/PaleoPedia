<?php
    include('config/database.php');
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    $title = 'Paleopedia';

    switch($page){
        case 'home':
            $title = 'Paleopedia - Homepage';
            break;

        case 'species':
            $title = 'Paleopedia - Espécies';
            break;

        case 'period':
            $title = 'Paleopedia - Périodos';
            break;   
            
        case 'species_info':
            $slug = $_GET['slug'] ?? '';

            if($slug !== ''){
                $stmt = $conn->prepare("
                    SELECT name
                    FROM species
                    WHERE slug = :slug
                    LIMIT 1
                ");

                $stmt->execute([
                    ':slug' => $slug
                ]);

                $speciesTitle = $stmt->fetch(PDO::FETCH_ASSOC);

                if($speciesTitle){
                    $title = 'Paleopedia - ' . $speciesTitle['name'];
                } else {
                    $title = 'Paleopedia - Espécie';

                }
            } else {
                $title = 'Paleopedia - Espécie';
            }
            break;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
<link rel="stylesheet" href="assets/css/variables.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/navbar.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/home.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/card.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/spotlight_banner.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/specie_info.css?v=<?= time(); ?>">
</head>
<body>
    <?php require 'includes/navbar.php';

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

            case 'species_info':
                include('pages/specie_info.php');
                break;
        }
    ?>

    <script src="assets/js/spotlight_banner.js"></script>
</body>
</html>