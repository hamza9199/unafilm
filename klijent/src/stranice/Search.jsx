/* eslint-disable no-useless-escape */
import React, { useState, useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import Header from '../komponente/Header';
import CustomCheckbox from '../komponente/CustomCheckbox';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import styles from './css/Search.module.css';
import Helmet from 'react-helmet';
import { Link } from 'react-router-dom';
import LoadingScreen from '../komponente/LoadingScreen';


const ArticleItem = ({ title, releaseDate, tipMjesta, opis, comment, uuid }) => {
    const link = `/arhiva/film/${uuid}`;
    const parsedOpis = opis
        ? /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(opis) || /[<#\*\-_\[\]]/i.test(opis)
            ? opis.replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '')
                  .replace(/<[^>]*>/g, '')
                  .replace(/[\*\#\<_\-_\[\]\>]/g, '')
                  .substring(0, 300) + (opis.length > 300 ? '...' : '')
            : opis.replace(/<[^>]*>/g, '')
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

const NovostItem = ({ title, datumKreiranja, tipNovosti, tekst, uuid }) => {
    const link = `/novosti/film/${uuid}`;
    const parsedTekst = tekst
        ? /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(tekst) || /[<#\*\-_\[\]]/i.test(tekst)
            ? tekst.replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '')
                  .replace(/<[^>]*>/g, '')
                  .replace(/[\*\#\<_\-_\[\]\>]/g, '')
                  .substring(0, 300) + (tekst.length > 300 ? '...' : '')
            : tekst.replace(/<[^>]*>/g, '')
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
                                <span className={styles.entryComment}>{Math.floor(Math.random() * 1000 + 1)} komentara</span>
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
    const [showMovies, setShowMovies] = useState(true); // State for showing movies
    const [showNovosti, setShowNovosti] = useState(true); // State for showing novosti
    const [combinedResults, setCombinedResults] = useState([]);

    const articlesPerPage = 15;

    useEffect(() => {
        setArticles([]); // Reset articles on new search
        setNovosti([]); // Reset novosti on new search
        setCombinedResults([]); // Reset combined results on new searchs
        const fetchArticles = async () => {
            if (!searchTerm.trim()) return; // Prevent API call if the search term is empty
            setLoading(true);
            setError(null);
            try {
                const response = await fetch(`https://unafilm.onrender.com/server/filmovi/search/${searchTerm}`, {
                    headers: {
                        'x-api-key': 'admin'
                    }
                });
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
            setNovosti([]); // Reset novosti on new search
            setArticles([]);
            setCombinedResults([]); // Reset combined results on new search
            try {
                const response = await fetch(`https://unafilm.onrender.com/server/novosti/search/${searchTerm}`, {
                    headers: {
                        'x-api-key': 'admin'
                    }
                });
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
        // Combine and sort by date (newest first)
        const combined = [
            ...(showMovies ? articles.map(item => ({ ...item, type: 'article' })) : []),
            ...(showNovosti ? novosti.map(item => ({ ...item, type: 'novost' })) : [])
        ];

        combined.sort((a, b) => {
            const dateA = new Date(a.releaseDate || a.datumKreiranja);
            const dateB = new Date(b.releaseDate || b.datumKreiranja);
            return dateB - dateA;
        });

        setCombinedResults(combined);
        setCurrentPage(1); // Reset to first page
    }, [articles, novosti, showMovies, showNovosti]);

    const totalPages = Math.ceil(combinedResults.length / articlesPerPage);

    const handlePageChange = (page) => {
        if (page > 0 && page <= totalPages) {
            setCurrentPage(page);
        }
    };

    const currentArticles = combinedResults.slice(
        (currentPage - 1) * articlesPerPage,
        currentPage * articlesPerPage
    );

    const handleMovieCheckboxChange = () => {
        setShowMovies(!showMovies);
    };

    const handleNovostiCheckboxChange = () => {
        setShowNovosti(!showNovosti);
    };

    return (
        <>
            <Header />
            <Helmet>
                <title>Pretraga: {searchTerm} - Una Film</title>
                <meta name="description" content={`Pretraga rezultata za: ${searchTerm}`} />
                <meta name="keywords" content={`filmovi, pretraga, ${searchTerm}`} />
                <meta name="author" content="Una Film" />
            </Helmet>
            <Breadcrumb items={[
                { name: 'Una Film Distribucija', link: '/' },
                { name: `Rezultati pretrage za: ${searchTerm}`, link: '/search' }
            ]} />
<div className={styles.container}>
<LijeviBaner />
<div className={styles.content}>
<div className={styles.filterCheckboxes}>
    <CustomCheckbox label="Filmovi" checked={showMovies} onChange={handleMovieCheckboxChange} />
    <CustomCheckbox label="Novosti" checked={showNovosti} onChange={handleNovostiCheckboxChange} />
</div>

{loading ? (
<LoadingScreen/>
) : error ? (
<p>{error}</p>
) : currentArticles.length === 0 ? (
<p className={styles.nema}>Nema rezultata za: {searchTerm}</p>
) : (
<>
{currentArticles.map(item =>
item.type === 'article' ? (
<ArticleItem key={item.id} {...item} />
) : (
<NovostItem key={item.id} {...item} />
)
)}
</>
)}
{totalPages > 1 && (
<div className={styles.pagination}>
<button onClick={() => handlePageChange(currentPage - 1)} disabled={currentPage === 1}>
« Prethodna
</button>
<span className={styles.strana}> Strana {currentPage} od {totalPages} </span>
<button onClick={() => handlePageChange(currentPage + 1)} disabled={currentPage === totalPages}>
Sljedeća » </button>
</div>
)}
</div>
</div>
<Footer />
</>
);
};


export default Search;