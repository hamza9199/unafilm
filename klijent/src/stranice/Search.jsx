import React, { useState, useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import styles from './css/Search.module.css';
import Helmet from 'react-helmet'; // Import Helmet for managing document head


const ArticleItem = ({  title, releaseDate, tipMjesta, description, comment, id }) => {
    return (
        <a href={`/arhiva/film/${id}`} className={styles.articleImage}>

        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={styles.entryTitle} itemprop="name headline">
                            <a href={`/arhiva/film/${id}`} rel="bookmark" className={styles.entryTitle} itemprop="url">
                                {title}
                            </a>
                        </h1>
                        <div className={styles.entryInfo}>
                            
                            <a className="url u-url" href={`/arhiva/film/${id}`}>
                                <span className={styles.entryDate}>{new Date(releaseDate).toLocaleDateString()}</span>
                            </a>
                            <span>/</span>
                            <span className={styles.entryCategory}>
                                            {tipMjesta}
                                    
                            
                            </span>
                            <span>/</span>
                            <span className={styles.entryComment}>{comment} komentara</span>
                        </div>
                        <div className={`${styles.entrySummary} entry-summary p-summary`} itemprop="description">
                        <p>
                            {description.length > 300 
                                ? `${description.substring(0, 300)}...` 
                                : description}
                            </p> 
                        </div>
                    </div>
                </div>
            </article>
        </div>
        </a>
    );
};

const NovostItem = ({  title, datumKreiranja, tipNovosti, tekst, id }) => {
    return (
        <a href={`/novosti/film/${id}`} className={styles.articleImage}>

        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={styles.entryTitle} itemprop="name headline">
                            <a href={`/novosti/film/${id}`} rel="bookmark" className={styles.entryTitle} itemprop="url">
                                {title}
                            </a>
                        </h1>
                        <div className={styles.entryInfo}>
                            
                            <a className="url u-url" href={`/novosti/film/${id}`}>
                                <span className={styles.entryDate}>{new Date(datumKreiranja).toLocaleDateString()}</span>
                            </a>
                            <span>/</span>
                            <span className={styles.entryCategory}>
                                            {tipNovosti}
                                    
                            
                            </span>
                            <span>/</span>
                        </div>
                        <div className={`${styles.entrySummary} entry-summary p-summary`} itemprop="description">
                        <p>
                            {
                                tekst.replace(/[#*>]/g, '').length > 300 
                                ? `${tekst.replace(/[#*>]/g, '').substring(0, 300)}...` 
                                : tekst.replace(/[#*>]/g, '')
                            }
                        </p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        </a>
    );
};


const Search = () => {
    const location = useLocation();
    const searchParams = new URLSearchParams(location.search);
    const searchTerm = searchParams.get('query') || '';

    const [articles, setArticles] = useState([]);
    const [novosti, setNovosti] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [combinedResults, setCombinedResults] = useState([]);


    const articlesPerPage = 15;

    useEffect(() => {
        setArticles([]); // Reset articles on new search
        setNovosti([]); // Reset novosti on new search
        const fetchArticles = async () => {
            if (!searchTerm.trim()) return; // Prevent API call if the search term is empty
            setLoading(true);
            setError(null);
            try {
                const response = await fetch(`https://unafilm-production.up.railway.app/server/filmovi/search/${searchTerm}`);
                const data = await response.json();

                if (response.ok) {
                    setArticles(data);
                } else {
                    setError('');
                }
            } catch {
                setError('Error fetching articles. Please try again later.');
            } finally {
                setLoading(false);
            }
        };

        const fetchNovosti = async () => {
            if (!searchTerm.trim()) return; // Prevent API call if the search term is empty
            setLoading(true);
            setError(null);
            try {
                const response = await fetch(`https://unafilm-production.up.railway.app/server/novosti/search/${searchTerm}`);
                const data = await response.json();

                if (response.ok) {
                    setNovosti(data);
                } else {
                    setError('');
                }
            } catch {
                setError('Error fetching articles. Please try again later.');
            } finally {
                setLoading(false);
            }
        };

        fetchArticles();
        fetchNovosti();
    }, [searchTerm]);


        useEffect(() => {
            // Kombinovanje i sortiranje po datumu (noviji prvi)
            const combined = [
                ...articles.map((item) => ({ ...item, type: 'article' })),
                ...novosti.map((item) => ({ ...item, type: 'novost' }))
            ];

            combined.sort((a, b) => {
                const dateA = new Date(a.releaseDate || a.datumKreiranja);
                const dateB = new Date(b.releaseDate || b.datumKreiranja);
                return dateB - dateA;
            });

            setCombinedResults(combined);
            setCurrentPage(1); // Resetuj na prvu stranicu
        }, [articles, novosti]);


        const totalPages = Math.ceil(combinedResults.length / articlesPerPage);
        
    const handlePageChange = (page) => {
        if (page > 0 && page <= totalPages) {
            setCurrentPage(page);
        }
    };

    const currentArticles =  combinedResults.slice(
        (currentPage - 1) * articlesPerPage,
        currentPage * articlesPerPage
    );

    return (
        <>
            <Header />
            <Helmet>
                <title>Pretraga: {searchTerm} - Una Film</title>
                <meta name="description" content={`Pretraga rezultata za: ${searchTerm}`} />
                <meta name="keywords" content={`filmovi, pretraga, ${searchTerm}`} />
                <meta name="author" content="Una Film" />
            </Helmet>
            <Breadcrumb items={[{ name: 'Una Film Distribucija', link: '/' }, { name: `Search: ${searchTerm}`, link: '/search' }]} />
            <div className={styles.container}>
                <LijeviBaner />
                <div className={styles.articleItemsWrapper}>
                    {loading && <p>Loading...</p>}
                    {error && <p className={styles.error}>{error}</p>}
                    {articles.length === 0 && novosti.length === 0 && !loading && !error &&  (
                        <p className={styles.noResults}>Nema rezultata za vašu pretragu.</p>
                    )}
                    {currentArticles.map((item, index) => {
    return item.type === 'article'
        ? <ArticleItem key={index} {...item} />
        : <NovostItem key={index} {...item} />;
})}

                </div>
            </div>
            {combinedResults.length > 0 && !loading && !error && (
    <nav className={styles.pagination}>
        {Array.from({ length: totalPages }, (_, i) => (
            <span
                key={i}
                className={currentPage === i + 1 ? styles.currentPage : styles.pageNumbers}
                onClick={() => handlePageChange(i + 1)}
            >
                {i + 1}
            </span>
        ))}
        {currentPage < totalPages && (
            <span className={styles.nextPage} onClick={() => handlePageChange(currentPage + 1)}>Next »</span>
        )}
    </nav>
)}

            <Footer />
        </>
    );
};

export default Search;
