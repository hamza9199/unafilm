import React, { useState, useEffect } from 'react';  
import { useParams } from 'react-router-dom';
import styles from './css/FilmTrejler.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import RelatedArticle from '../komponente/RelatedArticle';

const FilmTrejler = () => {
    const { id } = useParams(); 
    const [novost, setNovost] = useState(null);

    useEffect(() => {
        const fetchNovostData = async () => {
            try {
                const response = await fetch(`http://localhost:3000/server/novosti/${id}`);
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
                                    <i className="fa fa-comments" aria-hidden="true"></i> {novost.comment}
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

                                    {novost.tekst4 ? (
                                            <p className={styles.pu}>
                                                {novost.tekst4}
                                            </p>
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
