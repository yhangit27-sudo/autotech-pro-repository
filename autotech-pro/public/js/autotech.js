/* ============================================================
   AutoTech Pro — Utilitários globais
   - Máscara CPF/CNPJ com detecção automática
   - Validação de CPF via API
   - Máscara de placa (Mercosul / antiga)
   - Toggle "espiar senha" (um único olho por campo)
   ============================================================ */

/* ---------- TOGGLE SENHA ---------- */
function initPasswordToggles() {
    document.querySelectorAll('input[type="password"]').forEach(function (input) {
        // Evitar duplicar o botão se já foi adicionado
        if (input.dataset.toggleInit) return;
        input.dataset.toggleInit = 'true';

        const wrapper = document.createElement('div');
        wrapper.className = 'input-group';

        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-outline-secondary';
        btn.title = 'Mostrar / ocultar';
        btn.innerHTML = iconEye();
        btn.style.borderLeft = '0';

        btn.addEventListener('click', function () {
            const visible = input.type === 'text';
            input.type = visible ? 'password' : 'text';
            btn.innerHTML = visible ? iconEye() : iconEyeOff();
            input.focus();
        });

        wrapper.appendChild(btn);
    });
}

function iconEye() {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">' +
        '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>' +
        '<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>' +
        '</svg>';
}

function iconEyeOff() {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" viewBox="0 0 16 16">' +
        '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>' +
        '<path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>' +
        '<path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>' +
        '</svg>';
}

/* ---------- MÁSCARA CPF / CNPJ ---------- */
function maskTaxId(input) {
    let v = input.value.replace(/\D/g, '');

    if (v.length <= 11) {
        // CPF: 000.000.000-00
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        // CNPJ: 00.000.000/0000-00
        v = v.substring(0, 14);
        v = v.replace(/(\d{2})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1/$2');
        v = v.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
    }

    input.value = v;
}

/* ---------- VALIDAÇÃO CPF via API ---------- */
let cpfTimer = null;

function initCpfValidation() {
    const input = document.getElementById('tax_id');
    if (!input) return;

    let feedback = document.getElementById('tax_id_feedback');
    if (!feedback) {
        feedback = document.createElement('div');
        feedback.id = 'tax_id_feedback';
        feedback.style.fontSize = '0.85em';
        feedback.style.marginTop = '4px';
        // Inserir após o wrapper (input-group) ou após o próprio input
        const parent = input.closest('.input-group') || input;
        parent.insertAdjacentElement('afterend', feedback);
    }

    input.addEventListener('input', function () {
        maskTaxId(input);

        const digits = input.value.replace(/\D/g, '');
        feedback.textContent = '';
        feedback.style.color = '';
        clearTimeout(cpfTimer);

        if (digits.length === 11) {
            feedback.textContent = '⏳ Verificando CPF...';
            feedback.style.color = '#888';

            cpfTimer = setTimeout(function () {
                fetch('https://api.cpfcnpj.com.br/consultarCPF.php?cpf=' + digits)
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data && data.status === 'OK' && data.situacao && data.situacao.toUpperCase() !== 'REGULAR') {
                            feedback.textContent = '⚠️ CPF encontrado mas situação: ' + data.situacao;
                            feedback.style.color = '#e67e22';
                        } else if (data && data.status === 'OK') {
                            feedback.textContent = '✅ CPF válido';
                            feedback.style.color = '#27ae60';
                        } else {
                            feedback.textContent = '❌ CPF inválido ou não encontrado';
                            feedback.style.color = '#e74c3c';
                        }
                    })
                    .catch(function () {
                        // Fallback: validação matemática local
                        if (validarCpfLocal(digits)) {
                            feedback.textContent = '✅ CPF válido (verificado localmente)';
                            feedback.style.color = '#27ae60';
                        } else {
                            feedback.textContent = '❌ CPF inválido';
                            feedback.style.color = '#e74c3c';
                        }
                    });
            }, 600);

        } else if (digits.length === 14) {
            // CNPJ — só validação local
            if (validarCnpjLocal(digits)) {
                feedback.textContent = '✅ CNPJ válido';
                feedback.style.color = '#27ae60';
            } else {
                feedback.textContent = '❌ CNPJ inválido';
                feedback.style.color = '#e74c3c';
            }
        }
    });

    // Aplicar máscara no valor já preenchido (modo edição)
    if (input.value) maskTaxId(input);
}

/* ---------- VALIDAÇÃO LOCAL CPF ---------- */
function validarCpfLocal(cpf) {
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    var soma = 0, resto;
    for (var i = 1; i <= 9; i++) soma += parseInt(cpf[i - 1]) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf[9])) return false;
    soma = 0;
    for (var i = 1; i <= 10; i++) soma += parseInt(cpf[i - 1]) * (12 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    return resto === parseInt(cpf[10]);
}

/* ---------- VALIDAÇÃO LOCAL CNPJ ---------- */
function validarCnpjLocal(c) {
    if (c.length !== 14 || /^(\d)\1{13}$/.test(c)) return false;
    var t = c.length - 2, d = c.substring(t), n = c.substring(0, t), s = 0, p = t - 7;
    for (var i = t; i >= 1; i--) { s += parseInt(n[t - i]) * p--; if (p < 2) p = 9; }
    var r = s % 11 < 2 ? 0 : 11 - s % 11;
    if (r !== parseInt(d[0])) return false;
    t += 1; n = c.substring(0, t); s = 0; p = t - 7;
    for (var i = t; i >= 1; i--) { s += parseInt(n[t - i]) * p--; if (p < 2) p = 9; }
    r = s % 11 < 2 ? 0 : 11 - s % 11;
    return r === parseInt(d[1]);
}

/* ---------- MÁSCARA PLACA ---------- */
function initLicensePlate() {
    const input = document.getElementById('license_plate');
    if (!input) return;
    input.addEventListener('input', function () {
        let v = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        if (v.length > 7) v = v.substring(0, 7);
        // Mercosul: ABC1D23  |  Antiga: ABC1234
        if (v.length > 3) v = v.substring(0, 3) + '-' + v.substring(3);
        input.value = v;
    });
}

/* ---------- INICIALIZAR TUDO ---------- */
document.addEventListener('DOMContentLoaded', function () {
    initPasswordToggles();
    initCpfValidation();
    initLicensePlate();
});
