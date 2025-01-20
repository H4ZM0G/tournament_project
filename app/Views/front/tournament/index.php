<div class="container mt-4">
    <div class="row">
        <?php if (!empty($tournaments)) : ?>
            <?php foreach ($tournaments as $tournament): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Fixer une taille uniforme pour les images -->
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
                            <a href="#" id="signupButton" class="btn btn-primary" data-bs-toggle="modal"
                               data-bs-target="#confirmationModal">
                                S'inscrire
                            </a>
                            <div class="modal fade" id="confirmationModal" tabindex="-1"
                                 aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirmation
                                                d'inscription</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir vous inscrire au tournoi suivant
                                            : <?= esc($tournament['name']); ?> ?
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</a>
                                            <form action="/Participant" method="POST">
                                                <input type="hidden" name="id_user" value="<?= $user->id ?>">
                                                <input type="hidden" name="id_tournament"
                                                       value="<?= $tournament['id'] ?>">
                                                <button type="submit" class="btn btn-primary">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center">Aucun tournois n'est disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>