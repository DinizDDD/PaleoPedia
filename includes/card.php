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
                    <?= htmlspecialchars($species['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <p class="species-card-scientific">
                    <?= htmlspecialchars(
                        $species['scientific_name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </p>
            </div>

            <dl class="species-info">
                <div class="info-item">
                    <dt class="sr-only">Dieta</dt>
                    <dd>
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
                    </dd>
                </div>

                <div class="info-item">
                    <dt class="sr-only"><?= !empty($species['epoch_name'])
                        ? 'Época'
                        : (!empty($species['period_name']) ? 'Período' : 'Tempo geológico'); ?></dt>
                    <dd>
                        <?= htmlspecialchars(
                            ($species['epoch_name'] ?? '') ?: (($species['period_name'] ?? '') ?: 'Não informado'),
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </dd>
                </div>

                <div class="info-item">
                    <dt class="sr-only">Onde viveu</dt>
                    <dd>
                        <?= htmlspecialchars(
                            $species['continent'] ?? 'Não informado',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </dd>
                </div>
            </dl>

            <div class="species-card-cta" aria-hidden="true">
                <span class="species-card-arrow">&rarr;</span>
            </div>
        </div>
    </div>
</a>
