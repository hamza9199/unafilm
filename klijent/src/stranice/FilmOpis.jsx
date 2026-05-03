import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import styles from './css/FilmOpis.module.css'; 
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import { Helmet } from 'react-helmet';
import ReactMarkdown from 'react-markdown'; 
import { format } from 'date-fns';
import { bs } from 'date-fns/locale';
import LoadingScreen from '../komponente/LoadingScreen';

const FilmOpis = () => {
    const { id } = useParams();
    const [movie, setMovie] = useState(null);

    useEffect(() => {
        const fetchMovieData = async () => {
            try {
                const response = await fetch(`https://unafilm-34ky.onrender.com/server/filmovi/${id}`, {
                    headers: {
                        'x-api-key': 'admin'
                    }
                });
                if (!response.ok) {
                    throw new Error('Film not found');
                }
                const data = await response.json();
                setMovie(data); 
            } catch (error) {
                console.error(error);
                setMovie(null); 
            }
        };

        fetchMovieData();
    }, [id]);

    if (!movie) {
        return <LoadingScreen />; 
    }

    return (
        <div
            style={{
                position: 'relative',
                minHeight: '100vh',
                overflow: 'hidden'
            }}
        >
            <div
                style={{
                    backgroundImage: `url(${movie.imageUrl})`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    backgroundColor: '#181818',
                    filter: 'blur(16px) brightness(0.6)', 
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    right: 0,
                    bottom: 0,
                    zIndex: 0,
                    overflow: 'hidden',
                    transform: 'scale(1.1)',
                }}
            />
            <div style={{ position: 'relative', zIndex: 1 }}>
                <Header />
                <Helmet>
                    <title>{movie.title} - Una Film</title>
                    <meta name="description" content={movie.opis} />
                    <link rel="canonical" href={`https://unafilm.ba/filmovi/${id}`} />
                    <meta name="keywords" content={`${movie.title}, film, opis, Una Film`} />
                    <meta name="author" content="Una Film" />

                    <meta property="og:title" content={movie.title} />
                    <meta property="og:description" content={movie.opis} />
                    <meta property="og:image" content={movie.imageUrl} />
                    <meta property="og:url" content={`https://unafilm.ba/filmovi/${id}`} />
                    <meta property="og:type" content="article" />
                    <meta property="og:site_name" content="Una Film" />
                    <meta name="twitter:card" content="summary_large_image" />
                    <meta name="twitter:title" content={movie.title} />
                    <meta name="twitter:description" content={movie.opis} />
                    <meta name="twitter:image" content={movie.imageUrl} />
                    <meta name="twitter:site" content="@UnaFilm" />
                    <meta name="twitter:creator" content="@UnaFilm" />
                </Helmet>

                <div className={styles.container}>
                    <section className={styles.pageHeader}>
                        <img
                            src={movie.imageUrl}
                            alt={movie.title}
                            className={styles.entryImage}
                        />
                    </section>
                    <section className={styles.pageContent}>
                        <div className={styles.entryImage}>
                            <img
                                src={movie.imageUrl2}
                                alt={movie.title}
                                className={styles.entryImage}
                            />
                        </div>
                        <div className={styles.entryInfo}>
                            <h1 className={styles.entryTitle}>{movie.title}</h1>
                            <div className={styles.entryDetails}>
                                <span className={styles.duration}>Trajanje: {movie.duration} min</span>
                                <span className={styles.releaseDate}>
                                    {format(new Date(movie.releaseDate), "d. MMMM yyyy", { locale: bs })}
                                </span>
                            </div>
                            <div className={styles.entryDescription}>
                                <h3 className={styles.title3}>Opis</h3>
                                <div className={styles.entryDescriptionText}>
                                    {movie.opis && <ReactMarkdown>{movie.opis}</ReactMarkdown>}
                                </div>
                            </div>
                        </div>
                    </section>

                    <div className={styles.entryMedia}>
                        <h3>Video</h3>
                        <iframe
                            width="560"
                            height="315"
                            src={movie.trailerUrl}
                            title="Movie Video"
                            frameBorder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowFullScreen
                        ></iframe>
                    </div>
                </div>
                <Footer />
            </div>
        </div>
    );
};
export default FilmOpis;
