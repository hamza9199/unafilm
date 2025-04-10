const { Sequelize } = require('sequelize');
const dotenv = require('dotenv');


dotenv.config();

const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database.sqlite',
    logging: false,
    retry: {
        match: [/SQLITE_CONSTRAINT/], // Pokušaj ponovo ako naiđe na constraint grešku
        max: 3, // Maksimalno 3 pokušaja
    },
});

module.exports = sequelize;
