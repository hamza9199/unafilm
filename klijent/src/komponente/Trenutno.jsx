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
    <div className={styles.con2}>
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
            left: `${340 * hoveredIndex}px`,
          }}
        >
          <div className={styles.left}>
            <img 
              src={selectedFilm.imageUrl2}
              alt={selectedFilm.title}
            />
          </div>
      
          <div className={styles.right}>
            <h3 className={styles.movieTitle}>
              <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`}>
                {selectedFilm.title}
              </a>
            </h3>
      
            <div className={styles.metaInfo}>
              <span>{new Date(selectedFilm.releaseDate).toLocaleDateString()}</span>
              <span>{selectedFilm.duration} min</span>
            </div>
      
            <p className={styles.description}>{selectedFilm.description}</p>
              <div className={styles.buttons}>
                <a onClick={() => setSelectedTrailer(selectedFilm.trailerUrl)} className={styles.watchButton}>
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
                <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`} className={styles.infoButton}>
                <svg width="30px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM10.25 11C10.25 10.4477 10.6977 10 11.25 10H12.75C13.3023 10 13.75 10.4477 13.75 11V18C13.75 18.5523 13.3023 19 12.75 19H11.25C10.6977 19 10.25 18.5523 10.25 18V11ZM14 7C14 5.89543 13.1046 5 12 5C10.8954 5 10 5.89543 10 7C10 8.10457 10.8954 9 12 9C13.1046 9 14 8.10457 14 7Z" fill="#000000"></path> </g></svg>

                </a>
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
