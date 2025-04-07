import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Uskoro.module.css'; // Import the CSS module

const Uskoro = () => {
  const [films, setFilms] = useState([]); // State to store the films
  const [loading, setLoading] = useState(true); // Loading state to show while fetching data
  const [error, setError] = useState(null); // Error state to handle API errors

  // Fetch films data from the API
  useEffect(() => {
    const fetchFilms = async () => {
      try {
        const response = await axios.get('http://localhost:3000/server/filmovi/uskoro'); // Replace with your actual API endpoint
        setFilms(response.data.sort(() => Math.random() - 0.5).slice(0, 6)); // Assuming the API returns an array of films
        setLoading(false); // Set loading to false after fetching data
      } catch {
        setError('Failed to fetch films'); // Handle errors
        setLoading(false);
      }
    };

    fetchFilms(); // Call the function to fetch data
  }, []); // Empty dependency array to run the effect only once on mount

  if (loading) {
    return <p>Loading...</p>; // Show loading state
  }

  if (error) {
    return <p>{error}</p>; // Show error message if the fetch fails
  }

  return (
    <div className={styles.kon}>
      <h1 className={styles.title}>Uskoro u kinima</h1>
      <div className={styles.container}>
        {/* Movie list */}
        <ul className={styles.movieList}>
          {films.slice(0, 7).map((film, index) => ( // Display only 7 films
            <li key={index}>
              <span className={styles.number}>{index + 1}</span>
              <a href={`/uskoro-u-kinima/film/${film.id}`} className={styles.link}>{film.title}</a> {/* Assuming `film.link` is provided by the API */}
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default Uskoro;
