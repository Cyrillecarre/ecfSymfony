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

        // Construction de l'URL pour la requête Fetch
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
        .then(text => {
            console.log('Contenu de la réponse :', text);
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

    // Sélectionnez toutes les cartes de véhicules
    const cards = document.querySelectorAll('.card');

    // Parcourez chaque carte de véhicule
    cards.forEach(card => {
        // Récupérez les informations du véhicule à partir de la carte
        const carDate = parseInt(card.querySelector('#carDate').textContent);
        const carKilometrage = parseInt(card.querySelector('#carKilometrage').textContent);
        const carPrix = parseInt(card.querySelector('#carPrix').textContent);

        // Vérifiez si les critères de filtrage sont satisfaits
        if (carDate >= anneeMin && carKilometrage <= kmMax && carPrix <= prixMax) {
            // Si les critères sont satisfaits, affichez la carte
            card.style.display = 'block';
        } else {
            // Sinon, masquez la carte
            card.style.display = 'none';
        }
    });
}



/*class Filtre {
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

});*/
