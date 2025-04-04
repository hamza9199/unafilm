import React from 'react';
import styles from './css/Novosti.module.css';

// Array of films based on your Sequelize Film model structure
const films = [
    {
        title: 'Te sitnice: Povijesna drama o tihim herojima',
        description: 'Povijesna drama koja istražuje tihe heroje...',
        trailerUrl: 'https://example.com/trailer',
        detailsUrl: 'https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/',
        imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/Cover-Te-sitnice-u-kinima-1500x667-1-1024x455-1.jpg',
        imageAlt: 'Te Sitnice Film',
        duration: '1h 40m',
        releaseDate: '2025-03-24',
        categories: ['Drama', 'Historical'],
        author: 'John Doe',
        comment: 5,
        content: { text: 'Detailed content about the movie.' },
        link: 'https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/',
        type: "Iz svijeta filma"
    },
    {
        title: 'Michael Fassbender: Od konobara do holivudske zvijezde',
        description: 'Priča o Michaelu Fassbenderu i njegovoj karijeri...',
        trailerUrl: 'https://example.com/trailer2',
        detailsUrl: 'https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/',
        imageUrl: 'https://unafilm.ba/wp-content/uploads/2025/03/Michael-Fassbender_BlackBag__Universal-Pictures.jpg',
        imageAlt: 'Michael Fassbender Documentary',
        duration: '1h 30m',
        releaseDate: '2025-03-24',
        categories: ['Biography', 'Documentary'],
        author: 'Jane Doe',
        comment: 2,
        content: { text: 'In-depth documentary content.' },
        link: 'https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/',
        type: "Novosti"

    }
];

const Novosti = () => {
    return (
        <section className={styles.novostiSection}>
            <div className={styles.container}>
                <div className={styles.column}>
                    <div className={styles.headingWrapper}>
                        <header className={styles.header}>
                            <span className={styles.separatorLeft}></span>
                            <h2 className={styles.titleHeading}>Novosti</h2>
                            <span className={styles.separatorRight}></span>
                        </header>
                    </div>
                    <div className={styles.blogWrapper}>
                        <div className={styles.row}>
                            {films.map((film, index) => (
                                <div key={index} className={styles.col}>
                                    <div className={styles.entryItem}>
                                        <div className={styles.entryThumb}>
                                            <img
                                                src={film.imageUrl}
                                                alt={film.imageAlt}
                                                className={styles.imga}
                                            />
                                            <div className={styles.entryCat}>{film.type}</div>
                                        </div>
                                        <div className={styles.entryContent}>
                                            <h2 className={styles.entryTitle}>
                                                <a href={film.detailsUrl}>
                                                    {film.title}
                                                </a>
                                            </h2>
                                            <a className={styles.entryBtn} href={film.detailsUrl}>
                                                Pročitaj više
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Novosti;
