import React from 'react';  
import styles from './css/Film.module.css';

const Film = () => {
    const title = "Inception";
    const posterUrl = "https://example.com/inception.jpg"; 
    const description = "A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.";
    const releaseDate = "July 16, 2010";

    return (
        <div style={styles.container}>
            <h1 style={styles.title}>{title}</h1>
            <img src={posterUrl} alt={`${title} Poster`} style={styles.poster} />
            <p style={styles.description}>{description}</p>
            <p style={styles.releaseDate}>Release Date: {releaseDate}</p>
        </div>
    );
};


export default Film;