
<a
    href="index.php?page=species_info&slug=<?= urlencode($species['slug']); ?>"
    class="species-link"
>
    <div class="species-card">
        <div class="species-image">
            <img
                src="<?= htmlspecialchars($species['image_path'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?= htmlspecialchars($species['name'], ENT_QUOTES, 'UTF-8'); ?>"
            >
        </div>

        <div class="species-content">
            <div class="species-title">
                <h2>
                    <?= strtoupper(
                        htmlspecialchars($species['name'], ENT_QUOTES, 'UTF-8')
                    ); ?>
                </h2>
                <h3>
                    <?= htmlspecialchars(
                        $species['scientific_name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </h3>
            </div>

            <div class="species-info">
                <div class="info-item">
                    <span>Dieta</span>
                    <p>
                        <?php
                        $dietNames = [
                            'carnívoro' => 'Carnívoro',
                            'herbívoro' => 'Herbívoro',
                            'onívoro' => 'Onívoro',
                            'piscívoro' => 'Piscívoro',
                            'insetívoro' => 'Insetívoro'
                        ];

                        echo htmlspecialchars(
                            $dietNames[$species['diet'] ?? ''] ?? 'Não informada',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </p>
                </div>

                <div class="info-item">
                    <span>Época</span>
                    <p>
                        <?= htmlspecialchars(
                            $species['epoch_name'] ?? $species['period_name'] ?? 'Não informada',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </p>
                </div>

                <div class="info-item">
                    <span>Onde viveu</span>
                    <p>
                        <?= htmlspecialchars(
                            $species['continent'] ?? 'Não informado',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</a>
