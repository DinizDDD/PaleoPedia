
<?php

$slug = $_GET['slug'] ?? '';

if ($slug === '') {
    header('Location: index.php?page=period');
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM geo_time
    WHERE slug = :slug
    LIMIT 1
");

$stmt->execute([
    ':slug' => $slug
]);

$time = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$time) {
    header('Location: index.php?page=period');
    exit;
}

function timeInfoEscape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function timeInfoText($value) {
    if ($value === null || trim($value) === '') {
        return 'Informação ainda não cadastrada.';
    }

    return nl2br(timeInfoEscape($value));
}

function formatGeologicalDate($value) {
    if ($value === null) {
        return 'Não informado';
    }

    $value = (float) $value;

    if ($value <= 0) {
        return 'Presente';
    }

    if ($value >= 1000) {
        $formatted = number_format($value / 1000, 2, ',', '.');
        return $formatted . ' bilhões de anos';
    }

    $formatted = number_format($value, 2, ',', '.');

    return $formatted . ' milhões de anos';
}

function formatGeologicalDuration($begin, $end) {
    if ($begin === null || $end === null) {
        return 'Não informado';
    }

    $duration = abs((float) $begin - (float) $end);

    if ($duration >= 1000) {
        return number_format($duration / 1000, 2, ',', '.') . ' bilhões de anos';
    }

    return number_format($duration, 2, ',', '.') . ' milhões de anos';
}

$typeNames = [
    'eon' => 'Éon',
    'era' => 'Era',
    'periodo' => 'Período',
    'epoca' => 'Época',
    'idade' => 'Idade'
];

$typeName = $typeNames[$time['type']] ?? 'Divisão geológica';

$beginDate = formatGeologicalDate($time['begin_year']);
$endDate = formatGeologicalDate($time['end_year']);
$duration = formatGeologicalDuration($time['begin_year'], $time['end_year']);

