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
import rehypeRaw from 'rehype-raw';

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
                <title>{novost.film ? novost.film.title : novost.title} - Una Film</title>
                <meta name="author" content="Una Film" />
                <meta property="og:type" content="article" />
                <meta property="og:site_name" content="Una Film" />
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:site" content="@UnaFilm" />
                <meta name="twitter:creator" content="@UnaFilm" />
            </Helmet>
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: novost.film ? novost.film.title : novost.title, link: `/novosti/traileri/film/${id}` },
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
                                    src={novost.film ? novost.film.imageUrl : novost.image} 
                                    className={styles.img}
                                    alt={novost.film ? novost.film.title : "Film"}
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
                                    <i className="fa fa-comments" aria-hidden="true"></i> {novost.film ? novost.film.comment : "100"} komentara
                                </div>
                            </div>
                            <div className={styles.entryLeft}>
                                <h1 className={styles.entryTitle}>
                                    <a 
                                        href={`/arhiva/film/${novost.film ? novost.film.id : novost.id}`}
                                        className={styles.entryLink}
                                        itemProp="url"
                                    >
                                        {novost.film ? novost.film.title : novost.title}
                                    </a>
                                </h1>
                                <div className={styles.entryContent}>
                                    {novost.film ? (
                                        <div className={styles.videoWrapper}>
                                            <iframe
                                                width="560"
                                                height="315"
                                                src={novost.film ? novost.film.trailerUrl : null}
                                                title={novost.film.title}
                                                frameBorder="0"
                                                allowFullScreen
                                            ></iframe>
                                        </div>
                                    ) : (
                                        null
                                    )}

                                    <div style={{ textAlign: 'justify' }}>
                                        <ReactMarkdown rehypePlugins={[rehypeRaw]}>
                                            {novost.film ? novost.film.opis : novost.tekst}
                                        </ReactMarkdown>
                                    </div>

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
