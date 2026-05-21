<?php 

include('config/database.php');

$sql = "
SELECT
    species.id
    species.name
    species.scientific.name
    species.diet
    species.continent

    images._path AS image_path
    geo_time.name AS period_name

FROM species

LEFT JOIN images
ON species.image.id = images.id

LEFT JOIN geo_time
ON species.geotime_id = geo_time.id
";

$result = $conn->query($sql);

?>

<section class="spotlight_banner">
    <div class="spotlight-div">
        <a href="index.php?page=specie$&slug=<?= $species['slug']; ?>">ola</a>
    </div>
</section>