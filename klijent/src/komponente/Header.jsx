import React, { useState } from 'react';
import styles from './css/Header.module.css';

const Header = () => {
    const [isSearchOpen, setIsSearchOpen] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

    const toggleSearch = (e) => {
        e.preventDefault();
        setIsSearchOpen(!isSearchOpen);
    };

    const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
    };

    return (
        <header id="masthead" className={styles.header}>
            <div className={styles.container}>
                <div className={styles.logo}>
                    <a href="https://unafilm.ba/">
                        <img src="https://unafilm.ba/wp-content/uploads/2024/12/unaFilm141-2.png" alt="Una Film Distribucija" />
                    </a>
                </div>
                <nav id="amy-site-nav" className={`${styles.nav} ${isMobileMenuOpen ? styles.mobileOpen : ''}`}>
                    <ul className={styles.menu}>
                        <li className={styles.menuItem}><a href="https://unafilm.ba/">Početna</a></li>
                        <li className={`${styles.menuItem} ${styles.hasSubmenu}`}>
                            <a href="#">Filmovi</a>
                            <ul className={styles.submenu}>
                                <li><a href="https://unafilm.ba/trenutno-u-kinima/">Trenutno u kinima</a></li>
                                <li><a href="https://unafilm.ba/uskoro-u-kinima/">Uskoro u kinima</a></li>
                                <li><a href="https://unafilm.ba/arhiva/">Arhiva</a></li>
                            </ul>
                        </li>
                        <li className={styles.menuItem}><a href="/o-nama">O nama</a></li>
                        <li className={`${styles.menuItem} ${styles.hasSubmenu}`}>
                            <a href="http://unafilm.ba/category/novosti">Novosti</a>
                            <ul className={styles.submenu}>
                                <li><a href="https://unafilm.ba/category/novosti/iz-svijeta-filma/">Iz svijeta filma</a></li>
                                <li><a href="https://unafilm.ba/category/novosti/traileri/">Traileri</a></li>
                            </ul>
                        </li>
                        <li className={styles.menuItem}><a href="https://unafilm.ba/kontakt/">Kontakt</a></li>
                        <li className={styles.searchIcon}>
                            <a href="#" role="button" aria-label="Search" onClick={toggleSearch}>
                                <svg width="20" height="20" viewBox="0 0 24 24">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div className={styles.menuToggle} onClick={toggleMobileMenu}>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </header>
    );
};

export default Header;
