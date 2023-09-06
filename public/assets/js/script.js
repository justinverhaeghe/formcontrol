// SELECTORS

let pwdElement = document.querySelector("#pwd");
let confirmElement = document.querySelector("#confirmPwd");
let pwdHelp = document.querySelector("#pwdHelp");
let pwdWeak = document.querySelector("#pwdWeak");
let pwdMedium = document.querySelector("#pwdMedium");
let pwdStrong = document.querySelector("#pwdStrong");
let nameElement = document.querySelector("#name");
let nameHelp = document.querySelector("#nameHelp");
let cpElement = document.querySelector("#cp");
let cpHelp = document.querySelector("#cpHelp");
let urlElement = document.querySelector("#url");
let urlHelp = document.querySelector("#urlHelp");
let myForm = document.querySelector("#myForm");

// VARIABLES & CONSTANTES
let mediumRegexPwd = midPwdRegex;
let StrongRegexPwd = strongPwdRegex;
let nameRegex = regexName;
let cpRegex = regexCP;
let urlRegex = regexURL;

// FUNCTIONS

const checkPwd = () => {
    pwdElement.classList.remove("border-danger", "border-success", "border-4");
    confirmElement.classList.remove("border-danger", "border-success", "border-4");
    pwdHelp.classList.add("d-none");
    if (confirmElement.value == "") {
        return;
    }

    let isIdentical = pwdElement.value == confirmElement.value;

    if (isIdentical == false) {
        pwdElement.classList.add("border-danger", "border-4");
        confirmElement.classList.add("border-danger", "border-4");
        pwdHelp.classList.remove("d-none");
    } else {
        pwdElement.classList.add("border-success", "border-4");
        confirmElement.classList.add("border-success", "border-4");
        emailHelp.classList.add("d-none");
        validationPwd();
    }
};

const validationPwd = () => {
    pwdWeak.classList.add("d-none");
    if (pwdElement.value == "") {
        return;
    }
    pwdMedium.classList.add("d-none");
    if (pwdElement.value == "") {
        return;
    }
    pwdStrong.classList.add("d-none");
    if (pwdElement.value == "") {
        return;
    }

    let isStrong = StrongRegexPwd.test(pwdElement.value);
    let isMedium = mediumRegexPwd.test(pwdElement.value);

    if (isStrong == false) {
        if (isMedium == false) {
            pwdElement.classList.add("border-danger", "border-4");
            pwdWeak.classList.add("text-danger");
            pwdWeak.classList.remove("d-none");
            pwdStrong.classList.add("d-none");
        } else {
            pwdElement.classList.remove("border-danger", "border-4");
            pwdWeak.classList.remove("text-danger");
            pwdWeak.classList.add("d-none");
            pwdStrong.classList.add("d-none");
            pwdElement.classList.add("border-warning", "border-4");
            pwdMedium.classList.remove("d-none");
            pwdMedium.classList.add("text-warning");
        }
    } else {
        pwdElement.classList.remove("border-danger", "border-warning");
        pwdElement.classList.add("border-success", "border-4");
        pwdMedium.classList.add("d-none");
        pwdWeak.classList.add("d-none");
        pwdStrong.classList.remove("d-none");
        pwdStrong.classList.add("text-success");
    }
};

const checkName = () => {
    nameElement.classList.remove("border-danger", "border-success", "border-3");
    nameHelp.classList.add("d-none");
    if (nameElement.value == "") {
        return;
    }

    let isValid = nameRegex.test(nameElement.value);

    if (isValid == false) {
        // if (!isValid)
        nameElement.classList.add("border-danger", "border-4");
        nameHelp.classList.add("text-danger");
        nameHelp.classList.remove("d-none");
    } else {
        nameElement.classList.add("border-success", "border-4");
        nameHelp.classList.add("d-none");
    }
};

const checkCP = () => {
    cpElement.classList.remove("border-danger", "border-success", "border-3");
    cpHelp.classList.add("d-none");
    if (cpElement.value == "") {
        return;
    }

    let isValid = cpRegex.test(cpElement.value);

    if (isValid == false) {
        // if (!isValid)
        cpElement.classList.add("border-danger", "border-4");
        cpHelp.classList.add("text-danger");
        cpHelp.classList.remove("d-none");
    } else {
        cpElement.classList.add("border-success", "border-4");
        cpHelp.classList.add("d-none");
    }
};

const checkUrl = () => {
    urlElement.classList.remove("border-danger", "border-success", "border-3");
    urlHelp.classList.add("d-none");
    if (urlElement.value == "") {
        return;
    }

    let isValid = urlRegex.test(urlElement.value);

    if (isValid == false) {
        // if (!isValid)
        urlElement.classList.add("border-danger", "border-4");
        urlHelp.classList.add("text-danger");
        urlHelp.classList.remove("d-none");
    } else {
        urlElement.classList.add("border-success", "border-4");
        urlHelp.classList.add("d-none");
    }
};

const checkForm = () => {
    event.preventDefault();
    if (pwdElement.value == confirmElement.value && pwdElement != "") {
        myForm.submit();
    } else {
        pwdElement.classList.add("border-danger", "border-4");
        confirmElement.classList.add("border-danger", "border-4");
        pwdHelp.classList.remove("d-none");
    }
};

// EVENT LISTENER

cpElement.addEventListener("input", checkCP);
nameElement.addEventListener("input", checkName);
pwdElement.addEventListener("input", checkPwd);
confirmElement.addEventListener("input", checkPwd);
pwdElement.addEventListener("input", validationPwd);
urlElement.addEventListener("input", checkUrl);
myForm.addEventListener("submit", checkForm);
