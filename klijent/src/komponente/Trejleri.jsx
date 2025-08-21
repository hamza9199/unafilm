import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Trejleri.module.css';
import LoadingScreen from './LoadingScreen'; // Adjust the path as necessary

const Trejleri = () => {
  const [trailers, setTrailers] = useState([]); // State za trejlere
  const [loading, setLoading] = useState(true); // Loading state
  const [error, setError] = useState(null); // Error state
  const [selectedTrailer, setSelectedTrailer] = useState(null); // Drži trenutno odabrani trailer

  useEffect(() => {
    const fetchTrailers = async () => {
      try {
        const response = await axios.get('https://unafilm-34ky.onrender.com/server/filmovi/uskoro' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
        const response2 = await axios.get('https://unafilm-34ky.onrender.com/server/filmovi/trenutno' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });

        const combinedTrailers = [...response.data, ...response2.data].sort(() => Math.random() - 0.5).slice(0, 6);
        setTrailers(combinedTrailers);
        setLoading(false);
      } catch (error) {
        setError('Failed to fetch trailers: ' + error.message);
        setLoading(false);
      }
    };

    fetchTrailers();
  }, []);

  if (loading) return <LoadingScreen />; // Prikaz loading ekrana dok se podaci učitavaju
  if (error) return <p>{error}</p>;
  const getAutoplayUrl = (url) => {
  if (!url.includes('?')) return `${url}?autoplay=1`;
  return `${url}&autoplay=1`;
};
  return (
    <div className={styles.container}>
      <h2 className={styles.heading}>Trailer & Video</h2>
      <div className={styles.trailerGrid}>
        {trailers.map((trailer) => {
          const isActive = selectedTrailer === trailer.trailerUrl;
          return (
            <div
              key={trailer.id}
              className={styles.trailerItem}
              onClick={() => setSelectedTrailer(trailer.trailerUrl)} // Postavlja trailer kad klikneš
            >
              <div className={styles.thumbnailContainer}>
                <img src={trailer.imageUrl} alt={trailer.title} className={`${styles.thumbnail} ${isActive ? styles.pulsing : ''}`} />
                <div className={styles.overlay}>
                  <p className={styles.playIcon}>▶</p>
                </div>
              </div>
              <h3 className={styles.title}>{trailer.title}</h3>
            </div>
          );
        })}
      </div>


       {/* Prikaz odabranog trailera */}
       {selectedTrailer && (
        <div className={styles.selectedTrailer}>
          <div className={styles.iframeContainer}>
            <iframe 
              width="700" 
              height="400" 
              src={getAutoplayUrl(selectedTrailer)} 
              title="Trailer Video" 
              frameBorder="0" 
              allowFullScreen
              autoplay
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            ></iframe>
          </div>
          <button className={styles.closeButton} onClick={() => setSelectedTrailer(null)}>X</button>
        </div>
        )}
    </div>
  );
};

export default Trejleri;