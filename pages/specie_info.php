<?php

include(__DIR__ . '/../config/database.php');

$slug = $_GET['slug'] ?? '';

if ($slug === '') {
    header('Location: index.php?page=species');
    exit;
}

$stmt = $conn->prepare("
    SELECT
        species.*,
        geo_time.name AS period_name,
        geo_time.type AS period_type,

        principal_file._path AS image_path,
        principal_file.legenda AS image_legend,

        COALESCE(
            behavior_file._path,
            principal_file._path
        ) AS behavior_image_path,

        COALESCE(
            ecology_file._path,
            principal_file._path
        ) AS ecology_image_path,

        COALESCE(
            curiosities_file._path,
            principal_file._path
        ) AS curiosities_image_path,

        COALESCE(
            discovery_file._path,
            principal_file._path
        ) AS discovery_image_path

    FROM species

    LEFT JOIN geo_time
        ON species.geotime_id = geo_time.id

    LEFT JOIN species_images AS principal_relation
        ON principal_relation.species_id = species.id
        AND principal_relation.purpose = 'principal'

    LEFT JOIN images AS principal_file
        ON principal_file.id = COALESCE(
            principal_relation.image_id,
            species.image_id
        )

    LEFT JOIN species_images AS behavior_relation
        ON behavior_relation.species_id = species.id
        AND behavior_relation.purpose = 'behavior'

    LEFT JOIN images AS behavior_file
        ON behavior_file.id = behavior_relation.image_id

    LEFT JOIN species_images AS ecology_relation
        ON ecology_relation.species_id = species.id
        AND ecology_relation.purpose = 'ecology'

    LEFT JOIN images AS ecology_file
        ON ecology_file.id = ecology_relation.image_id

    LEFT JOIN species_images AS curiosities_relation
        ON curiosities_relation.species_id = species.id
        AND curiosities_relation.purpose = 'curiosities'

    LEFT JOIN images AS curiosities_file
        ON curiosities_file.id = curiosities_relation.image_id

    LEFT JOIN species_images AS discovery_relation
        ON discovery_relation.species_id = species.id
        AND discovery_relation.purpose = 'discovery'

    LEFT JOIN images AS discovery_file
        ON discovery_file.id = discovery_relation.image_id

    WHERE species.slug = :slug
    LIMIT 1
");

$stmt->execute([':slug' => $slug]);
$species = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$species) {
    header('Location: index.php?page=species');
    exit;
}

