import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import LoadingScreen from '../komponente/LoadingScreen';
import Breadcrumb from '../komponente/Breadcrumb';
import styles from './css/Arhiva.module.css'; 
import { Helmet } from 'react-helmet';
import { format } from 'date-fns';
import { bs } from 'date-fns/locale';

const Arhiva = () => {
    const [movies, setMovies] = useState([]);
    const [loading, setLoading] = useState(true); 
    const [error, setError] = useState(null); 
    const [selectedTrailer, setSelectedTrailer] = useState(null); 

    useEffect(() => {
        const fetchMovies = async () => {
            try {
                const response = await axios.get('https://unafilm-34ky.onrender.com/server/filmovi/arhiva',{ headers: {
                    'x-api-key': 'admin'
                }});
                setMovies(response.data);
                setLoading(false); 
                console.log(response.data)
            } catch (err) {
                setError(err.message);
                setLoading(false);
            }
        };

        fetchMovies(); 
    }, []); 

    if (loading) {
        return <LoadingScreen />; 
    }

    if (error) {
        return <p>Error: {error}</p>;
    }
  const getAutoplayUrl = (url) => {
  if (!url.includes('?')) return `${url}?autoplay=1`;
  return `${url}&autoplay=1`;
};
    return (
        <>
            <Header/>  
            <Helmet>
                <title>Arhiva - Una Film</title>
                <meta name="description" content="Arhiva filmova Una Film" />
                <link rel="canonical" href="https://www.unafilm.ba/arhiva" />
                <meta name="keywords" content="Una Film, arhiva filmova, filmovi, distribucija, kino" />
                <meta name="author" content="Una Film" />
                <meta property="og:title" content="Arhiva - Una Film" />
                <meta property="og:description" content="Arhiva filmova Una Film" />
                <meta property="og:url" content="https://www.unafilm.ba/arhiva" />
                <meta property="og:type" content="website" />
                <meta property="og:image" content="https://www.unafilm.ba/unaFilm141-2.png" />
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:title" content="Arhiva - Una Film" />
                <meta name="twitter:description" content="Arhiva filmova Una Film" />
                <meta name="twitter:image" content="https://www.unafilm.ba/unaFilm141-2.png" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta httpEquiv="Content-Security-Policy" content="default-src 'self' https://www.youtube.com; script-src 'self' 'unsafe-inline' https://www.youtube.com; style-src 'self' 'unsafe-inline'; img-src 'self' data: https://www.youtube.com; frame-src 'self' https://www.youtube.com;" />
                <meta name="theme-color" content="#ffffff" />
                <link rel="icon" href="/favicon.ico" />
                <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
                <link rel="manifest" href="/manifest.json" />
                <meta name="application-name" content="Una Film Distribucija" />
                <meta name="mobile-web-app-capable" content="yes" />
                <meta name="apple-mobile-web-app-capable" content="yes" />
                <meta name="apple-mobile-web-app-status-bar-style" content="default" />
                <meta name="msapplication-TileColor" content="#ffffff" />
                <meta name="msapplication-TileImage" content="/mstile-150x150.png" />
                <meta name="msapplication-config" content="/browserconfig.xml" />
                
            </Helmet>
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: 'Arhiva', link: '/arhiva' },
                ]}
            />
            <div className={styles.container}>
                <div className={styles.movieList}>
                    {movies.length > 0 ? (
                        movies.map((movie, index) => (
                            <div key={index} className={styles.movieItem}>
                                <div className={styles.movieImageWrapper}>
                                    <img src={movie.imageUrl2} alt={movie.title} className={styles.movieImage}/>
                                </div>
                                <div className={styles.movieText}>
                                    <a href={`/arhiva/film/${movie.uuid}`} className={styles.movieTitle}>{movie.title}</a>
                                    <div className={styles.uzo}>
                                       <span className={styles.releaseDate}>
  {format(new Date(movie.releaseDate), "d. MMMM yyyy", { locale: bs })}
</span>
                                                            <span className={styles.duration}>{movie.duration} min</span>
                                                            </div>
                                    <p className={styles.movieDescription}>{
    movie.opis.replace(/[#*>]/g, '').length > 180 
      ? `${movie.opis.replace(/[#*>]/g, '').substring(0, 180)}...` 
      : movie.opis.replace(/[#*>]/g, '')
  }</p>
                                    <div className={styles.buttonContainer}>
                                        <a href={`/arhiva/film/${movie.uuid}`} className={styles.infoButton} rel="noopener noreferrer">
                                        
                                        <svg width="30px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM10.25 11C10.25 10.4477 10.6977 10 11.25 10H12.75C13.3023 10 13.75 10.4477 13.75 11V18C13.75 18.5523 13.3023 19 12.75 19H11.25C10.6977 19 10.25 18.5523 10.25 18V11ZM14 7C14 5.89543 13.1046 5 12 5C10.8954 5 10 5.89543 10 7C10 8.10457 10.8954 9 12 9C13.1046 9 14 8.10457 14 7Z" fill="#000000"></path> </g></svg>

                                        </a>
                                        <a onClick={() => setSelectedTrailer(movie.trailerUrl)}  className={styles.trailerButton} target="_blank" rel="noopener noreferrer">
                                            
                                        <svg
  viewBox="-0.5 0 7 7"
  version="1.1"
  xmlns="http://www.w3.org/2000/svg"
  fill="#000000"
  width="30px"
  height="20px"
>
  <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
  <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
  <g id="SVGRepo_iconCarrier">
    <title>play [#1003]</title>
    <desc>Created with Sketch.</desc>
    <defs></defs>
    <g id="Page-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd">
      <g id="Dribbble-Light-Preview" transform="translate(-347.000000, -3766.000000)" fill="#000000">
        <g id="icons" transform="translate(56.000000, 160.000000)">
          <path
            d="M296.494737,3608.57322 L292.500752,3606.14219 C291.83208,3605.73542 291,3606.25002 291,3607.06891 L291,3611.93095 C291,3612.7509 291.83208,3613.26444 292.500752,3612.85767 L296.494737,3610.42771 C297.168421,3610.01774 297.168421,3608.98319 296.494737,3608.57322"
            id="play-[#1003]"
          ></path>
        </g>
      </g>
    </g>
  </g>
</svg>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>No movies found.</p>
                    )}
                </div>
            </div>


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
            <Footer/>
        </>
    );
};

export default Arhiva;
