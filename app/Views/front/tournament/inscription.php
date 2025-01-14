<div class="container mt-4">
    <div class="row">
        <?php if (!empty($tournaments)) : ?>
            <?php foreach ($tournaments as $tournament): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="<?= base_url($tournament['avatartournament_url'] ?? 'assets/img/avatars/default.png'); ?>"
                                 class="card-img-top" alt="Image du jeu"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($tournament['name']); ?></h5>
                            <p class="card-text">
                                Jeu : <?= esc($tournament['game_name'] ?? 'Inconnue'); ?>
                            </p>
                            <form action="<?= base_url('Participant/register'); ?>" method="post">
                                <input type="hidden" name="id_tournament" value="<?= $tournament['id']; ?>">
                                <input type="hidden" name="id_user" value="<?= session()->get('user_id'); ?>">
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center">Aucun tournoi n'est disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>