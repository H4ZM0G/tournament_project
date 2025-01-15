<div class="row">
    <div class="col">
        <form action="<?= isset($utilisateur) ? base_url("/user/update") : base_url("/user/user/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($utilisateur) ? "Editez votre profil" : "Créer un utilisateur" ?>
                    </h4>
                    <?php
                    if (isset($utilisateur) && $utilisateur['deleted_at'] == null) { ?>
                        <a title="Désactiver l'utilisateur" href="<?= base_url('user/user/deactivate/') . $utilisateur['id']; ?>">
                            <i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                        </a>
                        <?php
                    } elseif(isset($utilisateur)) { ?>
                        <a title="Activer un utilisateur"href="<?= base_url('user/user/activate/') . $utilisateur['id']; ?>">
                            <i class="fa-solid fa-toggle-off fa-xl text-danger"></i>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab" aria-controls="profil" aria-selected="true">Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="onglet-tab" data-bs-toggle="tab"
                                    data-bs-target="#onglet" type="button" role="tab" aria-controls="onglet"
                                    aria-selected="false">ONGLET</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                            <div class="mb-3">
                                <label for="username" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="username" placeholder="username" value="<?= isset($utilisateur) ? $utilisateur['username'] : ""; ?>" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="mail" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="mail" placeholder="mail" value="<?= isset
                                ($utilisateur) ? $utilisateur['email'] : "" ?>" <?= isset($utilisateur) ? "readonly"
                                    : "" ?> <?= isset($utilisateur) ? "" : "name='email'" ?> >
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="name" value="<?= isset($utilisateur) ? $utilisateur['name'] : ""; ?>" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="firstname" placeholder="firstname" value="<?= isset($utilisateur) ? $utilisateur['firstname'] : ""; ?>" name="firstname">
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Biographie</label>
                                <input type="text" class="form-control" id="bio" placeholder="bio" value="<?= isset($utilisateur) ? $utilisateur['bio'] : ""; ?>" name="bio">
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="image" class="form-label me-2">Avatar</label>
                                <div id="preview">
                                    <?php
                                    $profileImageUrl = isset($utilisateur['avatar_url']) ? base_url($utilisateur['avatar_url']) : "#";
                                    ?>
                                    <img class="img-thumbnail me-2"alt="Aperçu de l'image"
                                         style="display: <?= isset($utilisateur['avatar_url']) ? "block" : "none" ?>; max-width: 100px;"
                                         src="<?= $profileImageUrl ?>">
                                </div>

                                <input class="form-control" type="file" name="profile_image" id="image">
                            </div>
                        </div>

                        <div class="tab-pane" id="onglet" role="tabpanel" aria-labelledby="onglet-tab" tabindex="0">

                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <?php if (isset($utilisateur)): ?>
                        <input type="hidden" name="id" value="<?= $utilisateur['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($utilisateur) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>