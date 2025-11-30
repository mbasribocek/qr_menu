// --- Admin Sidebar Toggle Functions ---
function toggleAdminSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggle = document.querySelector('.admin-menu-toggle');

    if (sidebar && overlay && toggle) {
        sidebar.classList.toggle('is-open');
        overlay.classList.toggle('active');
        toggle.classList.toggle('active');
    }
}

function closeAdminSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggle = document.querySelector('.admin-menu-toggle');

    if (sidebar && overlay && toggle) {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('active');
        toggle.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // --- Event Listeners for Admin Sidebar ---
    const menuToggle = document.querySelector('.admin-menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleAdminSidebar);
    }

    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeAdminSidebar);
    }

    const sidebarLinks = document.querySelectorAll('.admin-sidebar-nav a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 991.98) {
                closeAdminSidebar();
            }
        });
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 991.98) {
            closeAdminSidebar();
        }
    });
});
