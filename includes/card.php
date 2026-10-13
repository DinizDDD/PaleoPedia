
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

                <?php if (!empty($species['epoch_name'])): ?>
                    <div class="info-item">
                        <span>Época</span>
                        <p><?= htmlspecialchars($species['epoch_name']); ?></p>
                    </div>
                <?php elseif (!empty($species['period_name'])): ?>
                    <div class="info-item">
                        <span>Período</span>
                        <p><?= htmlspecialchars($species['period_name']); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($species['age_name'])): ?>
                    <div class="info-item">
                        <span>Idade geológica</span>
                        <p><?= htmlspecialchars($species['age_name']); ?></p>
                    </div>
                <?php endif; ?>

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
