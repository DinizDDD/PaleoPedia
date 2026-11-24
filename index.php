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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
        $commonStyles = ['variables.css', 'navbar.css', 'footer.css'];
        $pageStyles = [
            'home' => ['home.css', 'spotlight_banner.css'],
            'species' => ['card.css'],
            'period' => ['period.css'],
            'species_info' => ['specie_info.css'],
            'time_info' => ['time_info.css'],
            'not_found' => ['not_found.css'],
        ];
        foreach (array_merge($commonStyles, $pageStyles[$page] ?? []) as $cssFile) {
            $styleVersion = filemtime(__DIR__ . '/assets/css/' . $cssFile);
            echo '<link rel="stylesheet" href="assets/css/'
                . rawurlencode($cssFile) . '?v=' . $styleVersion . '">' . "\n";
        }
    ?>
    <?php if (in_array($page, ['period', 'species_info', 'time_info'], true)): ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <?php endif; ?>
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
                    <div class="not-found-links">
                        <a href="index.php?page=home">Voltar à página inicial</a>
                        <a href="index.php?page=species">Explorar espécies</a>
                        <a href="index.php?page=period">Explorar tempos geológicos</a>
                    </div>
                </main>
                <?php
                break;
        }
    ?>

    <?php require 'includes/footer.php'; ?>

    <script src="assets/js/navbar.js" defer></script>
    <?php if ($page === 'home'): ?>
    <script src="assets/js/spotlight_banner.js" defer></script>
    <?php endif; ?>
</body>
</html>