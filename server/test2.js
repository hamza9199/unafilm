const sequelize = require('./sequelizeInstance'); // Already configured for SQLite
const Novost = require('./modeli/Novost');

// Funkcija za unos podataka
async function insertNovost() {
    try {
        // Sinhroniziraj bazu
        await sequelize.sync();


        const novosti = [
            {
                filmId: 1,  // Povezivanje sa prvim filmom
                title: 'Novost 1',
                kreator: 'Kreator 1',
                tekst: 'Tekst 1',
                tekst2: 'Tekst 2',
                tekst3: 'Tekst 3',
                tekst4: 'Tekst 4',
                slika1: 'https://unafilm.ba/wp-content/uploads/2025/03/Drop-FB-cover-BiH.jpg',
                slika2: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                slika3: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                tipNovosti: 'novost',
                datumKreiranja: '2025-04-07 23:36:58',
            },
        ];

        for (let i = 2; i <= 20; i++) {
            novosti.push({
                filmId: i,  // Povezivanje sa odgovarajućim filmom
                title: `Novost ${i}`,
                kreator: `Kreator ${i}`,
                tekst: `Tekst ${i}`,
                tekst2: `Tekst ${i}`,
                tekst3: `Tekst ${i}`,
                tekst4: `Tekst ${i}`,
                slika1: 'https://unafilm.ba/wp-content/uploads/2025/03/Drop-FB-cover-BiH.jpg',
                slika2: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                slika3: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                tipNovosti: i % 3 === 0 ? 'novost' : i % 3 === 1 ? 'trailer' : 'svijetfilma',
                datumKreiranja: '2025-04-07 23:36:58',
            });
        }

        // Unesi novosti u bazu
        await Novost.bulkCreate(novosti);


        console.log('Tabele popunjene.');
    } catch (error) {
        console.error('Došlo je do greške prilikom unosa:', error);
    } finally {
        // Zatvori vezu prema bazi
        await sequelize.close();
    }
}

// Pozovi funkciju za unos filmova
insertNovost();
