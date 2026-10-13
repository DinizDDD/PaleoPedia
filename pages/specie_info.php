<?php
include(__DIR__ . '/../config/database.php');

$slug = $_GET['slug'] ?? '';
if($slug === ''){
    header('Location: index.php?page=species');
    exit;
}
$stmt = $conn->prepare("
    SELECT
        species.*,
        geo_time.name AS period_name,
        geo_time.type AS period_type,
        images._path AS image_path,
        images.legenda AS image_legend
    FROM species
    LEFT JOIN geo_time
        ON species.geotime_id = geo_time.id
    LEFT JOIN images
        ON species.image_id = images.id
    WHERE species.slug = :slug
    LIMIT 1
");
$stmt->execute([
    ':slug' => $slug
]);
$species = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$species){
    header('Location: index.php?page=species');
    exit;
}

function formatValue($value){
    if($value === null || $value === ''){
        return 'Não informado';
    }
    return htmlspecialchars($value);
}

function formatNumber($value, $unit = ''){
    if($value === null || $value === ''){
        return 'Não informado';
    }
    $number = number_format(
        (float) $value,
        2,
        ',',
        '.'
    );
    $number = rtrim($number, '0');
    $number = rtrim($number, ',');
    return $number . ($unit !== '' ? ' ' . $unit : '');
}

function getDietName($diet){
    $diets = [
        'carnívoro' => 'Carnívoro',
        'herbívoro' => 'Herbívoro',
        'onívoro' => 'Onívoro',
        'piscívoro' => 'Piscívoro',
        'insetívoro' => 'Insetívoro'
    ];
    return $diets[$diet] ?? $diet;
}

$taxonomy = [];

