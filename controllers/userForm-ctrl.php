<?php
// Récupération constantes

require_once __DIR__ . '/../config/regex.php';
require_once __DIR__ . '/../config/constants.php';
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

include __DIR__ . '/../views/templates/header.php';
include __DIR__ . '/../views/userForm.php';
include __DIR__ . '/../views/templates/footer.php';
