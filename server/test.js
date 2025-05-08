const sequelize = require('./sequelizeInstance'); // Already configured for SQLite
const Film = require('./modeli/Film');
const { v4: uuidv4 } = require('uuid');

async function updateUUIDs() {
    try {
        // Uzimamo sve filmove
        const films = await Film.findAll();

        // Prolazimo kroz svaki film i dodajemo UUID
        for (const film of films) {
            if (!film.uuid) { // Ako UUID nije već postavljen
                film.uuid = uuidv4(); // Generišemo UUID
                await film.save(); // Spremamo promenu u bazu
            }
        }

        console.log('Svi filmovi su ažurirani sa UUID-om.');
    } catch (err) {
        console.error('Greška prilikom ažuriranja UUID-ova:', err);
    }
}

updateUUIDs();

