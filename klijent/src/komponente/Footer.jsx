import React from "react";
import styles from './css/Footer.module.css';

// Define the array of movies
const movies = [
    {
        title: "'Te sitnice': Povijesna drama o tihim herojima",
        imageUrl: "https://unafilm.ba/wp-content/uploads/2025/03/Cover-Te-sitnice-u-kinima-1500x667-1-1024x455-1-115x85_c.jpg",
        link: "https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/",
        releaseDate: "March 24, 2025",
        comments: "0 Comments"
    },
    {
        title: "Michael Fassbender: Od konobara do holivudske zvijezde",
        imageUrl: "https://unafilm.ba/wp-content/uploads/2025/03/Michael-Fassbender_BlackBag__Universal-Pictures-115x85_c.jpg",
        link: "https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/",
        releaseDate: "March 24, 2025",
        comments: "0 Comments"
    }
];

const Footer = () => {
    return (
        <footer id="amy-colophon" className={styles.amySiteFooter}>
            <div className={styles.container}>
                <div className={styles.amyFooterWidgets}>
                    {/* Column 1: Logo Section */}
                    <div className={styles.colMd3}>
                        <div className={styles.amyWidget}>
                            <div className={`${styles.amyWidget} ${styles.about}`}>
                                <h4 className={styles.amyTitle}></h4>
                                <div className={styles.footerLogo}>
                                    <a href="https://unafilm.ba/">
                                        <img
                                            src="https://unafilm.ba/wp-content/uploads/2024/12/unaFilm141-2.png"
                                            alt="Una Film Logo"
                                        />
                                    </a>
                                </div>
                            </div>
                            <div className={styles.clear}></div>
                        </div>
                    </div>

                    {/* Column 2: Navigation Section */}
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

                    {/* Column 3: Latest News Section */}
                    <div className={styles.colMd6}>
                        <div className={styles.amyWidget}>
                            <div className={`${styles.amyWidget} ${styles.listPost}`}>
                                <h4 className={styles.amyTitle}>Zadnje novosti</h4>

                                {/* Loop through movies and render them */}
                                {movies.map((movie, index) => (
                                    <div key={index} className={styles.entryItem}>
                                        <div className={styles.entryThumb}>
                                            <img
                                                src={movie.imageUrl}
                                                alt={movie.title}
                                            />
                                        </div>
                                        <div className={styles.entryContent}>
                                            <h2 className={styles.entryTitle}>
                                                <a href={movie.link}>
                                                    {movie.title}
                                                </a>
                                            </h2>
                                            <div className={styles.entryMeta}>
                                                <span className={styles.entryDate}>{movie.releaseDate}</span>
                                                <span> / </span>
                                                <span className={styles.entryComment}>{movie.comments}</span>
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
