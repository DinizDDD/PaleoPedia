<?php

include(__DIR__ . '/../config/database.php');

function periodValue($value)
{
    if ($value === null || $value === '') {
        return 'Informação não cadastrada.';
    }

    return nl2br(htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'));
}

function periodDate($value)
{
    if ($value === null) {
        return 'Não informado';
    }

    $value = (float) $value;

    if ($value <= 0) {
        return 'Presente';
    }

    if ($value < 1) {
        $years = $value * 1000000;

        return number_format($years, 0, ',', '.') . ' anos atrás';
    }

    $number = number_format($value, 2, ',', '.');
    $number = rtrim(rtrim($number, '0'), ',');

    return $number . ' milhões de anos atrás';
}

function periodRange($begin, $end)
{
    return periodDate($begin) . ' — ' . periodDate($end);
}

$periodStmt = $conn->query("
    SELECT *
    FROM geo_time
    WHERE type = 'periodo'
    ORDER BY begin_year DESC
");

$periods = $periodStmt->fetchAll(PDO::FETCH_ASSOC);

$timeStmt = $conn->query("
    SELECT id, name, slug, type, begin_year, end_year, parent_id
    FROM geo_time
    WHERE type IN ('epoca', 'idade')
    ORDER BY begin_year DESC
");

$timeDivisions = $timeStmt->fetchAll(PDO::FETCH_ASSOC);

$children = [];

foreach ($timeDivisions as $division) {
    $children[$division['parent_id']][] = $division;
}

$totalPeriods = count($periods);

$totalEpochs = count(array_filter(
    $timeDivisions,
    fn($division) => $division['type'] === 'epoca'
));

$totalAges = count(array_filter(
    $timeDivisions,
    fn($division) => $division['type'] === 'idade'
));

?>

<main class="period-page">

    <!-- BANNER -->

    <section class="period-hero">
        <img class="period-hero-image" src="assets/images/period/period_banner.jpg" alt="Representação da história geológica da Terra">
        <div class="period-hero-overlay"></div>
        <div class="period-hero-content">
            <span class="period-hero-label">
                A HISTÓRIA DO NOSSO PLANETA
            </span>
            <h1>
                TEMPO <span>GEOLÓGICO</span>
            </h1>
            <p>
                Explore bilhões de anos de transformações e descubra como
                a Terra se formou, como seus continentes mudaram e como a
                vida evoluiu ao longo de diferentes períodos geológicos.
            </p>
            <a href="#geological-scale" class="period-hero-link">
                EXPLORAR A ESCALA GEOLÓGICA
                <i class="fa-solid fa-arrow-down"></i>
            </a>
        </div>
    </section>

    <section class="period-introduction">
        <div class="period-section-heading">
            <span>01 — INTRODUÇÃO</span>
            <h2>O que é o tempo geológico?</h2>
        </div>
        <div class="period-introduction-content">
            <div class="period-introduction-text">
                <p>
                    O tempo geológico representa toda a história da Terra,
                    desde sua formação, há aproximadamente 4,54 bilhões de
                    anos, até os dias atuais. Para compreender essa enorme
                    escala de tempo, os cientistas organizaram a história
                    do planeta em diferentes divisões, permitindo estudar
                    suas transformações geológicas, climáticas e biológicas.
                </p>
                <p>
                    Cada divisão representa um intervalo marcado por
                    acontecimentos importantes, como mudanças na
                    configuração dos continentes, alterações ambientais,
                    surgimento de grupos de organismos e grandes eventos
                    de extinção.
                </p>
            </div>
            <div class="period-introduction-highlight">
                <span>4,54</span>
                <strong>BILHÕES DE ANOS</strong>
                <p>
                    Idade aproximada da Terra, estimada por meio de
                    evidências geológicas e datações radiométricas.
                </p>
            </div>
        </div>
    </section>

    <!-- ORGANIZAÇÃO DO TEMPO GEOLÓGICO -->

    <section class="period-hierarchy">
        <div class="period-section-heading">
            <span>02 — ORGANIZAÇÃO</span>
            <h2>Como o tempo geológico é dividido?</h2>
            <p>
                A escala do tempo geológico é organizada em unidades
                hierárquicas, que vão dos maiores intervalos de tempo
                até subdivisões mais específicas.
            </p>
        </div>
        <div class="period-hierarchy-grid">
            <article class="period-hierarchy-card">
                <span class="hierarchy-number">01</span>
                <div class="hierarchy-icon">
                    <i class="fa-solid fa-earth-americas"></i>
                </div>
                <h3>Éon</h3>
                <p>
                    Representa os maiores intervalos da história da Terra,
                    abrangendo bilhões de anos e grandes transformações
                    no planeta.
                </p>

            </article>
            <article class="period-hierarchy-card">
                <span class="hierarchy-number">02</span>
                <div class="hierarchy-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <h3>Era</h3>
                <p>
                    Subdivide os éons e reúne intervalos caracterizados
                    por importantes mudanças na vida e nas condições
                    ambientais da Terra.
                </p>
            </article>

            <article class="period-hierarchy-card">
                <span class="hierarchy-number">03</span>
                <div class="hierarchy-icon">
                    <i class="fa-solid fa-mountain"></i>
                </div>
                <h3>Período</h3>
                <p>
                    Divide as eras em intervalos menores, marcados por
                    transformações geológicas, climáticas e biológicas.
                </p>
            </article>

            <article class="period-hierarchy-card">
                <span class="hierarchy-number">04</span>
                <div class="hierarchy-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3>Época</h3>
                <p>
                    Subdivide os períodos em intervalos mais específicos,
                    permitindo observar mudanças ocorridas ao longo
                    de milhões de anos.
                </p>
            </article>

            <article class="period-hierarchy-card">
                <span class="hierarchy-number">05</span>
                <div class="hierarchy-icon">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <h3>Idade</h3>
                <p>
                    Corresponde a subdivisões menores das épocas,
                    utilizadas para representar intervalos mais
                    detalhados da história geológica.
                </p>
            </article>
        </div>
        <div class="period-hierarchy-note">
            <i class="fa-solid fa-circle-info"></i>
            <p>
                Essas divisões formam uma hierarquia: os éons são
                subdivididos em eras, as eras em períodos, os períodos
                em épocas e as épocas em idades.
            </p>
        </div>
    </section>

    <!-- ESCALA DO TEMPO GEOLOGICO -->

    <section class="period-scale" id="geological-scale">
        <div class="period-section-heading">
            <span>03 — ESCALA GEOLÓGICA</span>
            <h2>A história da Terra em períodos</h2>
            <p>
                Explore os períodos geológicos cadastrados na Paleopedia
                e conheça suas subdivisões.
            </p>
        </div>
        <div class="period-scale-summary">

            <div class="period-scale-stat">
                <strong><?= $totalPeriods; ?></strong>
                <span>PERÍODOS</span>
            </div>

            <div class="period-scale-stat">
                <strong><?= $totalEpochs; ?></strong>
                <span>ÉPOCAS</span>
            </div>

            <div class="period-scale-stat">
                <strong><?= $totalAges; ?></strong>
                <span>IDADES</span>
            </div>
        </div>

        <?php if (!empty($periods)) { ?>
            <div class="period-scale-list">
                <?php foreach ($periods as $period) { ?>
                    <article class="period-scale-item">
                        <div class="period-scale-main">

                            <div class="period-scale-date">
                                <span>
                                    <?= periodDate($period['begin_year']); ?>
                                </span>
                                <i class="fa-solid fa-arrow-right"></i>
                                <span>
                                    <?= periodDate($period['end_year']); ?>
                                </span>
                            </div>

                            <div class="period-scale-information">
                                <span>PERÍODO GEOLÓGICO</span>
                                <h3>
                                    <?= htmlspecialchars($period['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </h3>
                                <p>
                                    <?= htmlspecialchars($period['slug'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>

                            <div class="period-scale-action">
                                <a
                                    href="index.php?page=period_info&slug=<?= urlencode($period['slug']); ?>"
                                    aria-label="Conhecer <?= htmlspecialchars($period['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                >
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </div>

                        <?php if (!empty($children[$period['id']])) { ?>
                            <div class="period-scale-children">
                                <?php foreach ($children[$period['id']] as $epoch) { ?>
                                    <?php if ($epoch['type'] === 'epoca') { ?>
                                        <div class="period-scale-epoch">

                                            <div class="period-scale-division-heading">
                                                <span>ÉPOCA</span>
                                                <strong>
                                                    <?= htmlspecialchars($epoch['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </strong>
                                                <small>
                                                    <?= periodRange($epoch['begin_year'], $epoch['end_year']); ?>
                                                </small>
                                            </div>

                                            <?php if (!empty($children[$epoch['id']])) { ?>
                                                <div class="period-scale-ages">
                                                    <?php foreach ($children[$epoch['id']] as $age) { ?>
                                                        <div class="period-scale-age">
                                                            <span>
                                                                <?= htmlspecialchars($age['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                            </span>
                                                            <small>
                                                                <?= periodRange($age['begin_year'], $age['end_year']); ?>
                                                            </small>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </article>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="period-empty-message">
                Nenhum período geológico foi cadastrado até o momento.
            </p>
        <?php } ?>

        <p class="period-scale-disclaimer">
            A escala será ampliada conforme novas divisões geológicas
            forem cadastradas na Paleopedia.
        </p>
    </section>

    <!-- COMO OS CIENTISTAS DIVIDEM O TEMPO -->

    <section class="period-science">
        <div class="period-science-content">

            <div class="period-section-heading period-section-heading-light">
                <span>04 — INVESTIGAÇÃO CIENTÍFICA</span>
                <h2>Como os cientistas determinam o tempo geológico?</h2>
                <p>
                    A divisão da história da Terra não é feita de maneira
                    aleatória. Ela é estabelecida por meio da análise de
                    evidências preservadas nas rochas e nos fósseis.
                </p>
            </div>

            <div class="period-science-grid">
                <article class="period-science-card">
                    <div class="period-science-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3>Camadas de rochas</h3>
                    <p>
                        A estratigrafia estuda as camadas de rochas e suas
                        relações. Em muitos casos, as camadas inferiores
                        são mais antigas que as superiores, ajudando a
                        estabelecer a sequência dos acontecimentos.
                    </p>
                </article>

                <article class="period-science-card">
                    <div class="period-science-icon">
                        <i class="fa-solid fa-bone"></i>
                    </div>
                    <h3>Fósseis</h3>
                    <p>
                        Os fósseis permitem identificar organismos que
                        viveram em diferentes épocas. Algumas espécies
                        são especialmente importantes para reconhecer
                        e comparar camadas geológicas.
                    </p>
                </article>

                <article class="period-science-card">
                    <div class="period-science-icon">
                        <i class="fa-solid fa-atom"></i>
                    </div>
                    <h3>Datação radiométrica</h3>
                    <p>
                        A análise do decaimento de elementos radioativos
                        em minerais permite estimar a idade de determinadas
                        rochas e estabelecer datas para acontecimentos
                        geológicos.
                    </p>
                </article>

                <article class="period-science-card">
                    <div class="period-science-icon">
                        <i class="fa-solid fa-earth-americas"></i>
                    </div>
                    <h3>Mudanças ambientais</h3>
                    <p>
                        Alterações climáticas, variações no nível dos mares,
                        mudanças na vegetação e grandes eventos geológicos
                        também ajudam a reconhecer transformações
                        importantes na história do planeta.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- GRANDES ACONTECIMENTOS -->

    <section class="period-events">
        <div class="period-section-heading">
            <span>05 — GRANDES TRANSFORMAÇÕES</span>
            <h2>Acontecimentos que marcaram a Terra</h2>
            <p>
                Ao longo de bilhões de anos, diversos acontecimentos
                transformaram profundamente o planeta e a evolução da vida.
            </p>
        </div>

        <div class="period-events-grid">
            <article class="period-event-card">
                <div class="period-event-image">
                    <img
                        src="assets/images/period/pangea.jpg"
                        alt="Representação do supercontinente Pangeia"
                        loading="lazy"
                    >
                    <span>CONTINENTES</span>
                </div>
                <div class="period-event-content">
                    <span>ERA PALEOZOICA E MESOZOICA</span>
                    <h3>A formação e fragmentação da Pangeia</h3>
                    <p>
                        Os continentes já estiveram unidos em um enorme
                        supercontinente chamado Pangeia. Ao longo de milhões
                        de anos, ele se fragmentou, contribuindo para a
                        configuração dos continentes atuais.
                    </p>
                </div>
            </article>

            <article class="period-event-card">
                <div class="period-event-image">
                    <img
                        src="assets/images/period/dinosaurs.jpg"
                        alt="Representação de dinossauros"
                        loading="lazy"
                    >
                    <span>BIODIVERSIDADE</span>
                </div>
                <div class="period-event-content">
                    <span>ERA MESOZOICA</span>
                    <h3>A diversificação dos dinossauros</h3>
                    <p>
                        Durante a Era Mesozoica, os dinossauros se
                        diversificaram e ocuparam diferentes ambientes,
                        tornando-se um dos grupos mais marcantes da
                        história da vida terrestre.
                    </p>
                </div>
            </article>

            <article class="period-event-card">
                <div class="period-event-image">
                    <img
                        src="assets/images/period/extinction.jpg"
                        alt="Representação da extinção do Cretáceo-Paleógeno"
                        loading="lazy"
                    >
                    <span>EXTINÇÕES</span>
                </div>
                <div class="period-event-content">
                    <span>FINAL DO CRETÁCEO</span>
                    <h3>A extinção em massa do Cretáceo</h3>
                    <p>
                        Há aproximadamente 66 milhões de anos, um grande
                        evento de extinção eliminou os dinossauros não
                        avianos e diversos outros grupos de organismos,
                        provocando profundas mudanças nos ecossistemas.
                    </p>
                </div>
            </article>

            <article class="period-event-card">
                <div class="period-event-image">
                    <img
                        src="assets/images/period/ice_age.jpg"
                        alt="Representação de uma paisagem da Era do Gelo"
                        loading="lazy"
                    >
                    <span>CLIMA</span>
                </div>
                <div class="period-event-content">
                    <span>PERÍODO QUATERNÁRIO</span>
                    <h3>As grandes glaciações</h3>
                    <p>
                        Durante o Quaternário, o planeta passou por
                        importantes ciclos de avanço e recuo das geleiras,
                        influenciando o clima, os ambientes e a distribuição
                        de diversas espécies.
                    </p>
                </div>
            </article>
        </div>
    </section>
</main>
