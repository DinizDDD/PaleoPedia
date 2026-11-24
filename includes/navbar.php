<nav class="site-nav" aria-label="Navegação principal">
    <div class="nav-left">
        <a class="nav-image" href="index.php?page=home" aria-label="Paleopedia — ir para a página inicial">
            <img src="assets/images/logo.png" alt="" width="48" height="48">
        </a>
    </div>

    <button type="button" class="nav-toggle" aria-label="Abrir menu de navegação"
            aria-expanded="false" aria-controls="primary-navigation">
        <span class="nav-toggle-line" aria-hidden="true"></span>
        <span class="nav-toggle-line" aria-hidden="true"></span>
        <span class="nav-toggle-line" aria-hidden="true"></span>
    </button>

    <div class="nav-mid" id="primary-navigation">
        <div class="itens">
            <a class="nav-item" href="index.php?page=home" <?= $page === 'home' ? 'aria-current="page"' : ''; ?>>HOME</a>
            <a class="nav-item" href="index.php?page=species" <?= in_array($page, ['species', 'species_info'], true) ? 'aria-current="page"' : ''; ?>>ESPÉCIES</a>
            <a class="nav-item" href="index.php?page=period" <?= in_array($page, ['period', 'time_info'], true) ? 'aria-current="page"' : ''; ?>>PERÍODOS</a>
        </div>
    </div>
</nav>