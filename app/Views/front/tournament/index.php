<div class="container mt-4">
    <div class="row">
        <?php if (!empty($tournaments)) : ?>
            <?php foreach ($tournaments as $tournament): ?>
                <input type="hidden" name="id_tournament" value="<?= $tournament['id']; ?>">
                <input type="hidden" name="id_user" value="<?= ($user->id); ?>">
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
                                Jeu : <?= esc($tournament['game_name'] ?? 'Inconnue'); ?><br>
                                Nombre de joueurs qualifiés : <?= esc($tournament['nb_player'] ?? 'Inconnue'); ?><br>
                                Nombre de participants : <?= esc($tournament['nb_player'] ?? 'Inconnue'); ?>

                            </p>

                            <?php
                            // Vérifier si l'utilisateur est inscrit
                            $isRegistered = false;
                            foreach ($qualifications as $qualification) {
                                if ($qualification['id_tournament'] == $tournament['id'] && $qualification['id_user'] == $user->id) {
                                    $isRegistered = true;
                                    break;
                                }
                            }
                            ?>

                            <?php if ($isRegistered): ?>
                                <!-- Bouton de désinscription -->
                                <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#confirmationModaldésinscrire<?= esc($tournament['id']); ?>">
                                    Se désinscrire
                                </a>

                                <div class="modal fade" id="confirmationModaldésinscrire<?= esc($tournament['id']); ?>" tabindex="-1"
                                     aria-labelledby="confirmationModalLabel<?= esc($tournament['id']); ?>"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="confirmationModalLabel<?= esc($tournament['id']); ?>">
                                                    Désinscription
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir vous désinscrire des phases de qualification du tournoi suivant :
                                                <strong><?= esc($tournament['name']); ?></strong> ?
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</a>
                                                <a href="<?= base_url('/tournament/unregister?id_user=' . ($user->id) . '&id_tournament=' . $tournament['id']); ?>">
                                                    <button class="btn btn-primary">Confirmer</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>

                            <!-- Bouton avec un ID unique pour ouvrir le bon modal -->
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                               data-bs-target="#confirmationModal<?= esc($tournament['id']); ?>">
                                S'inscrire
                            </a>

                            <!-- Modal spécifique à chaque tournoi -->
                            <div class="modal fade" id="confirmationModal<?= esc($tournament['id']); ?>" tabindex="-1"
                                 aria-labelledby="confirmationModalLabel<?= esc($tournament['id']); ?>"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="confirmationModalLabel<?= esc($tournament['id']); ?>">
                                                Confirmation d'inscription
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir vous inscrire au phase de qualification du tournoi suivant :
                                            <strong><?= esc($tournament['name']); ?></strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</a>
                                            <a href="<?= base_url('/tournament/register?id_user=' . ($user->id) . '&id_tournament=' . $tournament['id']); ?>">
                                                <button class="btn btn-primary">Confirmer</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Fin du modal -->
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center">Aucun tournoi n'est disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>