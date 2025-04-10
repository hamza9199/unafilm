const multer = require("multer");
const path = require("path");

// Set Storage Engine for Multer
const storage = multer.diskStorage({
    destination: "./uploads/", // Folder where images are stored
    filename: (req, file, cb) => {
        cb(null, Date.now() + path.extname(file.originalname)); // Unique filename
    }
});

module.exports = storage; // Export the storage configuration