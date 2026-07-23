// Import Laravel Bootstrap and Alpine.js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// On DOM ready…
document.addEventListener('DOMContentLoaded', () => {
  const munSelect   = document.getElementById('municipality');
  const brgySelect  = document.getElementById('barangay');

  if (!munSelect || !brgySelect) return;

  // Fetch the Nueva Ecija data
  fetch('/js/nueva-ecija.json')
    .then(res => {
      if (!res.ok) throw new Error('Network response was not ok');
      return res.json();
    })
    .then(data => {
      // Populate municipalities
      Object.keys(data)
        .sort()
        .forEach(mun => {
          const o = document.createElement('option');
          o.value = mun;
          o.textContent = mun;
          munSelect.appendChild(o);
        });

      // When municipality changes, fill barangays
      munSelect.addEventListener('change', () => {
        const list = data[munSelect.value] || [];
        // reset
        brgySelect.innerHTML = '<option disabled selected>Select Barangay</option>';
        // populate
        list.sort().forEach(name => {
          const o = document.createElement('option');
          o.value = name;
          o.textContent = name;
          brgySelect.appendChild(o);
        });
      });
    })
    .catch(err => {
      console.error('Failed to load Nueva Ecija data:', err);
    });
});
