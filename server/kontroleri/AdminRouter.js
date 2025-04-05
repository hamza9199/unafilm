const express = require('express');
const Admin = require('../modeli/Admin');

const router = express.Router();

// Get all admins
router.get('/', async (req, res) => {
    try {
        const admins = await Admin.findAll();
        res.json(admins);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Get admin by ID
router.get('/:id', async (req, res) => {
    try {
        const admin = await Admin.findByPk(req.params.id);
        if (!admin) {
            return res.status(404).json({ error: 'Admin not found' });
        }
        res.json(admin);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Create a new admin
router.post('/', async (req, res) => {
    try {
        const { username, password } = req.body;

        const newAdmin = await Admin.create({
            username,
            password, // Password is stored as plain text (not recommended for production)
        });

        res.status(201).json(newAdmin);
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
});

// Update an admin by ID
router.put('/:id', async (req, res) => {
    try {
        const admin = await Admin.findByPk(req.params.id);
        if (!admin) {
            return res.status(404).json({ error: 'Admin not found' });
        }

        const { username, password } = req.body;

        const updatedData = {
            username,
            password: password || admin.password, // Update password only if provided
        };

        await admin.update(updatedData);
        res.json(admin);
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
});

// Delete an admin by ID
router.delete('/:id', async (req, res) => {
    try {
        const admin = await Admin.findByPk(req.params.id);
        if (!admin) {
            return res.status(404).json({ error: 'Admin not found' });
        }
        await admin.destroy();
        res.json({ message: 'Admin deleted successfully' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Admin login
router.post('/login', async (req, res) => {
    try {
        const { username, password } = req.body;

        // Find admin by username
        const admin = await Admin.findOne({ where: { username } });
        if (!admin || admin.password !== password) {
            return res.status(404).json({ error: 'Invalid username or password' });
        }

        // Return success message
        res.json({ message: 'Login successful' });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

module.exports = router;
