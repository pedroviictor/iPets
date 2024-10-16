
function validarCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj.length !== 14) {
        alert("CNPJ inválido! O CNPJ deve ter 14 dígitos.");
        return false;
    }

    if (/^(\d)\1{13}$/.test(cnpj)) {
        alert("CNPJ inválido!");
        return false;
    }

    // primeiro dígito verificador
    let soma = 0;
    let multiplicador = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for (let i = 0; i < 12; i++) {
        soma += cnpj[i] * multiplicador[i];
    }

    let resto = soma % 11;
    let digito1 = (resto < 2) ? 0 : 11 - resto;

    // segundo dígito verificador
    soma = 0;
    multiplicador = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for (let i = 0; i < 13; i++) {
        soma += cnpj[i] * multiplicador[i];
    }

    resto = soma % 11;
    let digito2 = (resto < 2) ? 0 : 11 - resto;

    if (cnpj[12] == digito1 && cnpj[13] == digito2) {
        return true;
    } else {
        alert("CNPJ inválido! Os dígitos verificadores estão incorretos.");
        return false;
    }
}

function verificarCNPJ() {
    var cnpj = document.getElementById('cnpj').value;
    document.getElementById('cnpj').value = cnpj;

    if (!validarCNPJ(cnpj)) {
        document.getElementById('cnpj').setCustomValidity("CNPJ inválido");
    } else {
        document.getElementById('cnpj').setCustomValidity("");
    }
}
