<?php
$nav_services = services();

$current_page = current_page();
$on_service   = isset($nav_services[$current_page]);

/** Markiert den Eintrag der Seite, auf der man gerade ist. */
function nav_current(bool $is_current): string
{
    return $is_current ? ' class="current"' : '';
}
?>
<a class="skiplink" href="#main">Zum Inhalt springen</a>

<nav aria-label="Hauptnavigation">
    <a href="index" class="logocontainer">
        <div class="innercircle" aria-hidden="true"></div>
        <div class="outercircle" aria-hidden="true"><img src="img/logo-circle.svg" alt="" width="50" height="50"></div>
        <span class="logo"><?= e(SITE_NAME) ?><br><?= e(SITE_OWNER) ?></span>
    </a>
    <div class="navbar">
        <button class="burger-icon" type="button" aria-label="Menü öffnen" aria-expanded="false" aria-controls="navList">
            <span class="bar" aria-hidden="true"></span>
            <span class="bar" aria-hidden="true"></span>
            <span class="bar" aria-hidden="true"></span>
        </button>
        <div class="nav-list-cont">
            <ul class="nav-list" id="navList">
                <li<?= nav_current($current_page === 'uebermich') ?>>
                    <a href="uebermich"<?= $current_page === 'uebermich' ? ' aria-current="page"' : '' ?>>Über mich</a>
                </li>
                <li class="nav-angebot">
                    <button id="angebotBtn" type="button" class="<?= $on_service ? 'current' : '' ?>"
                            aria-expanded="false" aria-controls="angebotPanel">Angebot</button>
                </li>
                <?php foreach ($nav_services as $slug => $item): ?>
                    <li class="nav-resp<?= $current_page === $slug ? ' current' : '' ?>">
                        <a href="<?= e($slug) ?>"<?= $current_page === $slug ? ' aria-current="page"' : '' ?>><?= e($item['name']) ?></a>
                    </li>
                <?php endforeach; ?>
                <li<?= nav_current($current_page === 'preise') ?>>
                    <a href="preise"<?= $current_page === 'preise' ? ' aria-current="page"' : '' ?>>Preise</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="angebotnav" id="angebotPanel" aria-label="Angebotsübersicht">
    <div class="angebotsun" aria-hidden="true">
        <div class="innercirclesun"></div>
        <div class="outercirclesun">
            <img src="img/sun-circle.svg" alt="" width="300" height="300">
        </div>
    </div>
    <div class="angebot">
        <?php foreach ($nav_services as $slug => $item): ?>
            <a href="<?= e($slug) ?>"<?= $current_page === $slug ? ' class="current" aria-current="page"' : '' ?>><?= e($item['name']) ?></a>
        <?php endforeach; ?>
    </div>
</section>
