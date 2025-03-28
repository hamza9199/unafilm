import React from 'react';
import styles from './css/Istaknuto.module.css';
import Slider from 'react-slick';
import 'slick-carousel/slick/slick.css';  // Ensure slick carousel styles are loaded
import 'slick-carousel/slick/slick-theme.css'; // Ensure theme styles are loaded

const filmovi = [
  {
    title: 'IGRA STRAHA',
    description: 'Prvi sastanci sami po sebi izazivaju nervozu...',
    trailerUrl: 'https://www.youtube.com/embed/lqzGlT8DsDg',
    detailsUrl: 'https://unafilm.ba/movie/igra-straha/',
    imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/Drop-FB-cover-BiH.jpg',
  },
  {
    title: 'MOČVARA',
    description: 'Za diplomiranu studentkinju sa Hjustona...',
    trailerUrl: 'https://www.youtube.com/embed/D9wXGwOzuEA',
    detailsUrl: 'https://unafilm.ba/movie/mocvara/',
    imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-FB-Cover-851x315px.jpg',
  },
  {
    title: 'PINGVINOVE LEKCIJE',
    description: 'Ova potresna drama reditelja Petera Cattanea...',
    trailerUrl: 'https://www.youtube.com/embed/WWSnYxBBT70',
    detailsUrl: 'https://unafilm.ba/movie/pingvinove-lekcije/',
    imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/PENGUIN-LESSONS-THE-FB-Cover-851x315px.jpg',
  },
];

const Istaknuto = () => {
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

  return (
    <section className={styles.istaknutoSection}>
      <div className={styles.sliderContainer}>
        <Slider {...settings}>
          {filmovi.map((film, index) => (
            <div key={index} className={styles.slideItem}>
              <div className={styles.slideThumb}>
                <a href={film.detailsUrl} target="_blank" rel="noopener noreferrer">
                  <img src={film.imageUrl} alt={film.title} className={styles.slideImage} />
                </a>
              </div>
              <div className={styles.slideContent}>
                <h2 className={styles.slideTitle}>
                  <a href={film.detailsUrl} target="_blank" rel="noopener noreferrer">
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
                  <a href={film.detailsUrl} className={styles.detailsLink} target="_blank" rel="noopener noreferrer">
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
