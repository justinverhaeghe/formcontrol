    <main>
        <!-- Consigne de l'exercice -->
        <div class="container-fluid my-4" id="consigne">
            <div class="text-center p-4 ">
                <p>Consigne : Faire un formulaire d'inscription permettant à un utilisateur de saisir les informations
                    suivantes :</p>
            </div>
            <hr>
            <ul>
                <li>E-mail</li>
                <li>Mot de passe</li>
                <li>Civilité (Mr, Mme)</li>
                <li>Nom</li>
                <li>Date de naissance</li>
                <li>Pays de naissance (France, Belgique, Suisse, Luxembourg, Allemagne, Italie, Espagne, Portugal)</li>
                <li>Code postal</li>
                <li>Photo de profil</li>
                <li>Url compte linked</li>
                <li>Quel langages web connaissez-vous? (HTML/CSS, PHP, Javascript, Python, Autres)</li>
                <li>Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir.</li>
            </ul>
            <div class="text-center p-4">
                <p>Les données saisies par l'utilisateurs devront être contrôlées et validées côté Front, mais également
                    côte Back

                    Si toutes les données sont valides, alors, afficher un récapitulatif à l'utilisateur.
                </p>
            </div>
        </div>

        <!-- Réponse -->
        <div class="container-fluid" id="secondpart">
            <div class="row">
                <div class="col-12 ">
                    <form id="myForm" method="post" class="p-5" enctype="multipart/form-data">
                        <small>Les champs avec une étoile sont obligatoires</small>

                        <!-- Groupe email et PWD -->
                        <div class="row">


                            <div class="col-12">
                                <!-- EMAIL -->
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="name@example.com" required>
                                    <label for="email">Email *</label>
                                </div>
                                <?php if (isset($errors['email'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['email'] ?> </div>
                                <?php } ?>
                            </div>


                            <div class=" col-12">
                                <!-- PASSWORD -->
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="pwd" placeholder="Password"
                                        name="pwd" aria-describedby="pwdHelp" required>
                                    <label for="pwd">Mot de passe *</label>
                                </div>
                                <div id="pwdWeak" class="d-none">
                                    Mot de passe FAIBLE
                                </div>
                                <div id="pwdMedium" class="d-none">
                                    Mot de passe MEDIUM
                                </div>
                                <div id="pwdStrong" class="d-none">
                                    Mot de passe FORT
                                </div>
                                <?php if (isset($errors['pwd'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['pwd'] ?> </div>
                                <?php } ?>
                            </div>


                            <div class="col-12">
                                <!-- VALIDATION PASSWORD -->
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="confirmPwd" name="confirmPwd"
                                        placeholder="Confirmation Mot de passe" required>
                                    <label for="confirmPwd">Confirmation Mot de passe *</label>
                                    <div id="pwdHelp" class="d-none">
                                        Votre mot de passe n'est pas identique
                                    </div>
                                    <?php if (isset($errors['confirmPwd'])) { ?>
                                    <div class="text-danger mb-3"> <?= $errors['confirmPwd'] ?> </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>



                        <!-- Groupe civilité et nom -->
                        <div class="row">
                            <div class="col-6">
                                <!-- CIVILITE -->
                                <fieldset class="mb-3 d-flex justify-content-center">
                                    <legend>Civilité * :</legend>
                                    <div class="form-check p-3">
                                        <input class="form-check-input" type="radio" name="gender" id="monsieur"
                                            value="1" checked>
                                        <label class="form-check-label" for="monsieur">
                                            Monsieur
                                        </label>
                                    </div>
                                    <div class="form-check p-3 mx-4">
                                        <input class="form-check-input" type="radio" name="gender" id="madame"
                                            value="2">
                                        <label class="form-check-label" for="madame">
                                            Madame
                                        </label>
                                    </div>
                                </fieldset>
                                <?php if (isset($errors['gender'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['gender'] ?> </div>
                                <?php } ?>
                            </div>



                            <div class="col-6 align-self-center">
                                <!-- NOM -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name"
                                        autocomplete="family-name" placeholder="Nom" required>
                                    <label for="name">Nom * </label>
                                </div>
                                <div id="nameHelp" class="d-none">
                                    Cet nom n'est pas valide
                                </div>
                                <?php if (isset($errors['name'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['name'] ?> </div>
                                <?php } ?>
                            </div>
                        </div>


                        <!-- Groupe Date Naissance et Pays -->
                        <div class="row">
                            <div class="col-6">
                                <!-- DATE DE NAISSANCE -->
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="birthday" id="birthday"
                                        max="<?= date('Y-m-d') ?>" required>
                                    <label for="birthday">Date de Naissance *</label>
                                </div>
                                <?php if (isset($errors['birthday'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['birthday'] ?> </div>
                                <?php } ?>
                            </div>



                            <div class="col-6">
                                <!-- PAYS DE NAISSANCE -->
                                <div class="form-floating mb-3">
                                    <select class="form-select" aria-label="country" name="country" id="country"
                                        required>
                                        <option selected disabled>----- Pays de Naissance * ----- </option>
                                        <?php
                                        foreach (COUNTRIES as $key => $country) { ?>
                                        <option value="<?= $key ?>"><?= $country ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <?php if (isset($errors['country'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['country'] ?> </div>
                                <?php } ?>
                            </div>
                        </div>



                        <!-- Groupe CP et Lien linkedin -->
                        <div class="row">


                            <div class="col-6">
                                <!-- CODE POSTAL -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="cp" id="cp" placeholder="Code Postal"
                                        required>
                                    <label for="cp">Code Postal *</label>
                                </div>
                                <div id="cpHelp" class="d-none">
                                    Ce code postal n'est pas valide
                                </div>
                                <?php if (isset($errors['cp'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['cp'] ?> </div>
                                <?php } ?>
                            </div>



                            <div class="col-6">
                                <!-- URL LINKEDIN -->
                                <div class="form-floating mb-3">
                                    <input type="url" name="url" id="url" class="form-control" required />
                                    <label for="url">Lien URL de votre Linkedin *</label>
                                </div>
                                <div id="urlHelp" class="d-none">
                                    Cet URL n'est pas valide
                                </div>
                                <?php if (isset($errors['url'])) { ?>
                                <div class="text-danger mb-3"> <?= $errors['url'] ?> </div>
                                <?php } ?>
                            </div>
                        </div>



                        <!-- PHOTO DE PROFIL -->
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Photo de profil *</label>
                            <input name="formFile" class="form-control" type="file" id="formFile"
                                accept=".png, image/jpeg" required>
                        </div>



                        <!-- LANGAGES CONNUS -->
                        <fieldset>
                            <legend>Langages de programmation connus :</legend>
                            <?php foreach (LANGUAGES as $key => $language) { ?>
                            <div class="form-check form-switch">
                                <input name="languages[]" class="form-check-input mb-3" type="checkbox" role="switch"
                                    id="language-<?= $key ?>" value="<?= $language ?>">
                                <label class="form-check-label" for="language-<?= $key ?>"><?= $language ?></label>
                            </div>
                            <?php } ?>
                        </fieldset>
                        <?php if (isset($errors['languages'])) { ?>
                        <div class="text-danger mb-3"> <?= $errors['languages'] ?> </div>
                        <?php } ?>




                        <!-- EXPERIENCE INFORMATIQUE -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="experience" id="experience" maxlength="400"></textarea>
                            <label for="experience">Racontez une expérience avec la programmation et/ou
                                l'informatique que vous auriez pu avoir... (400 caractères max) </label>
                        </div>
                        <?php if (isset($errors['experience'])) { ?>
                        <div class="text-danger mb-3"> <?= $errors['experience'] ?> </div>
                        <?php } ?>




                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-success">Submit</button>
                        </div>

                    </form>


                    <?php
                    if (empty($errors) && $_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = $_POST['email'];
                    ?>
                    <p>Formulaire envoyé avec succès !</p>
                    <?php } ?>

                </div>
            </div>
        </div>

    </main>
    <script>
const regexCP = <?= REGEX_CP ?>;
const regexName = <?= REGEX_NAME ?>;
const regexURL = <?= REGEX_URL ?>;
const midPwdRegex = <?= REGEX_MID_PWD ?>;
const strongPwdRegex = <?= REGEX_STRONG_PWD ?>;
    </script>
    <script src="/public/assets/js/script.js"></script>