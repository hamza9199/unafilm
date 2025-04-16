const path = require('path');
const fs = require('fs');
const express = require('express');
const multer = require('multer');
const storage = require('../kontroleri/multer.js'); // Import the multer storage configuration
const upload = multer({ storage });
const router = express.Router();


// Upload nove baze
router.post('/database', upload.single('database'), (req, res) => {
    const uploadedFilePath = req.file.path;
    const targetPath = path.join(__dirname, '../database.sqlite');

    fs.copyFile(uploadedFilePath, targetPath, (err) => {
        fs.unlinkSync(uploadedFilePath); // obriši temp fajl

        if (err) {
            console.error('Greška pri zamjeni baze:', err);
            return res.status(500).send('Neuspješan upload baze.');
        }

        res.status(200).send('Baza uspješno zamijenjena.');
    });
});

// Upload  za uploads folder
router.post('/uploads', upload.array('uploadsFolder'), (req, res) => {
    const uploadsPath = path.join(__dirname, '../uploads');

    try {
        // Obriši stari uploads folder
        if (fs.existsSync(uploadsPath)) {
            fs.rmSync(uploadsPath, { recursive: true, force: true });
        }

        // Rekreiraj uploads folder
        fs.mkdirSync(uploadsPath, { recursive: true });

        // Prebaci sve fajlove iz privremene putanje u strukturu folderski
        req.files.forEach(file => {
            // file.originalname čuva path strukturu (npr. "subfolder/file.jpg")
            const destPath = path.join(uploadsPath, file.originalname);
            const destDir = path.dirname(destPath);

            // Kreiraj sve potrebne foldere
            fs.mkdirSync(destDir, { recursive: true });

            // Pomjeri fajl
            fs.renameSync(file.path, destPath);
        });

        res.status(200).send('Uploads folder uspješno zamijenjen.');
    } catch (err) {
        console.error('Greška pri uploadu foldera:', err);
        res.status(500).send('Neuspješan upload foldera.');
    }
});


module.exports = router;
