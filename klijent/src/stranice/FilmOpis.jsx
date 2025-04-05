import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import styles from './css/FilmOpis.module.css'; // Import CSS module
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';

const FilmOpis = () => {
    const { id } = useParams(); // Koristimo useParams da dobijemo id iz URL-a
    const [movie, setMovie] = useState(null);

    useEffect(() => {
        // API poziv za pretragu filma prema id-u
        const fetchMovieData = async () => {
            try {
                const response = await fetch(`http://localhost:3000/server/filmovi/${id}`);
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
        return <div>Loading...</div>;
    }

    return (
        <>
            <Header />
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
                            src={movie.imageUrl} 
                            alt={movie.title}
                            className={styles.entryImage}
                        />
                    </div>
                    <div className={styles.entryInfo}>
                        <h1 className={styles.entryTitle}>{movie.title}</h1>
                        <div className={styles.entryDetails}>
                            <span className={styles.duration}>Trajanje: {movie.duration}</span>
                        </div>
                        <div className={styles.entryDescription}>
                            <h3>Opis</h3>
                            <p>{movie.description}</p>
                        </div>
                    </div>
                </section>

                <div className={styles.entryMedia}>
                    <h3>Video</h3>
                    <iframe
                        width="560"
                        height="315"
                        src={movie.videoSrc}
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
