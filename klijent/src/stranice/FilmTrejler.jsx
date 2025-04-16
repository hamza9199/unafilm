import React, { useState, useEffect } from 'react';  
import { useParams } from 'react-router-dom';
import styles from './css/FilmTrejler.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import RelatedArticle from '../komponente/RelatedArticle';
import { Helmet } from 'react-helmet';
import ReactMarkdown from 'react-markdown'; // Uvozimo ReactMarkdown za renderovanje Markdown sadržaja

const FilmTrejler = () => {
    const { id } = useParams(); 
    const [novost, setNovost] = useState(null);

    useEffect(() => {
        const fetchNovostData = async () => {
            try {
                const response = await fetch(`https://unafilm-production.up.railway.app/server/novosti/${id}`);
                if (!response.ok) {
                    throw new Error('Novost not found');
                }
                const data = await response.json();
                setNovost(data);
            } catch (error) {
                console.error(error);
                setNovost(null);
            }
        };

        fetchNovostData();
    }, [id]);

    if (!novost) {
        return <div>Loading...</div>;
    }

    return (
        <>
            <Header />
            <Helmet>
                <title>{novost.film.title} - Una Film</title>
                <meta name="description" content={novost.film.opis} />
                <link rel="canonical" href={`https://unafilm.com/novosti/traileri/film/${id}`} />
                <meta name="keywords" content={`${novost.film.title}, film, trailer, novosti`} />
                <meta name="author" content="Una Film" />
                <meta property="og:title" content={novost.film.title} />
                <meta property="og:description" content={novost.film.opis} />
                <meta property="og:image" content={novost.film.imageUrl} />
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
                    { name: novost.film.title, link: `/novosti/traileri/film/${id}` },
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
                                    src={novost.film.imageUrl} 
                                    className={styles.img}
                                    alt={novost.film.title}
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
                                        {novost.film.title}
                                    </a>
                                </h1>
                                <div className={styles.entryContent}>
                                    {novost.film.trailerUrl ? (
                                        <div className={styles.videoWrapper}>
                                            <iframe
                                                width="560"
                                                height="315"
                                                src={novost.film.trailerUrl}
                                                title={novost.film.title}
                                                frameBorder="0"
                                                allowFullScreen
                                            ></iframe>
                                        </div>
                                    ) : (
                                        <p>No trailer available.</p>
                                    )}

                                    {novost.film.opis ? (
                                            <div style={{ textAlign: 'justify' }}>
                                            {novost.film.opis && <ReactMarkdown>{novost.film.opis}</ReactMarkdown>}
                                            </div>
                                    ) : null}
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

export default FilmTrejler;
