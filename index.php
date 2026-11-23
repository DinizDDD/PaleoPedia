<?php
require_once __DIR__ . '/config/database.php';

$page = $_GET['page'] ?? 'home';

$validPages = ['home', 'species', 'period', 'species_info', 'time_info'];
$title = 'Paleopedia';

if (!is_string($page) || !in_array($page, $validPages, true)) {
    $page = 'not_found';
    $title = 'Paleopedia - Página não encontrada';
    http_response_code(404);
} else {
    switch ($page) {
        case 'home':
            $title = 'Paleopedia - Homepage';
            break;

        case 'species':
            $title = 'Paleopedia - Espécies';
            break;

        case 'period':
            $title = 'Paleopedia - Períodos';
            break;

        case 'species_info':
        case 'time_info':
            $slug = $_GET['slug'] ?? '';

            if (!is_string($slug) || trim($slug) === '') {
                $destination = $page === 'species_info' ? 'species' : 'period';
                header('Location: index.php?page=' . $destination, true, 302);
                exit;
            }

            $slug = trim($slug);
            $table = $page === 'species_info' ? 'species' : 'geo_time';

            $stmt = $conn->prepare("SELECT name FROM {$table} WHERE slug = :slug LIMIT 1");
            $stmt->execute([':slug' => $slug]);
            $name = $stmt->fetchColumn();

            if ($name === false) {
                $page = 'not_found';
                $title = 'Paleopedia - Página não encontrada';
                http_response_code(404);
            } else {
                $title = 'Paleopedia - ' . $name;
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/variables.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/navbar.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/home.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/card.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/spotlight_banner.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/specie_info.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/period.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/time_info.css?v=<?= time(); ?>">
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
            
            case 'time_info':
                include('pages/time_info.php');
                break;

            case 'not_found':
                ?>
                <main class="not-found-page">
                    <h1>Página não encontrada</h1>
                    <p>O endereço solicitado não existe no Paleopedia ou não está disponível.</p>
                    <p>
                        <a href="index.php?page=home">Voltar à página inicial</a>
                        | <a href="index.php?page=species">Explorar espécies</a>
                        | <a href="index.php?page=period">Explorar tempos geológicos</a>
                    </p>
                </main>
                <?php
                break;
        }
    ?>

    <?php require 'includes/footer.php'; ?>

    <script src="assets/js/spotlight_banner.js"></script>
</body>
</html>