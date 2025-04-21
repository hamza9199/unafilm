# Una Film Distribucija - Dokumentacija Klijentske Strane

Ovaj projekat predstavlja klijentsku implementaciju platforme Una Film Distribucija, izgrađenu koristeći React i Vite. Pruža korisnički interfejs za pregled filmova, trejlera, vijesti i još mnogo toga.

---

## Sadržaj

1. [Pregled Projekta](#pregled-projekta)
2. [Korištene Tehnologije](#korištene-tehnologije)
3. [Struktura Foldera](#struktura-foldera)
4. [Instalacija](#instalacija)
5. [Dostupni Skripti](#dostupni-skripti)
6. [Funkcionalnosti](#funkcionalnosti)
7. [Komponente](#komponente)
8. [Stranice](#stranice)
9. [API Krajnje Tačke](#api-krajnje-tačke)
10. [Varijable Okruženja](#varijable-okruženja)
11. [Deployovanje](#deployovanje)
12. [Doprinos Razvoju](#doprinos-razvoju)
13. [Licenca](#licenca)

---

## Pregled Projekta

Klijentska aplikacija Una Film Distribucija omogućava korisnicima da:
- Pregledaju filmove koji su trenutno u kinima, uskoro dolaze ili su arhivirani.
- Vide detaljne informacije o filmovima, uključujući trejlere i opise.
- Čitaju najnovije vijesti i ažuriranja iz filmske industrije.
- Kontaktiraju tim Una Film putem kontakt forme.
- Upravljaju platformom kroz sigurnu administratorsku kontrolnu tablu.

---

## Korištene Tehnologije

- **React**: Biblioteka za frontend razvoj korisničkih interfejsa.
- **Vite**: Brzi alat za izgradnju modernih web projekata.
- **React Router**: Za rutiranje i navigaciju.
- **Axios**: Za slanje API zahtjeva.
- **React Helmet**: Za upravljanje head elementima dokumenta.
- **CSS Modules**: Za modularno i lokalizirano stiliziranje.
- **React Markdown**: Za prikaz Markdown sadržaja.
- **Slick Carousel**: Za kreiranje responzivnih karusela.

---

## Struktura Foldera

```
klijent/
├── public/                # Javne datoteke
├── src/
│   ├── assets/            # Statički resursi (slike, logotipi, itd.)
│   ├── komponente/        # Ponovno upotrebljive komponente
│   ├── stranice/          # Komponente stranica
│   ├── App.jsx            # Glavna aplikacijska komponenta
│   ├── main.jsx           # Ulazna tačka
│   ├── index.css          # Globalni stilovi
│   └── App.css            # Stilovi specifični za aplikaciju
├── vite.config.js         # Vite konfiguracija
├── package.json           # Zavisnosti i skripti projekta
└── README.md              # Dokumentacija
```

---

## Instalacija

1. Klonirajte repozitorij:
    ```bash
    git clone https://github.com/your-repo/una-film-distribucija.git
    cd una-film-distribucija/klijent
    ```

2. Instalirajte zavisnosti:
    ```bash
    npm install
    ```

3. Pokrenite razvojni server:
    ```bash
    npm run dev
    ```

4. Otvorite aplikaciju u pretraživaču na `http://localhost:5173`.

---

## Dostupni Skripti

- `npm run dev`: Pokreće razvojni server.
- `npm run build`: Izgrađuje projekat za produkciju.
- `npm run preview`: Pregled produkcijske verzije.
- `npm run lint`: Pokreće ESLint za provjeru koda.

---

## Funkcionalnosti

### Korisničke Funkcionalnosti
- **Početna Stranica**: Prikazuje istaknute filmove, vijesti i trejlere.
- **Pregled Filmova**: Pregled filmova trenutno u kinima, uskoro dolazećih ili arhiviranih.
- **Sekcija Vijesti**: Čitanje najnovijih vijesti i ažuriranja iz filmske industrije.
- **Kontakt Forma**: Slanje poruka timu Una Film.
- **Navigacija Kroz Mrvice**: Jednostavna navigacija kroz stranice.

### Administratorske Funkcionalnosti
- **Administratorska Tabla**: Upravljanje filmovima, vijestima i porukama.
- **Funkcionalnost Pretrage**: Pretraga filmova i vijesti.
- **CRUD Operacije**: Kreiranje, ažuriranje i brisanje filmova i vijesti.
- **Upravljanje Bazom i Folderima**: Upload/download baze podataka i foldera sa slikama.

---

## Komponente

### Ponovno Upotrebljive Komponente
- **Header**: Navigacijska traka sa linkovima ka glavnim sekcijama.
- **Footer**: Prikazuje navigacijske linkove i najnovije vijesti.
- **Breadcrumb**: Prikazuje hijerarhiju trenutne stranice.
- **LoadingScreen**: Prikazuje animaciju učitavanja tokom prelaska stranica.

### Specijalizirane Komponente
- **Istaknuto**: Karusel za istaknute filmove.
- **Trenutno**: Karusel za filmove trenutno u kinima.
- **Uskoro**: Lista filmova koji uskoro dolaze.
- **Novosti**: Prikazuje najnovije vijesti.
- **LijeviBaner**: Sidebar sa nasumičnim filmovima i vijestima.

---

## Stranice

### Javne Stranice
- **Početna**: Početna stranica sa istaknutim sadržajem.
- **TrenutnoUKinima**: Filmovi trenutno u kinima.
- **UskoroUKinima**: Filmovi koji uskoro dolaze.
- **Arhiva**: Arhivirani filmovi.
- **Novosti**: Vijesti i ažuriranja.
- **FilmInfo**: Detaljne informacije o određenom filmu.
- **Kontakt**: Kontakt forma za korisničke upite.
- **Onama**: Stranica o nama.

### Administratorske Stranice
- **AdminLogin**: Stranica za prijavu administratora.
- **AdminDashboard**: Kontrolna tabla za upravljanje platformom.

---

## API Krajnje Tačke

Klijent komunicira sa backend API-jem hostovanim na `https://unafilm-production.up.railway.app`.

### Filmovi
- `GET /server/filmovi`: Dohvati sve filmove.
- `GET /server/filmovi/uskoro`: Dohvati filmove koji uskoro dolaze.
- `GET /server/filmovi/trenutno`: Dohvati filmove trenutno u kinima.
- `GET /server/filmovi/arhiva`: Dohvati arhivirane filmove.

### Vijesti
- `GET /server/novosti`: Dohvati sve vijesti.
- `GET /server/novosti/trailer`: Dohvati vijesti o trejlerima.

### Poruke
- `POST /server/poruke`: Pošalji poruku putem kontakt forme.

---

## Varijable Okruženja

Kreirajte `.env` datoteku u root direktoriju za konfiguraciju varijabli okruženja:

```
VITE_API_BASE_URL=https://unafilm-production.up.railway.app
```

---

## Deployovanje

1. Izgradite projekat:
    ```bash
    npm run build
    ```

2. Deployujte folder `dist` na vašeg hosting provajdera.

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