$allTimesStmt = $conn->query("
    SELECT id, name, slug, type, begin_year, end_year, parent_id
    FROM geo_time
    ORDER BY begin_year DESC, name ASC
");

$allTimes = $allTimesStmt->fetchAll(PDO::FETCH_ASSOC);

$timesById = [];
$childrenByParent = [];

foreach ($allTimes as $item) {
    $timesById[$item['id']] = $item;

    if ($item['parent_id'] !== null) {
        $childrenByParent[$item['parent_id']][] = $item;
    }
}

$hierarchy = [];
$current = $time;
$visited = [];

while ($current) {
    if (isset($visited[$current['id']])) {
        break;
    }

    $visited[$current['id']] = true;
    $hierarchy[] = $current;

    $parentId = $current['parent_id'];

    if ($parentId === null || !isset($timesById[$parentId])) {
        break;
    }

    $current = $timesById[$parentId];
}

$hierarchy = array_reverse($hierarchy);

$children = $childrenByParent[$time['id']] ?? [];

$descendantIds = [];
$pendingIds = [$time['id']];

while (!empty($pendingIds)) {
    $currentId = array_pop($pendingIds);

    if (in_array($currentId, $descendantIds, true)) {
        continue;
    }

    $descendantIds[] = $currentId;

    if (!empty($childrenByParent[$currentId])) {
        foreach ($childrenByParent[$currentId] as $child) {
            $pendingIds[] = $child['id'];
        }
    }
}

$bannerStmt = $conn->prepare("
    SELECT images._path, images.legenda
    FROM geotime_images
    INNER JOIN images
        ON images.id = geotime_images.image_id
    WHERE geotime_images.geotime_id = :id
      AND geotime_images.purpose = 'banner'
    LIMIT 1
");

$bannerStmt->execute([
    ':id' => $time['id']
]);

$bannerImage = $bannerStmt->fetch(PDO::FETCH_ASSOC);

$environmentStmt = $conn->prepare("
    SELECT images._path, images.legenda
    FROM geotime_images
    INNER JOIN images
        ON images.id = geotime_images.image_id
    WHERE geotime_images.geotime_id = :id
      AND geotime_images.purpose = 'environment'
    LIMIT 1
");

$environmentStmt->execute([
    ':id' => $time['id']
]);

$environmentImage = $environmentStmt->fetch(PDO::FETCH_ASSOC);

$species = [];

if (!empty($descendantIds)) {
    $placeholders = implode(',', array_fill(0, count($descendantIds), '?'));

    $speciesStmt = $conn->prepare("
        SELECT
            s.id,
            s.name,
            s.scientific_name,
            s.slug,
            s.summary,
            s.geotime_id,
            COALESCE(
                (
                    SELECT img._path
                    FROM species_images si
                    INNER JOIN images img
                        ON img.id = si.image_id
                    WHERE si.species_id = s.id
                    ORDER BY
                        CASE si.purpose
                            WHEN 'card' THEN 1
                            WHEN 'principal' THEN 2
                            ELSE 3
                        END
                    LIMIT 1
                ),
                (
                    SELECT img._path
                    FROM images img
                    WHERE img.id = s.image_id
                    LIMIT 1
                )
            ) AS image_path
        FROM species s
        WHERE s.geotime_id IN ($placeholders)
        ORDER BY s.name ASC
    ");

    $speciesStmt->execute($descendantIds);
    $species = $speciesStmt->fetchAll(PDO::FETCH_ASSOC);
}

$hasBannerImage = false;
$hasEnvironmentImage = false;

if ($bannerImage && !empty($bannerImage['_path'])) {
    $hasBannerImage = file_exists(__DIR__ . '/../' . $bannerImage['_path']);
}

if ($environmentImage && !empty($environmentImage['_path'])) {
    $hasEnvironmentImage = file_exists(__DIR__ . '/../' . $environmentImage['_path']);
}

?>

<main class="time-info-page">

    <!-- BANNER -->

    <section class="time-info-hero">
        <div class="time-info-hero-banner">
            <?php if ($hasBannerImage): ?>
                <img src="<?= timeInfoEscape($bannerImage['_path']); ?>" alt="<?= timeInfoEscape($bannerImage['legenda'] ?: $time['name']); ?>">
            <?php endif; ?>
            <div class="time-info-hero-overlay"></div>
            <div class="time-info-hero-content">
                <div class="time-info-breadcrumb">
                    <a href="index.php?page=period">
                        Tempo geológico
                    </a>
                        <?php foreach ($hierarchy as $index => $item): ?>
                            <span>/</span>
                            <?php if ($index === count($hierarchy) - 1): ?>
                                <strong><?= timeInfoEscape($item['name']); ?></strong>
                            <?php else: ?>
                                <a href="index.php?page=time_info&slug=<?= urlencode($item['slug']); ?>">
                                    <?= timeInfoEscape($item['name']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                </div>

                <span class="time-info-type">
                    <?= timeInfoEscape($typeName); ?>
                </span>
                <h1><?= timeInfoEscape($time['name']); ?></h1>
                <div class="time-info-date">
                    <?= timeInfoEscape($beginDate); ?>
                    <span>—</span>
                    <?= timeInfoEscape($endDate); ?>
                </div>
                <p>
                    <?= timeInfoEscape($time['summary'] ?: 'Informações sobre esta divisão do tempo geológico.'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- INFORMACOES GERAIS -->

    <section class="time-info-basic-section">
        <div class="time-info-section-title">
            <span>VISÃO GERAL</span>
            <h2>Informações gerais</h2>
            <p>
                Conheça a posição desta divisão na escala do tempo geológico
                e suas principais características.
            </p>
        </div>

        <div class="time-info-facts-grid">
            <article class="time-info-fact">
                <span>CLASSIFICAÇÃO</span>
                <strong><?= timeInfoEscape($typeName); ?></strong>
            </article>

            <article class="time-info-fact">
                <span>INÍCIO</span>
                <strong><?= timeInfoEscape($beginDate); ?></strong>
            </article>

            <article class="time-info-fact">
                <span>TÉRMINO</span>
                <strong><?= timeInfoEscape($endDate); ?></strong>
            </article>

            <article class="time-info-fact">
                <span>DURAÇÃO</span>
                <strong><?= timeInfoEscape($duration); ?></strong>
            </article>

            <article class="time-info-fact time-info-fact-wide">
                <span>DIVISÃO SUPERIOR</span>
                <strong>
                    <?php if (count($hierarchy) > 1): ?>
                        <?= timeInfoEscape($hierarchy[count($hierarchy) - 2]['name']); ?>
                    <?php else: ?>
                        Não possui divisão superior cadastrada.
                    <?php endif; ?>
                </strong>
            </article>
        </div>
    </section>

    <!-- CONTEXTO GEOLOGICO -->

    <section class="time-info-context-section">
        <div class="time-info-content">
            <div class="time-info-section-title time-info-section-title-dark">
                <span>O PLANETA NO PASSADO</span>
                <h2>Contexto geológico</h2>
                <p>
                    As condições físicas e ambientais da Terra durante
                    <?= timeInfoEscape($time['name']); ?>.
                </p>
            </div>

            <div class="time-info-editorial-grid">
                <article class="time-info-editorial-card">
                    <span>01 / CONTINENTES</span>
                    <h3>Configuração continental</h3>
                    <p><?= timeInfoText($time['continental_configuration']); ?></p>
                </article>

                <article class="time-info-editorial-card">
                    <span>02 / CLIMA</span>
                    <h3>Condições climáticas</h3>
                    <p><?= timeInfoText($time['climate']); ?></p>
                </article>

                <article class="time-info-editorial-card">
                    <span>03 / OCEANOS</span>
                    <h3>Oceanos e mares</h3>
                    <p><?= timeInfoText($time['oceans']); ?></p>
                </article>

                <article class="time-info-editorial-card">
                    <span>04 / VEGETAÇÃO</span>
                    <h3>Vegetação</h3>
                    <p><?= timeInfoText($time['vegetation']); ?></p>
                </article>
            </div>
        </div>
    </section>

    
    <!-- ECOSSISTEMAS E BIODIVERSIDADE -->

    <section class="time-info-topics-section">
        <div class="time-info-topics-content">

            <!-- ECOSSISTEMAS -->

            <?php if (!empty($time['environments'])): ?>
                <div class="time-info-environment-section">
                    <div class="time-info-environment-content">
                        <div class="time-info-environment-text">
                            <div class="time-info-section-title">
                                <span>ECOSSISTEMAS</span>
                                <h2>Ambientes e paisagens</h2>
                            </div>

                            <p><?= timeInfoText($time['environments']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- BIODIVERSIDADE -->

            <div class="time-info-biodiversity-section">
                <div class="time-info-biodiversity-content">
                    <div class="time-info-section-title">
                        <span>VIDA NO PASSADO</span>
                        <h2>Biodiversidade</h2>
                        <p>
                            As principais formas de vida e transformações biológicas
                            associadas a este intervalo geológico.
                        </p>
                    </div>
                    <div class="time-info-biodiversity-text">
                        <?= timeInfoText($time['biodiversity']); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRINCIPAIS ACONTECIMENTOS -->

    <?php if (!empty($time['curiosities'])): ?>
        <section class="time-info-events-section">
            <div class="time-info-events-content">
                <div class="time-info-section-title time-info-section-title-dark">
                    <span>MARCOS HISTÓRICOS</span>
                    <h2>Principais acontecimentos</h2>
                    <p>
                        Acontecimentos geológicos, ambientais e evolutivos
                        marcantes durante este intervalo.
                    </p>
                </div>

                <div class="time-info-events-text">
                    <p><?= timeInfoText($time['curiosities']); ?></p>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ESPECIES -->

    <section class="time-info-species-section">
        <div class="time-info-species-content">
            <div class="time-info-section-title">
                <span>REGISTRO FÓSSIL</span>
                <h2>Espécies deste tempo</h2>
                <p>
                    Espécies cadastradas na Paleopedia que viveram durante
                    <?= timeInfoEscape($time['name']); ?> ou em alguma de suas subdivisões.
                </p>
            </div>

            <?php if (!empty($species)): ?>
                <div class="time-info-species-grid">
                    <?php foreach ($species as $specie): ?>
                        <a
                            href="index.php?page=species_info&slug=<?= urlencode($specie['slug']); ?>"
                            class="time-info-species-card"
                        >
                            <div class="time-info-species-image">
                                <?php
                                    $speciesImageExists = !empty($specie['image_path'])
                                        && file_exists(__DIR__ . '/../' . $specie['image_path']);
                                ?>
                                <?php if ($speciesImageExists): ?>
                                    <img
                                        src="<?= timeInfoEscape($specie['image_path']); ?>"
                                        alt="<?= timeInfoEscape($specie['name']); ?>"
                                    >
                                <?php else: ?>
                                    <div class="time-info-no-image">
                                        <span>Imagem indisponível</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="time-info-species-card-content">
                                <strong><?= timeInfoEscape($specie['name']); ?></strong>
                                <span>
                                    <?= timeInfoEscape($specie['scientific_name']); ?>
                                </span>
                                <div class="time-info-species-link">
                                    Conhecer espécie
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>

                <div class="time-info-empty">
                    <i class="fa-solid fa-bone"></i>
                    <p>
                        Ainda não existem espécies cadastradas para esta
                        divisão do tempo geológico.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- SUBDIVISOES -->

    <?php if (!empty($children)): ?>
        <section class="time-info-divisions-section">
            <div class="time-info-divisions-content">
                <div class="time-info-section-title time-info-section-title-dark">
                    <span>ESCALA DO TEMPO GEOLÓGICO</span>
                    <h2>Divisões internas</h2>
                    <p>
                        Explore as subdivisões que compõem
                        <?= timeInfoEscape($time['name']); ?>.
                    </p>
                </div>

                <div class="time-info-divisions-list">
                    <?php foreach ($children as $child): ?>
                        <a
                            href="index.php?page=time_info&slug=<?= urlencode($child['slug']); ?>"
                            class="time-info-division-item"
                        >
                            <div class="time-info-division-main">
                                <span>
                                    <?= timeInfoEscape($typeNames[$child['type']] ?? 'Divisão geológica'); ?>
                                </span>
                                <h3><?= timeInfoEscape($child['name']); ?></h3>
                            </div>

                            <div class="time-info-division-date">
                                <span>
                                    <?= timeInfoEscape(formatGeologicalDate($child['begin_year'])); ?>
                                </span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    <?php endif; ?>

    <!-- NAVEGACAO FINAL -->

    <section class="time-info-back-section">

        <a href="index.php?page=period">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar à escala do tempo geológico
        </a>
    </section>
</main>