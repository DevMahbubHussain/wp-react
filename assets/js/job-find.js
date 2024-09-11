document.addEventListener('DOMContentLoaded', function () {
    // Function to set the active menu item
    function setActiveMenu() {
        const menuItems = document.querySelectorAll('#toplevel_page_jobfind .wp-submenu a');
        const currentHash = window.location.hash;

        // Ensure only one active menu item at a time
        menuItems.forEach((item) => {
            const itemHash = item.getAttribute('href').split('#')[1] || '/';
            
            // Compare full hash only (ensures /jobs doesn't match /)
            if (currentHash === `#${itemHash}`) {
                item.classList.add('current');
                item.parentElement.classList.add('current');
            } else {
                item.classList.remove('current');
                item.parentElement.classList.remove('current');
            }
        });
    }

    // Run on page load
    setActiveMenu();

    // Run on hash change (for navigation)
    window.addEventListener('hashchange', setActiveMenu);
});
