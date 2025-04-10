import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/LijeviBaner.module.css';
import logo from './../assets/unaFilm-2.jpg'; // Adjust the path as necessary


// Component for rendering each film item
const FilmItem = ({ src, alt, title, duration, id }) => {
    return (
        <div className={styles.entryItem}>
            <div className={styles.entryThumb}>
                <img className={styles.image} src={src} alt={alt} />
            </div>
            <div className={styles.entryContent}>
                <h2 className={styles.entryTitle}>
                    <a href={`/arhiva/film/${id}`}>{title}</a>
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

// Main Sidebar component
const LijeviBaner = () => {
    const [films, setFilms] = useState([]);
    const [newsItems, setNewsItems] = useState([]);
    const [loadingFilms, setLoadingFilms] = useState(true);
    const [loadingNews, setLoadingNews] = useState(true);
    const [errorFilms, setErrorFilms] = useState(null);
    const [errorNews, setErrorNews] = useState(null);

    useEffect(() => {
        // Fetch films from API
        const fetchFilms = async () => {
            try {
                const response = await axios.get('http://localhost:3000/server/filmovi'); // API endpoint for films
                const randomFilms = response.data.sort(() => Math.random() - 0.5).slice(0, 4); // Get 4 random films
                setFilms(randomFilms);
                setLoadingFilms(false);
            } catch (err) {
                setErrorFilms(err.message);
                setLoadingFilms(false);
            }
        };

        // Fetch news items from API
        const fetchNews = async () => {
            try {
                const response = await axios.get('http://localhost:3000/server/novosti'); // API endpoint for news
                const randomNews = response.data.sort(() => Math.random() - 0.5).slice(0, 2); // Get 2 random news
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

    if (loadingFilms || loadingNews) {
        return <p>Loading...</p>;
    }

    if (errorFilms || errorNews) {
        return <p>Error: {errorFilms || errorNews}</p>;
    }

    return (
        <aside id="sidebar" className={styles.sidebar}>
            <div className={styles.widgetBlock}>
                <figure className={styles.wpBlockImage}>
                    <img
                        fetchpriority="high"
                        decoding="async"
                        width="320"
                        height="320"
                        src={logo}
                        alt=""
                        className={styles.wpImage}
                    />
                </figure>
            </div>
            <div className={styles.widgetList}>
                <h4 className={styles.widgetTitle}>Filmovi</h4>
                {films.map((film, index) => (
                    <FilmItem
                        key={index}
                        src={film.imageUrl}
                        alt={film.title}
                        title={film.title}
                        duration={film.duration}
                        id={film.id}

                    />
                ))}
            </div>
            <div className={styles.widgetList}>
                <h4 className={styles.widgetTitle}>Najnovije vijesti</h4>
                {newsItems.map((item, index) => (
                    <div key={index} className={styles.entryItem}>
                        <div className={styles.entryThumb2}>
                            <img
                                src={item.film.imageUrl}
                                alt={item.film.title}
                                className={styles.image2}
                            />
                        </div>
                        <div className={styles.entryContent2}>
                            <h2 className={styles.entryTitle}>
                                <a href={`/novosti/film/${item.id}`}
                                >{item.title}</a>
                            </h2>
                            <div className={styles.entryMeta}>
                                <span className={styles.entryDate}>{new Date(item.datumKreiranja).toLocaleDateString()}</span>
                                <span> / </span>
                                <span className={styles.entryComment}>{item.film.comment} komentara</span>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </aside>
    );
};

export default LijeviBaner;
