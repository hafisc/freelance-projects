    </div> <!-- Akhir dari .admin-page-content -->
    
    <!-- Footer Dashboard -->
    <footer class="admin-footer">
        <p>&copy; <?= date('Y') ?> GreenHaven Admin Dashboard. Hak Cipta Dilindungi.</p>
        <p>PHP Native v8.3 | Crafted with Care</p>
    </footer>
</main> <!-- Akhir dari .admin-content-wrapper -->
</div> <!-- Akhir dari .admin-wrapper -->

<!-- JavaScript Interaktivitas Admin Panel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const wrapper = document.querySelector('.admin-wrapper');
    
    if (sidebarToggle && wrapper) {
        sidebarToggle.addEventListener('click', function() {
            // Toggle class 'sidebar-collapsed' untuk menyembunyikan/menampilkan sidebar di desktop & mobile
            wrapper.classList.toggle('sidebar-collapsed');
        });
    }
});
</script>
</body>
</html>
