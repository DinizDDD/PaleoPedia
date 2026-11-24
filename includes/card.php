<a
    href="index.php?page=species_info&slug=<?= urlencode($species['slug']); ?>"
    class="species-link"
>
    <div class="species-card">
        <div class="species-image">
            <?php if (!empty($species['image_path'])): ?>
                <img src="<?= htmlspecialchars($species['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                     alt="Representação de <?= htmlspecialchars($species['name'], ENT_QUOTES, 'UTF-8'); ?>"
                     loading="lazy" decoding="async">
            <?php else: ?>
                <span class="species-image-missing">Imagem indisponível</span>
            <?php endif; ?>
        </div>

        <div class="species-content">
            <div class="species-title">
                <h3 class="species-card-name">
                    <?= htmlspecialchars(mb_strtoupper($species['name'] ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <p class="species-card-scientific">
                    <?= htmlspecialchars(
                        $species['scientific_name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </p>
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
