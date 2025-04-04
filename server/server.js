const express = require('express');
const cors = require('cors');
const dotenv = require('dotenv');
const sequelize = require('./sequelizeInstance')
const Film = require('./modeli/Film')
const FilmRouter = require('./kontroleri/FilmRouter');



const app = express();
require('dotenv').config();
dotenv.config();
const PORT = 3000;


// Testiranje konekcije s bazom
(async () => {
    try {
        await sequelize.authenticate();
        console.log('Konekcija s MySQL bazom je uspješna.');
        await sequelize.sync({ alter: true }); // Sinhronizacija modela s bazom
        console.log('Baza sinhronizovana.');
    } catch (error) {
        console.error('Greška pri konekciji s bazom:', error);
        process.exit(1);
    }
})();


// CORS opcije
const corsOptions = {
    origin: ['http://localhost:5173'],
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
    credentials: true,
    optionsSuccessStatus: 204,
};

app.use(cors());
app.use(cors(corsOptions));
app.use(express.json());


//Rute
app.use('/filmovi', FilmRouter);


// Pokretanje servera
app.listen(PORT, () => {
    console.log(`Server pokrenut na http://localhost:${PORT}`);
});