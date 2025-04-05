const express = require('express');
const Novost = require('../modeli/Novost');

const router = express.Router();

// Get all novosti
router.get('/', async (req, res) => {
    try {
        const novosti = await Novost.findAll();
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});


// Get all novosti with tipNovosti "svijetfilma"
router.get('/svijetfilma', async (req, res) => {
    try {
        const novosti = await Novost.find({ tipNovosti: 'svijetfilma' });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});

// Get all novosti with tipNovosti "novost"
router.get('/novost', async (req, res) => {
    try {
        const novosti = await Novost.find({ tipNovosti: 'novost' });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});

// Get all novosti with tipNovosti "trailer"
router.get('/trailer', async (req, res) => {
    try {
        const novosti = await Novost.find({ tipNovosti: 'trailer' });
        res.status(200).json(novosti);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novosti', error });
    }
});

// Get a single novost by ID
router.get('/:id', async (req, res) => {
    try {
        const novost = await Novost.findById(req.params.id);
        if (!novost) {
            return res.status(404).json({ message: 'Novost not found' });
        }
        res.status(200).json(novost);
    } catch (error) {
        res.status(500).json({ message: 'Error fetching novost', error });
    }
});

// Create a new novost
router.post('/', async (req, res) => {
    try {
        const novost = new Novost(req.body);
        const savedNovost = await novost.save();
        res.status(201).json(savedNovost);
    } catch (error) {
        res.status(400).json({ message: 'Error creating novost', error });
    }
});

// Update an existing novost by ID
router.put('/:id', async (req, res) => {
    try {
        const updatedNovost = await Novost.findByIdAndUpdate(req.params.id, req.body, { new: true });
        if (!updatedNovost) {
            return res.status(404).json({ message: 'Novost not found' });
        }
        res.status(200).json(updatedNovost);
    } catch (error) {
        res.status(400).json({ message: 'Error updating novost', error });
    }
});

// Delete a novost by ID
router.delete('/:id', async (req, res) => {
    try {
        const deletedNovost = await Novost.findByIdAndDelete(req.params.id);
        if (!deletedNovost) {
            return res.status(404).json({ message: 'Novost not found' });
        }
        res.status(200).json({ message: 'Novost deleted successfully' });
    } catch (error) {
        res.status(500).json({ message: 'Error deleting novost', error });
    }
});

module.exports = router;