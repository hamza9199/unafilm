import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import styles from './css/FilmOpis.module.css'; // Import CSS module
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import { Helmet } from 'react-helmet';
import ReactMarkdown from 'react-markdown'; // Uvozimo ReactMarkdown za renderovanje Markdown sadržaja
import { format } from 'date-fns';
import { bs } from 'date-fns/locale';
import LoadingScreen from '../komponente/LoadingScreen';

const FilmOpis = () => {
    const { id } = useParams(); // Koristimo useParams da dobijemo id iz URL-a
    const [movie, setMovie] = useState(null);

    useEffect(() => {
        // API poziv za pretragu filma prema id-u
        const fetchMovieData = async () => {
            try {
                const response = await fetch(`https://unafilm.up.railway.app/server/filmovi/${id}`);
                if (!response.ok) {
                    throw new Error('Film not found');
                }
                const data = await response.json();
                setMovie(data); // Postavljamo podatke filma u stanje
            } catch (error) {
                console.error(error);
                setMovie(null); // Ako dođe do greške, postavljamo film na null
            }
        };

        fetchMovieData();
    }, [id]); // Ponovno učitavanje kada se id promeni

    if (!movie) {
        return <LoadingScreen />; // Prikazujemo LoadingScreen dok se podaci učitavaju
    }

    return (
        <>
            <Header />
            <Helmet>
                <title>{movie.title} - Una Film</title>
                <meta name="description" content={movie.opis} />
                <link rel="canonical" href={`https://unafilm.com/filmovi/${id}`} />
                <meta name="keywords" content={`${movie.title}, film, opis, Una Film`} />
                <meta name="author" content="Una Film" />

                <meta property="og:title" content={movie.title} />
                <meta property="og:description" content={movie.opis} />
                <meta property="og:image" content={movie.imageUrl} />
                <meta property="og:url" content={`https://unafilm.com/filmovi/${id}`} />
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
                            <div style={{ textAlign: 'justify', marginRight: '20px', marginLeft: '20px' }}>
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
        </>
    );
};

export default FilmOpis;
