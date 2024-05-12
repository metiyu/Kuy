document.addEventListener('DOMContentLoaded', function () {
    const openButton = document.getElementById('open-btn');
    const closeButton = document.getElementById('close-btn');
    const mobileMenu = document.getElementById('mobile-nav');
    const profileModal = document.getElementById('profile-modal')
    const profileButton = document.getElementById('profile-btn')

    openButton.addEventListener('click', function () {
        mobileMenu.classList.remove('hidden');
    });

    closeButton.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
    });

    profileButton.addEventListener('click', function () {
        profileModal.classList.toggle('hidden');
    })

});
