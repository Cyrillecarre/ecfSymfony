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

    const cars = Array.from(document.querySelectorAll('.tableImg'));

    rangeInputPrix.addEventListener('input', filterVehicles);
    rangeInputAnnee.addEventListener('input', filterVehicles);
    rangeInputKm.addEventListener('input', filterVehicles);

    // Fonction de filtrage des véhicules
    function filterVehicles() {
        const prixMax = parseInt(rangeInputPrix.value);
        const anneeMin = parseInt(rangeInputAnnee.value);
        const kmMax = parseInt(rangeInputKm.value);

        // Filtrer les véhicules en fonction des critères sélectionnés
        cars.forEach(car => {
            const carAnnee = parseInt(car.querySelector('#carDate').textContent);
            const carKm = parseInt(car.querySelector('#carKilometrage').textContent);
            const carPrix = parseInt(car.querySelector('#carPrix').textContent);

            if (carAnnee >= anneeMin && carKm <= kmMax && carPrix <= prixMax) {
                car.style.display = 'block';
            } else {
                car.style.display = 'none';
            }
        });
    }


class Filtre {
    constructor() {
        this.filtreForm = document.getElementById('filtreForm');

        this.filtreForm.addEventListener('submit', function (event) {
            event.preventDefault();
            this.filterVehicules();
        }.bind(this));
    }

    filterVehicules() {
        const formData = new FormData(this.filtreForm);
        const params = new URLSearchParams(formData).toString();

        const url = this.filtreForm.getAttribute('data-action');
        const xhr = new XMLHttpRequest();
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                this.updateVehiculeContent(xhr.responseText);
            } else if (xhr.readyState === 4) {
                console.error('Erreur lors de la requête au serveur. Statut:', xhr.status);
            }
        };
        xhr.send(params);
    }

    updateVehiculeContent(response) {
        const vehiculeContener = document.querySelector('.card');
        vehiculeContener.innerHTML = response;
    }
}

const filtre = new Filtre();

});
