<?php

include('config/database.php');

$sql = "
SELECT 
    species.id,
    species.name,
    species.scientific_name,
    species.slug,
    species.diet,
    species.continent,

    images._path AS image_path,

    geo_time.name AS period_name

FROM species

LEFT JOIN images
ON species.image_id = images.id

LEFT JOIN geo_time
ON species.geotime_id = geo_time.id

ORDER BY species.id DESC
";

$result = $conn->query($sql);

?>

<section class="species-section">
    <div class="species-grid">
        <?php while($species = $result->fetch()) { ?>
            <a href="index.php?page=species_info&slug=<?= $species['slug']; ?>" class="species-link">
                <div class="species-card">
                    <div class="species-image">
                        <img src="<?= $species['image_path']; ?>" alt="<?= $species['name']; ?>">
                    </div>
                    <div class="species-content">
                        <div class="species-title">
                            <h2><?= strtoupper($species['name']); ?></h2>
                            <h3><?= $species['scientific_name']; ?></h3>
                        </div>
                        <div class="species-info">
                            <div class="info-item">
                                <span>Dieta</span>
                                <p><?= ucfirst($species['diet']); ?></p>
                            </div>
                            <div class="info-item">
                                <span>Período</span>
                                <p><?= $species['period_name']; ?></p>
                            </div>
                            <div class="info-item">
                                <span>Onde Viveu</span>
                                <p><?= $species['continent']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
</section>