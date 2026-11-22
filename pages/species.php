
<?php

require_once __DIR__ . '/../config/database.php';

$search = trim($_GET['search'] ?? '');
$diet = $_GET['diet'] ?? '';
$period = $_GET['period'] ?? '';
$continent = $_GET['continent'] ?? '';

$conditions = [];
$params = [];

$validContinents = [
    'África',
    'América do Norte',
    'América do Sul',
    'Ásia',
    'Europa',
    'Oceania',
    'Antártida'
];

if ($search !== '') {
    $conditions[] = "(
        species.name LIKE :search
        OR species.scientific_name LIKE :search
    )";

    $params['search'] = '%' . $search . '%';
}

$validDiets = [
    'carnívoro',
    'herbívoro',
    'onívoro',
    'piscívoro',
    'insetívoro'
];

if (in_array($diet, $validDiets, true)) {
    $conditions[] = "species.diet = :diet";
    $params['diet'] = $diet;
} else {
    $diet = '';
}

// Define a consulta recursiva somente quando existe um filtro geológico válido.
$geologicalCte = '';

if ($period !== '' && ctype_digit((string) $period)) {
    $geologicalCte = "
        WITH RECURSIVE selected_geotime AS (
            SELECT id
            FROM geo_time
            WHERE id = :selected_geotime_id

            UNION ALL

            SELECT child.id
            FROM geo_time AS child
            INNER JOIN selected_geotime AS parent
                ON child.parent_id = parent.id
        )
    ";

    $conditions[] = 'species.geotime_id IN (SELECT id FROM selected_geotime)';
    $params['selected_geotime_id'] = (int) $period;
} else {
    $period = '';
}

if (in_array($continent, $validContinents, true)) {
    $conditions[] = "
        CONCAT(
            ',',
            REPLACE(
                REPLACE(species.continent, ' e ', ','),
                ', ',
                ','
            ),
            ','
        ) LIKE :continent
    ";

    $params['continent'] = '%,' . $continent . ',%';
} else {
    $continent = '';
}

$where = '';

if (!empty($conditions)) {
    $where = 'WHERE ' . implode(' AND ', $conditions);
}

$sql = "
$geologicalCte
SELECT
    species.id,
    species.name,
    species.scientific_name,
    species.slug,
    species.diet,
    species.continent,

    COALESCE(card_file._path, principal_file._path) AS image_path,

    geo_time.id AS geotime_id,
    geo_time.name AS geotime_name,
    geo_time.type AS geotime_type,
    geo_time.begin_year AS geotime_begin_year,

    geo_parent.id AS parent_id,
    geo_parent.name AS parent_name,
    geo_parent.type AS parent_type,

    geo_grandparent.id AS grandparent_id,
    geo_grandparent.name AS grandparent_name,
    geo_grandparent.type AS grandparent_type,

    CASE
        WHEN geo_time.type = 'periodo'
            THEN geo_time.id
        WHEN geo_parent.type = 'periodo'
            THEN geo_parent.id
        WHEN geo_grandparent.type = 'periodo'
            THEN geo_grandparent.id
        ELSE NULL
    END AS period_id,

    CASE
        WHEN geo_time.type = 'periodo'
            THEN geo_time.name
        WHEN geo_parent.type = 'periodo'
            THEN geo_parent.name
        WHEN geo_grandparent.type = 'periodo'
            THEN geo_grandparent.name
        ELSE NULL
    END AS period_name,

    CASE
        WHEN geo_time.type = 'epoca'
            THEN geo_time.name
        WHEN geo_parent.type = 'epoca'
            THEN geo_parent.name
        ELSE NULL
    END AS epoch_name,

    CASE
        WHEN geo_time.type = 'periodo'
            THEN geo_time.begin_year
        WHEN geo_parent.type = 'periodo'
            THEN geo_parent.begin_year
        WHEN geo_grandparent.type = 'periodo'
            THEN geo_grandparent.begin_year
        ELSE NULL
    END AS period_begin_year

FROM species

LEFT JOIN species_images AS card_image
    ON card_image.species_id = species.id
    AND card_image.purpose = 'card'

LEFT JOIN images AS card_file
    ON card_file.id = card_image.image_id

LEFT JOIN species_images AS principal_image
    ON principal_image.species_id = species.id
    AND principal_image.purpose = 'principal'

LEFT JOIN images AS principal_file
    ON principal_file.id = COALESCE(
        principal_image.image_id,
        species.image_id
    )

LEFT JOIN geo_time
    ON species.geotime_id = geo_time.id

