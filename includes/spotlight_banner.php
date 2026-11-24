<?php 

require_once __DIR__ . '/../config/database.php';

$sql = "
SELECT
    species.id,
    species.name,
    species.scientific_name,
    species.slug,
    species.diet,
    species.continent,
    species.summary,

    COALESCE(spotlight_file._path, principal_file._path) AS image_path,

    geo_time.name AS period_name

FROM species

LEFT JOIN species_images AS spotlight_image
    ON spotlight_image.species_id = species.id
    AND spotlight_image.purpose = 'spotlight'

LEFT JOIN images AS spotlight_file
    ON spotlight_file.id = spotlight_image.image_id

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

ORDER BY RAND()
LIMIT 3
";

$result = $conn->query($sql);
?>

<section class="spotlight_banner">
    <h2 class="spotlight-title" id="spotlight-heading">ESPÉCIES EM DESTAQUE</h2>

    <div class="carousel-container" role="region" aria-roledescription="carrossel" aria-labelledby="spotlight-heading">

        <button type="button" class="carousel-btn prev-btn" aria-label="Espécie anterior">&#10094;</button>
        <button type="button" class="carousel-btn next-btn" aria-label="Próxima espécie">&#10095;</button>

        <div class="carousel">
            <?php while ($species = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <?php

                $imagePath = $species['image_path'] ?? '';
                if (
                    !is_string($imagePath) ||
                    preg_match('~\Aassets/images/[a-zA-Z0-9_/-]+\.(?:png|jpe?g|webp|gif)\z~i', $imagePath) !== 1
                ) {
                    $imagePath = '';
                }

                $backgroundStyle = $imagePath !== ''
                    ? 'background-image: url("' . $imagePath . '");'
                    : '';
                ?>
                <div class="slide" role="group" aria-roledescription="slide">
                    <a href="index.php?page=species_info&slug=<?= urlencode($species['slug']); ?>">
                        <div class="spotlight-div"<?php if ($backgroundStyle !== '') { ?> style="<?= htmlspecialchars($backgroundStyle, ENT_QUOTES, 'UTF-8'); ?>"<?php } ?>>
                            <div class="text">
                                <h3><?= htmlspecialchars(mb_strtoupper($species['name'] ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="scientific-h2"><?= htmlspecialchars($species['scientific_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                                <h4><?= htmlspecialchars(mb_strtoupper($species['diet'] ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?> | <?= htmlspecialchars(mb_strtoupper($species['period_name'] ?? 'Não informado', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?> | <?= htmlspecialchars(mb_strtoupper($species['continent'] ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p class="spotlight-summary"><?= htmlspecialchars($species['summary'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>