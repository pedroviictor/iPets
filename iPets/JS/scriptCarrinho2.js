document.addEventListener('DOMContentLoaded', function () {
    const paymentElements = document.querySelectorAll('.pag-element');

    let selectedPayment = null;

    function updateSelections() { // Onde coleta qual o método de pagamento o cliente escolheu - quando escolhido "Pagar na entrega"
        console.log(`Método de Pagamento Selecionado: ${selectedPayment}`);
    }

    paymentElements.forEach(element => {
        element.addEventListener('click', function () {
            if (selectedPayment) {
                document.querySelector(`.pag-element[data-payment="${selectedPayment}"]`).classList.remove('selected-payment');
            }
            selectedPayment = this.getAttribute('data-payment');
            this.classList.add('selected-payment');
            updateSelections();
        });
    });
});

function showTab(tab) {
    document.getElementById('tab-app').classList.remove('active');
    document.getElementById('tab-entrega').classList.remove('active');
    document.getElementById(`tab-${tab}`).classList.add('active');

    document.getElementById('app-content').style.display = tab === 'app' ? 'block' : 'none';
    document.getElementById('entrega-content').style.display = tab === 'entrega' ? 'block' : 'none';
}

document.getElementById('pag-form').addEventListener('submit', function (event) {
    const isAppTabActive = document.getElementById('tab-app').classList.contains('active');

    if (isAppTabActive) {
        const cardNumber = document.getElementById('card-number').value;
        const cardName = document.getElementById('card-name').value;
        const expiryDate = document.getElementById('expiry-date').value;
        const cvv = document.getElementById('cvv').value;

        if (!cardNumber || !cardName || !expiryDate || !cvv) {
            alert('Por favor, preencha todos os campos do cartão.');
            event.preventDefault();
        }
    }
});

document.getElementById('card-number').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '')
        .replace(/(.{4})/g, '$1 ')
        .trim();
});

document.getElementById('expiry-date').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');

    if (value.length >= 3) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4);
    }

    e.target.value = value;
});


document.getElementById('expiry-date').addEventListener('keypress', function (e) {
    if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
    }
});

document.getElementById('cvv').addEventListener('input', function (e) {
    e.target.value = e.target.value.slice(0, 3);
});