import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/LijeviBaner.module.css';
import logo from './../assets/unaFilm-2.jpg';

const FilmItem = ({ src, alt, title, duration, uuid }) => {
    return (
        <div className={styles.entryItem}>
            <div className={styles.entryThumb}>
                <a href={`/arhiva/film/${uuid}`}>
                <img className={styles.image} src={src} alt={alt} />
                </a>
            </div>
            <div className={styles.entryContent}>
                <h2 className={styles.entryTitle}>
                    <a href={`/arhiva/film/${uuid}`}>{title}</a>
                </h2>
                <div>
                    <span className={styles.duration}>
                        <i className="fa fa-clock-o"></i> {duration} min
                    </span>
                </div>
            </div>
        </div>
    );
};

const LijeviBaner = () => {
    const [films, setFilms] = useState([]);
    const [newsItems, setNewsItems] = useState([]);
    const [loadingFilms, setLoadingFilms] = useState(true);
    const [loadingNews, setLoadingNews] = useState(true);
    const [errorFilms, setErrorFilms] = useState(null);
    const [errorNews, setErrorNews] = useState(null);
    const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

    useEffect(() => {
        const handleResize = () => setIsMobile(window.innerWidth <= 768);
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    useEffect(() => {
        const fetchFilms = async () => {
            try {
                const response = await axios.get('https://unafilm.onrender.com/server/filmovi' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                const randomFilms = response.data.sort(() => Math.random() - 0.5).slice(0, 4);
                setFilms(randomFilms);
                setLoadingFilms(false);
            } catch (err) {
                setErrorFilms(err.message);
                setLoadingFilms(false);
            }
        };

        const fetchNews = async () => {
            try {
                const response = await axios.get('https://unafilm.onrender.com/server/novosti' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                const randomNews = response.data.sort(() => Math.random() - 0.5).slice(0, 2);
                setNewsItems(randomNews);
                setLoadingNews(false);
            } catch (err) {
                setErrorNews(err.message);
                setLoadingNews(false);
            }
        };

        fetchFilms();
        fetchNews();
    }, []);

    if (loadingFilms || loadingNews) return <p>Loading...</p>;
    if (errorFilms || errorNews) return <p>Error: {errorFilms || errorNews}</p>;

    return (
        <aside id="sidebar" className={styles.sidebar}>
            <div className={styles.widgetBlock}>
                <figure className={styles.wpBlockImage}>
                    <img src={logo} alt="Logo" className={styles.wpImage} />
                </figure>
            </div>
            <div className={styles.widgetList}>
                <h4 className={styles.widgetTitle}>Filmovi</h4>
                <div className={isMobile ? styles.mobileGrid : ''}>
                    {films.slice(0, isMobile ? 2 : films.length).map((film, index) => (
                        <FilmItem key={index} src={film.imageUrl2} alt={film.title} title={film.title} duration={film.duration} uuid={film.uuid} />
                    ))}
                </div>

            </div>
            <div className={styles.widgetList}>
                <h4 className={styles.widgetTitle}>Najnovije vijesti</h4>
                <div className={isMobile ? styles.mobileGrid : ''}>
                    {newsItems.map((item, index) => (
                        <div key={index} className={styles.entryItem}>
                            <div className={styles.entryThumb2}>
                                <a href={`/novosti/film/${item.uuid}`}>
                                <img src={item.film ? item.film.imageUrl : item.image} alt={item.film ? item.film.title : "No image"} className={styles.image2} />
                                </a>
                            </div>
                            <div className={styles.entryContent2}>
                                <h2 className={styles.entryTitle}>
                                    <a href={`/novosti/film/${item.uuid}`}>{item.title}</a>
                                </h2>
                                <div className={styles.entryMeta}>
                                    <span className={styles.entryDate}>{new Date(item.datumKreiranja).toLocaleDateString()}</span>
                                    <span> / </span>
                                    <span className={styles.entryComment}>{item.film ? item.film.comment : Math.floor(Math.random() * 1000 + 1)} komentara</span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </aside>
    );
};

export default LijeviBaner;