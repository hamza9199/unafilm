import React from 'react';
import styles from './css/Uskoro.module.css'; // Import the CSS module

const Uskoro = () => {
  const films = [
    { title: "PETI SEPTEMBAR" },
    { title: "MOČVARA" },
    { title: "PETI SEPTEMBAR" },
    { title: "PETI SEPTEMBAR" },
    { title: "PETI SEPTEMBAR" },
    { title: "PETI SEPTEMBAR" },
  ];

  return (
    <div className={styles.kon}>
      <h1 className={styles.title}>Uskoro u kinima</h1>
      <div className={styles.container}>
        {/* Movie list */}
        <ul className={styles.movieList}>
          {films.map((film, index) => (
            <li key={index}>
              <span className={styles.number}>{index + 1}</span>
              <a href="#" className={styles.link}>{film.title}</a>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default Uskoro;
