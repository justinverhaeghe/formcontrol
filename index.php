<?php
// Récupération constantes

require './regex.php';
require './constants.php';
$errors = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validation de l'EMAIL
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        $errors['email'] = 'Veuillez obligatoirement entrer un email';
    } else {
        $isOk = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($isOk == false) {
            $errors['email'] = 'Veuillez entre un email valide';
        }
    }


    // Validation du NOM
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($name)) {
        $errors['name'] = 'Veuillez obligatoirement entrer un nom';
    } else {
        if (preg_match(REGEX_NAME, $name) == false) {
            $errors['name'] = 'Veuillez entrer un nom valide';
        }
    }


    // Validation du CODE POSTAL
    $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_NUMBER_INT);
    if (empty($cp)) {
        $errors['cp'] = 'Veuillez obligatoirement entrer un code postal';
    } else {
        if (preg_match(REGEX_CP, $cp) == false) {
            $errors['cp'] = 'Veuillez entrer un code postal valide';
        }
    };


    // Validation du PAYS DE NAISSANCE
    $country = filter_input(INPUT_POST, 'country');
    if (empty($country)) {
        $errors['country'] = 'Veuillez obligatoirement sélectionner un pays de naissance';
    } else {
        if ((array_key_exists($country, COUNTRIES)) == false) {
            $errors['country'] = 'Veuillez selectionner votre pays de naissance';
        }
    }



    // Validation de la CIVILITE
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_NUMBER_INT);
    if (empty($gender)) {
        $errors['gender'] = 'Veuillez obligatoirement entrer une civilité';
    } else {
        if ($gender != 1 && $gender !=  2) {
            $errors['gender'] = 'Veuillez sélectionner Monsieur ou Madame';
        }
    }


    // Validation URL LINKEDIN
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
    if (empty($url)) {
        $errors['url'] = 'Veuillez entrer votre profil Linkedin';
    } else {
        $isOk = filter_var($url, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => REGEX_URL)));
        if (!$isOk) {
            $errors['url'] = 'Veuillez entrer une URL Linkedin valide';
        }
    }


    // Validation des languages de programmation
    $language = filter_input(INPUT_POST, 'languages', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? [];
    foreach ($language as $key => $value) {
        if (in_array($value, LANGUAGES) == false) {
            $errors['languages'] = 'Veuillez selectionner un language valide';
        }
    }


    // Validation Date de Naissance
    $birthday = filter_input((INPUT_POST), 'birthday', FILTER_SANITIZE_NUMBER_INT);
    if (empty($birthday)) {
        $errors['birthday'] = 'Veuillez entrer votre date d\'anniversaire';
    } else {
        $date = DateTime::createFromFormat('Y-m-d', $birthday);
        $currentDate = new DateTime();

        if (!$date || $date->format('Y-m-d') !== $birthday || $date > $currentDate) {
            $errors['birthdate'] = "* Veuillez entrer une date de naissance valide et inférieure à la date d'aujourd'hui.";
        }


        // Validation TextArea 
        $experience = filter_input(INPUT_POST, 'experience', FILTER_SANITIZE_SPECIAL_CHARS);
        if (strlen($experience) > 400) {
            $errors['experience'] = 'Maximum 400 caractères.';
        }


        // Validation PWD
        $pwd = filter_input(INPUT_POST, 'pwd');
        $confirmPwd = filter_input(INPUT_POST, 'confirmPwd');
        if (empty($pwd)) {
            $errors['pwd'] = 'Veuillez obligatoirement entrer un mot de passe';
        } else {
            if ($pwd !== $confirmPwd) {
                $errors['confirmPwd'] = 'Veuillez entrer deux mots de passe identique';
            } else {
                $isOk = filter_var($pwd, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => REGEX_STRONG_PWD)));
                if (!$isOk) {
                    $errors['pwd'] = 'Veuillez entrer un mot de passe valide';
                }
                $password = password_hash($pwd, PASSWORD_BCRYPT);
            }
        }

        // Validation Fichier
        try {
            $formFile = $_FILES['formFile'];
            if (empty($formFile['name'])) {
                throw new Exception("Veuillez renseigner un fichier", 1);
            }
            if ($formFile['error'] != 0) {
                throw new Exception("Fichier non envoyé", 2);
            }
            if (!in_array($formFile['type'], VALID_EXTENSIONS)) {
                throw new Exception("Mauvaise extension de fichier", 3);
            }
            if ($formFile['size'] >= FILE_SIZE) {
                throw new Exception("Taille du fichier dépassé", 4);
            }
            $extension = pathinfo($formFile['name'], PATHINFO_EXTENSION);
            $newNameFile = uniqid('pp_') . '.' . $extension;
            $from = $formFile['tmp_name'];
            $to = './public/uploads/user/' . $newNameFile;
            move_uploaded_file($from, $to);
        } catch (\Throwable $th) {
            $errors['formFile'] = $th->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Handjet:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Phudu&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script defer src="./public/assets/js/script.js"></script>
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <title>Validation Formulaire</title>
</head>
<!-- Header -->

<body p-5>
    <header class="d-flex flex-column justify-content-center align-items-center text-light">
        <h1>Validation Formulaire</h1>
    </header>
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
    <footer class="text-center text-light pt-5">
        <p>By Forza &copy; 2023 - Réalisé dans le cadre d'un projet d'étude - La Manu</p>
    </footer>
    <script>
    const regexCP = <?= REGEX_CP ?>;
    const regexName = <?= REGEX_NAME ?>;
    const regexURL = <?= REGEX_URL ?>;
    const midPwdRegex = <?= REGEX_MID_PWD ?>;
    const strongPwdRegex = <?= REGEX_STRONG_PWD ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>