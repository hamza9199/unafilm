const path = require('path');
const fs = require('fs');
const archiver = require('archiver');
const express = require('express');
const router = express.Router();

// Ruta za preuzimanje SQLite baze
router.get('/database', (req, res) => {
    const dbPath = path.join(__dirname, '../database.sqlite'); // Relativna putanja prema server.js lokaciji
    if (fs.existsSync(dbPath)) {
        res.download(dbPath, 'database.sqlite', (err) => {
            if (err) {
                console.error('Greška pri preuzimanju baze:', err);
                res.sendStatus(500);
            }
        });
    } else {
        res.status(404).send('Baza nije pronađena.');
    }
});

// Ruta za preuzimanje cijelog uploads foldera kao ZIP
router.get('/uploads', (req, res) => {
    const uploadsPath = path.join(__dirname, '../uploads');

    if (!fs.existsSync(uploadsPath)) {
        return res.status(404).send('Uploads folder ne postoji.');
    }

    res.setHeader('Content-Disposition', 'attachment; filename=uploads.zip');
    res.setHeader('Content-Type', 'application/zip');

    const archive = archiver('zip', {
        zlib: { level: 9 }
    });

    archive.on('error', (err) => {
        console.error('Greška pri arhiviranju:', err);
        res.sendStatus(500);
    });

    archive.pipe(res);
    archive.directory(uploadsPath, false);
    archive.finalize();
});


module.exports = router;
