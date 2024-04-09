document.addEventListener('DOMContentLoaded', function () {
    const rangeInputPrix = document.getElementById('rangeInputPrix');
    const rangeInputAnnee = document.getElementById('rangeInputAnnee');
    const rangeInputKm = document.getElementById('rangeInputKm');
    const currentValuePrix = document.getElementById('currentValuePrix');
    const currentValueAnnee = document.getElementById('currentValueAnnee');
    const currentValueKm = document.getElementById('currentValueKm');

    rangeInputPrix.addEventListener('input', (event) => {
        currentValuePrix.textContent = event.target.value;
    });

    rangeInputAnnee.addEventListener('input', (event) => {
        currentValueAnnee.textContent = event.target.value;
    });

    rangeInputKm.addEventListener('input', (event) => {
        currentValueKm.textContent = event.target.value;
    });

    const form = document.getElementById('filtreForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const prixMax = parseInt(rangeInputPrix.value);
        const anneeMin = parseInt(rangeInputAnnee.value);
        const kmMax = parseInt(rangeInputKm.value);

        const url = form.getAttribute('data-action');

        fetch(url, {
            method: 'POST',
            body: JSON.stringify({ prixMax, anneeMin, kmMax }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('reponse serveur', response);
            return response.text();
        })
        .then(data => {
            filterVehicles(data);    
        })
        .catch(error => {
            console.error('Erreur lors de la requête:', error);
        });
    });
});

function filterVehicles(data) {
    const prixMax = parseInt(rangeInputPrix.value);
    const anneeMin = parseInt(rangeInputAnnee.value);
    const kmMax = parseInt(rangeInputKm.value);
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        const carDate = parseInt(card.querySelector('#carDate').textContent);
        const carKilometrage = parseInt(card.querySelector('#carKilometrage').textContent);
        const carPrix = parseInt(card.querySelector('#carPrix').textContent);

        if (carDate >= anneeMin && carKilometrage <= kmMax && carPrix <= prixMax) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}