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
    const [selectedTrailer, setSelectedTrailer] = useState(null); // Drži trenutno odabrani trailer

    useEffect(() => {
        // Funkcija za dobijanje filmova sa API-ja
        const fetchMovies = async () => {
            try {
                const response = await axios.get('https://unafilm-production.up.railway.app/server/filmovi/uskoro'); // Ovde promeniti API endpoint
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
                                    <img src={movie.imageUrl2} alt={movie.title} className={styles.movieImage}/>
                                </div>
                                <div className={styles.movieText}>
                                    <a href={`/uskoro-u-kinima/film/${movie.id}`} className={styles.movieTitle}>{movie.title}</a>
                                    <p className={styles.movieDescription}>{movie.description}</p>
                                    <div className={styles.buttonContainer}>
                                        <a href={`/uskoro-u-kinima/film/${movie.id}`} className={styles.infoButton}  rel="noopener noreferrer">
                                        
                                        <svg width="30px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM10.25 11C10.25 10.4477 10.6977 10 11.25 10H12.75C13.3023 10 13.75 10.4477 13.75 11V18C13.75 18.5523 13.3023 19 12.75 19H11.25C10.6977 19 10.25 18.5523 10.25 18V11ZM14 7C14 5.89543 13.1046 5 12 5C10.8954 5 10 5.89543 10 7C10 8.10457 10.8954 9 12 9C13.1046 9 14 8.10457 14 7Z" fill="#000000"></path> </g></svg>

                                        
                                        </a>
                                        <a onClick={() => setSelectedTrailer(movie.trailerUrl)} className={styles.trailerButton} target="_blank" rel="noopener noreferrer">
                                        <svg
  viewBox="-0.5 0 7 7"
  version="1.1"
  xmlns="http://www.w3.org/2000/svg"
  fill="#000000"
  width="30px"
  height="20px"
>
  <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
  <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
  <g id="SVGRepo_iconCarrier">
    <title>play [#1003]</title>
    <desc>Created with Sketch.</desc>
    <defs></defs>
    <g id="Page-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd">
      <g id="Dribbble-Light-Preview" transform="translate(-347.000000, -3766.000000)" fill="#000000">
        <g id="icons" transform="translate(56.000000, 160.000000)">
          <path
            d="M296.494737,3608.57322 L292.500752,3606.14219 C291.83208,3605.73542 291,3606.25002 291,3607.06891 L291,3611.93095 C291,3612.7509 291.83208,3613.26444 292.500752,3612.85767 L296.494737,3610.42771 C297.168421,3610.01774 297.168421,3608.98319 296.494737,3608.57322"
            id="play-[#1003]"
          ></path>
        </g>
      </g>
    </g>
  </g>
</svg>
                                        </a>
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

export default UskoroUKinima;
