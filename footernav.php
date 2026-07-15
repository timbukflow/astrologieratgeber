<?php
?>
<section class="angebotnavfooter maincontent" aria-label="Angebote">
    <div class="sun" aria-hidden="true">
        <div class="innercirclesun"></div>
        <div class="outercirclesun">
            <img src="img/sun-circle.svg" alt="" width="300" height="300">
        </div>
    </div>
    <div class="angebot">
        <?php foreach (services() as $slug => $item): ?>
            <a href="<?= e($slug) ?>"><?= e($item['name']) ?></a>
        <?php endforeach; ?>
    </div>
</section>
