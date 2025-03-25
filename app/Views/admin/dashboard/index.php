 <div class="container mt-5">
    <header class="mb-5">
        <h1 class="text-center">SLAM Admin</h1>
    </header>

    <div class="row">
        <!-- User Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users card-custom-icon text-primary"></i>
                    <h5 class="card-title mt-2">Utilisateurs</h5>
                    <p class="card-text">Gérer les utilisateurs et leurs permissions.</p>
                    <a href="<?= base_url('/admin/user') ?>" class="btn btn-primary">Voir les utilisateurs</a>
                </div>
            </div>
        </div>
        <!-- School Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-school card-custom-icon text-primary"></i>
                    <h5 class="card-title mt-2">École</h5>
                    <p class="card-text">Gérer les écoles et leurs Catégories.</p>
                    <a href="<?= base_url('/admin/school') ?>" class="btn btn-primary">Voir les écoles</a>
                </div>
            </div>
        </div>
        <!-- Game Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-gamepad card-custom-icon text-primary"></i>
                    <h5 class="card-title mt-2">Jeux</h5>
                    <p class="card-text">Gérer les jeux et leurs Catégories.</p>
                    <a href="<?= base_url('/admin/game') ?>" class="btn btn-primary">Voir les jeux</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <!-- Tournament Card -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-trophy card-custom-icon text-primary"></i>
                    <h5 class="card-title mt-2">Tournois</h5>
                    <p class="card-text">Tournois en cours</p>
                    <a href="<?= base_url('/admin/tournament') ?>" class="btn btn-primary">Voir les tournois</a>
                </div>
            </div>
        </div>
    </div>
</div>