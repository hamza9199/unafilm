import React, { useState, useEffect } from 'react';  
import { useParams } from 'react-router-dom'; // Uvozimo useParams za dobijanje id-a iz URL-a
import styles from './css/FilmInfo.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import RelatedArticle from '../komponente/RelatedArticle';

const FilmInfo = () => {
    const { id } = useParams(); // Preuzimanje id-a iz URL-a
    const [novost, setNovost] = useState(null);

    useEffect(() => {
        // API poziv za pretragu novosti prema id-u   
        const fetchNovostData = async () => {
            try {
                const response = await fetch(`http://localhost:3000/server/novosti/${id}`); // Endpoint za pretragu po id
                if (!response.ok) {
                    throw new Error('Novost not found');
                }
                const data = await response.json();
                setNovost(data); // Postavljanje novosti u stanje
            } catch (error) {
                console.error(error);
                setNovost(null); // Ako dođe do greške, postavljamo novost na null
            }
        };

        fetchNovostData(); // Pozivanje funkcije za pretragu novosti
    }, [id]); // Poziva se svaki put kada se id promeni

    if (!novost) {
        return <div>Loading...</div>; // Prikazujemo loading dok ne učitamo podatke
    }

    const { film } = novost; // Preuzimanje filma iz odgovora

    return (
        <>
            <Header />
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: film.title, link: `novosti/iz-svijeta-filma/film/${id}` }, // Dinamički link sa id
                ]}
            />

            <div className={styles.container}>
                <LijeviBaner />
                <div className={styles.pageContent}>
                    <article id="post-1045" className={styles.article}>
                        <div className={styles.entryTop}>
                            <div className={styles.entryThumb}>
                                <img 
                                    width="990" 
                                    height="440" 
                                    src={film.imageUrl} 
                                    className={styles.img}
                                    alt={film.title}
                                    decoding="async" 
                                />
                            </div>
                        </div>
                        <div className={styles.entryBottom}>
                            <div className={styles.entryMeta}>
                                <div className={styles.entryDate}>
                                <span className={styles.day}>{new Date(novost.datumKreiranja).toLocaleDateString()}</span>

                                </div>
                                <div className={styles.entryComment}>
                                    <i className="fa fa-comments" aria-hidden="true"></i> {novost.film.comment} komentara
                                </div>
                            </div>
                            <div className={styles.entryLeft}>
                                <h1 className={styles.entryTitle}>
                                    <a 
                                        href={`/arhiva/film/${novost.film.id}`}
                                        className={styles.entryLink}
                                        itemProp="url"
                                    >
                                        {novost.title}
                                    </a>
                                    <p><em>Preuzeto sa: {novost.kreator}</em></p>
                                </h1>
                                <div className={styles.entryContent}>
                                    {novost.slika1 && <img className={styles.smallImg} src={novost.slika1} alt=""  />}
                                    {novost.tekst && <p>{novost.tekst}</p>}

                                    {novost.slika2 && <img className={styles.smallImg}  src={novost.slika2} alt=""  />}
                                    {novost.tekst2 && <p>{novost.tekst2}</p>}

                                    {novost.slika3 && <img className={styles.smallImg}  src={novost.slika3} alt="" />}
                                    {novost.tekst3 && <p>{novost.tekst3}</p>}


                                    {novost.film.trailerUrl && (
                                        <div className={styles.videoWrapper}>
                                            <iframe 
                                                width="560" 
                                                height="315" 
                                                src={novost.film.trailerUrl} 
                                                title="Trailer"
                                                frameBorder="0" 
                                                allowFullScreen
                                            ></iframe>
                                        </div>
                                    )}
                                    {novost.tekst4 && <p>{novost.tekst4}</p>}

                                </div>
                            </div>
                        </div>
                        <RelatedArticle />
                    </article>
                </div>
            </div>

            <Footer />
        </>
    );
};

export default FilmInfo;
