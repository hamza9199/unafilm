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
    const [movie, setMovie] = useState(null);

    useEffect(() => {
        // API poziv za pretragu filma prema id-u   
        const fetchMovieData = async () => {
            try {
                const response = await fetch(`http://localhost:3000/server/filmovi/${id}`); // Endpoint za pretragu po id
                if (!response.ok) {
                    throw new Error('Film not found');
                }
                const data = await response.json();
                setMovie(data); // Postavljanje filma u stanje
            } catch (error) {
                console.error(error);
                setMovie(null); // Ako dođe do greške, postavljamo movie na null
            }
        };

        fetchMovieData(); // Pozivanje funkcije za pretragu filma
    }, [id]); // Poziva se svaki put kada se id promeni

    if (!movie) {
        return <div>Loading...</div>; // Prikazujemo loading dok ne učitamo podatke
    }

    return (
        <>
            <Header/>
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: movie.title, link: `novosti/iz-svijeta-filma/film/${id}` }, // Dinamički link sa id
                ]}
            />

            <div className={styles.container}>
                <LijeviBaner/>
                <div className={styles.pageContent}>
                    <article id="post-1045" className={styles.article}>
                        <div className={styles.entryTop}>
                            <div className={styles.entryThumb}>
                                <img 
                                    width="990" 
                                    height="440" 
                                    src={movie.imageUrl} 
                                    className={styles.img}
                                    alt={movie.imageAlt}
                                    decoding="async" 
                                />
                            </div>
                        </div>
                        <div className={styles.entryBottom}>
                            <div className={styles.entryMeta}>
                                <div className={styles.entryDate}>
                                    <span className={styles.day}>{movie.date.split(' ')[0]}</span>
                                    <span className={styles.month}>{movie.date.split(' ')[1]}</span>
                                </div>
                                <div className={styles.entryComment}>
                                    <i className="fa fa-comments" aria-hidden="true"></i> {movie.comment}
                                </div>
                            </div>
                            <div className={styles.entryLeft}>
                                <h1 className={styles.entryTitle}>
                                    <a 
                                        href={movie.link} 
                                        className={styles.entryLink}
                                        itemProp="url"
                                    >
                                        {movie.title}
                                    </a>
                                    <p><em>Preuzeto sa: {movie.preuzeto}</em></p>
                                </h1>
                                <div className={styles.entryContent}>
                                    {Array.isArray(movie.content) ? (
                                        movie.content.map((item, index) => {
                                            switch (item.type) {
                                                case 'text':
                                                    return <p key={index}>{item.text}</p>;
                                                case 'image':
                                                    return (
                                                        <figure key={index} className={styles.figure}>
                                                            <img src={item.src} alt={item.alt} className={styles.smallImg} />
                                                            <figcaption className={styles.figcaption}>
                                                                <em>{item.caption}</em>
                                                            </figcaption>
                                                        </figure>
                                                    );
                                                case 'trailer':
                                                    return (
                                                        <div key={index} className={styles.videoWrapper}>
                                                            <iframe 
                                                                width="560" 
                                                                height="315" 
                                                                src={item.src} 
                                                                title={item.title} 
                                                                frameBorder="0" 
                                                                allowFullScreen
                                                            ></iframe>
                                                        </div>
                                                    );
                                                default:
                                                    return null;
                                            }
                                        })
                                    ) : (
                                        <p>No content available.</p>
                                    )}
                                </div>
                            </div>
                        </div>
                        <RelatedArticle />
                    </article>
                </div>
            </div>

            <Footer/>
        </>
    );
};

export default FilmInfo;
