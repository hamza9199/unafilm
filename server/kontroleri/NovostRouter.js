const express = require('express');
const Novost = require('../modeli/Novost');
const Film = require('../modeli/Film');
const { Op } = require('sequelize');
const multer = require('multer');
const storage = require('../kontroleri/multer.js'); // Import the multer storage configuration
const upload = multer({ storage });
const fs = require('fs');
const path = require('path');
const { deleteFromFrontend, uploadToFrontend } = require('./ftp.js');

const router = express.Router();


/**
 * @swagger
 * tags:
 *   name: Novosti
 *   description: API for managing novosti
 */

/**
 * @swagger
 * components:
 *   schemas:
 *     Novost:
 *       type: object
 *       properties:
 *         id:
 *           type: integer
 *           example: 1
 *         filmId:
 *           type: integer
 *           example: 2
 *         title:
 *           type: string
 *           example: "New Trailer Released"
 *         kreator:
 *           type: string
 *           example: "John Doe"
 *         tekst:
 *           type: string
 *           example: "This is the main text of the news."
 *         tekst2:
 *           type: string
 *           example: "Additional text section 2."
 *         tekst3:
 *           type: string
 *           example: "Additional text section 3."
 *         tekst4:
 *           type: string
 *           example: "Additional text section 4."
 *         slika1:
 *           type: string
 *           example: "image1.jpg"
 *         slika2:
 *           type: string
 *           example: "image2.jpg"
 *         slika3:
 *           type: string
 *           example: "image3.jpg"
 *         tipNovosti:
 *           type: string
 *           example: "trailer"
 *         datumKreiranja:
 *           type: string
 *           format: date-time
 *           example: "2023-01-01T12:00:00Z"
 */

/**
 * @swagger
 * /server/novosti:
 *   get:
 *     summary: Retrieve all novosti
 *     tags: [Novosti]
 *     responses:
 *       200:
 *         description: List of novosti
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Novost'
 */

/**
 * @swagger
 * /server/novosti:
 *   post:
 *     summary: Create a new novost
 *     tags: [Novosti]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Novost'
 *     responses:
 *       201:
 *         description: Successfully created a new novost
 *       400:
 *         description: Bad request
 */

/**
 * @swagger
 * /server/novosti/svijetfilma:
 *   get:
 *     summary: Retrieve novosti with tipNovosti "svijetfilma"
 *     tags: [Novosti]
 *     responses:
 *       200:
 *         description: List of novosti with tipNovosti "svijetfilma"
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Novost'
 */

/**
 * @swagger
 * /server/novosti/novost:
 *   get:
 *     summary: Retrieve novosti with tipNovosti "novost"
 *     tags: [Novosti]
 *     responses:
 *       200:
 *         description: List of novosti with tipNovosti "novost"
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Novost'
 */

/**
 * @swagger
 * /server/novosti/trailer:
 *   get:
 *     summary: Retrieve novosti with tipNovosti "trailer"
 *     tags: [Novosti]
 *     responses:
 *       200:
 *         description: List of novosti with tipNovosti "trailer"
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Novost'
 */

/**
 * @swagger
 * /server/novosti/{id}:
 *   get:
 *     summary: Retrieve a novost by ID
 *     tags: [Novosti]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the novost
 *     responses:
 *       200:
 *         description: Successfully retrieved the novost
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Novost'
 *       404:
 *         description: Novost not found
 */

/**
 * @swagger
 * /server/novosti/{id}:
 *   put:
 *     summary: Update a novost by ID
 *     tags: [Novosti]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the novost
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Novost'
 *     responses:
 *       200:
 *         description: Successfully updated the novost
 *       404:
 *         description: Novost not found
 *       400:
 *         description: Bad request
 */

/**
 * @swagger
 * /server/novosti/{id}:
 *   delete:
 *     summary: Delete a novost by ID
 *     tags: [Novosti]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the novost
 *     responses:
 *       200:
 *         description: Successfully deleted the novost
 *       404:
 *         description: Novost not found
 */

/**
 * @swagger
 * /server/novosti/search/{query}:
 *   get:
 *     summary: Search novosti by title 
 *     tags: [Novosti]
 *     parameters:
 *       - in: path
 *         name: query
 *         required: true
 *         schema:
 *           type: string
 *         description: The search query
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of novosti
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Novost'
 *       400:
 *         description: Query parameter is required
 *       404:
 *         description: No novosti found matching the search criteria
 *       500:
 *         description: Server error
 */

