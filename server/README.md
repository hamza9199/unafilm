# Una Film Distribucija - Dokumentacija Serverske Strane

Ovaj projekat predstavlja serversku implementaciju platforme Una Film Distribucija, izgrađenu koristeći Node.js i Express. Server pruža RESTful API za upravljanje filmovima, vijestima, porukama i administracijom.

---

## Sadržaj

1. [Pregled Projekta](#pregled-projekta)
2. [Korištene Tehnologije](#korištene-tehnologije)
3. [Struktura Foldera](#struktura-foldera)
4. [Instalacija](#instalacija)
5. [Dostupni Skripti](#dostupni-skripti)
6. [Funkcionalnosti](#funkcionalnosti)
7. [Modeli](#modeli)
8. [API Krajnje Tačke](#api-krajnje-tačke)
9. [Swagger Dokumentacija](#swagger-dokumentacija)
10. [Varijable Okruženja](#varijable-okruženja)
11. [Deployovanje](#deployovanje)
12. [Doprinos Razvoju](#doprinos-razvoju)
13. [Licenca](#licenca)

---

## Pregled Projekta

Serverska aplikacija Una Film Distribucija omogućava:
- Upravljanje filmovima, vijestima i porukama.
- Administraciju putem sigurnih API krajnjih tačaka.
- Upload i download baze podataka i foldera sa slikama.
- Pretragu filmova i vijesti.

---

## Korištene Tehnologije

- **Node.js**: JavaScript runtime za backend razvoj.
- **Express**: Web framework za izgradnju RESTful API-ja.
- **Sequelize**: ORM za rad sa SQLite bazom podataka.
- **Multer**: Middleware za upload fajlova.
- **Swagger**: Za automatsku dokumentaciju API-ja.
- **SQLite**: Relaciona baza podataka za skladištenje podataka.

---

## Struktura Foldera

```
server/
├── kontroleri/            # API rute i logika
├── modeli/                # Sequelize modeli
├── uploads/               # Uploadovane slike
├── database.sqlite        # SQLite baza podataka
├── sequelizeInstance.js   # Konfiguracija Sequelize instance
├── server.js              # Glavna ulazna tačka servera
└── README.md              # Dokumentacija
```

---

## Instalacija

1. Klonirajte repozitorij:
    ```bash
    git clone https://github.com/Hamza9199/UnaFilm
    cd una-film-distribucija/server
    ```

2. Instalirajte zavisnosti:
    ```bash
    npm install
    ```

3. Pokrenite server:
    ```bash
    npm start
    ```

4. Server će biti dostupan na `http://localhost:3000`.

---

## Dostupni Skripti

- `npm start`: Pokreće server u produkcijskom modu.
- `npm run dev`: Pokreće server u razvojnom modu sa automatskim restartom (koristi `nodemon`).

---

## Funkcionalnosti

- **Upravljanje Filmovima**: Kreiranje, ažuriranje, brisanje i pretraga filmova.
- **Upravljanje Vijestima**: Kreiranje, ažuriranje, brisanje i pretraga vijesti.
- **Upravljanje Porukama**: Slanje i brisanje poruka.
- **Administracija**: Upravljanje administratorima i prijava.
- **Upload i Download**: Upload i download baze podataka i foldera sa slikama.
- **Swagger Dokumentacija**: Automatska dokumentacija API-ja.

---

## Modeli

### Film
Model za upravljanje filmovima.

**Polja:**
- `id`: Primarni ključ.
- `title`: Naslov filma.
- `description`: Opis filma.
- `trailerUrl`: URL trejlera.
- `imageUrl`: URL prve slike.
- `imageUrl2`: URL druge slike.
- `releaseDate`: Datum izlaska.
- `duration`: Trajanje filma u minutama.
- `reditelj`: Ime reditelja.
- `comment`: Broj komentara.
- `type`: Tip (film ili serija).
- `tipMjesta`: Lokacija (uskoro, trenutno, arhiva).
- `opis`: Detaljan opis filma.

### Novost
Model za upravljanje vijestima.

**Polja:**
- `id`: Primarni ključ.
- `filmId`: ID povezanog filma.
- `title`: Naslov vijesti.
- `kreator`: Autor vijesti.
- `tekst`: Glavni tekst vijesti.
- `image`: URL slike vijesti.
- `tipNovosti`: Tip vijesti (novost, svijetfilma, trailer).
- `datumKreiranja`: Datum kreiranja vijesti.

### Poruka
Model za upravljanje porukama.

**Polja:**
- `id`: Primarni ključ.
- `ime`: Ime pošiljaoca.
- `email`: Email pošiljaoca.
- `poruka`: Tekst poruke.
- `createdAt`: Datum slanja poruke.

### Admin
Model za upravljanje administratorima.

**Polja:**
- `id`: Primarni ključ.
- `username`: Korisničko ime.
- `password`: Lozinka (nešifrovana, samo za razvojne svrhe).

---

## API Krajnje Tačke

### Filmovi
- `GET /server/filmovi`: Dohvati sve filmove.
- `POST /server/filmovi`: Kreiraj novi film.
- `GET /server/filmovi/uskoro`: Dohvati filmove koji uskoro dolaze.
- `GET /server/filmovi/trenutno`: Dohvati filmove trenutno u kinima.
- `GET /server/filmovi/arhiva`: Dohvati arhivirane filmove.
- `GET /server/filmovi/:id`: Dohvati film po ID-u.
- `PUT /server/filmovi/:id`: Ažuriraj film po ID-u.
- `DELETE /server/filmovi/:id`: Obriši film po ID-u.
- `GET /server/filmovi/search/:query`: Pretraži filmove po naslovu ili opisu.

### Vijesti
- `GET /server/novosti`: Dohvati sve vijesti.
- `POST /server/novosti`: Kreiraj novu vijest.
- `GET /server/novosti/svijetfilma`: Dohvati vijesti tipa "svijetfilma".
- `GET /server/novosti/novost`: Dohvati vijesti tipa "novost".
- `GET /server/novosti/trailer`: Dohvati vijesti tipa "trailer".
- `GET /server/novosti/:id`: Dohvati vijest po ID-u.
- `PUT /server/novosti/:id`: Ažuriraj vijest po ID-u.
- `DELETE /server/novosti/:id`: Obriši vijest po ID-u.
- `GET /server/novosti/search/:query`: Pretraži vijesti po naslovu.

### Poruke
- `GET /server/poruke`: Dohvati sve poruke.
- `POST /server/poruke`: Pošalji novu poruku.
- `DELETE /server/poruke/:id`: Obriši poruku po ID-u.

### Administracija
- `POST /server/admin/login`: Prijava administratora.

### Upload i Download
- `POST /server/upload/database`: Upload baze podataka.
- `POST /server/upload/uploads`: Upload foldera sa slikama.
- `GET /server/download/database`: Download baze podataka.
- `GET /server/download/uploads`: Download foldera sa slikama.

---

## Swagger Dokumentacija

Swagger dokumentacija je dostupna na `/api-docs`.

---

## Varijable Okruženja

Kreirajte `.env` datoteku u root direktoriju za konfiguraciju varijabli okruženja:

```
PORT=3000
DATABASE_URL=sqlite:./database.sqlite
```

---

## Deployovanje

1. Instalirajte zavisnosti:
    ```bash
    npm install
    ```

2. Pokrenite server:
    ```bash
    npm start
    ```

3. Deployujte server na hosting provajdera po izboru (npr. Heroku, Vercel).

---

## Doprinos Razvoju

1. Forkujte repozitorij.
2. Kreirajte novu granu:
    ```bash
    git checkout -b feature-name
    ```
3. Komitujte svoje promjene:
    ```bash
    git commit -m "Dodaj funkcionalnost"
    ```
4. Pushajte na granu:
    ```bash
    git push origin feature-name
    ```
5. Otvorite pull request.

---

## Licenca

Ovaj projekat je licenciran pod MIT licencom. Pogledajte LICENSE datoteku za detalje.
