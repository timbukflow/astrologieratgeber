<?php
function field(
    string $name,
    string $label,
    array $form_values,
    array $errors,
    string $type = 'text',
    string $autocomplete = 'on',
    string $hint = '',
    bool $required = true
): void {
    $id       = 'f-' . $name;
    $has_error = isset($errors[$name]);
    ?>
    <fieldset>
        <label for="<?= e($id) ?>"><?= e($label) ?><?= $required ? ' *' : ' (optional)' ?></label>
        <input
            id="<?= e($id) ?>"
            type="<?= e($type) ?>"
            name="<?= e($name) ?>"
            value="<?= e($form_values[$name] ?? '') ?>"
            autocomplete="<?= e($autocomplete) ?>"
            <?= $hint !== '' ? 'placeholder="' . e($hint) . '"' : '' ?>
            <?= $required ? 'required aria-required="true"' : '' ?>
            <?= $has_error ? 'aria-invalid="true" aria-describedby="' . e($id) . '-error"' : '' ?>
        >
        <span class="error" id="<?= e($id) ?>-error"><?= e($errors[$name] ?? '') ?></span>
    </fieldset>
    <?php
}

function question_field(string $name, string $label, array $form_values, array $errors): void
{
    $id = 'f-' . $name;
    ?>
    <fieldset>
        <label for="<?= e($id) ?>"><?= e($label) ?></label>
        <textarea id="<?= e($id) ?>" name="<?= e($name) ?>" rows="2" maxlength="500" class="boxed"
            <?= isset($errors[$name]) ? 'aria-invalid="true"' : '' ?>><?= e($form_values[$name] ?? '') ?></textarea>
        <span class="error"><?= e($errors[$name] ?? '') ?></span>
    </fieldset>
    <?php
}

function checkbox_group(string $name, string $legend, array $options, array $selected): void
{
    ?>
    <fieldset class="checkgroup">
        <legend><?= e($legend) ?></legend>
        <div class="checkrow">
            <?php foreach ($options as $key => $label): ?>
                <label class="check">
                    <input type="checkbox" name="<?= e($name) ?>[]" value="<?= e($key) ?>"
                        <?= in_array($key, $selected, true) ? 'checked' : '' ?>>
                    <span><?= e($label) ?></span>
                </label>
            <?php endforeach; ?>
        </div>
    </fieldset>
    <?php
}
?>

<?php if (isset($errors['form'])): ?>
    <p class="formerror" role="alert"><?= e($errors['form']) ?></p>
<?php endif; ?>

<form id="contact" method="post" action="#form" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="rendered_at" value="<?= time() ?>">

    <div class="hp" aria-hidden="true">
        <label for="f-website">Website (bitte leer lassen)</label>
        <input id="f-website" type="text" name="website" tabindex="-1" autocomplete="off">
    </div>

    <?php
    field('vorname', 'Vorname', $form_values, $errors, 'text', 'given-name');
    field('name', 'Name', $form_values, $errors, 'text', 'family-name');
    field('geburtsort', 'Geburtsort', $form_values, $errors, 'text', 'off');
    field('geburtsdatum', 'Geburtsdatum', $form_values, $errors, 'text', 'off', '01.01.2001');
    field('geburtszeit', 'Geburtszeit (von amtlichem Geburtsschein)', $form_values, $errors, 'text', 'off', '14:30', false);
    field('email', 'Email', $form_values, $errors, 'email', 'email');
    field('telefon', 'Telefon', $form_values, $errors, 'tel', 'tel');
    ?>

    <?php if (!empty($svc['partner_fields'])): ?>
        <p class="fieldgroup gold">Geburtsdaten der zweiten Person</p>
        <?php
        field('partner_name', 'Vorname und Name', $form_values, $errors, 'text', 'off');
        field('partner_geburtsort', 'Geburtsort', $form_values, $errors, 'text', 'off');
        field('partner_geburtsdatum', 'Geburtsdatum', $form_values, $errors, 'text', 'off', '01.01.2001');
        field('partner_geburtszeit', 'Geburtszeit', $form_values, $errors, 'text', 'off', '14:30', false);
        ?>
    <?php endif; ?>

    <p class="fieldgroup gold">Was ist Ihr Hauptanliegen? <span class="fieldgroup-note">Bis zu drei Fragen, freiwillig</span></p>
    <?php
    question_field('frage1', '1. Frage', $form_values, $errors);
    question_field('frage2', '2. Frage', $form_values, $errors);
    question_field('frage3', '3. Frage', $form_values, $errors);
    ?>

    <p class="fieldgroup gold">Wann passt es Ihnen? <span class="fieldgroup-note">Freiwillig, Mehrfachauswahl möglich</span></p>
    <?php
    checkbox_group('wunschtage', 'An welchen Tagen?', WUNSCHTAGE, $form_values['wunschtage']);
    checkbox_group('wunschzeiten', 'Zu welcher Tageszeit?', WUNSCHZEITEN, $form_values['wunschzeiten']);
    ?>

    <fieldset>
        <label for="f-nachricht">Ihre Nachricht (optional)</label>
        <textarea id="f-nachricht" name="nachricht" rows="4" class="boxed"
            <?= isset($errors['nachricht']) ? 'aria-invalid="true"' : '' ?>><?= e($form_values['nachricht'] ?? '') ?></textarea>
        <span class="error"><?= e($errors['nachricht'] ?? '') ?></span>
    </fieldset>

    <?php if (turnstile_enabled()): ?>
        <div class="cf-turnstile" data-sitekey="<?= e(config('turnstile_site_key')) ?>"
             data-theme="dark" data-language="de"></div>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <?php endif; ?>

    <fieldset>
        <button type="submit" id="contact-submit"><?= e($svc['booking_button']) ?></button>
    </fieldset>

    <p class="formnote">
        Ihre Angaben werden ausschliesslich für die Bearbeitung Ihrer Buchung verwendet.
        Näheres in der <a href="datenschutz">Datenschutzerklärung</a>.
    </p>
</form>
