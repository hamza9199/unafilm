const express = require('express');
const router = express.Router();
const { Film } = require('../modeli/Film');

// Get all films
router.get('/', async (req, res) => {
  try {
    const films = await Film.findAll();
    res.json(films);
  } catch (err) {
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

// Create a new film
router.post('/', async (req, res) => {
  try {
    const newFilm = await Film.create(req.body);
    res.status(201).json(newFilm);
  } catch (err) {
    res.status(400).json({ error: err.message });
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
    const films = await Film.findAll({
      where: {
        [Op.or]: [
          { title: { [Op.like]: `%${query}%` } },
          { description: { [Op.like]: `%${query}%` } },
        ],
      },
    });
    res.json(films);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;