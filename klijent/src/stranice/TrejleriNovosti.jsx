import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Importing Axios for API requests
import styles from './css/TrejleriNovosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';

const ArticleItem = ({ film, novost }) => {
    return (
        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <img
                            width="300"
                            height="133"
                            src={film.imageUrl} // Ensure this is correct, otherwise use film.imageUrl properly
                            className="attachment-medium size-medium wp-post-image"
                            alt={film.title || 'Film image'}
                            decoding="async"
                        />
                    </div>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={`${styles.entryTitle} entry-title p-name`} itemprop="name headline">
                            <a href={`/novosti/traileri/film/${novost.id}`} rel="bookmark" className="u-url url" itemprop="url">
                                {film.title}
                            </a>
                        </h1>
                        <div className={styles.entryInfo}>
                            <span className={`${styles.entryAuthor} entry-author p-author vcard hcard h-card`} itemtype="http://schema.org/Person" itemprop="author editor publisher">
                                <a className="url uid u-url u-uid fn p-name" rel="author" itemprop="url" >
                                    By {novost.kreator}
                                </a>
                            </span>
                            <span>/</span>
                            <a className="url u-url" href={`/novosti/traileri/film/${novost.id}`}>
                                <span className={styles.entryDate}>{new Date(novost.datumKreiranja).toLocaleDateString()}</span>
                            </a>
                            <span>/</span>
                            <span className={styles.entryCategory}>
                                {/* Check if tipNovosti exists */}
                                {novost.tipNovosti ? (
                                    <span>
                                        <a rel="category tag">
                                            {novost.tipNovosti}
                                        </a>
                                    </span>
                                ) : (
                                    <span>No category</span>  // Fallback if no category
                                )}
                            </span>
                            <span>/</span>
                            <span className={styles.entryComment}>{film.comment} komentara</span>
                        </div>
                        <div className={`${styles.entrySummary} entry-summary p-summary`} itemprop="description">
                            <p>{novost.tekst4}</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    );
};

const TrejleriNovosti = () => {
    const [novosti, setNovosti] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [loading, setLoading] = useState(true); // Loading state
    const [error, setError] = useState(null); // Error state
    const novostiPerPage = 15;

    useEffect(() => {
        // Fetch novosti data from API
        const fetchNovosti = async () => {
            try {
                const response = await axios.get('http://localhost:3000/server/novosti/trailer'); // Replace with your API endpoint
                setNovosti(response.data);
                setLoading(false);
            } catch {
                setError('Failed to fetch novosti');
                setLoading(false);
            }
        };
        
        fetchNovosti();
    }, []);

    const totalPages = Math.ceil(novosti.length / novostiPerPage);

    const handlePageChange = (page) => {
        if (page > 0 && page <= totalPages) {
            setCurrentPage(page);
        }
    };

    const currentNovosti = novosti.slice(
        (currentPage - 1) * novostiPerPage,
        currentPage * novostiPerPage
    );

    return (
        <>
            <Header />
            <Breadcrumb items={[{ name: 'Una Film Distribucija', link: '/' }, { name: 'Novosti', link: '/novosti' }, { name: 'Traileri', link: '/novosti/traileri' }]} />
            <div className={styles.container}>
                <LijeviBaner />
                <div className={styles.articleItemsWrapper}>
                    {loading ? (
                        <p>Loading novosti...</p>
                    ) : error ? (
                        <p>{error}</p>
                    ) : (
                        currentNovosti.map((novost, index) => (
                            novost.film && <ArticleItem key={index} film={novost.film} novost={novost} />
                        ))
                    )}
                </div>
            </div>
            <nav className={styles.pagination}>
                {Array.from({ length: totalPages }, (_, i) => (
                    <span key={i} className={currentPage === i + 1 ? styles.currentPage : styles.pageNumbers} onClick={() => handlePageChange(i + 1)}>
                        {i + 1}
                    </span>
                ))}
                {currentPage < totalPages && (
                    <span className={styles.nextPage} onClick={() => handlePageChange(currentPage + 1)}>Next »</span>
                )}
            </nav>
            <Footer />
        </>
    );
};

export default TrejleriNovosti;
