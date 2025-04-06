import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Novosti.module.css';

const Novosti = () => {
  const [films, setFilms] = useState([]); // State to store films
  const [loading, setLoading] = useState(true); // Loading state
  const [error, setError] = useState(null); // Error state

  // Fetch films data from the API
  useEffect(() => {
    const fetchFilms = async () => {
      try {
        const response = await axios.get('http://localhost:3000/server/novosti/'); // Replace with your API endpoint
        setFilms(response.data.slice(0, 3)); // Assuming the API returns an array of films, limit to 6
        setLoading(false); // Set loading to false after fetching data
      } catch {
        setError('Failed to fetch films'); // Handle errors
        setLoading(false);
      }
    };

    fetchFilms(); // Call function to fetch data
  }, []); // Empty dependency array to fetch only on mount

  if (loading) {
    return <p>Loading...</p>; // Show loading state
  }

  if (error) {
    return <p>{error}</p>; // Show error if something goes wrong
  }

  return (
    <section className={styles.novostiSection}>
      <div className={styles.container}>
        <div className={styles.column}>
          <div className={styles.headingWrapper}>
            <header className={styles.header}>
              <span className={styles.separatorLeft}></span>
              <h2 className={styles.titleHeading}>Novosti</h2>
              <span className={styles.separatorRight}></span>
            </header>
          </div>
          <div className={styles.blogWrapper}>
            <div className={styles.row}>
              {films.map((film, index) => (
                <div key={index} className={styles.col}>
                  <div className={styles.entryItem}>
                    <div className={styles.entryThumb}>
                      <img
                        src={film.film.imageUrl}
                        alt={film.film.imageAlt}
                        className={styles.imga}
                      />
                      <div className={styles.entryCat}>{film.tipNovosti}</div>
                    </div>
                    <div className={styles.entryContent}>
                      <h2 className={styles.entryTitle}>
                        <a href={`/novosti/film/${film.id}`}>
                          {film.title}
                        </a>
                      </h2>
                      <a className={styles.entryBtn} href={`/novosti/film/${film.id}`}>
                        Pročitaj više
                      </a>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Novosti;
