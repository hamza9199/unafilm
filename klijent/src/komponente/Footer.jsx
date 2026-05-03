import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Footer.module.css';
import logo from './../assets/unaFilm141-2.png'; 
import LoadingScreen from './LoadingScreen'; 

const Footer = () => {
    const [movies, setMovies] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchMovies = async () => {
            try {
                const response = await axios.get('https://unafilm-34ky.onrender.com/server/novosti', {
                    headers: {
                        'x-api-key': 'admin'
                    } 
                });
                const sorted = response.data.sort((a, b) => new Date(b.datumKreiranja) - new Date(a.datumKreiranja)).slice(0, 2);
                setMovies(sorted);
                setLoading(false);
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

    return (
        <footer id="amy-colophon" className={styles.amySiteFooter}>
            <div className={styles.container}>
                <div className={styles.amyFooterWidgets}>
                    <div className={styles.colMd3}>
                        <div className={styles.amyWidget}>
                            <div className={`${styles.amyWidget} ${styles.about}`}>
                                <h4 className={styles.amyTitle}></h4>
                                <div className={styles.footerLogo}>
                                    <a href="/">
                                        <img
                                            src={logo}
                                            alt="Una Film Logo"
                                        />
                                    </a>
                                </div>
                            </div>
                            <div className={styles.clear}></div>
                        </div>
                    </div>

                    <div className={styles.colMd3}>
                        <div className={styles.amyWidget}>
                            <div className={styles.amyWidgetTitle}>
                                <h4>Una Film</h4>
                            </div>
                            <div className={styles.amyWidgetContent}>
                                <ul id="menu-customer-services" className={styles.menu}>
                                    <li className={styles.menuItem}>
                                        <a href="/" aria-current="page">
                                            Početna
                                        </a>
                                    </li>
                                    <li className={styles.menuItem}>
                                        <a href="/uskoro-u-kinima/">
                                            Uskoro u kinima
                                        </a>
                                    </li>
                                    <li className={styles.menuItem}>
                                        <a href="/trenutno-u-kinima/">
                                            Trenutno u kinima
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div className={styles.clear}></div>
                        </div>
                    </div>

                    <div className={styles.colMd6}>
                        <div className={styles.amyWidget}>
                            <div className={`${styles.amyWidget} ${styles.listPost}`}>
                                <h4 className={styles.amyTitle}>Zadnje novosti</h4>

                                {movies.map((movie, index) => (
                                    <div key={index} className={styles.entryItem}>
                                        <div className={styles.entryThumb}>
                                            <a href={`/novosti/film/${movie.uuid}`}
                                            >
                                            <img
                                                src={movie.film ? movie.film.imageUrl : movie.image}
                                                    alt={movie.film ? movie.film.title : "No Title"}
                                                href={`/novosti/film/${movie.uuid}`}
                                            />
                                            </a>
                                        </div>
                                        <div className={styles.entryContent}>
                                            <h2 className={styles.entryTitle}>
                                                <a href={`/novosti/film/${movie.uuid}`}>
                                                    {movie.title}
                                                </a>
                                            </h2>
                                            <div className={styles.entryMeta}>
                                                <span className={styles.entryDate}>{new Date(movie.datumKreiranja).toLocaleDateString()}</span>
                                                <span> / </span>
                                                <span className={styles.entryComment}>{movie.film ? movie.film.comment : Math.floor(Math.random() * 1000 + 1)} komentara</span>
                                            </div>
                                        </div>
                                        <div className={styles.clearfix}></div>
                                    </div>
                                ))}
                            </div>
                            <div className={styles.clear}></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
