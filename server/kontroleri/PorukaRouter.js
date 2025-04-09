const express = require('express');
const Poruka = require('../modeli/Poruka');

const router = express.Router();

/**
 * @swagger
 * tags:
 *   name: Poruke
 *   description: API for managing messages
 */

/**
 * @swagger
 * /server/poruke:
 *   get:
 *     summary: Retrieve all messages
 *     tags: [Poruke]
 *     responses:
 *       200:
 *         description: Successfully retrieved the list of messages
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Poruka'
 *       500:
 *         description: Server error
 */
router.get('/', async (req, res) => {
    try {
        const poruke = await Poruka.findAll();
        res.json(poruke);
    } catch (err) {
        res.status(500).json({ error: 'Server error' });
    }
});

/**
 * @swagger
 * /server/poruke:
 *   post:
 *     summary: Create a new message
 *     tags: [Poruke]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Poruka'
 *     responses:
 *       201:
 *         description: Successfully created a new message
 *       400:
 *         description: Validation error
 *       500:
 *         description: Server error
 */
router.post('/', async (req, res) => {
    try {
        const { ime, email, poruka } = req.body;
        const novaPoruka = await Poruka.create({ ime, email, poruka });
        console.log('Nova poruka:', novaPoruka);
        res.status(201).json(novaPoruka);
    } catch (err) {
        res.status(500).json({ error: 'Server error' });
    }
});


/**
 * @swagger
 * /server/poruke/{id}:
 *   delete:
 *     summary: Delete a message by ID
 *     tags: [Poruke]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: The ID of the message to delete
 *     responses:
 *       200:
 *         description: Successfully deleted the message
 *       404:
 *         description: Message not found
 *       500:
 *         description: Server error
 */
router.delete('/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const deleted = await Poruka.destroy({ where: { id } });
        if (deleted) {
            res.status(200).json({ message: 'Message deleted successfully' });
        } else {
            res.status(404).json({ error: 'Message not found' });
        }
    } catch (err) {
        res.status(500).json({ error: 'Server error' });
    }
});

/**
 * @swagger
 * components:
 *   schemas:
 *     Poruka:
 *       type: object
 *       properties:
 *         id:
 *           type: integer
 *         ime:
 *           type: string
 *         email:
 *           type: string
 *           format: email
 *         poruka:
 *           type: string
 *         createdAt:
 *           type: string
 *           format: date-time
 */

module.exports = router;