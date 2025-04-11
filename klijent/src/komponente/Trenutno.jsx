import React, { useState, useEffect } from 'react';
import styles from './css/Trenutno.module.css';
import Slider from 'react-slick'; 
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css'; 
import axios from 'axios';

const Trenutno = () => {
  const [films, setFilms] = useState([]); 
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null); 
  const [selectedFilm, setSelectedFilm] = useState(null);
  const [hoveredIndex, setHoveredIndex] = useState(null);
  const [currentSlide, setCurrentSlide] = useState(0); // Prati početni indeks slajdera
  const [selectedTrailer, setSelectedTrailer] = useState(null); // Drži trenutno odabrani trailer
  const [windowWidth, setWindowWidth] = useState(window.innerWidth); // Za praćenje veličine prozora
  
  useEffect(() => {
    axios.get('https://unafilm-production.up.railway.app/server/filmovi/trenutno')
      .then(response => {
        setFilms(response.data.sort(() => Math.random() - 0.5).slice(0, 6)); 
        setLoading(false);
      })
      .catch(() => {
        setError('Failed to fetch films data.');
        setLoading(false);
      });
  }, []);
  
  // Postavljanje broja slajdova na osnovu širine prozora
  const getSlidesToShow = () => {
    if (windowWidth < 768) {
      return 2; // Prikazuje samo 2 slajda na mobilnim uređajima
    }
    return 3; // Prikazuje 3 slajda na većim uređajima
  };

  // Responsivno praćenje promjena širine prozora
  useEffect(() => {
    const handleResize = () => {
      setWindowWidth(window.innerWidth);
    };
    
    window.addEventListener('resize', handleResize);
    
    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);

  const settings = {
    slidesToShow: getSlidesToShow(), // Dinamički broj slajdova na osnovu širine
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    arrows: false,
    beforeChange: (oldIndex, newIndex) => setCurrentSlide(newIndex), // Prati početni indeks slajdera
  };

  if (loading) {
    return <div>Loading films...</div>;
  }

  if (error) {
    return <div>{error}</div>;
  }

  return (
    <div>
      <h2 className={styles.title}>Trenutno u kinima</h2>
      <div className={styles.container}>
        <Slider {...settings}>
          {films.map((film, index) => {
            const relativeIndex = ((index - currentSlide + films.length) % films.length) % 3; // Računa relativni indeks unutar 3 vidljiva slajda

            return (
              <div 
                className={styles.movieItem} 
                key={index} 
                onMouseEnter={() => {
                  setHoveredIndex(relativeIndex + 1.5); // Postavlja hoveredIndex na 1, 2 ili 3
                  setSelectedFilm(film);
                }} 
                onMouseLeave={() => {
                  if (hoveredIndex !== null) {
                    setHoveredIndex(null);
                    setSelectedFilm(null);

                  }
                }}
              >
                <div className={styles.movieFront}></div>
                <div className={styles.movieFront}>
                  <a href={`/trenutno-u-kinima/film/${film.id}`} className={styles.moviePoster}>
                    <img 
                      src={film.imageUrl2}
                      alt={film.title}
                      className={styles.movieImage}
                    />
                  </a>
                </div>
                <div className={styles.dole}>
                  <a className={styles.title2} href={`/trenutno-u-kinima/film/${film.id}`}>{film.title}</a>
                  <p className={styles.releaseDate}>{new Date(film.releaseDate).toLocaleDateString()}</p>
                </div>
              </div>
            );
          })}
        </Slider>

        {selectedFilm && (
          <div 
            className={styles.selectedFilm}
            onMouseEnter={() => {
              setHoveredIndex(hoveredIndex);
              setSelectedFilm(selectedFilm);
            }}
            onMouseLeave={() => {
              setHoveredIndex(null);
              setSelectedFilm(null);
            }}
            style={{
              left: (340 * hoveredIndex) + 'px',
            }}          
          >
            <div className={styles.left}>
              <img 
                src={selectedFilm.imageUrl2}
                alt={selectedFilm.title}
                className={styles.movieImage}
              />
            </div>
            <div className={styles.right}>
              <h3 className={styles.movieTitle}>
                <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`}>{selectedFilm.title}</a>
              </h3>
              <p className={styles.duration}>Trajanje: {selectedFilm.duration} min</p>
              <p className={styles.releaseDate}>Datum izlaska: {new Date(selectedFilm.releaseDate).toLocaleDateString()}</p>
              <p className={styles.description}>{selectedFilm.description}</p>
              <div className={styles.buttons}>
                <a onClick={() => setSelectedTrailer(selectedFilm.trailerUrl)} className={styles.watchButton}>Gledaj</a>
                <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`} className={styles.infoButton}>Info</a>
              </div>
            </div>
          </div>
        )}



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
      </div>
    </div>
  );
};

export default Trenutno;
