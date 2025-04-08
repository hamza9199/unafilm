import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Trejleri.module.css';

const Trejleri = () => {
  const [trailers, setTrailers] = useState([]); // State za trejlere
  const [loading, setLoading] = useState(true); // Loading state
  const [error, setError] = useState(null); // Error state
  const [selectedTrailer, setSelectedTrailer] = useState(null); // Drži trenutno odabrani trailer

  useEffect(() => {
    const fetchTrailers = async () => {
      try {
        const response = await axios.get('http://localhost:3000/server/filmovi/');
        setTrailers(response.data.sort(() => Math.random() - 0.5).slice(0, 6));
        setLoading(false);
      } catch {
        setError('Failed to fetch trailers');
        setLoading(false);
      }
    };

    fetchTrailers();
  }, []);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>{error}</p>;

  return (
    <div className={styles.container}>
      <h2 className={styles.heading}>Trailer & Video</h2>
      <div className={styles.trailerGrid}>
        {trailers.map((trailer) => (
          <div
            key={trailer.id}
            className={styles.trailerItem}
            onClick={() => setSelectedTrailer(trailer.trailerUrl)} // Postavlja trailer kad klikneš
          >
            {selectedTrailer === trailer.trailerUrl ? (
              <div className={styles.videoContainer}>
              <iframe
                width="430"
                height="203"
                src={trailer.trailerUrl.replace("watch?v=", "embed/")} // Zamjena za embed URL
                title={trailer.title}
                frameBorder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
                autoplay
              ></iframe>
              </div>
            ) : (
              <div className={styles.thumbnailContainer}>
                <img src={trailer.imageUrl} alt={trailer.title} className={styles.thumbnail} />
                <div className={styles.overlay}>
                  <p className={styles.playIcon}>▶</p>
                </div>
              </div>
            )}
            <h3 className={styles.title}>{trailer.title}</h3>
          </div>
        ))}
      </div>


       {/* Prikaz odabranog trailera */}
       {selectedTrailer && (
        <div className={styles.selectedTrailer}>
          <div className={styles.iframeContainer}>
            <iframe 
              width="700" 
              height="400" 
              src={selectedTrailer} 
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
