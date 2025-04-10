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
                title: 'Film 1',
                description: 'Description 1',
                trailerUrl: 'https://www.youtube.com/embed/lqzGlT8DsDg',
                imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/Drop-FB-cover-BiH.jpg',
                imageUrl2: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                releaseDate: '2024-01-01 00:00:00',
                duration: 120,
                reditelj: 'Reditelj 1',
                comment: 10,
                type: 'film',
                tipMjesta: 'uskoro',
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
