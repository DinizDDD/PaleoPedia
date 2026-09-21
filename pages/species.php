<?php

require_once __DIR__ . '/../config/database.php';

$search = $_GET['search'] ?? '';
$diet = $_GET['diet'] ?? '';
$period = $_GET['period'] ?? '';
$continent = $_GET['continent'] ?? '';

$conditions = [];
$params = [];

if($search !== ''){

    $conditions[] = "
        (
            species.name LIKE :search
            OR species.scientific_name LIKE :search
        )
    ";

    $params['search'] = '%' . $search . '%';
}

if($diet !== ''){

    $conditions[] = "species.diet = :diet";

    $params['diet'] = $diet;
}

if($period !== ''){

    $conditions[] = "species.geotime_id = :period";

    $params['period'] = $period;
}

if($continent !== ''){

    $conditions[] = "species.continent = :continent";

    $params['continent'] = $continent;
}

$where = '';

if(!empty($conditions)){

    $where = 'WHERE ' . implode(' AND ', $conditions);

}

$sql = "
SELECT 
    species.id,
    species.name,
    species.scientific_name,
    species.slug,
    species.diet,
    species.continent,

    images._path AS image_path,

    geo_time.id AS period_id,
    geo_time.name AS period_name,
    geo_time.begin_year

FROM species

LEFT JOIN images
ON species.image_id = images.id

LEFT JOIN geo_time
ON species.geotime_id = geo_time.id

$where

ORDER BY
    geo_time.begin_year ASC,
    species.name ASC
";

$stmt = $conn->prepare($sql);

$stmt->execute($params);

$speciesList = $stmt->fetchAll();

$groupedSpecies = [];

foreach($speciesList as $species){

    $periodName = $species['period_name'];

    if(!$periodName){
        $periodName = 'Período desconhecido';
    }

    $groupedSpecies[$periodName][] = $species;
}

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
                    value="<?= htmlspecialchars($search); ?>"
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
                        <option value="">
                            Todas
                        </option>
                        <option
                            value="carnivoro"
                            <?= $diet === 'carnivoro' ? 'selected' : ''; ?>
                        >
                            Carnívoro
                        </option>
                        <option
                            value="herbivoro"
                            <?= $diet === 'herbivoro' ? 'selected' : ''; ?>
                        >
                            Herbívoro
                        </option>
                        <option
                            value="onivoro"
                            <?= $diet === 'onivoro' ? 'selected' : ''; ?>
                        >
                            Onívoro
                        </option>
                        <option
                            value="piscivoro"
                            <?= $diet === 'piscivoro' ? 'selected' : ''; ?>
                        >
                            Piscívoro
                        </option>
                        <option
                            value="insetivoro"
                            <?= $diet === 'insetivoro' ? 'selected' : ''; ?>
                        >
                            Insetívoro
                        </option>
                    </select>
                </div>

                <div class="filter">
                    <label for="period">
                        Período
                    </label>
                    <select name="period" id="period">
                        <option value="">
                            Todos
                        </option>
                        <?php
                        $periods = $conn->query("
                            SELECT id, name
                            FROM geo_time
                            WHERE type = 'periodo'
                            ORDER BY begin_year ASC
                        ");
                        while($periodItem = $periods->fetch()){
                        ?>
                            <option
                                value="<?= $periodItem['id']; ?>"
                                <?= $period == $periodItem['id'] ? 'selected' : ''; ?>
                            >
                                <?= htmlspecialchars($periodItem['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="filter">
                    <label for="continent">
                        Onde viveu
                    </label>
                    <select name="continent" id="continent">
                        <option value="">
                            Todos
                        </option>
                        <?php
                        $continents = $conn->query("
                            SELECT DISTINCT continent
                            FROM species
                            WHERE continent IS NOT NULL
                            AND continent != ''
                            ORDER BY continent
                        ");
                        while($continentItem = $continents->fetch()){
                        ?>
                            <option
                                value="<?= htmlspecialchars($continentItem['continent']); ?>"
                                <?= $continent === $continentItem['continent'] ? 'selected' : ''; ?>
                            >
                                <?= htmlspecialchars($continentItem['continent']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button
                    type="submit"
                    class="filter-button"
                >
                    Filtrar
                </button>

                <a
                    href="index.php?page=species"
                    class="clear-button"
                >
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <?php if(empty($speciesList)){ ?>
        <div class="no-results">
            <h2>Nenhuma espécie encontrada</h2>
            <p>
                Tente alterar os filtros ou o termo pesquisado.
            </p>
        </div>
    <?php } ?>

    <div class="species-results">
        <?php foreach($groupedSpecies as $periodName => $speciesGroup){ ?>
            <div class="period-group">
                <div class="period-title">
                    <h2>
                        <?= htmlspecialchars($periodName); ?>
                    </h2>
                </div>

                <div class="species-grid">
                    <?php foreach($speciesGroup as $species){ ?>
                        <?php
                            include('includes/card.php');
                        ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>