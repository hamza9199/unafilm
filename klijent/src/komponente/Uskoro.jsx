import React from 'react';
import styles from './css/Uskoro.module.css'; // Import the CSS module

const Uskoro = () => {
  return (
    <div className={styles.kon}>
      <h1 className={styles.title}>Uskoro u kinima</h1>
    <div className={styles.container}>

    
      {/* Movie list */}
      <ul className={styles.movieList}>
        <li><span className={styles.number}>1</span><a href="https://unafilm.ba/movie/moČvara" className={styles.link}>MOČVARA</a></li>
        <li><span className={styles.number}>2</span><a href="https://unafilm.ba/movie/igra-straha" className={styles.link}>IGRA STRAHA</a></li>
        <li><span className={styles.number}>3</span><a href="https://unafilm.ba/movie/pingvinove-lekcije" className={styles.link}>PINGVINOVE LEKCIJE</a></li>
        <li><span className={styles.number}>4</span><a href="https://unafilm.ba/movie/kako-da-dresirate-svog-zmaja" className={styles.link}>KAKO DA DRESIRATE SVOG ZMAJA</a></li>
        <li><span className={styles.number}>5</span><a href="https://unafilm.ba/movie/jurski-svijet:-preporod" className={styles.link}>JURSKI SVIJET: PREPOROD</a></li>
        <li><span className={styles.number}>6</span><a href="https://unafilm.ba/movie/Štrumpfovi-–-veliki-film-(the-smurfs-movie)" className={styles.link}>ŠTRUMPFOVI – VELIKI FILM</a></li>
      </ul>
    </div>
    </div>
  );
};

export default Uskoro;
