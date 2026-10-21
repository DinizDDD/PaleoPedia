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
    species.summary,

    images._path AS image_path,
    geo_time.name AS period_name

FROM species

LEFT JOIN images
ON species.image_id = images.id

LEFT JOIN geo_time
ON species.geotime_id = geo_time.id

ORDER BY RAND()
LIMIT 3
";

$result = $conn->query($sql);
?>

<section class="spotlight_banner">
    <h1>ESPÉCIES EM DESTAQUE</h1>

    <div class="carousel-container">

        <button class="carousel-btn prev-btn">&#10094;</button>
        <button class="carousel-btn next-btn">&#10095;</button>

        <div class="carousel">
            <?php while($species = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="slide">
                    <a href="index.php?page=species_info&slug=<?= urlencode($species['slug']); ?>">
                        <div class="spotlight-div" style="background-image:url('<?= htmlspecialchars($species['image_path'] ?? '', ENT_QUOTES, 'UTF-8'); ?>')">
                            <div class="text">
                                <h2><?= mb_strtoupper($species['name']); ?></h2>
                                <h2 class="scientific-h2"><?= mb_strtoupper($species['scientific_name']); ?></h2>
                                <h4><?= mb_strtoupper($species['diet'] ?? ''); ?> | <?= mb_strtoupper($species['period_name'] ?? 'Não informado'); ?> | <?= mb_strtoupper($species['continent'] ?? ''); ?></h4>
                                <p><?= htmlspecialchars($species['summary'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>