const express = require('express');
const cors = require('cors');
const dotenv = require('dotenv');
const sequelize = require('./sequelizeInstance'); // Already configured for SQLite
const Film = require('./modeli/Film');
const Novost = require('./modeli/Novost');
const Admin = require('./modeli/Admin');
const Poruka = require('./modeli/Poruka');
const AdminRouter = require('./kontroleri/AdminRouter');
const FilmRouter = require('./kontroleri/FilmRouter');
const NovostRouter = require('./kontroleri/NovostRouter');
const PorukaRouter = require('./kontroleri/PorukaRouter');
const swaggerUi = require('swagger-ui-express');
const swaggerJsDoc = require('swagger-jsdoc');

const app = express();
require('dotenv').config();
dotenv.config();
const PORT = 3000;


// Testiranje konekcije s bazom
(async () => {
    try {
        await sequelize.authenticate();
        console.log('Konekcija s SQLite bazom je uspješna.');
        await sequelize.query('PRAGMA foreign_keys = ON;');
        await sequelize.sync({ force: false }); // Onemogućeno automatsko ažuriranje
        console.log('Baza sinhronizovana.');
    } catch (error) {
        console.error('Greška pri konekciji s bazom:', error);
        process.exit(1);
    }
})();

/*
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
})();*/

// CORS opcije
const corsOptions = {
    origin: ['https://una-film-klijent.vercel.app', 'http://localhost:5173', 'https://una-film-klijent-hamza-gacics-projects.vercel.app', 'https://una-film-klijent-git-main-hamza-gacics-projects.vercel.app'],
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
    credentials: true,
    optionsSuccessStatus: 204,
};

// Middleware
app.use(cors(corsOptions));
app.use(express.json());

// Swagger setup
const swaggerSetup = require('./kontroleri/swagger.js');
swaggerSetup(app);


// Serve Images as Static Files
app.use("/uploads", express.static("uploads"));

// Rute
app.use('/server/filmovi', FilmRouter);
app.use('/server/novosti', NovostRouter);
app.use('/server/admin', AdminRouter);
app.use('/server/poruke', PorukaRouter);

app.use("/" , (req, res) => {
    res.status(200).json({ message: "Server radi!" });
}
);

// Pokretanje servera
app.listen(PORT, () => {
    console.log(`Server pokrenut na http://localhost:${PORT}`);
});
