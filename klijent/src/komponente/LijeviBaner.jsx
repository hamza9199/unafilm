import React from 'react';
import styles from './css/LijeviBaner.module.css';

// Component for rendering each film item
const FilmItem = ({ src, alt, title, duration, link }) => {
    return (
        <div className={styles.entryItem}>
            <div className={styles.entryThumb}>
                <img className={styles.image} src={src} alt={alt} />
            </div>
            <div className={styles.entryContent}>
                <h2 className={styles.entryTitle}>
                    <a href={link}>{title}</a>
                </h2>
                <div>
                    <span className={styles.duration}>
                        <i className="fa fa-clock-o"></i> {duration}
                    </span>
                </div>
            </div>
        </div>
    );
};

// Main Sidebar component
const LijeviBaner = () => {
    const films = [
        {
            src: "https://unafilm.ba/wp-content/uploads/2025/03/Drop-1080x1920-IG-Story-118x159_c.jpg",
            alt: "IGRA STRAHA",
            title: "IGRA STRAHA",
            duration: "01 sati 40 minuta",
            link: "https://unafilm.ba/movie/igra-straha/"
        },
        {
            src: "https://unafilm.ba/wp-content/uploads/2025/03/BAYOU-THE-1080x1920px-WEB-INSTAGRAM-118x159_c.jpg",
            alt: "MOČVARA",
            title: "MOČVARA",
            duration: "01 sati 27 minuta",
            link: "https://unafilm.ba/movie/mocvara/"
        },
        {
            src: "https://unafilm.ba/wp-content/uploads/2025/03/PENGUIN-LESSONS-THE-1080x1920px-WEB-INSTAGRAM-118x159_c.jpg",
            alt: "PINGVINOVE LEKCIJE",
            title: "PINGVINOVE LEKCIJE",
            duration: "01 sati 50 minuta",
            link: "https://unafilm.ba/movie/pingvinove-lekcije/"
        },
        {
            src: "https://unafilm.ba/wp-content/uploads/2025/03/September-5-1080x1920-IG-Story-118x159_c.jpg",
            alt: "PETI SEPTEBMAR",
            title: "PETI SEPTEBMAR",
            duration: "01 sati 35 minuta",
            link: "https://unafilm.ba/movie/peti-septembar/"
        },
    ];

    const newsItems = [
        {
            src: "https://unafilm.ba/wp-content/uploads/2025/03/Cover-Te-sitnice-u-kinima-1500x667-1-1024x455-1-115x85_c.jpg",
            alt: "Te sitnice u kinima",
            title: "‘Te sitnice’: Povijesna drama o tihim herojima",
            date: "March 24, 2025",
            link: "https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/"
        },
        {
            src: "https://unafilm.ba/wp-content/uploads/2025/03/Michael-Fassbender_BlackBag__Universal-Pictures-115x85_c.jpg",
            alt: "Michael Fassbender",
            title: "Michael Fassbender: Od konobara do holivudske zvijezde",
            date: "March 24, 2025",
            link: "https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/"
        }
    ];

    return (
        <aside id="sidebar" className={styles.sidebar}>
            <div className={styles.widgetBlock}>
                <figure className={styles.wpBlockImage}>
                    <img
                        fetchpriority="high"
                        decoding="async"
                        width="320"
                        height="320"
                        src="https://unafilm.ba/wp-content/uploads/2024/12/unaFilm-2.jpg"
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
                        src={film.src}
                        alt={film.alt}
                        title={film.title}
                        duration={film.duration}
                        link={film.link}
                    />
                ))}
            </div>
            <div className={styles.widgetList}>
                <h4 className={styles.widgetTitle}>Najnovije vijesti</h4>
                {newsItems.map((item, index) => (
                    <div key={index} className={styles.entryItem}>
                        <div className={styles.entryThumb2}>
                            <img
                                src={item.src}
                                alt={item.alt}
                                className={styles.image2}
                            />
                        </div>
                        <div className={styles.entryContent}>
                            <h2 className={styles.entryTitle}>
                                <a href={item.link}>{item.title}</a>
                            </h2>
                            <div className={styles.entryMeta}>
                                <span className={styles.entryDate}>{item.date}</span>
                                <span> / </span>
                                <span className={styles.entryComment}>0 Comments</span>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </aside>
    );
};

export default LijeviBaner;
