import React from 'react';
import styles from './css/Novosti.module.css';

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
                            <div className={styles.col}>
                                <div className={styles.entryItem}>
                                    <div className={styles.entryThumb}>
                                        <img
                                            src="https://unafilm.ba/wp-content/uploads/2025/03/Cover-Te-sitnice-u-kinima-1500x667-1-1024x455-1.jpg"
                                            alt=""
                                            className={styles.imga}
                                        />
                                        <div className={styles.entryCat}>Iz svijeta filma</div>
                                    </div>
                                    <div className={styles.entryContent}>
                                        <h2 className={styles.entryTitle}>
                                            <a href="https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/">
                                                ‘Te sitnice’: Povijesna drama o tihim herojima
                                            </a>
                                        </h2>
                                        <a className={styles.entryBtn} href="https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/">
                                            Pročitaj više
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div className={styles.col}>
                                <div className={styles.entryItem}>
                                    <div className={styles.entryThumb}>
                                        <img
                                            src="https://unafilm.ba/wp-content/uploads/2025/03/Michael-Fassbender_BlackBag__Universal-Pictures.jpg"
                                            alt=""
                                            className={styles.imga}
                                        />
                                        <div className={styles.entryCat}>Iz svijeta filma</div>
                                    </div>
                                    <div className={styles.entryContent}>
                                        <h2 className={styles.entryTitle}>
                                            <a href="https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/">
                                                Michael Fassbender: Od konobara do holivudske zvijezde
                                            </a>
                                        </h2>
                                        <a className={styles.entryBtn} href="https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/">
                                            Pročitaj više
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Novosti;
