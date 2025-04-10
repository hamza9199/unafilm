const { Sequelize } = require('sequelize');
const dotenv = require('dotenv');


dotenv.config();

/*const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database.sqlite',
    logging: false,
    retry: {
        match: [/SQLITE_CONSTRAINT/], // Pokušaj ponovo ako naiđe na constraint grešku
        max: 3, // Maksimalno 3 pokušaja
    },
});*/


const sequelize = new Sequelize('defaultdb', 'avnadmin', 'AVNS_bYKnnvCQgPQoFwz-s3Q', {
    host: 'decibel-redbullshop.h.aivencloud.com',
    dialect: 'mysql',
    logging: false,
    port: '16855',
});


module.exports = sequelize;
