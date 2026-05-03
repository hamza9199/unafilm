import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Novosti.module.css';
import LoadingScreen from './LoadingScreen'; 

const Novosti = () => {
  const [films, setFilms] = useState([]); 
  const [loading, setLoading] = useState(true); 
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchFilms = async () => {
      try {
        const response = await axios.get('https://unafilm-34ky.onrender.com/server/novosti/' , {
                    headers: {
                        'x-api-key': 'admin'
                    } 
                }); 
        const sorted = response.data.sort((a, b) => new Date(b.datumKreiranja) - new Date(a.datumKreiranja)).slice(0, 3);
        setFilms(sorted);
        setLoading(false); 
      } catch {
        setError('Failed to fetch films'); 
        setLoading(false);
      }
    };

    fetchFilms(); 
  }, []); 

  if (loading) {
    return <LoadingScreen />;
  }

  if (error) {
    return <p>{error}</p>;
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
                      <a href={`/novosti/film/${film.uuid}`}>
                      <img
                        src={film.film ? film.film.imageUrl : film.image}
                        alt=""
                        className={styles.imga}
                      />
                      </a>
                    <div className={styles.entryCat}>
                      {(() => {
                        switch (film.tipNovosti) {
                          case "svijetfilma":
                            return "SVIJET FILMA";
                          case "trailer":
                            return "TRAILER";
                          case "novost":
                            return "NOVOST";
                          default:
                            return "NOVOST";
                        }
                      })()}
                    </div>
                    </div>
                    <div className={styles.entryContent}>
                      <h2 className={styles.entryTitle}>
                        <a href={`/novosti/film/${film.uuid}`}>
                          {film.title}
                        </a>
                      </h2>
                      <a className={styles.entryBtn} href={`/novosti/film/${film.uuid}`}>
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
