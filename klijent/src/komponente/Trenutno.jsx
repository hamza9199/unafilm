import React, { useState, useEffect } from 'react';
import styles from './css/Trenutno.module.css';
import Slider from 'react-slick'; 
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css'; 
import axios from 'axios'; // Import axios for making API requests

const Trenutno = () => {
  const [films, setFilms] = useState([]); // State to hold the films data
  const [loading, setLoading] = useState(true); // Loading state to show loading spinner or message
  const [error, setError] = useState(null); // Error state to handle any issues with API calls

  useEffect(() => {
    // Fetch films data from API
    axios.get('http://localhost:3000/server/filmovi/trenutno') // Replace with your API endpoint
      .then(response => {
        setFilms(response.data); // Set the films data into the state
        setLoading(false); // Stop loading
      })
      .catch(() => {
        setError('Failed to fetch films data.'); // Set error message if API call fails
        setLoading(false); // Stop loading
      });
  }, []);

  const settings = {
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    arrows: false,
  };

  // If data is loading, show a loading message
  if (loading) {
    return <div>Loading films...</div>;
  }

  // If there is an error, show an error message
  if (error) {
    return <div>{error}</div>;
  }

  return (
    <div>
      <h2 className={styles.title}>Trenutno u kinima</h2>
      <div className={styles.container}>
        <Slider {...settings}>
          {films.map((film, index) => (
            <div className={styles.movieItem} key={index}>
              <div className={styles.movieFront}></div>
              <div className={styles.movieFront}>
                <a href={film.link} className={styles.moviePoster}>
                  <img 
                    src={film.imageUrl}
                    alt={film.title}
                    className={styles.movieImage}
                  />
                </a>
              </div>
              <div className={styles.dole}>
                <a className={styles.title2} href={film.link}>{film.title}</a>
                <p className={styles.releaseDate}>{film.releaseDate}</p>
              </div>

              <div className={styles.movieContent}>
                <h3 className={styles.movieTitle}>
                  <a href={film.link}>{film.title}</a>
                </h3>

                <p className={styles.duration}>{film.duration}</p>
                <p className={styles.description}>{film.description}</p>
                <p className={styles.releaseDate}>Datum izlaska: {film.releaseDate}</p>
                <a href={film.link} className={styles.watchButton}>Gledaj</a>
                <a href={film.link} className={styles.infoButton}>Info</a>
              </div>
            </div>
          ))}
        </Slider>
      </div>
    </div>
  );
};

export default Trenutno;
