const express = require('express');
const router = express.Router();
const  Film  = require('../modeli/Film');
const { Sequelize, Op } = require('sequelize'); 
const multer = require('multer');
const storage = require('../kontroleri/multer.js'); // Import the multer storage configuration
const upload = multer({ storage });
const fs = require('fs');
const path = require('path');
const { uploadToFrontend } = require('./ftp.js');


/**
 * @swagger
 * tags:
 *   name: Filmovi
 *   description: API for managing films
 */

/**
 * @swagger
 * /server/filmovi:
 *   get:
 *     summary: Retrieve all films
 *     tags: [Filmovi]
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of films
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Film'
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * /server/filmovi:
 *   post:
 *     summary: Create a new film
 *     tags: [Filmovi]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Film'
 *     responses:
 *       201:
 *         description: Successfully created a new film
 *       400:
 *         description: Bad request
 */

/**
 * @swagger
 * /server/filmovi/uskoro:
 *   get:
 *     summary: Retrieve films with "uskoro" type
 *     tags: [Filmovi]
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of films
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Film'
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * /server/filmovi/trenutno:
 *   get:
 *     summary: Retrieve films with "trenutno" type
 *     tags: [Filmovi]
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of films
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Film'
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * /server/filmovi/arhiva:
 *   get:
 *     summary: Retrieve films with "arhiva" type
 *     tags: [Filmovi]
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of films
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Film'
 *       404:
 *         description: No films found with "arhiva" type
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * /server/filmovi/{id}:
 *   get:
 *     summary: Retrieve a film by ID
 *     tags: [Filmovi]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the film
 *     responses:
 *       200:
 *         description: Successfully retrieved the film
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Film'
 *       404:
 *         description: Film not found
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * /server/filmovi/{id}:
 *   put:
 *     summary: Update a film by ID
 *     tags: [Filmovi]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the film
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Film'
 *     responses:
 *       200:
 *         description: Successfully updated the film
 *       404:
 *         description: Film not found
 *       400:
 *         description: Bad request
 */

/**
 * @swagger
 * /server/filmovi/{id}:
 *   delete:
 *     summary: Delete a film by ID
 *     tags: [Filmovi]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the film
 *     responses:
 *       200:
 *         description: Successfully deleted the film
 *       404:
 *         description: Film not found
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * /server/filmovi/search/{query}:
 *   get:
 *     summary: Search films by title or description
 *     tags: [Filmovi]
 *     parameters:
 *       - in: path
 *         name: query
 *         required: true
 *         schema:
 *           type: string
 *         description: The search query
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of films
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Film'
 *       400:
 *         description: Query parameter is required
 *       404:
 *         description: No films found matching the search criteria
 *       500:
 *         description: Server error
 */

/**
 * @swagger
 * components:
 *   schemas:
 *     Film:
 *       type: object
 *       properties:
 *         id:
 *           type: integer
 *         title:
 *           type: string
 *         description:
 *           type: string
 *         trailerUrl:
 *           type: string
 *         imageUrl:
 *           type: string
 *         imageUrl2:
 *           type: string
 *         releaseDate:
 *           type: string
 *           format: date
 *         duration:
 *           type: integer
 *         reditelj:
 *           type: string
 *         type:
 *           type: string
 *         tipMjesta:
 *           type: string
 *           enum: [uskoro, trenutno, arhiva]
 *         createdAt:
 *           type: string
 *           format: date-time
 */