function formatValue($value)
{
    if ($value === null || $value === '') {
        return 'Não informado';
    }

    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function formatNumber($value, $unit = '')
{
    if ($value === null || $value === '') {
        return 'Não informado';
    }

    $number = number_format((float) $value, 2, ',', '.');
    $number = rtrim(rtrim($number, '0'), ',');

    return $number . ($unit !== '' ? ' ' . $unit : '');
}

function getDietName($diet)
{
    $diets = [
        'carnívoro' => 'Carnívoro',
        'herbívoro' => 'Herbívoro',
        'onívoro' => 'Onívoro',
        'piscívoro' => 'Piscívoro',
        'insetívoro' => 'Insetívoro'
    ];

    return $diets[$diet] ?? $diet;
}

/* HIERARQUIA */

$geologicalTime = [];
$geotimeId = $species['geotime_id'] ?? null;
$visitedGeotimeIds = [];

while ($geotimeId) {
    if (isset($visitedGeotimeIds[$geotimeId])) {
        break;
    }

    $visitedGeotimeIds[$geotimeId] = true;

    $timeStmt = $conn->prepare("
        SELECT id, name, type, parent_id
        FROM geo_time
        WHERE id = :id
        LIMIT 1
    ");

    $timeStmt->execute([':id' => $geotimeId]);
    $time = $timeStmt->fetch(PDO::FETCH_ASSOC);

    if (!$time) {
        break;
    }

    $geologicalTime[] = $time;
    $geotimeId = $time['parent_id'];
}

$geologicalTime = array_reverse($geologicalTime);

$geologicalTimeNames = array_column($geologicalTime, 'name');

$geologicalTimeText = implode(' → ', $geologicalTimeNames);

if ($geologicalTimeText === '') {
    $geologicalTimeText = 'Não informado';
}

/* TAXONOMIA */

$taxonomy = [];

if (!empty($species['taxon_id'])) {
    $taxonId = $species['taxon_id'];
    $visitedTaxonIds = [];

    while ($taxonId) {
        if (isset($visitedTaxonIds[$taxonId])) {
            break;
        }

        $visitedTaxonIds[$taxonId] = true;

        $taxonStmt = $conn->prepare("
            SELECT id, parent_id, name, rank
            FROM tax
            WHERE id = :id
            LIMIT 1
        ");

        $taxonStmt->execute([':id' => $taxonId]);
        $taxon = $taxonStmt->fetch(PDO::FETCH_ASSOC);

        if (!$taxon) {
            break;
        }

        $taxonomy[] = $taxon;
        $taxonId = $taxon['parent_id'];
    }

    $taxonomy = array_reverse($taxonomy);
}

/* ESPECIES RELACIONADAS */

$relationStmt = $conn->prepare("
    SELECT
        related.id,
        related.name,
        related.scientific_name,
        related.slug,
        related.continent,

        COALESCE(
            card_file._path,
            principal_file._path,
            legacy_file._path
        ) AS image_path

    FROM species AS current_species

    INNER JOIN geo_time AS current_geo_time
        ON current_geo_time.id = current_species.geotime_id

    INNER JOIN species AS related
        ON related.id != current_species.id

    INNER JOIN geo_time AS related_time
        ON related_time.id = related.geotime_id

    LEFT JOIN species_images AS card_relation
        ON card_relation.species_id = related.id
        AND card_relation.purpose = 'card'

    LEFT JOIN images AS card_file
        ON card_file.id = card_relation.image_id

    LEFT JOIN species_images AS principal_relation
        ON principal_relation.species_id = related.id
        AND principal_relation.purpose = 'principal'

    LEFT JOIN images AS principal_file
        ON principal_file.id = principal_relation.image_id

    LEFT JOIN images AS legacy_file
        ON legacy_file.id = related.image_id

    WHERE current_species.id = :species_id

        AND current_geo_time.begin_year >= related_time.end_year
        AND related_time.begin_year >= current_geo_time.end_year

    ORDER BY related.name
");

$relationStmt->execute([
    ':species_id' => $species['id']
]);

$timeRelatedSpecies = $relationStmt->fetchAll(PDO::FETCH_ASSOC);


/* CONTINENTES COMPARAÇÃO */

$currentContinents = preg_split(
    '/\s*,\s*|\s+e\s+/u',
    trim($species['continent'] ?? ''),
    -1,
    PREG_SPLIT_NO_EMPTY
);

$currentContinents = array_map(
    fn($continent) => mb_strtolower(trim($continent), 'UTF-8'),
    $currentContinents
);

$relatedSpecies = array_values(array_filter(
    $timeRelatedSpecies,
    function ($related) use ($currentContinents) {

        $relatedContinents = preg_split(
            '/\s*,\s*|\s+e\s+/u',
            trim($related['continent'] ?? ''),
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $relatedContinents = array_map(
            fn($continent) => mb_strtolower(trim($continent), 'UTF-8'),
            $relatedContinents
        );

        return count(
            array_intersect($currentContinents, $relatedContinents)
        ) > 0;
    }
));
?>

<main class="species-page">

    <section class="species-hero">
        <div class="species-hero-banner">
            <?php if (!empty($species['image_path'])) { ?>
                <img
                    src="<?= formatValue($species['image_path']); ?>"
                    alt="<?= formatValue($species['name']); ?>"
                >
            <?php } ?>
            <div class="species-hero-overlay"></div>
            <div class="species-hero-title">
                <h1>
                    <?= mb_strtoupper(formatValue($species['name']), 'UTF-8'); ?>
                </h1>
            </div>

            <div class="species-hero-info">
                <h2>
                    <?= formatValue($species['scientific_name']); ?>
                </h2>
                <h4>
                    <?= mb_strtoupper(formatValue(getDietName($species['diet'])), 'UTF-8'); ?>
                    |
                    <?= mb_strtoupper(formatValue($geologicalTime[0]['name'] ?? ''), 'UTF-8'); ?>
                    |
                    <?= mb_strtoupper(formatValue($species['continent']), 'UTF-8'); ?>
                </h4>
                <p>
                    <?= formatValue($species['summary']); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- CARACTERISTICAS DA ESPECIE -->

    <section class="species-basic-section">
        <div class="species-section-title">
            <span>INFORMAÇÕES</span>
            <h2>Características da espécie</h2>
            <p>
                Conheça as principais características físicas, biológicas
                e geográficas desta espécie.
            </p>
        </div>

        <div class="species-characteristics-grid">

            <div class="species-characteristics-group">

                <div class="species-characteristics-heading">

                    <div>
                        <h3>Dimensões físicas</h3>
                        <p>Proporções e tamanho corporal</p>
                    </div>
                </div>

                <div class="species-characteristics-list">
                    <div class="species-characteristics-row">
                        <span>Comprimento</span>
                        <strong>
                            <?= formatNumber($species['length'], 'm'); ?>
                        </strong>
                    </div>

                    <div class="species-characteristics-row">
                        <span>Altura</span>
                        <strong>
                            <?= formatNumber($species['height'], 'm'); ?>
                        </strong>
                    </div>

                    <div class="species-characteristics-row">
                        <span>Peso</span>
                        <strong>
                            <?= formatNumber($species['weight'], 'kg'); ?>
                        </strong>
                    </div>
                </div>
            </div>

            <div class="species-characteristics-group">
                <div class="species-characteristics-heading">

                    <div>
                        <h3>Características biológicas</h3>
                        <p>Alimentação e ambiente</p>
                    </div>
                </div>

                <div class="species-characteristics-list">
                    <div class="species-characteristics-row">
                        <span>Dieta</span>
                        <strong>
                            <?= formatValue(getDietName($species['diet'])); ?>
                        </strong>
                    </div>

                    <div class="species-characteristics-row">
                        <span>Habitat</span>
                        <strong>
                            <?= formatValue($species['habitat']); ?>
                        </strong>
                    </div>
                </div>
            </div>

            <div class="species-characteristics-group">
                <div class="species-characteristics-heading">
                    <div>
                        <h3>Distribuição temporal e geográfica</h3>
                        <p>Quando e onde viveu</p>
                    </div>
                </div>
                <div class="species-characteristics-list">
                    <?php
                    $geologicalTimeByType = [];

                    foreach ($geologicalTime as $time) {
                        $geologicalTimeByType[$time['type']] = $time['name'];
                    }
                    ?>
                    <div class="species-characteristics-row">
                        <span>Período geológico</span>
                        <strong>
                            <?= formatValue($geologicalTimeByType['periodo'] ?? null); ?>
                        </strong>
                    </div>
                    <div class="species-characteristics-row">
                        <span>Época geológica</span>
                        <strong>
                            <?= formatValue($geologicalTimeByType['epoca'] ?? null); ?>
                        </strong>
                    </div>
                    <div class="species-characteristics-row">
                        <span>Idade geológica</span>
                        <strong>
                            <?= formatValue($geologicalTimeByType['idade'] ?? null); ?>
                        </strong>
                    </div>
                    <div class="species-characteristics-row">
                        <span>Continente</span>
                        <strong>
                            <?= formatValue($species['continent']); ?>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TAXONOMIA -->

    <section class="species-dark-section species-taxonomy-section">
        <div class="species-dark-content">
            <div class="species-section-title species-section-title-dark">
                <span>CLASSIFICAÇÃO CIENTÍFICA</span>
                <h2>Taxonomia</h2>
            </div>

            <div class="taxonomy-table">
                <?php if (!empty($taxonomy)) { ?>
                    <?php foreach ($taxonomy as $taxon) { ?>
                        <div class="taxonomy-row">
                            <span class="taxonomy-rank">
                                <?= formatValue(ucfirst($taxon['rank'])); ?>
                            </span>
                            <span class="taxonomy-name">
                                <?= formatValue($taxon['name']); ?>
                            </span>
                        </div>
                    <?php } ?>

                <?php } else { ?>

                    <p class="species-empty-message">
                        Informações taxonômicas não disponíveis.
                    </p>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- COMPORTAMENTO, ECOLOGIA E CURIOSIDADES -->

    <section class="species-content-section species-editorial-section">
        <div class="species-section-title">
            <span>CONHECENDO A ESPÉCIE</span>
            <h2>Comportamento e ecologia</h2>
            <p>
                Explore os hábitos, o ambiente e as características
                que marcaram a história desta espécie.
            </p>
        </div>

        <!-- COMPORTAMENTO -->

        <article class="editorial-block editorial-behavior">
            <div class="editorial-image editorial-behavior-image">
                <?php if (!empty($species['behavior_image_path'])) { ?>
                    <img
                        src="<?= formatValue($species['behavior_image_path']); ?>"
                        alt="Representação do comportamento de <?= formatValue($species['name']); ?>"
                        loading="lazy"
                    >
                <?php } ?>

                <span class="editorial-image-caption">
                    COMPORTAMENTO
                </span>
            </div>
            <div class="editorial-content editorial-behavior-content">
                <div class="editorial-heading">
                    <span class="editorial-number">01</span>
                    <span class="editorial-label">
                        HÁBITOS E LOCOMOÇÃO
                    </span>
                </div>
                <h3>Como vivia esta espécie?</h3>
                <p>
                    <?= formatValue($species['behavior']); ?>
                </p>
                <div class="editorial-bottom-line"></div>
            </div>
        </article>

        <!-- ECOLOGIA -->

        <article class="editorial-block editorial-ecology">
            <div class="editorial-content editorial-ecology-content">
                <div class="editorial-heading">
                    <span class="editorial-number">02</span>
                    <span class="editorial-label">
                        AMBIENTE E RELAÇÕES ECOLÓGICAS
                    </span>
                </div>
                <h3>O ambiente em que habitava</h3>
                <p>
                    <?= formatValue($species['ecology']); ?>
                </p>
                <div class="editorial-ecology-details">
                    <div>
                        <span>HABITAT</span>
                        <strong>
                            <?= formatValue($species['habitat']); ?>
                        </strong>
                    </div>
                    <div>
                        <span>BIOMA</span>
                        <strong>
                            <?= formatValue($species['biome']); ?>
                        </strong>
                    </div>
                </div>
            </div>

            <div class="editorial-image editorial-ecology-image">
                <?php if (!empty($species['ecology_image_path'])) { ?>
                    <img
                        src="<?= formatValue($species['ecology_image_path']); ?>"
                        alt="Representação do ambiente ecológico de <?= formatValue($species['name']); ?>"
                        loading="lazy"
                    >
                <?php } ?>
                <span class="editorial-image-caption">
                    CONTEXTO ECOLÓGICO
                </span>
            </div>
        </article>

        <!-- CURIOSIDADES -->

        <article class="editorial-curiosities">
            <div class="editorial-curiosities-image">
                <?php if (!empty($species['curiosities_image_path'])) { ?>
                    <img
                        src="<?= formatValue($species['curiosities_image_path']); ?>"
                        alt="Características marcantes de <?= formatValue($species['name']); ?>"
                        loading="lazy"
                    >
                <?php } ?>
                <div class="editorial-curiosities-overlay">
                    <span>03 — CARACTERÍSTICAS MARCANTES</span>
                    <h3>O que torna esta espécie especial?</h3>
                </div>
            </div>

            <div class="editorial-curiosities-content">
                <span class="editorial-curiosities-number">03</span>
                <div class="editorial-curiosities-text">
                    <span class="editorial-label">
                        CURIOSIDADES
                    </span>
                    <p>
                        <?= formatValue($species['curiosities']); ?>
                    </p>
                </div>
            </div>
        </article>
    </section>

    <!-- ESPECIES RELACIONADAS -->

    <section class="species-dark-section species-related-section">
        <div class="species-dark-content">
            <div class="species-section-title species-section-title-dark">
                <span>COMPARTILHARAM O PASSADO</span>
                <h2>Espécies relacionadas</h2>
                <p>
                    Conheça outros animais que viveram juntos dessa espécie.
                </p>
            </div>
            <?php if (!empty($relatedSpecies)) { ?>
                <div class="related-species-grid">
                    <?php foreach ($relatedSpecies as $related) { ?>
                        <a
                            href="index.php?page=species_info&slug=<?= urlencode($related['slug']); ?>"
                            class="related-species-card"
                        >
                            <div class="related-species-image">
                                <?php if (!empty($related['image_path'])) { ?>

                                    <img
                                        src="<?= formatValue($related['image_path']); ?>"
                                        alt="<?= formatValue($related['name']); ?>"
                                        loading="lazy"
                                    >
                                <?php } ?>
                            </div>
                            <div class="related-species-content">
                                <strong>
                                    <?= formatValue($related['name']); ?>
                                </strong>
                                <span>
                                    <?= formatValue($related['scientific_name']); ?>
                                </span>
                                <div class="related-species-link">
                                    <span>Conhecer espécie</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p class="species-empty-message">
                    Nenhuma espécie relacionada encontrada.
                </p>
            <?php } ?>
        </div>
    </section>

    <!-- DESCOBERTA -->

    <section class="species-content-section species-discovery-section">
        <div class="species-section-title">
            <span>REGISTRO FOSSILÍFERO</span>
            <h2>Descoberta</h2>
            <p>
                Conheça os registros e as informações sobre a descoberta
                dos fósseis desta espécie.
            </p>
        </div>

        <div class="discovery-grid">
            <div class="discovery-image">
                <?php if (!empty($species['discovery_image_path'])) { ?>
                    <img
                        src="<?= formatValue($species['discovery_image_path']); ?>"
                        alt="Registro fóssil de <?= formatValue($species['name']); ?>"
                        loading="lazy"
                    >
                <?php } ?>

                <span class="discovery-image-caption">
                    REGISTRO FOSSILÍFERO
                </span>
            </div>

            <div class="discovery-information">
                <div class="discovery-item">
                    <span>ANO DE DESCOBERTA</span>
                    <strong>
                        <?= formatValue($species['discovery_year']); ?>
                    </strong>
                </div>

                <div class="discovery-item">
                    <span>LOCAL DA DESCOBERTA</span>
                    <strong>
                        <?= formatValue($species['discovery_local']); ?>
                    </strong>
                </div>

                <div class="discovery-item">
                    <span>FORMAÇÃO GEOLÓGICA</span>
                    <strong>
                        <?= formatValue($species['formation']); ?>
                    </strong>
                </div>

                <div class="discovery-item">
                    <span>DESCOBERTO POR</span>
                    <strong>
                        <?= formatValue($species['discovered_by']); ?>
                    </strong>
                </div>
            </div>
        </div>
    </section>
</main>