// Get all novosti
router.get('/', async (req, res) => {
    try {
        const novosti = await Novost.findAll({
            include: [{
                model: Film,
                as: 'film'  // Use the correct alias here
            }]
        });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});


// Create a new novost with image upload
router.post('/', upload.single('image'), async (req, res) => {
    try {
        const { title, kreator, tekst, tipNovosti, filmId } = req.body;

        const newNovostData = {
            title,
            kreator,
            tekst,
            tipNovosti,
            filmId: filmId ? filmId : null,  // Ako nije poslat filmId, postavi null
            };

        if (req.file) {
            const newImagePath = path.join(__dirname, '..', 'uploads', req.file.filename);
            await uploadToFrontend(newImagePath, req.file.filename);
            newNovostData.image = `https://unafilm.ba/uploads/${req.file.filename}`;
            fs.unlinkSync(newImagePath); 
        }

        const novost = await Novost.create(newNovostData);

        res.status(201).json({
            message: "Novost created successfully",
            novost
        });
    } catch (error) {
        res.status(400).json({ message: 'Error creating novost', error });
    }
});





// Get all novosti with tipNovosti "svijetfilma"
router.get('/svijetfilma', async (req, res) => {
    try {
        const novosti = await Novost.findAll({
            where: { tipNovosti: 'svijetfilma' },
            include: [{
                model: Film,
                as: 'film'  // Povezivanje sa filmom
            }]
        });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});

// Get all novosti with tipNovosti "novost"
router.get('/novost', async (req, res) => {
    try {
        const novosti = await Novost.findAll({
            where: { tipNovosti: 'novost' },
            include: [{
                model: Film,
                as: 'film'  // Povezivanje sa filmom
            }]
        });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});

// Get all novosti with tipNovosti "trailer"
router.get('/trailer', async (req, res) => {
    try {
        const novosti = await Novost.findAll({
            where: { tipNovosti: 'trailer' },
            include: [{
                model: Film,
                as: 'film'  // Povezivanje sa filmom
            }]
        });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});

// Get a single novost by ID with the associated film
router.get('/:uuid', async (req, res) => {
    try {
         const novost = await Novost.findOne({
            where: { uuid: req.params.uuid },
            include: [{
                model: Film,
                as: 'film'  // Povezivanje sa filmom
            }]
        });

        if (!novost) {
            return res.status(404).json({ message: 'Novost not found' });
        }
        res.status(200).json(novost);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novost', error });
    }
});



// Update an existing novost by ID and update image if provided
router.put('/:id', upload.single('image'), async (req, res) => {
  try {
    const novost = await Novost.findByPk(req.params.id);
    if (!novost) {
      return res.status(404).json({ message: 'Novost not found' });
    }

    let oldFilename;

    if (req.file) {
      const newImagePath = path.join(__dirname, '..', 'uploads', req.file.filename);

      // ===> Spasi staru sliku prije izmjene
      oldFilename = novost.image?.split('/').pop();

      // Upload nova slika na FTP
      await uploadToFrontend(newImagePath, req.file.filename);

      // Postavi novu sliku
      novost.image = `https://unafilm.ba/uploads/${req.file.filename}`;

      // ===> Briši staru ako nije ista kao nova
      if (oldFilename && oldFilename !== req.file.filename) {
        await deleteFromFrontend(oldFilename);
      }
    }

    // Ažuriraj ostale podatke
    novost.title = req.body.title || novost.title;
    novost.kreator = req.body.kreator || novost.kreator;
    novost.tekst = req.body.tekst || novost.tekst;
    novost.tipNovosti = req.body.tipNovosti || novost.tipNovosti;
    novost.filmId = req.body.filmId || null;

    await novost.save();

    res.status(200).json({ message: 'Novost updated successfully', novost });
  } catch (error) {
    res.status(400).json({ message: 'Error updating novost', error });
  }
});



// Delete a novost by ID
router.delete('/:id', async (req, res) => {
    try {
        const novost = await Novost.findByPk(req.params.id);

        if (!novost) {
            return res.status(404).json({ message: 'Novost not found' });
        }

        // Obriši sliku ako postoji
        if (novost.image) {
            const imageFilename = novost.image.split('/').pop();

            await deleteFromFrontend(imageFilename);
        }

        await novost.destroy();

        res.status(200).json({ message: 'Novost deleted successfully' });

    } catch (error) {
        res.status(500).json({ message: 'Error deleting novost', error });
    }
});



// Search novosti by title 
router.get('/search/:query', async (req, res) => {
    try {
        const query = req.params.query;

        // Proveravamo da li je query prazan
        if (!query || query.trim() === '') {
            return res.status(400).json({ error: 'Query parameter is required' });
        }

        // Sanitizacija unosa, obavezno bježite od specijalnih karaktera
        const sanitizedQuery = query.replace(/[^a-zA-Z0-9 ]/g, '');

        // Pretraga novosti po naslovu ili opisu, uključujući povezani Film model
        const novosti = await Novost.findAll({
            where: {
                [Op.or]: [
                    { title: { [Op.like]: `%${sanitizedQuery}%` } },
                ],
            },
            include: [{
                model: Film,
                as: 'film' // Povezivanje sa filmom
            }]
        });

        // Ako nema novosti
        if (novosti.length === 0) {
            return res.status(404).json({ message: 'No novosti found matching your search criteria.' });
        }

        // Vraćamo pronađene novosti
        res.json(novosti);
    } catch (err) {
        console.error('Error during search:', err.message);
        res.status(500).json({ error: 'An error occurred while searching for novosti. Please try again later.' });
    }
});






module.exports = router;