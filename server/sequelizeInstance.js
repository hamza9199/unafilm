const { Sequelize } = require('sequelize');
const mysql = require('serverless-mysql');

/*
const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database.sqlite',
    logging: false,
    retry: {
        match: [/SQLITE_CONSTRAINT/], // Pokušaj ponovo ako naiđe na constraint grešku
        max: 3, // Maksimalno 3 pokušaja
    },
});*/


const sequelize = new Sequelize('unafilm_db1', 'unafilm_1', 'na3Bnpkwcp1BLF6Z', {
    host: 'id4d.your-database.de',
    dialect: 'mysql',
    logging: false, // opcionalno: da ne ispisuje SQL upite u konzolu
    port: 3306 // standardni MySQL port ako ti nije drugačije navedeno
});


module.exports = sequelize;
