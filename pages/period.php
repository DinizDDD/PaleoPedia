
<?php

include(__DIR__ . '/../config/database.php');

function buildGeologicalScaleRows($node, $childrenByParent, $path = [])
{
    $path[] = $node;

    $children = $childrenByParent[$node['id']] ?? [];

    if (empty($children)) {
        return [$path];
    }

    $rows = [];

    foreach ($children as $child) {
        $rows = array_merge(
            $rows,
            buildGeologicalScaleRows($child, $childrenByParent, $path)
        );
    }

    return $rows;
}

$scaleStmt = $conn->query("
    SELECT id, name, slug, type, parent_id
    FROM geo_time
    ORDER BY begin_year DESC, name ASC
");

$scaleDivisions = $scaleStmt->fetchAll(PDO::FETCH_ASSOC);

$childrenByParent = [];
$scaleRoots = [];

foreach ($scaleDivisions as $division) {
    if ($division['parent_id'] === null) {
        $scaleRoots[] = $division;
    } else {
        $childrenByParent[$division['parent_id']][] = $division;
    }
}

$scaleRows = [];

foreach ($scaleRoots as $root) {
    $scaleRows = array_merge(
        $scaleRows,
        buildGeologicalScaleRows($root, $childrenByParent)
    );
}

$scaleColumns = [
    'eon' => 'Éon',
    'era' => 'Era',
    'periodo' => 'Período',
    'epoca' => 'Época',
    'idade' => 'Idade'
];

$scalePages = [
    'eon' => 'eon_info',
    'era' => 'era_info',
    'periodo' => 'period_info',
    'epoca' => 'epoch_info',
    'idade' => 'age_info'
];

?>

<main class="period-page">

    <!-- INTRODUÇÃO E BANNER -->

    <section class="period-intro">
        <div class="period-hero">
            <img class="period-hero-image" src="assets/images/period/period_banner.jpg" alt="Representação da história geológica da Terra">
            <div class="period-hero-overlay"></div>
            <div class="period-hero-content">
                <span class="period-hero-label">
                    A HISTÓRIA DO NOSSO PLANETA
                </span>

                <h1>
                    TEMPO <span>GEOLÓGICO</span>
                </h1>
                <a href="#geological-scale" class="period-hero-link">
                    EXPLORAR A ESCALA GEOLÓGICA
                    <i class="fa-solid fa-arrow-down"></i>
                </a>
            </div>
        </div>

        <div class="period-introduction">
            <div class="period-introduction-content">
                <div class="period-introduction-text">
                    <span>01 — INTRODUÇÃO</span>
                    <h2>O QUE É O TEMPO GEOLÓGICO?</h2>
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
        </div>
    </section>

    <!-- ORGANIZAÇÃO DO TEMPO GEOLÓGICO -->

    <section class="period-hierarchy">
        <div class="period-section-heading">
            <span>02 — ORGANIZAÇÃO</span>
            <h2>COMO O TEMPO GEOLÓGICO É DIVIDIDO?</h2>
            <p>
                A escala do tempo geológico é organizada em unidades
                hierárquicas, que vão dos maiores intervalos de tempo
                até subdivisões mais específicas.
            </p>
        </div>
        <div class="period-hierarchy-table-wrapper">
            <table class="period-hierarchy-table">
                <thead>
                    <tr>
                        <th>Divisão</th>
                        <th>Descrição</th>
                        <th>Organização</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="hierarchy-level">1º</span>
                            <strong>Éon</strong>
                        </td>
                        <td>
                            Representa os maiores intervalos da história
                            da Terra, abrangendo bilhões de anos e grandes
                            transformações no planeta.
                        </td>
                        <td>
                            Subdivide-se em eras.
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="hierarchy-level">2º</span>
                            <strong>Era</strong>
                        </td>
                        <td>
                            Reúne intervalos marcados por importantes
                            mudanças na vida, na geologia e nas condições
                            ambientais da Terra.
                        </td>
                        <td>
                            Subdivide-se em períodos.
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="hierarchy-level">3º</span>
                            <strong>Período</strong>
                        </td>
                        <td>
                            Divide as eras em intervalos menores,
                            caracterizados por transformações geológicas,
                            climáticas e biológicas.
                        </td>
                        <td>
                            Subdivide-se em épocas.
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="hierarchy-level">4º</span>
                            <strong>Época</strong>
                        </td>
                        <td>
                            Representa subdivisões dos períodos,
                            permitindo identificar mudanças ocorridas
                            em intervalos mais específicos.
                        </td>
                        <td>
                            Subdivide-se em idades.
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="hierarchy-level">5º</span>
                            <strong>Idade</strong>
                        </td>
                        <td>
                            Corresponde às menores unidades da escala
                            apresentada, utilizadas para representar
                            intervalos mais detalhados da história geológica.
                        </td>
                        <td>
                            É a menor subdivisão dessa hierarquia.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="period-hierarchy-note">
            <i class="fa-solid fa-circle-info"></i>
            <p>
                Essas unidades seguem uma hierarquia: os éons são
                subdivididos em eras, as eras em períodos, os períodos
                em épocas e as épocas em idades.
            </p>
        </div>
    </section>

    <!-- ESCALA DO TEMPO GEOLOGICO -->

    <section class="period-scale" id="geological-scale">
        <div class="period-section-heading">
            <span>03 — ESCALA GEOLÓGICA</span>
            <h2>A ESCALA ESTRATIGRÁFICA DA TERRA</h2>
            <p>
                Explore a organização do tempo geológico, desde os grandes
                intervalos da história terrestre até suas subdivisões mais
                específicas. Selecione uma divisão para conhecer seus detalhes.
            </p>
        </div>

        <?php if (!empty($scaleRows)) { ?>
            <div class="period-scale-table-wrapper">
                <table class="period-scale-table">
                    <thead>
                        <tr>
                            <th>Éon</th>
                            <th>Era</th>
                            <th>Período</th>
                            <th>Época</th>
                            <th>Idade</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($scaleRows as $rowIndex => $path) { ?>
                            <?php
                                $divisionsByType = array_fill_keys(
                                    array_keys($scaleColumns),
                                    null
                                );

                                foreach ($path as $division) {
                                    $divisionsByType[$division['type']] = $division;
                                }
                            ?>
                            <tr>
                                <?php foreach ($scaleColumns as $type => $label) { ?>

                                    <?php
                                        $division = $divisionsByType[$type];

                                        if ($division === null) {
                                            echo '<td class="period-scale-empty">—</td>';
                                            continue;
                                        }
                                        $previousDivision = null;
                                        if ($rowIndex > 0) {
                                            foreach ($scaleRows[$rowIndex - 1] as $previous) {
                                                if ($previous['type'] === $type) {
                                                    $previousDivision = $previous;
                                                    break;
                                                }
                                            }
                                        }
                                        if (
                                            $previousDivision !== null &&
                                            $previousDivision['id'] == $division['id']
                                        ) {
                                            continue;
                                        }
                                        $rowspan = 1;
                                        for (
                                            $nextIndex = $rowIndex + 1;
                                            $nextIndex < count($scaleRows);
                                            $nextIndex++
                                        ) {
                                            $nextDivision = null;
                                            foreach ($scaleRows[$nextIndex] as $next) {
                                                if ($next['type'] === $type) {
                                                    $nextDivision = $next;
                                                    break;
                                                }
                                            }
                                            if (
                                                $nextDivision !== null &&
                                                $nextDivision['id'] == $division['id']
                                            ) {
                                                $rowspan++;
                                            } else {
                                                break;
                                            }
                                        }

                                        $page = $scalePages[$type];
                                        $slug = urlencode($division['slug']);
                                        $name = htmlspecialchars(
                                            $division['name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>

                                    <td
                                        class="period-scale-cell period-scale-cell-<?= $type; ?>"
                                        rowspan="<?= $rowspan; ?>"
                                    >
                                        <a
                                            href="index.php?page=<?= $page; ?>&slug=<?= $slug; ?>"
                                            class="period-scale-link"
                                        >
                                            <?= $name; ?>
                                        </a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="period-scale-legend">
                <i class="fa-solid fa-circle-info"></i>
                <p>
                    Selecione uma das divisões da tabela para explorar sua
                    página individual e consultar informações sobre sua
                    duração, características geológicas e acontecimentos.
                </p>
            </div>

        <?php } else { ?>
            <p class="period-empty-message">
                Nenhuma divisão do tempo geológico foi cadastrada até o momento.
            </p>
        <?php } ?>
    </section>

    <!-- COMO OS CIENTISTAS DIVIDEM O TEMPO -->

    <section class="period-science">
        <div class="period-science-content">

            <div class="period-section-heading period-section-heading-light">
                <span>04 — INVESTIGAÇÃO CIENTÍFICA</span>
                <h2>COMO OS CIENTISTAS DETERMINAM O TEMPO GEOLÓGICO?</h2>
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
            <h2>ACONTECIMENTOS QUE MARCARAM A TERRA</h2>
            <p>
                Ao longo de bilhões de anos, diversos acontecimentos
                transformaram profundamente o planeta e a evolução da vida.
            </p>
        </div>

        <div class="period-events-grid">
            <article class="period-event-card">
                <div class="period-event-image">
                    <img src="assets/images/period/pangea.jpg" alt="Representação do supercontinente Pangeia" loading="lazy">
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
                    <img src="assets/images/period/dinosaurs.jpg" alt="Representação de dinossauros" loading="lazy">
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
                    <img src="assets/images/period/extinction.jpg" alt="Representação da extinção do Cretáceo-Paleógeno" loading="lazy">
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
                    <img src="assets/images/period/ice_age.jpg" alt="Representação de uma paisagem da Era do Gelo" loading="lazy">
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
