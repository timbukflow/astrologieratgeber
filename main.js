
(function () {
    'use strict';
    const angebotBtn = document.getElementById('angebotBtn');
    const angebotPanel = document.getElementById('angebotPanel');

    function setAngebot(open) {
        angebotBtn.classList.toggle('activBtn', open);
        angebotBtn.setAttribute('aria-expanded', String(open));
        angebotPanel.classList.toggle('open', open);
        document.body.classList.toggle('fixed', open);
        document.querySelectorAll('.maincontent, footer').forEach(function (el) {
            el.classList.toggle('fade', open);
        });
    }

    if (angebotBtn && angebotPanel) {
        angebotBtn.addEventListener('click', function () {
            setAngebot(angebotBtn.getAttribute('aria-expanded') !== 'true');
        });
    }
    const burger = document.querySelector('.burger-icon');
    const navListCont = document.querySelector('.nav-list-cont');

    function setMenu(open) {
        burger.classList.toggle('active', open);
        burger.setAttribute('aria-expanded', String(open));
        burger.setAttribute('aria-label', open ? 'Menü schliessen' : 'Menü öffnen');
        navListCont.classList.toggle('open', open);
        document.body.classList.toggle('fixed', open);
    }

    if (burger && navListCont) {
        burger.addEventListener('click', function () {
            setMenu(burger.getAttribute('aria-expanded') !== 'true');
        });
    }
    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }
        if (burger && burger.getAttribute('aria-expanded') === 'true') {
            setMenu(false);
            burger.focus();
        }
        if (angebotBtn && angebotBtn.getAttribute('aria-expanded') === 'true') {
            setAngebot(false);
            angebotBtn.focus();
        }
    });
    const nav = document.querySelector('nav');
    if (nav) {
        let lastScroll = 0;
        let ticking = false;
        const threshold = 100;

        window.addEventListener('scroll', function () {
            if (ticking) {
                return;
            }
            ticking = true;
            window.requestAnimationFrame(function () {
                const current = window.scrollY || document.documentElement.scrollTop;
                if (current > lastScroll + threshold) {
                    nav.classList.add('nav-hidden');
                    lastScroll = current;
                } else if (current < lastScroll - threshold) {
                    nav.classList.remove('nav-hidden');
                    lastScroll = current;
                }
                nav.classList.toggle(
                    'nav-scrolled',
                    current > 300 && !nav.classList.contains('nav-hidden')
                );
                ticking = false;
            });
        }, { passive: true });
    }
    const popup = document.getElementById('popup');
    const closePopup = document.getElementById('closePopup');

    if (popup && closePopup) {
        const subpage = document.querySelector('.subpage');

        const hidePopup = function () {
            popup.remove();
            document.body.classList.remove('freeze');
            if (subpage) {
                subpage.classList.remove('blurpop');
            }
            history.replaceState(null, '', window.location.pathname + '#form');
        };

        document.body.classList.add('freeze');
        if (subpage) {
            subpage.classList.add('blurpop');
        }
        closePopup.addEventListener('click', hidePopup);
        closePopup.focus();
    }
}());
