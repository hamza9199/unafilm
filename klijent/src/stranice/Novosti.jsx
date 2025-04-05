import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Novosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';

const ArticleItem = ({ imageUrl, alt, title, author, date, categories, summary, id }) => {
    return (
        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <img
                            width="300"
                            height="133"
                            src={imageUrl}
                            className="attachment-medium size-medium wp-post-image"
                            alt={alt}
                            decoding="async"
                        />
                    </div>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={`${styles.entryTitle} entry-title p-name`} itemprop="name headline">
                            <a href={`/novosti/film/${id}`} rel="bookmark" className="u-url url" itemprop="url">
                                {title}
                            </a>
                        </h1>
                        <div className={styles.entryInfo}>
                            <span className={`${styles.entryAuthor} entry-author p-author vcard hcard h-card`} itemtype="http://schema.org/Person" itemprop="author editor publisher">
                                <a className="url uid u-url u-uid fn p-name" rel="author" itemprop="url" href={author.link}>
                                    By {author.name}
                                </a>
                            </span>
                            <span>/</span>
                            <a className="url u-url" href={`/novosti/film/${id}`}>
                                <span className={styles.entryDate}>{date}</span>
                            </a>
                            <span>/</span>
                            <span className={styles.entryCategory}>
                                {categories.map((category, index) => (
                                    <span key={index}>
                                        <a href={category.link} rel="category tag">
                                            {category.name}
                                        </a>
                                        {index < categories.length - 1 && ', '}
                                    </span>
                                ))}
                            </span>
                            <span>/</span>
                            <span className={styles.entryComment}>0 Comment</span>
                        </div>
                        <div className={`${styles.entrySummary} entry-summary p-summary`} itemprop="description">
                            <p>{summary}</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    );
};

const Novosti = () => {
    const [articles, setArticles] = useState([]); // State to store articles
    const [currentPage, setCurrentPage] = useState(1); // Current page for pagination
    const [loading, setLoading] = useState(true); // Loading state
    const [error, setError] = useState(null); // Error state

    const articlesPerPage = 15;

    useEffect(() => {
        const fetchArticles = async () => {
            try {
                const response = await axios.get('http://localhost:3000/server/filmovi/'); // Replace with your API endpoint
                setArticles(response.data); // Set articles from API
                setLoading(false);
            } catch  {
                setError('Failed to fetch articles'); // Handle API error
                setLoading(false);
            }
        };

        fetchArticles(); // Fetch articles when the component mounts
    }, []);

    const totalPages = Math.ceil(articles.length / articlesPerPage); // Calculate total pages

    const handlePageChange = (page) => {
        if (page > 0 && page <= totalPages) {
            setCurrentPage(page);
        }
    };

    const currentArticles = articles.slice(
        (currentPage - 1) * articlesPerPage,
        currentPage * articlesPerPage
    );

    if (loading) {
        return <p>Loading...</p>; // Show loading text if articles are being fetched
    }

    if (error) {
        return <p>{error}</p>; // Show error if there was an issue fetching data
    }

    return (
        <>
            <Header />
            <Breadcrumb items={[{ name: 'Una Film Distribucija', link: '/' }, { name: 'Novosti', link: '/novosti' }]} />
            <div className={styles.container}>
                <LijeviBaner />
                <div className={styles.articleItemsWrapper}>
                    {currentArticles.map((article, index) => (
                        <ArticleItem key={index} {...article} />
                    ))}
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

export default Novosti;
