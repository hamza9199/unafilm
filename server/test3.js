const sequelize = require('./sequelizeInstance'); // Already configured for SQLite
const Admin = require('./modeli/Admin');

// Funkcija za unos podataka
async function insertAdmin() {
    try {
        // Sinhroniziraj bazu
        await sequelize.sync();

        

        const admin = [
            {
                username: 'admin',
                password: 'admin',
                createdAt: '2025-04-07 23:36:58',
            },
        ];

        // Unesi admina
        await Admin.bulkCreate(admin);

        console.log('Tabele popunjene.');
    } catch (error) {
        console.error('Došlo je do greške prilikom unosa:', error);
    } finally {
        // Zatvori vezu prema bazi
        await sequelize.close();
    }
}

// Pozovi funkciju za unos filmova
insertAdmin();
