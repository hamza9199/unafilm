import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Istaknuto.module.css';
import Slider from 'react-slick';
import 'slick-carousel/slick/slick.css';  // Ensure slick carousel styles are loaded
import 'slick-carousel/slick/slick-theme.css'; // Ensure theme styles are loaded

const Istaknuto = () => {
  const [filmovi, setFilmovi] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch movies from API
  useEffect(() => {
    const fetchFilmovi = async () => {
      try {
        const response = await axios.get('http://localhost:3000/server/filmovi'); // API endpoint for films
        setFilmovi(response.data.slice(0, 2)); // Limiting to 2 films
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
    return <p>Loading...</p>;
  }

  if (error) {
    return <p>Error: {error}</p>;
  }

  return (
    <section className={styles.istaknutoSection}>
      <div className={styles.sliderContainer}>
        <Slider {...settings}>
          {filmovi.map((film, index) => (
            <div key={index} className={styles.slideItem}>
              <div className={styles.slideThumb}>
                <a href={`/arhiva/film/${film.id}`}  rel="noopener noreferrer">
                  <img src={film.imageUrl} alt={film.title} className={styles.slideImage} />
                </a>
              </div>
              <div className={styles.slideContent}>
                <h2 className={styles.slideTitle}>
                  <a href={`/arhiva/film/${film.id}`} rel="noopener noreferrer">
                    {film.title}
                  </a>
                </h2>
                <div className={styles.slideDesc}>
                  <p>{film.description}</p>
                </div>
                <div className={styles.slideButton}>
                  <a href={film.trailerUrl} className={styles.trailerLink} target="_blank" rel="noopener noreferrer">
                    <i className="fa fa-play"></i> Trailer
                  </a>
                  <a href={`/arhiva/film/${film.id}`} className={styles.detailsLink}  rel="noopener noreferrer">
                    <i className="fa fa-exclamation"></i> Detalji
                  </a>
                </div>
              </div>
            </div>
          ))}
        </Slider>
      </div>
    </section>
  );
};

export default Istaknuto;
