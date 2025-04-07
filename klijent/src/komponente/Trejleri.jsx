import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Trejleri.module.css';

const Trejleri = () => {
  const [trailers, setTrailers] = useState([]); // State to store trailers
  const [loading, setLoading] = useState(true); // Loading state
  const [error, setError] = useState(null); // Error state

  // Fetch trailers data from the API
  useEffect(() => {
    const fetchTrailers = async () => {
      try {
        const response = await axios.get('http://localhost:3000/server/filmovi/'); // Replace with your API endpoint
        setTrailers(response.data.sort(() => Math.random() - 0.5).slice(0, 6)); // Ensure we only use the first 6 trailers
        setLoading(false); // Set loading to false after fetching data
      } catch {
        setError('Failed to fetch trailers'); // Handle errors
        setLoading(false);
      }
    };

    fetchTrailers(); // Call function to fetch data
  }, []); // Empty dependency array to fetch only on mount

  if (loading) {
    return <p>Loading...</p>; // Show loading state
  }

  if (error) {
    return <p>{error}</p>; // Show error if something goes wrong
  }

  return (
    <>
      <div className={styles.container}>
        <h2 className={styles.heading}>Trailer & Video</h2>
        <div className={styles.trailerGrid}>
          {trailers.map((trailer) => (
            <div key={trailer.id} className={styles.trailerItem}>
              <a href={trailer.trailerUrl} target="_blank" rel="noopener noreferrer">
                <div className={styles.thumbnailContainer}>
                  <img
                    src={trailer.imageUrl}
                    alt={trailer.title}
                    className={styles.thumbnail}
                  />
                  <div className={styles.overlay}>
                    <p className={styles.playIcon}>▶</p>
                  </div>
                </div>
                <h3 className={styles.title}>{trailer.title}</h3>
              </a>
            </div>
          ))}
        </div>
      </div>
    </>
  );
};

export default Trejleri;