LEFT JOIN geo_time AS geo_parent
    ON geo_time.parent_id = geo_parent.id

LEFT JOIN geo_time AS geo_grandparent
    ON geo_parent.parent_id = geo_grandparent.id

$where

ORDER BY
    period_begin_year DESC,
    species.name ASC
";

$stmt = $conn->prepare($sql);
$stmt->execute($params);

$speciesList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$groupedSpecies = [];

foreach ($speciesList as $species) {
    $periodName = $species['period_name'] ?? 'Período não informado';
    $groupedSpecies[$periodName][] = $species;
}

$geologicalTimes = $conn->query("
    SELECT
        gt_atual.id,
        gt_atual.name,
        gt_atual.type,
        gt_atual.begin_year,
        parent_time.name AS parent_name,
        grandparent_time.name AS grandparent_name,
        grandparent_time.type AS grandparent_type
    FROM geo_time AS gt_atual
    LEFT JOIN geo_time AS parent_time
        ON gt_atual.parent_id = parent_time.id
    LEFT JOIN geo_time AS grandparent_time
        ON parent_time.parent_id = grandparent_time.id
    ORDER BY gt_atual.begin_year DESC, gt_atual.id ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="species-section">
    <div class="species-search">
        <form method="GET" action="index.php">
            <input
                type="hidden"
                name="page"
                value="species"
            >
            <div class="search-area">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar espécie..."
                    value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"
                >
                <button type="submit">
                    Buscar
                </button>
            </div>

            <div class="filters">
                <div class="filter">
                    <label for="diet">
                        Dieta
                    </label>
                    <select name="diet" id="diet">
                        <option value="">Todas</option>

                        <?php
                        $dietOptions = [
                            'carnívoro' => 'Carnívoro',
                            'herbívoro' => 'Herbívoro',
                            'onívoro' => 'Onívoro',
                            'piscívoro' => 'Piscívoro',
                            'insetívoro' => 'Insetívoro'
                        ];

                        foreach ($dietOptions as $value => $label) {
                        ?>
                            <option
                                value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>"
                                <?= $diet === $value ? 'selected' : ''; ?>
                            >
                                <?= $label; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="filter">
                    <label for="period">
                        Tempo geológico
                    </label>

                    <select name="period" id="period">
                        <option value="">Todos</option>

                        <?php foreach ($geologicalTimes as $time) { ?>
                            <?php
                            $timeLabel = $time['name'];

                            if ($time['type'] === 'epoca' && $time['parent_name']) {
                                $timeLabel = $time['parent_name'] . ' → ' . $time['name'];
                            }

                            if ($time['type'] === 'idade') {
                                if ($time['parent_name']) {
                                    $timeLabel = $time['parent_name'] . ' → ' . $time['name'];
                                }

                                if (
                                    $time['grandparent_name']
                                    && $time['grandparent_type'] === 'periodo'
                                ) {
                                    $timeLabel = $time['grandparent_name']
                                        . ' → '
                                        . $time['parent_name']
                                        . ' → '
                                        . $time['name'];
                                }
                            }
                            ?>

                            <option
                                value="<?= (int) $time['id']; ?>"
                                <?= (string) $period === (string) $time['id'] ? 'selected' : ''; ?>
                            >
                                <?= htmlspecialchars($timeLabel, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="filter">
                    <label for="continent">
                        Onde viveu
                    </label>
                    <select name="continent" id="continent">
                        <option value="">Todos</option>
                        <?php foreach ($validContinents as $continentOption) { ?>
                            <option
                                value="<?= htmlspecialchars($continentOption, ENT_QUOTES, 'UTF-8'); ?>"
                                <?= $continent === $continentOption ? 'selected' : ''; ?>
                            >
                                <?= htmlspecialchars($continentOption, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="filter-button">
                    Filtrar
                </button>
                <a href="index.php?page=species" class="clear-button">
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <?php if (empty($speciesList)) { ?>
        <div class="no-results">
            <h2>Nenhuma espécie encontrada</h2>
            <p>
                Tente alterar os filtros ou o termo pesquisado.
            </p>
        </div>

    <?php } ?>
    <div class="species-results">
        <?php foreach ($groupedSpecies as $periodName => $speciesGroup) { ?>
            <div class="period-group">
                <div class="period-title">
                    <h2>
                        <?= htmlspecialchars($periodName, ENT_QUOTES, 'UTF-8'); ?>
                    </h2>
                </div>
                <div class="species-grid">
                    <?php foreach ($speciesGroup as $species) { ?>
                        <?php include __DIR__ . '/../includes/card.php'; ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
