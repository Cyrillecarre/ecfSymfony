var map = L.map('map').setView([43.6047, 1.4442], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    L.marker([43.6047, 1.4442]).addTo(map)
      .bindPopup('Garage V.PARROT')
      .openPopup();


