import { psgc } from 'ph-locations';
const { citiesMunicipalities, barangays } = psgc;

// Filter for Nueva Ecija only
const neCities = citiesMunicipalities.filter(c => c.province === '034900000');
// Optionally index barangays by city code
const barangaysByCity = barangays.reduce((map, b) => {
  if (!map[b.city]) map[b.city] = [];
  map[b.city].push(b);
  return map;
}, {});

window.NE_LOCATIONS = {
  cities: neCities.map(c => ({ id: c.code, name: c.name })),
  barangaysByCity
};
