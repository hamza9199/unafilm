import React, { useState, useEffect } from 'react';
import styles from './css/FilmOpis.module.css'; // Import CSS module
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';

const FilmOpis = () => {
    const [movie, setMovie] = useState(null);

    useEffect(() => {
        // Simulating an API call to fetch movie data
        const fetchMovieData = () => {
            setMovie({
                title: "MOČVARA",
                description: "Za diplomiranu studentkinju sa Hjustona, Kajl i njene prijatelje, odmor se pretvara u pakao nakon što su u močvarnoj pustoši Everglejdsa, u Luizijani, preživjeli avionsku nesreću i otkrili da nešto mnogo opasnije vreba u plićaku.",
                imageSrc: "https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-360x618_c.jpg",
                videoSrc: "https://www.youtube.com/embed/D9wXGwOzuEA",
                duration: "01 sati 27 minuta"
            });
        };

        fetchMovieData();
    }, []);

    if (!movie) {
        return <div>Loading...</div>;
    }

    return (
        <>
            <Header />
            <div className={styles.container}>
                <section className={styles.pageHeader}>
                    <img 
                        src="https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-FB-Cover-851x315px.jpg"
                        alt="MOČVARA"
                        className={styles.entryImage}
                    />
                </section>
                <section className={styles.pageContent}>
                    <div className={styles.entryImage}>
                        <img 
                            src={movie.imageSrc} 
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
