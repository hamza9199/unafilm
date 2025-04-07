const express = require('express');
const router = express.Router();
const  Film  = require('../modeli/Film');
const { Sequelize, Op } = require('sequelize'); 

// Get all films
router.get('/', async (req, res) => {
  try {
    const films = await Film.findAll();
    res.json(films);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});


// Create a new film
router.post('/', async (req, res) => {
  try {
    console.log("Received data:", req.body);  // Dodaj ovu liniju
    const newFilm = await Film.create(req.body);
    res.status(201).json(newFilm);
  } catch (err) {
    res.status(400).json({ error: err.message });
  }
});

// Get all films with tipMjesta "uskoro"
router.get('/uskoro', async (req, res) => {
  try {
    const films = await Film.findAll({
      where: {
        tipMjesta: 'uskoro',
      },
    });
    res.json(films);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Get all films with tipMjesta "trenutno"
router.get('/trenutno', async (req, res) => {
  try {
    const films = await Film.findAll({
      where: {
        tipMjesta: 'trenutno',
      },
    });
    res.json(films);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Get all films with tipMjesta "arhiva"
router.get('/arhiva', async (req, res) => {
  try {
    // Dohvati filmove sa tipom 'arhiva'
    const films = await Film.findAll({
      where: {
        tipMjesta: 'arhiva',
      },
    });

    // Ako nema filmova sa tipom 'arhiva', vrati 404
    if (!films.length) {
      return res.status(404).json({ error: 'No films found with "arhiva" type' });
    }

    // Mapiraj Sequelize instance u obične objekte
    const filmsData = films.map(film => film.get());  // ovo izvlači podatke iz Sequelize instanci

    // Vraćanje filmova kao JSON
    res.json(filmsData);
  } catch (err) {
    console.error(err);  // Log greške na serveru
    res.status(500).json({ error: err.message });
  }
});

// Get a single film by ID
router.get('/:id', async (req, res) => {
  try {
    const film = await Film.findByPk(req.params.id);
    if (!film) {
      return res.status(404).json({ error: 'Film not found' });
    }
    res.json(film);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});



// Update an existing film by ID
router.put('/:id', async (req, res) => {
  try {
    const film = await Film.findByPk(req.params.id);
    if (!film) {
      return res.status(404).json({ error: 'Film not found' });
    }
    await film.update(req.body);
    res.json(film);
  } catch (err) {
    res.status(400).json({ error: err.message });
  }
});

// Delete a film by ID
router.delete('/:id', async (req, res) => {
  try {
    const film = await Film.findByPk(req.params.id);
    if (!film) {
      return res.status(404).json({ error: 'Film not found' });
    }
    await film.destroy();
    res.json({ message: 'Film deleted successfully' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});



// Search films by title or description
router.get('/search/:query', async (req, res) => {
  try {
    const query = req.params.query;

    // Proveravamo da li je query prazan
    if (!query || query.trim() === '') {
      return res.status(400).json({ error: 'Query parameter is required' });
    }

    // Sanitizacija unosa, obavezno bježite od specijalnih karaktera
    const sanitizedQuery = query.replace(/[^a-zA-Z0-9 ]/g, '');

    // Pretraga filmova po naslovu ili opisu
    const films = await Film.findAll({
      where: {
        [Op.or]: [
          { title: { [Op.like]: `%${sanitizedQuery}%` } },
          { description: { [Op.like]: `%${sanitizedQuery}%` } },
        ],
      },
    });

    // Ako nema filmova
    if (films.length === 0) {
      return res.status(404).json({ message: 'No films found matching your search criteria.' });
    }

    // Vraćamo pronađene filmove
    res.json(films);
  } catch (err) {
    console.error('Error during search:', err.message);
    res.status(500).json({ error: 'An error occurred while searching for films. Please try again later.' });
  }
});




module.exports = router;