<?php
$ga_id = (string) config('ga_measurement_id');

if ($ga_id === '') {
    return;
}
?>
<div id="cookiebanner" hidden>
    <p>Wir verwenden Cookies, um Ihnen das beste Online-Erlebnis zu bieten. Mit Ihrer Zustimmung akzeptieren Sie die Verwendung von Cookies.</p>
    <button type="button" id="acceptBtn">Okay</button>
    <button type="button" id="declineBtn">Nein, danke</button>
</div>

<script>
(function () {
    'use strict';

    var trackingID = <?= json_encode($ga_id, JSON_UNESCAPED_SLASHES) ?>;
    var disableString = 'ga-disable-' + trackingID;
    var banner = document.getElementById('cookiebanner');

    function setCookie(name, value) {
        var expires = new Date();
        expires.setDate(expires.getDate() + 365);
        document.cookie = name + '=' + value + '; expires=' + expires.toUTCString() +
            '; path=/; SameSite=Lax' + (location.protocol === 'https:' ? '; Secure' : '');
    }

    function hasCookie(name) {
        return document.cookie.split('; ').some(function (entry) {
            return entry.indexOf(name + '=') === 0;
        });
    }

    /* Laedt gtag.js. Wird ausschliesslich nach erteilter Einwilligung
       aufgerufen — das ist der Kern der Korrektur. */
    function loadAnalytics() {
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () { window.dataLayer.push(arguments); };

        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(trackingID);
        document.head.appendChild(script);

        window.gtag('js', new Date());
        window.gtag('config', trackingID, {
            anonymize_ip: true,
            allow_google_signals: false,
            allow_ad_personalization_signals: false
        });
    }

    function hideBanner() {
        if (banner) {
            banner.remove();
        }
    }

    function accept() {
        setCookie('ga_consent', 'granted');
        hideBanner();
        loadAnalytics();
    }

    function decline() {
        setCookie(disableString, 'true');
        window[disableString] = true;
        hideBanner();
    }

    if (hasCookie(disableString)) {
        window[disableString] = true;
        hideBanner();
        return;
    }

    if (hasCookie('ga_consent')) {
        hideBanner();
        loadAnalytics();
        return;
    }

    document.getElementById('acceptBtn').addEventListener('click', accept);
    document.getElementById('declineBtn').addEventListener('click', decline);

    banner.hidden = false;
    setTimeout(function () {
        banner.classList.add('visible');
    }, 3000);
}());
</script>
