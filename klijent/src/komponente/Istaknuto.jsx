import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Istaknuto.module.css';
import Slider from 'react-slick';
import 'slick-carousel/slick/slick.css';  // Ensure slick carousel styles are loaded
import 'slick-carousel/slick/slick-theme.css'; // Ensure theme styles are loaded
import LoadingScreen from './LoadingScreen'; // Adjust the path as necessary

const Istaknuto = () => {
  const [filmovi, setFilmovi] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [selectedTrailer, setSelectedTrailer] = useState(null); // Drži trenutno odabrani trailer
  

  // Fetch movies from API
  useEffect(() => {
    const fetchFilmovi = async () => {
      try {
        const response = await axios.get('https://unafilm.onrender.com/server/filmovi/uskoro' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
        const response2 = await axios.get('https://unafilm.onrender.com/server/filmovi/trenutno' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
        const combinedFilmovi = [...response.data, ...response2.data].sort(() => Math.random() - 0.5).slice(0, 6); // Shuffle the films
        setFilmovi(combinedFilmovi); 
        setLoading(false);
      } catch (err) {
        setError(err.message);
        setLoading(false);
      }
    };

    fetchFilmovi();
  }, []);

  const settings = {
    slidesToShow: 1,
    arrows: false,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    infinite: true,
    fade: true,
    dots: true,
    cssEase: 'linear',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: true,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: true,
        },
      },
    ],
  };

  if (loading) {
    return <LoadingScreen />; 
  }

  if (error) {
    return <p>Error: {error}</p>;
  }

  const getAutoplayUrl = (url) => {
  if (!url.includes('?')) return `${url}?autoplay=1`;
  return `${url}&autoplay=1`;
};


  return (
    <section className={styles.istaknutoSection}>
      <div className={styles.sliderContainer}>
        <Slider {...settings}>
          {filmovi.map((film, index) => (
            <div key={index} className={styles.slideItem}>
              <div className={styles.slideThumb}>
                <a href={`/arhiva/film/${film.uuid}`}  rel="noopener noreferrer">
                  <img src={film.imageUrl} alt={film.title} className={styles.slideImage} />
                </a>
              </div>
              <div className={styles.slideContent}>
                <h2 className={styles.slideTitle}>
                  <a href={`/arhiva/film/${film.uuid}`} rel="noopener noreferrer" className={styles.slideLink}>
                    {film.title}
                  </a>
                </h2>
                <div className={styles.slideDesc}>
                  <p className={styles.desc}>

 {
    film.opis.replace(/[#*>]/g, '').length > 150 
      ? `${film.opis.replace(/[#*>]/g, '').substring(0, 150)}...` 
      : film.opis.replace(/[#*>]/g, '')
  }

                  </p>
                </div>
                <div className={styles.slideButton}>
                  <a  onClick={() => setSelectedTrailer(film.trailerUrl)} className={styles.trailerLink} target="_blank" rel="noopener noreferrer">
                    <i className="fa fa-play" onClick={() => setSelectedTrailer(film.trailerUrl)} // Postavlja trailer kad klikneš
                    ></i> 
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
                  <a href={`/arhiva/film/${film.uuid}`} className={styles.detailsLink}  rel="noopener noreferrer">
                    <i className="fa fa-exclamation"></i>

                    <svg width="30px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM10.25 11C10.25 10.4477 10.6977 10 11.25 10H12.75C13.3023 10 13.75 10.4477 13.75 11V18C13.75 18.5523 13.3023 19 12.75 19H11.25C10.6977 19 10.25 18.5523 10.25 18V11ZM14 7C14 5.89543 13.1046 5 12 5C10.8954 5 10 5.89543 10 7C10 8.10457 10.8954 9 12 9C13.1046 9 14 8.10457 14 7Z" fill="#000000"></path> </g></svg>
                  </a>
                </div>
              </div>
            </div>
          ))}
        </Slider>
      </div>

       {/* Prikaz odabranog trailera */}
             {selectedTrailer && (
              <div className={styles.selectedTrailer}>
                <div className={styles.iframeContainer}>
                  <iframe 
                    width="700" 
                    height="400" 
                    src={getAutoplayUrl(selectedTrailer)} 
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
    </section>
  );
};

export default Istaknuto;
