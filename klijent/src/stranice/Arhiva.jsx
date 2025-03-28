import React from 'react';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import styles from './css/Arhiva.module.css'; 

const Arhiva = () => {
    const movies = [
        {
          title: 'IGRA STRAHA',
          description: 'Prvi sastanci sami po sebi izazivaju nervozu...',
          trailerUrl: 'https://www.youtube.com/embed/lqzGlT8DsDg',
          detailsUrl: 'https://unafilm.ba/movie/igra-straha/',
          imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/September-5-1080x1920-IG-Story-196x336_c.jpg',
        },
        {
          title: 'MOČVARA',
          description: 'Za diplomiranu studentkinju sa Hjustona...',
          trailerUrl: 'https://www.youtube.com/embed/D9wXGwOzuEA',
          detailsUrl: 'https://unafilm.ba/movie/mocvara/',
          imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/September-5-1080x1920-IG-Story-196x336_c.jpg',
        },
        {
          title: 'PINGVINOVE LEKCIJE',
          description: 'Ova potresna drama reditelja Petera Cattanea...',
          trailerUrl: 'https://www.youtube.com/embed/WWSnYxBBT70',
          detailsUrl: 'https://unafilm.ba/movie/pingvinove-lekcije/',
          imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/September-5-1080x1920-IG-Story-196x336_c.jpg',
        },
        {
            title: 'MOČVARA',
            description: 'Za diplomiranu studentkinju sa Hjustona...',
            trailerUrl: 'https://www.youtube.com/embed/D9wXGwOzuEA',
            detailsUrl: 'https://unafilm.ba/movie/mocvara/',
            imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/September-5-1080x1920-IG-Story-196x336_c.jpg',
          },
          {
            title: 'PINGVINOVE LEKCIJE',
            description: 'Ova potresna drama reditelja Petera Cattanea...',
            trailerUrl: 'https://www.youtube.com/embed/WWSnYxBBT70',
            detailsUrl: 'https://unafilm.ba/movie/pingvinove-lekcije/',
            imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/September-5-1080x1920-IG-Story-196x336_c.jpg',
          },
      ];

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
                                    <h2 className={styles.movieTitle}>{movie.title}</h2>
                                    <p className={styles.movieDescription}>{movie.description}</p>
                                    <div className={styles.buttonContainer}>
                                        <a href={movie.detailsUrl} className={styles.infoButton} target="_blank" rel="noopener noreferrer">Info</a>
                                        <a href={movie.trailerUrl} className={styles.trailerButton} target="_blank" rel="noopener noreferrer">Trailer</a>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>Loading movies...</p>
                    )}
                </div>
            </div>
            <Footer/>
        </>
    );
};

export default Arhiva;