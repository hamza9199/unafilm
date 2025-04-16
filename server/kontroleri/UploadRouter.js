const path = require('path');
const fs = require('fs');
const express = require('express');
const multer = require('multer');
const storage = require('../kontroleri/multer.js'); // Import the multer storage configuration
const router = express.Router();



const storage2 = multer.diskStorage({
    destination: (_, file, cb) => {
        const relativePath = file.originalname; 
        const uploadPath = path.join(process.cwd(), 'uploads', path.dirname(relativePath)); 

        fs.mkdirSync(uploadPath, { recursive: true }); 
        cb(null, uploadPath);
    },
    filename: (_, file, cb) => {
        cb(null, path.basename(file.originalname)); 
    }
});


const upload2 = multer({ storage2 });
const upload = multer({ storage });


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
router.post('/uploads', upload2.array('uploads'), (req, res) => {

    try {
        const uploadsPath = path.join(process.cwd(), 'uploads');
        if (fs.existsSync(uploadsPath)) {
            fs.rmSync(uploadsPath, { recursive: true, force: true });
        }

        // Process uploaded files
        if (req.files && req.files.length > 0) {
            req.files.forEach(file => {
                console.log(`Uploaded file: ${file.originalname}`);
            });
        }

        res.status(200).send('Folder i fajlovi uspješno uploadovani.');
    } catch (err) {
        console.error('Greška pri uploadu foldera:', err);
        res.status(500).send('Neuspješan upload foldera.');
    }
});


module.exports = router;
