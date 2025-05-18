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
import { format } from 'date-fns';
import { bs } from 'date-fns/locale';
import LoadingScreen from '../komponente/LoadingScreen';

const FilmInfo = ({ svijet }) => { // Fix destructuring of svijet
    const { id } = useParams(); // Preuzimanje id-a iz URL-a
    const [novost, setNovost] = useState(null);

    useEffect(() => {
        // API poziv za pretragu novosti prema id-u   
        const fetchNovostData = async () => {
            try {
                const response = await fetch(`https://unafilm.onrender.com/server/novosti/${id}`, {
                    headers: {
                        'x-api-key': 'admin'
                    }
                }); // Endpoint za pretragu po id
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
        return (
                <LoadingScreen /> 
            
        );
    }

    const { film } = novost; // Preuzimanje filma iz odgovora

    return (
        <>
            <Header />
            <Helmet>
                <title>{novost.title} - Una Film</title>
                <link rel="canonical" href={`https://unafilm.vercel.app/novosti/iz-svijeta-filma/film/${id}`} />
                <meta name="author" content="Una Film" />
                <meta property="og:url" content={`https://unafilm.vercel.app/novosti/traileri/film/${id}`} />
                <meta property="og:type" content="article" />
                <meta property="og:site_name" content="Una Film" />
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:site" content="@UnaFilm" />
                <meta name="twitter:creator" content="@UnaFilm" />
            </Helmet>

            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: 'Novosti', link: `/novosti` },
                    ...(svijet ? [{ name: 'Iz svijeta filma', link: `/novosti/iz-svijeta-filma` }] : []), // Correctly handle svijet
                    { name: novost.title, link: `novosti/film/${id}` },
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
                                    src={novost.film ? film.imageUrl : novost.image} 
                                    className={styles.img}
                                    alt={novost.film ? film.title : "Film"}
                                    decoding="async" 
                                />
                            </div>
                        </div>
                        <div className={styles.entryBottom}>
                            <div className={styles.entryMeta}>
                                <div className={styles.entryDate}>
                                    <span className={styles.releaseDate}>
                                        {format(new Date(novost.datumKreiranja), "d. MMMM yyyy", { locale: bs })}
                                    </span>
                                </div>
                                <div className={styles.entryComment}>
                                    <i className="fa fa-comments" aria-hidden="true"></i> {novost.film ? novost.film.comment : "100"} komentara
                                </div>
                            </div>
                            <div className={styles.entryLeft}>
                                <h1 className={styles.entryTitle}>
                                    <a 
                                        href={`/novosti/film/${novost.uuid}`}
                                        className={styles.entryLink}
                                        itemProp="url"
                                    >
                                        {novost.title}
                                    </a>
                                    <p><em>Kreator novosti: {novost.kreator}</em></p>
                                </h1>
                                <div className={styles.entryContent}>
                                    <div>
                                        <ReactMarkdown rehypePlugins={[rehypeRaw]}>
                                            {
                                                novost.tekst !== null && novost.tekst !== undefined && novost.tekst !== ""
                                                    ? novost.tekst
                                                    : (novost.film && novost.film.opis ? novost.film.opis : "")
                                            }
                                        </ReactMarkdown>
                                    </div>
                                    {novost.film && (
                                        <div className={styles.videoWrapper}>
                                            <iframe
                                                width="660"
                                                height="415"
                                                src={novost.film ? novost.film.trailerUrl : null}
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
