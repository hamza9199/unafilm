import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Uskoro.module.css'; 
import LoadingScreen from './LoadingScreen'; 

const Uskoro = () => {
  const [films, setFilms] = useState([]); 
  const [loading, setLoading] = useState(true); 
  const [error, setError] = useState(null);
  const [screenWidth, setScreenWidth] = useState(window.innerWidth); 

  useEffect(() => {
    const fetchFilms = async () => {
      try {
        const response = await axios.get('https://unafilm-34ky.onrender.com/server/filmovi/uskoro' , {
                    headers: {
                        'x-api-key': 'admin'
                    } 
                }); 
        setFilms(response.data.sort(() => Math.random() - 0.5));
        setLoading(false);
      } catch {
        setError('Failed to fetch films');
        setLoading(false);
      }
    };

    fetchFilms(); 

    const handleResize = () => {
      setScreenWidth(window.innerWidth);
    };

    window.addEventListener('resize', handleResize);

    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []); 

  if (loading) {
    return <LoadingScreen />;
  }

  if (error) {
    return <p>{error}</p>; 
  }

  const isMobile = screenWidth <= 768; 
  const numberOfFilms = isMobile ? 4 : 6; 

  return (
    <div className={styles.kon}>
      <h1 className={styles.title}>Uskoro u kinima</h1>

      <div className={styles.container}>
        <ul className={styles.movieList}>
          {films.slice(0, numberOfFilms).map((film, index) => ( 
            <li key={index}>
              <span className={styles.number}>{index + 1}</span>
              <a href={`/uskoro-u-kinima/film/${film.uuid}`} className={styles.link}>{film.title}</a> 
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default Uskoro;
