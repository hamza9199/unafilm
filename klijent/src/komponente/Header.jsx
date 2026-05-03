import React, { useState, useEffect } from 'react';
import styles from './css/Header.module.css';
import { useNavigate } from 'react-router-dom';
import logo from './../assets/unaFilm141-2.png'; 
import { FaSearch } from 'react-icons/fa'; 

const Header = () => {
    const [isSearchOpen, setIsSearchOpen] = useState(false);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const history = useNavigate(); 
    const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);
  

useEffect(() => {
    const handleResize = () => {
        setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
}, []);

    const toggleSearch = (e) => {
        e.preventDefault();
        setIsSearchOpen(!isSearchOpen);
    
    };

    const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
    };

    const handleSearchInputChange = (e) => {
        setSearchTerm(e.target.value);
    };

    const handleSearchSubmit = (e) => {
        e.preventDefault();
        history(`/search/?query=${searchTerm}`);
    };

    return (
        <header id="masthead" className={styles.header}>
            <div className={styles.container}>
                <div className={styles.logo}>
                    <a href="/">
                        <img src={logo} alt="Una Film Distribucija" />
                    </a>
                </div>
                <nav id="amy-site-nav" className={`${styles.nav} ${isMobileMenuOpen ? styles.mobileOpen : ''}`}>
                    <ul className={styles.menu}>
                        <li className={styles.menuItem}><a href="/">Početna</a></li>
                        <li className={`${styles.menuItem} ${styles.hasSubmenu}`}>
                            <a href="#">Filmovi</a>
                            <ul className={styles.submenu}>
                                <li><a href="/trenutno-u-kinima">Trenutno u kinima</a></li>
                                <li><a href="/uskoro-u-kinima">Uskoro u kinima</a></li>
                                <li><a href="/arhiva">Arhiva</a></li>
                            </ul>
                        </li>
                        <li className={styles.menuItem}><a href="/o-nama">O nama</a></li>
                        <li className={`${styles.menuItem} ${styles.hasSubmenu}`}>
                            <a href="#">Novosti</a>
                            <ul className={styles.submenu}>
                                <li><a href="/novosti">Sve Novosti</a></li>
                                <li><a href="/novosti/iz-svijeta-filma/">Iz Svijeta Filma</a></li>
                                <li><a href="/novosti/traileri/">Traileri</a></li>
                            </ul>
                        </li>
                        <li className={styles.menuItem}><a href="/kontakt">Kontakt</a></li>
                        <li className={styles.searchIcon}>
                            {!isMobileMenuOpen ? (
                                <>
                            <a href="#" role="button" aria-label="Search" onClick={toggleSearch}>
                                <svg width="20" height="20" viewBox="0 0 24 24" className={styles.searchIconSvg} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                </svg>
                            </a>
                            <div className={`${styles.searchBox} ${isSearchOpen ? styles.open : ''}`}>
                                  <form onSubmit={handleSearchSubmit} className={styles.searchForm}>
                                    <div className={styles.searchInputWrapper}>
                                        <FaSearch className={styles.searchIconInput} />
                                        <input
                                            type="text"
                                            placeholder="Pretraži..."
                                            value={searchTerm}
                                            onChange={handleSearchInputChange}
                                            className={styles.searchInput}
                                        />
                                    </div>
                                </form>
                            </div>
                             </>
    ) : (
         <>
                            <a href="#" role="button" aria-label="Search" onClick={toggleSearch}> 
                                <svg width="20" height="20" viewBox="0 0 24 24" className={styles.searchIconSvg} fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                </svg>
                            </a>
                            {isMobile && (
                            <div className={`${styles.searchBox2} ${styles.open}`}>
                                <form onSubmit={handleSearchSubmit}>
                                    <input
                                        type="text"
                                        placeholder="Pretraži..."
                                        value={searchTerm}
                                        onChange={handleSearchInputChange}
                                        className={styles.searchInput2}
                                    />
                                </form>
                            </div>
                        )}
                            </>
                             )}
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
