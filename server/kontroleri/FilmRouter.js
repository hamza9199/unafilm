const express = require('express');
const router = express.Router();
const { Film } = require('../modeli/Film');

router.get('/', async (req, res) => {
  try {
    const movies = await Film.findAll();
    res.json(movies);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;