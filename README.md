# UnaFilm

## O projektu

UnaFilm je web aplikacija za distribuciju filmova i novosti iz svijeta filma. Aplikacija omogućava korisnicima pregled filmova, novosti, trejlera, kao i administraciju sadržaja putem administratorskog panela.

## Tehnologije

- **Backend**: Node.js, Express.js, Sequelize (ORM), MySQL
- **Frontend**: React.js, CSS moduli
- **Baza podataka**: MySQL
- **Ostalo**: Firebase Storage za upload slika, Swagger za API dokumentaciju

---

## Struktura projekta

### Backend

- **`server/modeli/Film.js`**  
  Model za filmove. Sadrži atribute kao što su naslov, opis, URL trejlera, slike, datum izlaska, trajanje, reditelj, komentari, tip (film/serija) i status (uskoro/trenutno/arhiva).

- **`server/kontroleri/FilmRouter.js`**  
  API rute za upravljanje filmovima. Omogućava CRUD operacije, pretragu filmova i filtriranje po statusu (`uskoro`, `trenutno`, `arhiva`).

### Frontend

- **`klijent/src/stranice/IzSvijetaFilma.jsx`**  
  Stranica za prikaz novosti iz svijeta filma. Koristi paginaciju i omogućava prikaz članaka povezanih s filmovima.

- **`klijent/src/stranice/FilmTrejler.jsx`**  
  Stranica za prikaz trejlera određenog filma. Prikazuje osnovne informacije o filmu i ugrađeni video trejler.

- **`klijent/src/stranice/FilmOpis.jsx`**  
  Stranica za detaljan opis filma. Prikazuje slike, opis, trajanje, datum izlaska i trejler.

- **`klijent/src/stranice/FilmInfo.jsx`**  
  Stranica za prikaz informacija o filmu i povezanim novostima. Prikazuje slike, tekstove i trejler.

- **`klijent/src/stranice/Admin.jsx`**  
  Administratorski panel za upravljanje filmovima, novostima i porukama. Omogućava kreiranje, ažuriranje, brisanje i pretragu sadržaja.

- **`klijent/src/komponente/Trenutno.jsx`**  
  Komponenta za prikaz filmova koji su trenutno u kinima. Koristi slider za prikaz filmova i omogućava pregled detalja.

---

## Funkcionalnosti

### Korisnički dio
- Pregled filmova po kategorijama (`uskoro`, `trenutno`, `arhiva`).
- Pretraga filmova po naslovu ili opisu.
- Pregled novosti iz svijeta filma.
- Pregled trejlera i detalja o filmovima.

### Administratorski dio
- Upravljanje filmovima (kreiranje, ažuriranje, brisanje).
- Upravljanje novostima (kreiranje, ažuriranje, brisanje).
- Upravljanje porukama korisnika.
- Pretraga filmova i novosti.

---

## Instalacija

1. Klonirajte repozitorij:
   ```bash
   git clone https://github.com/Hamza9199/UnaFilm
   cd UnaFilm
   ```

2. Instalirajte zavisnosti za backend:
   ```bash
   cd server
   npm install
   ```

3. Instalirajte zavisnosti za frontend:
   ```bash
   cd ../klijent
   npm install
   ```

4. Pokrenite backend server:
   ```bash
   cd ../server
   npm start
   ```

5. Pokrenite frontend aplikaciju:
   ```bash
   cd ../klijent
   npm start
   ```

---

## API Dokumentacija

API dokumentacija je dostupna putem Swagger-a na ruti `/api-docs` nakon pokretanja backend servera.

---

## Struktura baze podataka

### Tabela `filmovi`
| Kolona         | Tip              | Opis                          |
|----------------|------------------|-------------------------------|
| `id`           | INTEGER          | Primarni ključ                |
| `title`        | STRING           | Naslov filma                  |
| `description`  | TEXT             | Opis filma                    |
| `trailerUrl`   | STRING           | URL trejlera                  |
| `imageUrl`     | STRING           | URL glavne slike              |
| `imageUrl2`    | STRING           | URL dodatne slike             |
| `releaseDate`  | DATE             | Datum izlaska                 |
| `duration`     | INTEGER          | Trajanje u minutama           |
| `reditelj`     | STRING           | Ime reditelja                 |
| `comment`      | INTEGER          | Broj komentara                |
| `type`         | ENUM             | Tip (`film` ili `serija`)     |
| `tipMjesta`    | ENUM             | Status (`uskoro`, `trenutno`, `arhiva`) |

---

## Autori

Ovaj projekat je razvijen kao dio distribucije filmova i novosti. Za dodatne informacije, kontaktirajte nas putem [hamza.gacic.22@size.ba](hamza.gacic.22@size.ba).