const express = require('express');
const Admin = require('../modeli/Admin');

const router = express.Router();


/**
 * @swagger
 * tags:
 *   name: Admini
 *   description: API for managing admins
 */

/**
 * @swagger
 * /server/admini:
 *   get:
 *     summary: Retrieve all admins
 *     tags: [Admini]
 *     responses:
 *       200:
 *         description: List of admins
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Admin'
 *   post:
 *     summary: Create a new admin
 *     tags: [Admini]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Admin'
 *     responses:
 *       201:
 *         description: Admin created successfully
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Admin'
 */

/**
 * @swagger
 * /server/admini/{id}:
 *   get:
 *     summary: Retrieve an admin by ID
 *     tags: [Admini]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: Admin ID
 *     responses:
 *       200:
 *         description: Admin details
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Admin'
 *       404:
 *         description: Admin not found
 *   put:
 *     summary: Update an admin by ID
 *     tags: [Admini]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: Admin ID
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Admin'
 *     responses:
 *       200:
 *         description: Admin updated successfully
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Admin'
 *       404:
 *         description: Admin not found
 *   delete:
 *     summary: Delete an admin by ID
 *     tags: [Admini]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: Admin ID
 *     responses:
 *       200:
 *         description: Admin deleted successfully
 *       404:
 *         description: Admin not found
 */

/**
 * @swagger
 * components:
 *   schemas:
 *     Admin:
 *       type: object
 *       properties:
 *         id:
 *           type: integer
 *           example: 1
 *         username:
 *           type: string
 *           example: "admin"
 *         password:
 *           type: string
 *           example: "password123"
 *         createdAt:
 *           type: string
 *           format: date-time
 *           example: "2023-01-01T12:00:00Z"
 */

router.get('/', async (req, res) => {
    try {
        const admins = await Admin.findAll();
        res.json(admins);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

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

router.post('/', async (req, res) => {
    try {
        const { username, password } = req.body;

        const newAdmin = await Admin.create({
            username,
            password, 
        });

        res.status(201).json(newAdmin);
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
});

router.put('/:id', async (req, res) => {
    try {
        const admin = await Admin.findByPk(req.params.id);
        if (!admin) {
            return res.status(404).json({ error: 'Admin not found' });
        }

        const { username, password } = req.body;

        const updatedData = {
            username,
            password: password || admin.password, 
        };

        await admin.update(updatedData);
        res.json(admin);
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
});

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
