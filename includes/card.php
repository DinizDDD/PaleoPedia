<a
    href="index.php?page=species_info&slug=<?= urlencode($species['slug']); ?>"
    class="species-link"
>

    <div class="species-card">
        <div class="species-image">
            <img
                src="<?= htmlspecialchars($species['image_path']); ?>"
                alt="<?= htmlspecialchars($species['name']); ?>"
            >
        </div>

        <div class="species-content">
            <div class="species-title">
                <h2>
                    <?= strtoupper(
                        htmlspecialchars($species['name'])
                    ); ?>
                </h2>
                <h3>
                    <?= htmlspecialchars(
                        $species['scientific_name']
                    ); ?>
                </h3>
            </div>

            <div class="species-info">
                <div class="info-item">
                    <span>
                        Dieta
                    </span>
                    <p>
                        <?php

                        $dietNames = [
                            'carnivoro' => 'Carnívoro',
                            'herbivoro' => 'Herbívoro',
                            'onivoro' => 'Onívoro',
                            'piscivoro' => 'Piscívoro',
                            'insetivoro' => 'Insetívoro'
                        ];
                        echo $dietNames[$species['diet']]
                            ?? ucfirst($species['diet']);

                        ?>
                    </p>
                </div>

                <div class="info-item">
                    <span>
                        Período
                    </span>
                    <p>
                        <?= htmlspecialchars(
                            $species['period_name'] ?? 'Não informado'
                        ); ?>
                    </p>
                </div>

                <div class="info-item">
                    <span>
                        Onde Viveu
                    </span>
                    <p>
                        <?= htmlspecialchars(
                            $species['continent'] ?? 'Não informado'
                        ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</a>