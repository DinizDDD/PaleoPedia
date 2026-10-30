
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

        COALESCE(behavior_file._path, principal_file._path) AS behavior_image_path,
        COALESCE(ecology_file._path, principal_file._path) AS ecology_image_path,
        COALESCE(curiosities_file._path, principal_file._path) AS curiosities_image_path,
        COALESCE(discovery_file._path, principal_file._path) AS discovery_image_path

    FROM species

    LEFT JOIN geo_time
        ON species.geotime_id = geo_time.id

    LEFT JOIN species_images AS principal_image
        ON principal_image.species_id = species.id
        AND principal_image.purpose = 'principal'

    LEFT JOIN images AS principal_file
        ON principal_file.id = COALESCE(
            principal_image.image_id,
            species.image_id
        )

    LEFT JOIN species_images AS behavior_image
        ON behavior_image.species_id = species.id
        AND behavior_image.purpose = 'behavior'

    LEFT JOIN images AS behavior_file
        ON behavior_file.id = behavior_image.image_id

    LEFT JOIN species_images AS ecology_image
        ON ecology_image.species_id = species.id
        AND ecology_image.purpose = 'ecology'

    LEFT JOIN images AS ecology_file
        ON ecology_file.id = ecology_image.image_id

    LEFT JOIN species_images AS curiosities_image
        ON curiosities_image.species_id = species.id
        AND curiosities_image.purpose = 'curiosities'

    LEFT JOIN images AS curiosities_file
        ON curiosities_file.id = curiosities_image.image_id

    LEFT JOIN species_images AS discovery_image
        ON discovery_image.species_id = species.id
        AND discovery_image.purpose = 'discovery'

    LEFT JOIN images AS discovery_file
        ON discovery_file.id = discovery_image.image_id

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

/* HIERARQUIA GEOLOGICA */

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
        related_file._path AS image_path

    FROM (
        SELECT related_species_id AS related_id
        FROM species_relations
        WHERE species_id = :species_id_1

        UNION

        SELECT species_id AS related_id
        FROM species_relations
        WHERE related_species_id = :species_id_2
    ) AS relations

    INNER JOIN species AS related
        ON related.id = relations.related_id

    LEFT JOIN species_images AS related_principal
        ON related_principal.species_id = related.id
        AND related_principal.purpose = 'principal'

    LEFT JOIN images AS related_file
        ON related_file.id = COALESCE(
            related_principal.image_id,
            related.image_id
        )

    WHERE related.id != :species_id_3

    ORDER BY related.name
");

$relationStmt->execute([
    ':species_id_1' => $species['id'],
    ':species_id_2' => $species['id'],
    ':species_id_3' => $species['id']
]);

$relatedSpecies = $relationStmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <span class="species-characteristics-number">01</span>

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
                    <span class="species-characteristics-number">02</span>

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
                    <span class="species-characteristics-number">03</span>
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

    <section class="species-content-section">
        <div class="species-section-title">
            <span>CONHECENDO A ESPÉCIE</span>
            <h2>Comportamento e ecologia</h2>
        </div>

        <div class="species-text-grid">
            <article class="species-text-card">
                <span>01</span>
                <h3>Comportamento</h3>
                <p>
                    <?= formatValue($species['behavior']); ?>
                </p>
            </article>

            <article class="species-text-card">
                <span>02</span>
                <h3>Ecologia</h3>
                <p>
                    <?= formatValue($species['ecology']); ?>
                </p>
            </article>

            <article class="species-text-card">
                <span>03</span>
                <h3>Curiosidades</h3>
                <p>
                    <?= formatValue($species['curiosities']); ?>
                </p>
            </article>
        </div>
    </section>

    <!-- CONTEXTO AMBIENTAL -->

    <section class="species-dark-section species-environment-section">
        <div class="species-dark-content">
            <div class="species-section-title species-section-title-dark">
                <span>O MUNDO PRÉ-HISTÓRICO</span>
                <h2>Contexto ambiental</h2>
            </div>

            <div class="environment-grid">
                <div class="environment-card">
                    <span>BIOMA</span>
                    <strong>
                        <?= formatValue($species['biome']); ?>
                    </strong>
                </div>

                <div class="environment-card">
                    <span>CLIMA</span>
                    <strong>
                        <?= formatValue($species['climate']); ?>
                    </strong>
                </div>
                <div class="environment-card">
                    <span>HABITAT</span>
                    <strong>
                        <?= formatValue($species['habitat']); ?>
                    </strong>
                </div>
                <div class="environment-card">
                    <span>CONTINENTE</span>
                    <strong>
                        <?= formatValue($species['continent']); ?>
                    </strong>
                </div>
            </div>

            <!-- ESPECIES CONTEMPORANEAS -->

            <div class="contemporaneous-section">
                <div class="contemporaneous-title">
                    <span>COMPARTILHARAM O PASSADO</span>
                    <h3>Espécies relacionadas</h3>
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
                                </div>
                            </a>
                        <?php } ?>
                    </div>

                <?php } else { ?>
                    <p class="species-empty-message">
                        Nenhuma espécie relacionada cadastrada.
                    </p>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- DESCOBERTA -->

    <section class="species-content-section species-discovery-section">
        <div class="species-section-title">
            <span>REGISTRO FOSSILÍFERO</span>
            <h2>Descoberta</h2>
        </div>

        <div class="discovery-grid">
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
    </section>
</main>
