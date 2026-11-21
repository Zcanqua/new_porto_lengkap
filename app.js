import cvUrl from './assets/cv-ricky-kurniawan.pdf?url';

const cvDownload = document.querySelector('#cv-download');

if (cvDownload) {
    cvDownload.href = cvUrl;
}

const menuButton = document.querySelector('#hamburger');
const mobileNavigation = document.querySelector('#mobile-navigation');

if (menuButton && mobileNavigation) {
    const setMenuOpen = (isOpen) => {
        menuButton.setAttribute('aria-expanded', String(isOpen));
        menuButton.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
        mobileNavigation.classList.toggle('hidden', !isOpen);
        menuButton.querySelector('path').setAttribute(
            'd',
            isOpen ? 'M6 6l12 12M18 6L6 18' : 'M4 6h16M4 12h16M4 18h16',
        );
    };

    menuButton.addEventListener('click', () => {
        setMenuOpen(menuButton.getAttribute('aria-expanded') !== 'true');
    });

    mobileNavigation.addEventListener('click', (event) => {
        if (event.target.closest('a')) {
            setMenuOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });

    window.matchMedia('(min-width: 768px)').addEventListener('change', (event) => {
        if (event.matches) {
            setMenuOpen(false);
        }
    });
}

const contactForm = document.querySelector('#contact-form');
const contactStatus = document.querySelector('#contact-status');

if (contactForm && contactStatus) {
    contactForm.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!contactForm.reportValidity()) {
            return;
        }

        contactStatus.textContent = 'Form valid. Pengiriman pesan belum diaktifkan pada milestone ini.';
        contactForm.reset();
    });
}
