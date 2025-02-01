<!-- Tutup container utama -->
</div>

<!-- Footer -->
<footer class="footer mt-auto py-4 bg-dark text-light">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">TodoApp</h5>
                <p class="text-muted">
                    A simple yet powerful todo list application to help you stay organized and productive.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= BASE_URL ?>index.php" class="text-decoration-none text-light">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= BASE_URL ?>auth/login.php" class="text-decoration-none text-light">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= BASE_URL ?>auth/register.php" class="text-decoration-none text-light">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:support@todoapp.com" class="text-decoration-none text-light">
                            support@todoapp.com
                        </a>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i>+62 123 4567 890
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-4 pt-3 border-top">
            <p class="mb-0 text-muted">
                &copy; <?= date('Y') ?> TodoApp. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="<?= BASE_URL ?>js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
