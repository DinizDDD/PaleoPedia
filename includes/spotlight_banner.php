<?php 

include('config/database.php');

$sql = "
SELECT
    species.id,
    species.name,
    species.scientific_name,
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
";

$result = $conn->query($sql);


?>

<section class='spotlight_banner'>
    <h1>ESPÉCIES EM DESTAQUE</h1>

    <?php while($species = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <a href="#">
        <div class='spotlight-div'>
            <div class="text">
                <h2><?= mb_strtoupper($species['name']); ?></h2>
                <h2 class="scientific-h2"><?= mb_strtoupper($species['scientific_name']); ?></h2>
                <h4> <?= mb_strtoupper($species['diet']); ?> | <?= mb_strtoupper($species['period_name']);?> | <?= mb_strtoupper($species['continent']); ?></h4>
                <p><?=  ($species['summary']); ?></p>
            </div>
        </div>
    </a>
    <?php } ?>
</section>