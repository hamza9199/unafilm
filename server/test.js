const sequelize = require('./sequelizeInstance'); // Already configured for SQLite
const Film = require('./modeli/Film');

// Funkcija za unos podataka
async function insertMovies() {
    try {
        // Sinhroniziraj bazu
        await sequelize.sync();

        // Unesi filmove
        const movies = [
            {
                title: 'Pirates of the Caribbean: At Worlds End',
                description: 'Will Turner, Elizabeth Swann, Hector Barbossa, and the crew of the Black Pearl try and rescue Jack from davy jones locker and prepare to fight Lord Cutler Beckett, who controls Davy Jones and the Flying Dutchman.',
                trailerUrl: 'https://www.youtube.com/embed/HKSZtp_OGHY',
                imageUrl: 'https://unafilm-production.up.railway.app/uploads/1744669847947.jpg',
                imageUrl2: 'https://unafilm-production.up.railway.app/uploads/1744669849600.jpg',
                releaseDate: '2024-01-01 00:00:00',
                duration: 120,
                reditelj: 'Reditelj 1',
                comment: 10,
                type: 'film',
                tipMjesta: 'arhiva',
                opis: "Pirates of the Caribbean: At World's End is a 2007 American epic fantasy swashbuckler film directed by Gore Verbinski, produced by Jerry Bruckheimer, and written by Ted Elliott and Terry Rossio. The direct sequel to Pirates of the Caribbean: Dead Man's Chest, it is the third installment in the Pirates of the Caribbean film series, and follows an urgent quest to locate and save Captain Jack Sparrow, trapped on a sea of sand in Davy Jones' Locker, and convene the Brethren Court in a war against the East India Trading Company.",
                od: '2025-04-01',
                do: '2025-04-15',
                createdAt: '2025-04-07 23:36:58',
            },
            
        ];

        for (let i = 2; i <= 20; i++) {
            movies.push({
                title: `Film ${i}`,
                description: `Description ${i}`,
                trailerUrl: 'https://www.youtube.com/embed/lqzGlT8DsDg',
                imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/Drop-FB-cover-BiH.jpg',
                imageUrl2: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                releaseDate: `2024-${String(i).padStart(2, '0')}-01 00:00:00`,
                duration: 120,
                reditelj: `Reditelj ${i}`,
                comment: i * 5,
                type: 'film',
                tipMjesta: i % 3 === 0 ? 'uskoro' : i % 3 === 1 ? 'trenutno' : 'arhiva',
                opis: `Opis ${i}`,
                od: `2025-04-${String(i).padStart(2, '0')}`,
                do: `2025-04-${String(i+5).padStart(2, '0')}`,
                createdAt: '2025-04-07 23:36:58',
            });
        }

        // Unesi filmove u bazu
        await Film.bulkCreate(movies);

        console.log('Tabele popunjene.');
    } catch (error) {
        console.error('Došlo je do greške prilikom unosa:', error);
    } finally {
        // Zatvori vezu prema bazi
        await sequelize.close();
    }
}

// Pozovi funkciju za unos filmova
insertMovies();
