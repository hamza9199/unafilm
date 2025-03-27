const express = require('express');
const cors = require('cors');
const app = express();

// Port na kojem server radi
const PORT = 3000;

app.use(cors());
app.use(express.json());

// Ruta za provjeru
app.get('/', (req, res) => {
    res.send('Server radi!');
});

// Pokretanje servera
app.listen(PORT, () => {
    console.log(`Server pokrenut na http://localhost:${PORT}`);
});