if(!empty($species['taxon_id'])){
    $taxonId = $species['taxon_id'];
    while($taxonId){
        $taxonStmt = $conn->prepare("
            SELECT
                id,
                parent_id,
                name,
                rank
            FROM tax
            WHERE id = :id
            LIMIT 1
        ");
        $taxonStmt->execute([
            ':id' => $taxonId
        ]);
        $taxon = $taxonStmt->fetch(PDO::FETCH_ASSOC);
        if(!$taxon){
            break;
        }
        $taxonomy[] = $taxon;
        $taxonId = $taxon['parent_id'];
    }
    $taxonomy = array_reverse($taxonomy);
}

$relatedSpecies = [];

$relationStmt = $conn->prepare("
    SELECT
        species.id,
        species.name,
        species.scientific_name,
        species.slug,
        images._path AS image_path
    FROM species_relations
    INNER JOIN species
        ON (
            species.id = species_relations.species_id
            OR species.id = species_relations.related_species_id
        )
    LEFT JOIN images
        ON species.image_id = images.id
    WHERE
        (
            species_relations.species_id = :species_id
            OR species_relations.related_species_id = :species_id
        )
        AND species.id != :species_id
    GROUP BY species.id
    ORDER BY species.name
");

$relationStmt->execute([
    ':species_id' => $species['id']
]);
$relatedSpecies = $relationStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="species-page">

<section class="species-hero">
    <div class="species-hero-banner">
        <img src="<?= formatValue($species['image_path']); ?>"alt="<?= formatValue($species['name']); ?>">
        <div class="species-hero-overlay"></div>
        <div class="species-hero-title">
            <h1>
                <?= mb_strtoupper(formatValue($species['name'])); ?>
            </h1>
        </div>
        <div class="species-hero-info">
            <h2>
                <?= formatValue($species['scientific_name']); ?>
            </h2>
            <h4>
                <?= mb_strtoupper(getDietName($species['diet'])); ?>
                |
                <?= mb_strtoupper(formatValue($species['period_name'])); ?>
                |
                <?= mb_strtoupper(formatValue($species['continent'])); ?>
            </h4>
            <p>
                <?= formatValue($species['summary']); ?>
            </p>
        </div>
    </div>
</section>

    <section class="species-basic-section">
        <div class="species-section-title">
            <span>INFORMAÇÕES</span>
            <h2>
                Características da espécie
            </h2>
        </div>

        <div class="species-basic-grid">
            <div class="species-data-card">
                <span>PERÍODO</span>
                <strong>
                    <?= formatValue($species['period_name']); ?>
                </strong>
            </div>

            <div class="species-data-card">
                <span>HABITAT</span>
                <strong>
                    <?= formatValue($species['habitat']); ?>
                </strong>
            </div>

            <div class="species-data-card">
                <span>REGIÃO</span>
                <strong>
                    <?= formatValue($species['region']); ?>
                </strong>
            </div>

            <div class="species-data-card">
                <span>COMPRIMENTO</span>
                <strong>
                    <?= formatNumber($species['length'], 'm'); ?>
                </strong>
            </div>

            <div class="species-data-card">
                <span>ALTURA</span>
                <strong>
                    <?= formatNumber($species['height'], 'm'); ?>
                </strong>
            </div>

            <div class="species-data-card">
                <span>PESO</span>
                <strong>
                    <?= formatNumber($species['weight'], 'kg'); ?>
                </strong>
            </div>

            <div class="species-data-card species-diet-card">
                <span>DIETA</span>
                <strong>
                    <?= formatValue(getDietName($species['diet'])); ?>
                </strong>
            </div>
        </div>
    </section>

    <section class="species-dark-section species-taxonomy-section">
        <div class="species-dark-content">
            <div class="species-section-title species-section-title-dark">
                <span>CLASSIFICAÇÃO</span>
                <h2>
                    Taxonomia
                </h2>
            </div>

            <?php if(!empty($taxonomy)): ?>
                <div class="taxonomy-table">
                    <?php foreach($taxonomy as $taxon): ?>
                        <div class="taxonomy-row">
                            <div class="taxonomy-rank">
                                <?= formatValue(ucfirst($taxon['rank'])); ?>
                            </div>
                            <div class="taxonomy-name">
                                <?= formatValue($taxon['name']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="species-empty-message">
                    Classificação taxonômica não informada.
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="species-content-section">
        <div class="species-section-title">
            <span>COMPORTAMENTO E ECOLOGIA</span>
            <h2>
                Como era essa espécie?
            </h2>
        </div>

        <div class="species-text-grid">
            <article class="species-text-card">
                <span>01</span>
                <h3>
                    Comportamento
                </h3>
                <p>
                    <?= formatValue($species['behavior']); ?>
                </p>
            </article>
            <article class="species-text-card">
                <span>02</span>
                <h3>
                    Ecologia
                </h3>
                <p>
                    <?= formatValue($species['ecology']); ?>
                </p>
            </article>
            <article class="species-text-card">
                <span>03</span>
                <h3>
                    Curiosidades
                </h3>
                <p>
                    <?= formatValue($species['curiosities']); ?>
                </p>
            </article>
        </div>
    </section>

    <section class="species-dark-section species-environment-section">
        <div class="species-dark-content">
            <div class="species-section-title species-section-title-dark">
                <span>CONTEXTO PALEONTOLÓGICO</span>
                <h2>
                    O mundo em que viveu
                </h2>
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
                    <span>CONTINENTE</span>
                    <strong>
                        <?= formatValue($species['continent']); ?>
                    </strong>
                </div>

                <div class="environment-card">
                    <span>REGIÃO</span>
                    <strong>
                        <?= formatValue($species['region']); ?>
                    </strong>
                </div>
            </div>

            <?php if(!empty($relatedSpecies)): ?>
                <div class="contemporaneous-section">
                    <div class="contemporaneous-title">
                        <span>ESPÉCIES RELACIONADAS</span>
                        <h3>
                            Espécies que viveram no mesmo período
                        </h3>
                    </div>

                    <div class="related-species-grid">
                        <?php foreach($relatedSpecies as $related): ?>
                            <a
                                href="index.php?page=species_info&slug=<?= urlencode($related['slug']); ?>"
                                class="related-species-card"
                            >
                                <div class="related-species-image">

                                    <img
                                        src="<?= formatValue($related['image_path']); ?>"
                                        alt="<?= formatValue($related['name']); ?>"
                                    >

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
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="species-content-section species-discovery-section">
        <div class="species-section-title">
            <span>HISTÓRIA</span>
            <h2>
                Descoberta e registro
            </h2>
        </div>

        <div class="discovery-grid">
            <div class="discovery-item">
                <span>ANO DA DESCOBERTA</span>

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
                <span>FORMAÇÃO</span>
                <strong>
                    <?= formatValue($species['formation']); ?>
                </strong>
            </div>

            <div class="discovery-item">
                <span>DESCOBRIDOR</span>
                <strong>
                    <?= formatValue($species['discovered_by']); ?>
                </strong>
            </div>
        </div>
    </section>
</main>