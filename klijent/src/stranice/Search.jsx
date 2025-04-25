/* eslint-disable no-useless-escape */
import React, { useState, useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import styles from './css/Search.module.css';
import Helmet from 'react-helmet'; // Import Helmet for managing document head
import { Link } from 'react-router-dom';

const ArticleItem = ({ title, releaseDate, tipMjesta, opis, comment, id }) => {
    const link = `/arhiva/film/${id}`;

    const parsedOpis = opis
        ? /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(opis) || /[<#\*\-_\[\]]/i.test(opis)
            ? opis
                  .replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '')
                  .replace(/<[^>]*>/g, '')
                  .replace(/[\*\#\<_\-_\[\]\>]/g, '')
                  .substring(0, 300) + (opis.length > 300 ? '...' : '')
            : opis
                  .replace(/<[^>]*>/g, '')
                  .replace(/[\*\#\<_\-_\[\]\>]/g, '')
                  .substring(0, 300) + (opis.length > 300 ? '...' : '')
        : '';

    return (
        <Link to={link} className={styles.articleImage}>
            <div className={styles.articleItem}>
                <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                    <div className={styles.row}>
                        <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                            <h1 className={styles.entryTitle} itemProp="name headline">
                                {title}
                            </h1>
                            <div className={styles.entryInfo}>
                                <span className={styles.entryDate}>
                                    {new Date(releaseDate).toLocaleDateString()}
                                </span>
                                <span>/</span>
                                <span className={styles.entryCategory}>
                                    {tipMjesta}
                                </span>
                                <span>/</span>
                                <span className={styles.entryComment}>{comment} komentara</span>
                            </div>
                            <div className={`${styles.entrySummary} entry-summary p-summary`} itemProp="description">
                                {opis && <p>{parsedOpis}</p>}
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </Link>
    );
};


const NovostItem = ({ title, datumKreiranja, tipNovosti, tekst, id }) => {
    const link = `/novosti/film/${id}`;
    const parsedTekst = tekst
        ? /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(tekst) || /[<#\*\-_\[\]]/i.test(tekst)
            ? tekst
                  .replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '')
                  .replace(/<[^>]*>/g, '')
                  .replace(/[\*\#\<_\-_\[\]\>]/g, '')
                  .substring(0, 300) + (tekst.length > 300 ? '...' : '')
            : tekst
                  .replace(/<[^>]*>/g, '')
                  .replace(/[\*\#\<_\-_\[\]\>]/g, '')
                  .substring(0, 300) + (tekst.length > 300 ? '...' : '')
        : '';

    return (
        <Link to={link} className={styles.articleImage}>
            <div className={styles.articleItem}>
                <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                    <div className={styles.row}>
                        <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                            <h1 className={styles.entryTitle} itemProp="name headline">
                                {title}
                            </h1>
                            <div className={styles.entryInfo}>
                                <span className={styles.entryDate}>
                                    {new Date(datumKreiranja).toLocaleDateString()}
                                </span>
                                <span>/</span>
                                <span className={styles.entryCategory}>
                                    {tipNovosti}
                                </span>
                                <span>/</span>
                                <span className={styles.entryComment}>10 komentara</span>
                            </div>
                            <div className={`${styles.entrySummary} entry-summary p-summary`} itemProp="description">
                                {tekst && <p>{parsedTekst}</p>}
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </Link>
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
