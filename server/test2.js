const sequelize = require('./sequelizeInstance'); // Already configured for SQLite
const Novost = require('./modeli/Novost');

// Funkcija za unos podataka
async function insertNovost() {
    try {
        // Sinhroniziraj bazu
        await sequelize.sync();


        const novosti = [
            {
              filmId: 1,
              title: '“Čovjek vuk”: Pravi ugriz vukodlaka',
              kreator: 'www.kinofilm.hr',
              tekst: `## **Redatelj Leigh Whannell donosi nam novi hororac *Čovjek vuk*. Njegova glavna karakteristika je da “ne boji ekran u crveno” već je naglasak na građenju napete i jezive atmosfere a izražajna zvučna kulisa je u prvom planu. Scenaristički donosi nekoliko uspjelih novih i osvježavajućih ideja. Odličan nastup pružio je Christopher Abbott a tu je i Julia Garner.**
          
          Redatelj Leigh Whannell, nakon vrlo uspješnog filma Nevidljivi čovjek (The Invisible Man, 2020.), vraća se u Universalov svijet klasičnih čudovišta (Universal Classic Monsters). Svojim najnovijim filmom Čovjek vuk (Wolf Man, 2025.) a pred nas stavlja novi i moderni pogled na istoimeni klasični horor iz 1941. godine (kod nas preveden kao Vukodlak) redatelja Georgea Waggnera.
          
          **Dvije zasebne priče**
          
          Film počinje 1990-ih u Oregonu, gdje upoznajemo oca Gradyja i sina Blakea, koji žive u relativnoj izolaciji u divljini. Otac strogo upravlja njegovim životom, gotovo je opsjednut da ga zaštiti od opasnosti vanjskog svijeta. Jer, starosjedioci ovih šuma pričaju priče o ljudima-zvijerima koje teroriziraju kraj. Tijekom lova Blake se na trenutak udalji od oca i ugleda čudnu siluetu. Uskoro se on i njegov nađu progonjeni od nepoznate zvijeri ali se uspiju skloniti.`,
              tekst2: `Priča dalje prati odraslog Blakea (Christopher Abbott), obiteljskog čovjeka čiji je brak s novinarkom Charlotte (Julia Garner) pred raspadom. Njegova poslovna karijera stagnira pa se brine za njihovu mladu kćer Ginger (Matilda Firth). Nakon što primi obavijest da mu je otac umro, Blake i obitelj odlaze u dom njegovog djetinjstva, udaljenu farmu u šumama Oregona. Dok se voze prema njegovoj obiteljskoj kući napada ih tajanstveno stvorenje. Ipak, uspiju stići do kuće ali Blake se uskoro počinje transformirati iako se tome uzaludno opire.
          
          Autori scenarija su Whannell i glumica Corbett Tuck (Klub veterana/Last Man Club, 2016.), kojoj je ovo prvi scenaristički uradak. Može se reći da kroz njega pratimo dva filma. U prvom planu je, dakako, hororac s vukodlakom a u drugom je drama koja je vezana za glavnog protagonistu, koja je odlična ideja i daje jedan snažan i osvježavajući dodatak na već poznatu klasičnu priču o čovjeku vuku/vukodlaku.`,
              tekst3: `Julia Garner, Christopher Abbott i Matilda Firth u filmu “Čovjek vuk” (Foto: Universal Pictures)
          
          Whannellov Čovjek vuk napravljen je po uzoru na horor filmove iz 1980-ih. Atmosfera je kao preslikana iz takvih ostvarenja pa se osjeti dašak Joea Dantea (Zavijanje/The Howling, 1981.) i Johna Landisa (Američki vukodlak u Londonu/An American Werewolf in London, 1981.). No, ono najznačajnije se odražava u prikazu Blakeove transformacije u čovjeka vuka. To je izvedeno u stilu nezaboravnih horor klasika Stvor (The Thing, 1982.) redatelja **Johna Carpentera** i Muha (The Fly, 1986.) redatelja **Davida Cronenberga**. To daje dodatnu draž cjelokupnom filmu (a ako ste pravi filmofil i ljubitelj navedenih naslova bit ćete oduševljeni, a žica nostalgije će u vama zaigrati). Tu za CGI mjesta nema!`,
              tekst4: `Što se tiče glumačkih izvedbi, Christopher Abbott (Uboga stvorenja/Poor Things, 2024., nominiran za Zlatni globus za nastup u TV seriji Kvaka 22/Catch-22, 2019.), koji je odličan u svom nastupu te je uspio pokazati svu kompleksnost svoga lika (i njegove transformacije) te uvjerljivu emotivnost. Uz njega je tu Julia Garner (Projekt Anna/Inventing Anna, 2022., Asistentica/The Assistant, 2019., dobitnica Zlatnog globusa za nastup u TV seriji Ozark, 2017.-2022.), koja je vrlo solidna. Mali prigovor se može uputiti na Whannell i Tuck jer je dojam da su scenaristički mogli dati još malo prostora njenom liku (to se odnosi i na karakternu obradu).
          
          Gledajući u cjelini, Leigh Whannell snimio je sasvim solidan horor film koji u sebi nosi dovoljno jeze da vas prodrma. Njegova specifičnost leži u građenju atmosfere i vrlo dobrim vođenjem priče (dvije priče) ujednačenim ritmom. Klasična priča dobila je nove ideje koje u potpunosti funkcioniraju i mijenjaju njezinu bit. Zbog toga možemo reći da film Čovjek vuk nije samo film o vukodlaku (ili ako vam je draže – čudovištima) već nudi i nešto više od toga.`,
              slika1: 'https://unafilm-production.up.railway.app/uploads/1744737452158.jpg',
              slika2: 'https://unafilm-production.up.railway.app/uploads/1744737452158.jpg',
              slika3: 'https://unafilm-production.up.railway.app/uploads/1744737452158.jpg',
              tipNovosti: 'novost',
              datumKreiranja: '2025-04-07 23:36:58',
            },
          ];
          

        for (let i = 2; i <= 20; i++) {
            novosti.push({
                filmId: i,  // Povezivanje sa odgovarajućim filmom
                title: `Novost ${i}`,
                kreator: `Kreator ${i}`,
                tekst: `Tekst ${i}`,
                tekst2: `Tekst ${i}`,
                tekst3: `Tekst ${i}`,
                tekst4: `Tekst ${i}`,
                slika1: 'https://unafilm.ba/wp-content/uploads/2025/03/Drop-FB-cover-BiH.jpg',
                slika2: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                slika3: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-174x300_c.jpg',
                tipNovosti: i % 3 === 0 ? 'novost' : i % 3 === 1 ? 'trailer' : 'svijetfilma',
                datumKreiranja: '2025-04-07 23:36:58',
            });
        }

        // Unesi novosti u bazu
        await Novost.bulkCreate(novosti);


        console.log('Tabele popunjene.');
    } catch (error) {
        console.error('Došlo je do greške prilikom unosa:', error);
    } finally {
        // Zatvori vezu prema bazi
        await sequelize.close();
    }
}

// Pozovi funkciju za unos filmova
insertNovost();
