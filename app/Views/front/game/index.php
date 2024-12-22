<div class="container mt-4">
    <div class="row">
        <?php if (!empty($games)) : ?>
            <?php foreach ($games as $game): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Fixer une taille uniforme pour les images -->
                        <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="<?= base_url($game['avatargame_url'] ?? 'assets/img/avatars/default.png'); ?>"
                                 class="card-img-top" alt="Image du jeu"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($game['name']); ?></h5>
                            <p class="card-text">
                                Catégorie: <?= esc($game['category_name'] ?? 'Inconnue'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center">Aucun jeu disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>