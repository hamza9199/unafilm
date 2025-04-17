import React, { useState, useEffect } from 'react';  
import { useParams } from 'react-router-dom'; // Uvozimo useParams za dobijanje id-a iz URL-a
import styles from './css/FilmInfo.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import RelatedArticle from '../komponente/RelatedArticle';
import { Helmet } from 'react-helmet';
import ReactMarkdown from 'react-markdown'; // Uvozimo ReactMarkdown za renderovanje Markdown sadržaja
import rehypeRaw from 'rehype-raw';

const FilmInfo = () => {
    const { id } = useParams(); // Preuzimanje id-a iz URL-a
    const [novost, setNovost] = useState(null);

    useEffect(() => {
        // API poziv za pretragu novosti prema id-u   
        const fetchNovostData = async () => {
            try {
                const response = await fetch(`https://unafilm-production.up.railway.app/server/novosti/${id}`); // Endpoint za pretragu po id
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
            <Helmet>
                <title>{novost.title} - Una Film</title>
                <meta name="description" content={film.opis} />
                <link rel="canonical" href={`https://unafilm.com/novosti/iz-svijeta-filma/film/${id}`} />
                <meta name="keywords" content={`${film.title}, film, novosti`} />
                <meta name="author" content="Una Film" />
                <meta property="og:title" content={film.title} />

                <meta property="og:description" content={film.opis} />
                <meta property="og:image" content={film.imageUrl} />
                <meta property="og:url" content={`https://unafilm.com/novosti/traileri/film/${id}`} />
                <meta property="og:type" content="article" />
                <meta property="og:site_name" content="Una Film" />
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:title" content={novost.film.title} />
                <meta name="twitter:description" content={novost.film.opis} />
                <meta name="twitter:image" content={novost.film.imageUrl} />
                <meta name="twitter:site" content="@UnaFilm" />
                <meta name="twitter:creator" content="@UnaFilm" />
                </Helmet>


            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: novost.title, link: `novosti/film/${id}` }, // Dinamički link sa id
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
                                    src={film?.imageUrl || novost.image} 
                                    className={styles.img}
                                    alt={film.title}
                                    decoding="async" 
                                />
                            </div>
                        </div>
                        <div className={styles.entryBottom}>
                            <div className={styles.entryMeta}>
                                <div className={styles.entryDate}>
                                <span className={styles.day}>{new Date(novost.datumKreiranja).toLocaleDateString("bs-BA", {
                                    day: "numeric",
                                    month: "long",
                                    year: "numeric",
                                })}</span>

                                </div>
                                <div className={styles.entryComment}>
                                    <i className="fa fa-comments" aria-hidden="true"></i> {novost.film.comment} komentara
                                </div>
                            </div>
                            <div className={styles.entryLeft}>
                                <h1 className={styles.entryTitle}>
                                    <a 
                                        href={`/novost/film/${novost.id}`}
                                        className={styles.entryLink}
                                        itemProp="url"
                                    >
                                        {novost.title}
                                    </a>
                                    <p><em>Preuzeto sa: {novost.kreator}</em></p>
                                </h1>
                                <div className={styles.entryContent}>
                                        <div >
                                        {novost.tekst && <ReactMarkdown rehypePlugins={[rehypeRaw]}>{novost.tekst}</ReactMarkdown>}
                                        </div>

                                    
                                    {novost.film.trailerUrl && (
                                        <div className={styles.videoWrapper}>
                                        <iframe
                                            width="660"
                                            height="415"
                                            src={novost.film.trailerUrl}
                                            title="Trailer"
                                            frameBorder="0"
                                            allowFullScreen
                                        ></iframe>
                                        </div>
                                    )}

                                        

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
