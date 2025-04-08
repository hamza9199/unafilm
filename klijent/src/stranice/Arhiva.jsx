import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import styles from './css/Arhiva.module.css'; 

const Arhiva = () => {
    const [movies, setMovies] = useState([]);
    const [loading, setLoading] = useState(true); // Indikator učitavanja
    const [error, setError] = useState(null); // Za prikazivanje greške ako nešto pođe po zlu
    const [selectedTrailer, setSelectedTrailer] = useState(null); // Drži trenutno odabrani trailer

    useEffect(() => {
        // Funkcija za dobijanje filmova sa API-ja
        const fetchMovies = async () => {
            try {
                const response = await axios.get('http://localhost:3000/server/filmovi/arhiva');
                setMovies(response.data); // Postavljanje dobijenih filmova u stanje
                setLoading(false); // Završeno učitavanje
                console.log(response.data)
            } catch (err) {
                setError(err.message); // Postavljanje greške ako dođe do problema
                setLoading(false);
            }
        };

        fetchMovies(); // Pozivanje funkcije za učitavanje filmova
    }, []); // Prazan niz znači da se ovo poziva samo jednom, kada se komponenta učita

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
                    { name: 'Arhiva', link: '/arhiva' },
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
                                    <a href={`/arhiva/film/${movie.id}`} className={styles.movieTitle}>{movie.title}</a>
                                    <p className={styles.movieDescription}>{movie.description}</p>
                                    <div className={styles.buttonContainer}>
                                        <a href={`/arhiva/film/${movie.id}`} className={styles.infoButton} rel="noopener noreferrer">Info</a>
                                        <a onClick={() => setSelectedTrailer(movie.trailerUrl)}  className={styles.trailerButton} target="_blank" rel="noopener noreferrer">Trailer</a>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>No movies found.</p>
                    )}
                </div>
            </div>


             {/* Prikaz odabranog trailera */}
                                     {selectedTrailer && (
                                      <div className={styles.selectedTrailer}>
                                        <div className={styles.iframeContainer}>
                                          <iframe 
                                            width="700" 
                                            height="400" 
                                            src={selectedTrailer} 
                                            title="Trailer Video" 
                                            frameBorder="0" 
                                            allowFullScreen
                                            autoplay
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                          ></iframe>
                                        </div>
                                        <button className={styles.closeButton} onClick={() => setSelectedTrailer(null)}>X</button>
                                      </div>
                                      )}
            <Footer/>
        </>
    );
};

export default Arhiva;
