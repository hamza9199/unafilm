import React, { useState, useEffect } from 'react';
import styles from './css/Trenutno.module.css';
import Slider from 'react-slick'; 
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css'; 
import axios from 'axios';

const Trenutno = () => {
  const [films, setFilms] = useState([]); // State to hold the films data
  const [loading, setLoading] = useState(true); // Loading state
  const [error, setError] = useState(null); // Error state
  const [selectedFilm, setSelectedFilm] = useState(null); // State to hold selected film data
  const [hoveredIndex, setHoveredIndex] = useState(null); // Track hovered film index

  useEffect(() => {
    // Fetch films data from API
    axios.get('http://localhost:3000/server/filmovi/trenutno') // Replace with your API endpoint
      .then(response => {
        setFilms(response.data.sort(() => Math.random() - 0.5).slice(0, 8)); // Set the films data into the state
        setLoading(false); // Stop loading
      })
      .catch(() => {
        setError('Failed to fetch films data.'); // Set error message
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
            <div 
              className={styles.movieItem} 
              key={index} 
              onMouseEnter={() => {
                setHoveredIndex(index); // Set the hovered index
                setSelectedFilm(film); // Set the selected film on hover
              }} 
              onMouseLeave={() => {
                if (hoveredIndex !== null) {
                  setHoveredIndex(null); // Only reset hovered index, but not selectedFilm
                }
              }}
            >
              <div className={styles.movieFront}></div>
              <div className={styles.movieFront}>
                <a href={`/trenutno-u-kinima/film/${film.id}`} className={styles.moviePoster}>
                  <img 
                    src={film.imageUrl}
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
          ))}
        </Slider>
        
        {selectedFilm && (
          <div 
            className={styles.selectedFilm}
            onMouseLeave={() => {
              setHoveredIndex(null); // Reset hovered index when mouse leaves the selected film
              setSelectedFilm(null); // Reset selected film
            }}

            style={{
              left: `${150 * (hoveredIndex + 5)}px`, // Dynamically adjust position based on hovered film index
            }}          
          >
            <img 
              src={selectedFilm.imageUrl}
              alt={selectedFilm.title}
              className={styles.movieImage}
            />
            <h3 className={styles.movieTitle}>
              <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`}>{selectedFilm.title}</a>
            </h3>
            <p className={styles.duration}>{selectedFilm.duration}</p>
            <p className={styles.description}>{selectedFilm.description}</p>
            <p className={styles.releaseDate}>Datum izlaska: {new Date(selectedFilm.releaseDate).toLocaleDateString()}</p>
            <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`} className={styles.watchButton}>Gledaj</a>
            <a href={`/trenutno-u-kinima/film/${selectedFilm.id}`} className={styles.infoButton}>Info</a>
          </div>
        )}
      </div>
    </div>
  );
};

export default Trenutno;