// Get all films
router.get('/', async (req, res) => {
  try {
    const films = await Film.findAll();
    res.json(films);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Create a new film with image upload
router.post('/', upload.fields([
  { name: "image1", maxCount: 1 },
  { name: "image2", maxCount: 1 }
]), async (req, res) => {
  try {
    const { title, description, trailerUrl, releaseDate, duration, reditelj, comment, type, tipMjesta, opis, od, do: doDatum } = req.body;

    const newFilmData = {
      title,
      description,
      trailerUrl,
      releaseDate,
      duration,
      reditelj,
      comment,
      type,
      tipMjesta,
      opis,
      od,
      do: doDatum,
    };

    if (req.files.image1) {
      // Upload the first image to the frontend server
      const image1 = req.files.image1[0];
      const localPath = path.join(__dirname, '..', 'uploads', image1.filename);
      if (fs.existsSync(localPath)) {
        await uploadToFrontend(localPath, image1.filename);
      }
      else {
        console.error('Local file does not exist:', localPath);
      }


      const imagePath1 = `https://unafilm.ba/uploads/${req.files.image1[0].filename}`;
      newFilmData.imageUrl = imagePath1; // Set the imageUrl field
    }

    if (req.files.image2) {
      // Upload the second image to the frontend server
      const image2 = req.files.image2[0];
      await uploadToFrontend(path.join(__dirname, '..', 'uploads', image2.filename), image2.filename);

      const imagePath2 = `https://unafilm.ba/uploads/${req.files.image2[0].filename}`;
      newFilmData.imageUrl2 = imagePath2; // Set the imageUrl2 field
    }

    const newFilm = await Film.create(newFilmData);

    res.status(201).json({
      message: "Film created successfully",
      film: newFilm,
    });
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
router.get('/:uuid', async (req, res) => {
  try {
    const film = await Film.findOne({ where: { uuid: req.params.uuid } });
    if (!film) {
      return res.status(404).json({ error: 'Film not found' });
    }
    res.json(film);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});



// Update an existing film by ID with image upload
router.put('/:id', upload.fields([
  { name: "image1", maxCount: 1 },
  { name: "image2", maxCount: 1 }
]), async (req, res) => {
  try {
    const film = await Film.findByPk(req.params.id);
    if (!film) {
      return res.status(404).json({ error: 'Film not found' });
    }

    // Putanje do fajlova koje treba obrisati
    const oldImagePath1 = film.imageUrl?.split('/uploads/')[1];
    const oldImagePath2 = film.imageUrl2?.split('/uploads/')[1];

    const updatedData = {
      ...req.body,
    };

    if (req.files.image1) {
      const newImage1 = req.files.image1[0];

      await uploadToFrontend(path.join(__dirname, '..', 'uploads', newImage1.filename), newImage1.filename);
      
      updatedData.imageUrl = `https://unafilm.ba/uploads/${newImage1.filename}`;

      // Obrisi staru sliku ako postoji
      if (oldImagePath1) {
        fs.unlink(path.join(__dirname, '..', 'uploads', oldImagePath1), (err) => {
          if (err) console.error('Greška pri brisanju stare slike 1:', err.message);
        });
      }
    }

    if (req.files.image2) {
      const newImage2 = req.files.image2[0];

      await uploadToFrontend(path.join(__dirname, '..', 'uploads', newImage2.filename), newImage2.filename);

      updatedData.imageUrl2 = `https://unafilm.ba/uploads/${newImage2.filename}`;

      if (oldImagePath2) {
        fs.unlink(path.join(__dirname, '..', 'uploads', oldImagePath2), (err) => {
          if (err) console.error('Greška pri brisanju stare slike 2:', err.message);
        });
      }
    }

    await film.update(updatedData);
    res.status(200).json({ message: "Film updated successfully", film });
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

    const imagePath1 = film.imageUrl?.split('/uploads/')[1];
    const imagePath2 = film.imageUrl2?.split('/uploads/')[1];

    // Obrisi slike ako postoje
    if (imagePath1) {
      fs.unlink(path.join(__dirname, '..', 'uploads', imagePath1), (err) => {
        if (err) console.error('Greška pri brisanju slike 1:', err.message);
      });
    }

    if (imagePath2) {
      fs.unlink(path.join(__dirname, '..', 'uploads', imagePath2), (err) => {
        if (err) console.error('Greška pri brisanju slike 2:', err.message);
      });
    }

    await film.destroy();
    res.status(200).json({ message: "Film deleted successfully" });
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