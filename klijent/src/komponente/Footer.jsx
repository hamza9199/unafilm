import React from "react";
import styles from './css/Footer.module.css';

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

                                <div className={styles.entryItem}>
                                    <div className={styles.entryThumb}>
                                        <img
                                            src="https://unafilm.ba/wp-content/uploads/2025/03/Cover-Te-sitnice-u-kinima-1500x667-1-1024x455-1-115x85_c.jpg"
                                            alt="Te sitnice"
                                        />
                                    </div>
                                    <div className={styles.entryContent}>
                                        <h2 className={styles.entryTitle}>
                                            <a href="https://unafilm.ba/2025/03/24/te-sitnice-povijesna-drama-o-tihim-herojima/">
                                                'Te sitnice': Povijesna drama o tihim herojima
                                            </a>
                                        </h2>
                                        <div className={styles.entryMeta}>
                                            <span className={styles.entryDate}>March 24, 2025</span>
                                            <span> / </span>
                                            <span className={styles.entryComment}>0 Comments</span>
                                        </div>
                                    </div>
                                    <div className={styles.clearfix}></div>
                                </div>

                                <div className={styles.entryItem}>
                                    <div className={styles.entryThumb}>
                                        <img
                                            src="https://unafilm.ba/wp-content/uploads/2025/03/Michael-Fassbender_BlackBag__Universal-Pictures-115x85_c.jpg"
                                            alt="Michael Fassbender"
                                        />
                                    </div>
                                    <div className={styles.entryContent}>
                                        <h2 className={styles.entryTitle}>
                                            <a href="https://unafilm.ba/2025/03/24/michael-fassbender-od-konobara-do-holivudske-zvijezde/">
                                                Michael Fassbender: Od konobara do holivudske zvijezde
                                            </a>
                                        </h2>
                                        <div className={styles.entryMeta}>
                                            <span className={styles.entryDate}>March 24, 2025</span>
                                            <span> / </span>
                                            <span className={styles.entryComment}>0 Comments</span>
                                        </div>
                                    </div>
                                    <div className={styles.clearfix}></div>
                                </div>
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