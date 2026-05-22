<?php 

include('config/database.php');

$sql = "
SELECT
    species.id,
    species.name,
    species.scientific_name,
    species.diet,
    species.continent,

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

    <div class='spotlight-div'>
        <div class="text">
            <h2>TIRANOSSAURO REX</h2>
            <h2 class="scientific-h2">TYRANNOSAURUS REX</h2>
            <h4>CRETÁCEO SUPERIOR | CARNÍVORO</h4>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime explicabo eligendi exercitationem laboriosam quidem mollitia ut! Porro, asperiores a repudiandae mollitia accusantium esse qui voluptates magni alias nesciunt, optio officia.</p>
        </div>
    </div>
</section>