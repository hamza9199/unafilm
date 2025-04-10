const { Sequelize } = require('sequelize');
const mysql = require('serverless-mysql');


/*const sequelize = new Sequelize({
    dialect: 'sqlite',
    storage: './database.sqlite',
    logging: false,
    retry: {
        match: [/SQLITE_CONSTRAINT/], // Pokušaj ponovo ako naiđe na constraint grešku
        max: 3, // Maksimalno 3 pokušaja
    },
});*/


// Optimize Sequelize for Vercel (serverless)
const sequelize = new Sequelize('defaultdb', 'avnadmin', 'AVNS_bYKnnvCQgPQoFwz-s3Q', {
    host: 'decibel-redbullshop.h.aivencloud.com',
    dialect: 'mysql',
    logging: false,
    port: 16855,
    pool: { 
        max: 1,  // Prevent too many persistent connections
        min: 0,  
        idle: 5000, 
        acquire: 30000 
    },
    define: { freezeTableName: true }, // Prevent Sequelize from pluralizing table names
});


module.exports = sequelize;
