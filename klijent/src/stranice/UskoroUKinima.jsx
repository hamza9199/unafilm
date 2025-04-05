import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/TrenutnoUKinima.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';

const UskoroUKinima = () => {
    const [movies, setMovies] = useState([]); // Držimo podatke o filmovima
    const [loading, setLoading] = useState(true); // Indikator učitavanja
    const [error, setError] = useState(null); // Za greške pri učitavanju podataka

    useEffect(() => {
        // Funkcija za dobijanje filmova sa API-ja
        const fetchMovies = async () => {
            try {
                const response = await axios.get('http://localhost:3000/server/filmovi/uskoro'); // Ovde promeniti API endpoint
                setMovies(response.data); // Postavljanje dobijenih filmova u stanje
                setLoading(false); // Završeno učitavanje
            } catch (err) {
                setError(err.message); // Postavljanje greške ako dođe do problema
                setLoading(false);
            }
        };

        fetchMovies(); // Pozivanje funkcije za učitavanje filmova
    }, []); // Prazan niz znači da se ovo poziva samo jednom, kada se komponenta učitava

    if (loading) {
        return <p>Loading movies...</p>; // Prikazivanje poruke dok se filmovi učitavaju
    }

    if (error) {
        return <p>Error: {error}</p>; // Prikazivanje greške ako je nešto pošlo po zlu
    }

    return (
        <>
            <Header/>  
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: 'Uskoro u kinima', link: '/uskoro-u-kinima' },
                ]}
            />
            <div className={styles.container}>
                <div className={styles.movieList}>
                    {movies.length > 0 ? (
                        movies.map((movie, index) => (
                            <div key={index} className={styles.movieItem}>
                                <div className={styles.movieImageWrapper}>
                                    <img src={movie.imageUrl} alt={movie.title} className={styles.movieImage}/>
                                </div>
                                <div className={styles.movieText}>
                                    <a href={`/uskoro-u-kinima/film/${movie.id}`} className={styles.movieTitle}>{movie.title}</a>
                                    <p className={styles.movieDescription}>{movie.description}</p>
                                    <div className={styles.buttonContainer}>
                                        <a href={`/uskoro-u-kinima/film/${movie.id}`} className={styles.infoButton} target="_blank" rel="noopener noreferrer">Info</a>
                                        <a href={movie.trailerUrl} className={styles.trailerButton} target="_blank" rel="noopener noreferrer">Trailer</a>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>No movies found.</p>
                    )}
                </div>
            </div>
            <Footer/>
        </>
    );
};

export default UskoroUKinima;
