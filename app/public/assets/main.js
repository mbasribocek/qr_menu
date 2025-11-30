// --- Sidebar Toggle Functions ---
function toggleSidebar() {
    const publicSidebar = document.getElementById('publicSidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const menuToggle = document.querySelector('.menu-toggle');

    if (publicSidebar && sidebarOverlay && menuToggle) {
        publicSidebar.classList.toggle('is-open');
        sidebarOverlay.classList.toggle('active');
        menuToggle.classList.toggle('active');
    }
}

function closeSidebar() {
    const publicSidebar = document.getElementById('publicSidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const menuToggle = document.querySelector('.menu-toggle');

    if (publicSidebar && sidebarOverlay && menuToggle) {
        publicSidebar.classList.remove('is-open');
        sidebarOverlay.classList.remove('active');
        menuToggle.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // --- Event Listeners for Sidebar ---
    const sidebarLinks = document.querySelectorAll('.public-sidebar-nav a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });
    });

    const menuToggle = document.querySelector('.menu-toggle');
    if(menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    if(sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // --- Search Functionality ---
    // Category search
    const categorySearch = document.getElementById('categorySearch');
    if (categorySearch) {
        categorySearch.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const categoryItems = document.querySelectorAll('.category-item');
            
            categoryItems.forEach(function(item) {
                const categoryName = item.getAttribute('data-name') || '';
                const isMatch = categoryName.includes(searchTerm);
                item.style.display = isMatch ? 'block' : 'none';
            });
        });
    }
    
    // Product search
    const productSearch = document.getElementById('productSearch');
    if (productSearch) {
        productSearch.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const productItems = document.querySelectorAll('.product-item');
            
            productItems.forEach(function(item) {
                const productName = item.getAttribute('data-name') || '';
                const productDescription = item.getAttribute('data-description') || '';
                const isMatch = productName.includes(searchTerm) || productDescription.includes(searchTerm);
                item.style.display = isMatch ? 'block' : 'none';
            });
        });
    }
});
