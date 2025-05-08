const { v4: uuidv4 } = require('uuid');
const Novost = require('./modeli/Novost'); // Prilagodi putanju ako treba

async function updateNovostUUIDs() {
    try {
        // Uzimamo sve novosti
        const novosti = await Novost.findAll();

        // Prolazimo kroz svaku novost i dodajemo UUID
        for (const novost of novosti) {
            if (!novost.uuid) { // Ako UUID nije već postavljen
                novost.uuid = uuidv4(); // Generišemo UUID
                await novost.save(); // Spremamo promenu u bazu
            }
        }

        console.log('Svi novosti su ažurirani sa UUID-om.');
    } catch (err) {
        console.error('Greška prilikom ažuriranja UUID-ova:', err);
    }
}

updateNovostUUIDs();
