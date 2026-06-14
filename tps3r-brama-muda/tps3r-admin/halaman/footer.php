<?php
/**
 * ============================================================
 * HALAMAN/FOOTER.PHP - Bagian Bawah Web Admin
 * ============================================================
 */
?>
            <footer class="admin-footer">
                <p>&copy; <?php echo date('Y'); ?> TPS 3R Brama Muda. WasteAnalytics Smart Waste Platform.</p>
            </footer>

        </main> </div> <script>
        // Script untuk menghilangkan alert sukses otomatis setelah 3 detik
        setTimeout(function() {
            var alertBox = document.querySelector('.alert-success');
            if(alertBox) {
                alertBox.style.display = 'none';
            }
        }, 3000);

        // ============================================================
        // SCRIPT: Fitur Toggle / Buka-Tutup Sidebar
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebarBtn');
            const sidebar = document.getElementById('appSidebar');
            const mainContent = document.getElementById('mainContent');

            if (toggleBtn && sidebar && mainContent) {
                toggleBtn.addEventListener('click', function() {
                    // Toggle class 'collapsed' untuk menyusutkan sidebar
                    sidebar.classList.toggle('collapsed');
                    // Toggle class 'expanded' untuk melebarkan konten utama
                    mainContent.classList.toggle('expanded');
                });
            }
        });
    </script>
</body>
</html>