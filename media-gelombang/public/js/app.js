  /* =============================
     SIDEBAR ACCORDION (GLOBAL)
     ============================= */
     
document.addEventListener("DOMContentLoaded", function () {

    const toggles = document.querySelectorAll(".menu-item.has-toggle");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", function () {

            const targetId = this.dataset.target;
            const submenu = document.getElementById(targetId);

            if (!submenu) return;

            const isOpen = submenu.classList.contains("open");

            // tutup semua submenu
            document.querySelectorAll(".submenu").forEach(sm => {
                sm.classList.remove("open");
            });

            document.querySelectorAll(".menu-item").forEach(mi => {
                mi.classList.remove("menu-item-open");
            });

            // buka yang dipilih saja
            if (!isOpen) {
                submenu.classList.add("open");
                this.classList.add("menu-item-open");
            }
        });
    });


    /* ===============================
       AUTO OPEN SESUAI HALAMAN AKTIF
       =============================== */
    const activeLink = document.querySelector(".submenu a.active-link");

    if (activeLink) {
        const submenu = activeLink.closest(".submenu");
        const parentMenu = submenu.previousElementSibling;

        submenu.classList.add("open");
        parentMenu.classList.add("menu-item-open");
    }

});




document.querySelectorAll('.accordion-toggle').forEach(menu => {
    menu.addEventListener('click', () => {

        const submenu = menu.nextElementSibling;

        menu.classList.toggle('menu-item-open');
        submenu.classList.toggle('open');

    });
});

/* ==========================================
   SIDEBAR TOGGLE & BACKDROP EVENTS (GLOBAL)
   ========================================== */
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("sidebarToggle");
    const backdrop = document.getElementById("sidebarBackdrop");
    const sidebar = document.querySelector(".sidebar");

    // Hide toggle button if there is no sidebar on the page (e.g. quiz page)
    if (!sidebar) {
        if (toggleBtn) toggleBtn.style.display = "none";
        return;
    }

    // Load persisted state for desktop sidebar
    if (window.innerWidth > 768) {
        const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
        if (isCollapsed) {
            document.body.classList.add("sidebar-collapsed");
        }
    }

    // Toggle click handler
    toggleBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        if (window.innerWidth <= 768) {
            // Mobile: toggle overlay drawer
            document.body.classList.toggle("sidebar-open-mobile");
        } else {
            // Desktop: toggle collapsed state
            const collapsed = document.body.classList.toggle("sidebar-collapsed");
            localStorage.setItem("sidebarCollapsed", collapsed ? "true" : "false");
        }
    });

    // Backdrop click handler (mobile only)
    if (backdrop) {
        backdrop.addEventListener("click", function () {
            document.body.classList.remove("sidebar-open-mobile");
        });
    }

    // Close mobile sidebar if window is resized above mobile breakpoint
    window.addEventListener("resize", function () {
        if (window.innerWidth > 768) {
            document.body.classList.remove("sidebar-open-mobile");
        }
    });
});

