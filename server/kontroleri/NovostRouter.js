const express = require('express');
const Novost = require('../modeli/Novost');
const Film = require('../modeli/Film')

const router = express.Router();

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

// Create a new novost
router.post('/', async (req, res) => {
    try {
        const novost = await Novost.create(req.body);
        res.status(201).json(novost);
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
router.get('/:id', async (req, res) => {
    try {
        const novost = await Novost.findByPk(req.params.id, {
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



// Update an existing novost by ID
router.put('/:id', async (req, res) => {
    try {
        const novost = await Novost.findByPk(req.params.id);
        if (!novost) return res.status(404).json({ message: 'Novost not found' });
        await novost.update(req.body);
        res.status(200).json(novost);
    } catch (error) {
        res.status(400).json({ message: 'Error updating novost', error });
    }
});

// Delete a novost by ID
router.delete('/:id', async (req, res) => {
    try {
        const novost = await Novost.findByPk(req.params.id);
        if (!novost) return res.status(404).json({ message: 'Novost not found' });
        await novost.destroy();
        res.status(200).json({ message: 'Novost deleted successfully' });
    } catch (error) {
        res.status(500).json({ message: 'Error deleting novost', error });
    }
});


module.exports = router;