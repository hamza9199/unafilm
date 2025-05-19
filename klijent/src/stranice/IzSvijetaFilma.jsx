/* eslint-disable no-useless-escape */
import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Importing axios for API requests
import styles from './css/IzSvijetaFilma.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import Helmet from 'react-helmet'; // Import Helmet for managing document head
import LoadingScreen from '../komponente/LoadingScreen';
import Select from 'react-select'; // Importing react-select for dropdown


const ArticleItem = ({ film, novost }) => {
    return (
        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <a href={`/novosti/iz-svijeta-filma/film/${novost.uuid}`} rel="bookmark">
                        <img
                            width="300"
                            height="133"
                            src={novost.film ? film.imageUrl : novost.image} // Ensure this is correct, otherwise use film.imageUrl properly
                            className={styles.entryImage}
                            alt={'Film image'}
                            decoding="async"
                        />
                        </a>
                    </div>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={`${styles.entryTitle} entry-title p-name`} itemprop="name headline">
                            <a href={`/novosti/iz-svijeta-filma/film/${novost.uuid}`} rel="bookmark" className="u-url url" itemprop="url">
                                {novost.title}
                            </a>
                        </h1>
                        <div className={styles.entryInfo}>
                            <span className={`${styles.entryAuthor} entry-author p-author vcard hcard h-card`} itemtype="http://schema.org/Person" itemprop="author editor publisher">
                                <a className="url uid u-url u-uid fn p-name" rel="author" itemprop="url" >
                                    By {novost.kreator}
                                </a>
                            </span>
                            <span>/</span>
                            <a className="url u-url" href={`/novosti/iz-svijeta-filma/film/${novost.uuid}`}>
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
                            <span className={styles.entryComment}>{novost.film ? film.comment : Math.floor(Math.random() * 200 + 1)} komentara</span>
                        </div>
                        <div className={`${styles.entrySummary} entry-summary p-summary`} itemprop="description">
                       <p>
  {
    // Provjera da li postoje neprihvaćeni tagovi (<iframe>, <style>, <div>, <img>) ili Markdown tagovi
    /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(novost.tekst) || /[<#\*\-_\[\]]/i.test(novost.tekst) 
      ? novost.tekst
          .replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '') // Uklanjanje iframe, style, div, img tagova
          .replace(/<[^>]*>/g, '') // Uklanjanje svih drugih HTML tagova
          .replace(/[\*\#\<_\-_\[\]\>]/g, '') // Uklanjanje Markdown specijalnih znakova
          .substring(0, 300) // Ograničavanje teksta na 300 karaktera
          + (novost.tekst.length > 300 ? '...' : '') // Dodavanje tri tačke ako je tekst duži od 300 karaktera
      : novost.tekst
          .replace(/<[^>]*>/g, '') // Ako nema neprihvaćenih tagova, uklanjamo sve HTML tagove
          .replace(/[\*\#\<_\-_\[\]\>]/g, '') // Uklanjanje Markdown specijalnih znakova
          .substring(0, 300) // Ograničavanje teksta na 300 karaktera
          + (novost.tekst.length > 300 ? '...' : '') // Dodavanje tri tačke ako je tekst duži od 300 karaktera
  }
</p>

                       
                        </div>
                    </div>
                </div>
            </article>
        </div>
    );
};




const IzSvijetaFilma = () => {
    const [novosti, setNovosti] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [loading, setLoading] = useState(true); // Loading state
    const [error, setError] = useState(null); // Error state
    const [sortOrder, setSortOrder] = useState('najnovije'); // Default sort order
    const novostiPerPage = 13;

    useEffect(() => {
        // Fetch novosti data from API
        const fetchNovosti = async () => {
            try {
                const response = await axios.get('https://unafilm.onrender.com/server/novosti/svijetfilma', {
                    headers: {
                        'x-api-key': 'admin'
                    }
                }); // Your API endpoint
                 const sorted = response.data.sort((a, b) => new Date(b.datumKreiranja) - new Date(a.datumKreiranja));
                setNovosti(sorted);
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
            <Helmet>
                <title>Iz Svijeta Filma - Una Film</title>
                <meta name="description" content="Novosti iz svijeta filma." />
                <meta name="keywords" content="novosti, film, distribucija" />
                <meta name="author" content="Una Film" />
            </Helmet>
            <Breadcrumb items={[{ name: 'Una Film Distribucija', link: '/' }, { name: 'Novosti', link: '/novosti' }, { name: 'Iz Svijeta Filma', link: '/novosti/iz-svijeta-filma' }]} />
            <div className={styles.opcije}>
                           <label htmlFor="sortSelect" className={styles.sortLabel}>Sortiraj po:</label>
                           <div className={styles.selectWrapper}>
                               <Select
                                   id="sortSelect"
                                   value={{ value: sortOrder, label: sortOrder === 'najnovije' ? 'Najnovije' : 'Najstarije' }}
                                   onChange={option => {
                                       const value = option.value;
                                       setSortOrder(value);
                                       const sorted = [...novosti].sort((a, b) =>
                                           value === 'najnovije'
                                               ? new Date(b.datumKreiranja) - new Date(a.datumKreiranja)
                                               : new Date(a.datumKreiranja) - new Date(b.datumKreiranja)
                                       );
                                       setNovosti(sorted);
                                       setCurrentPage(1);
                                   }}
                                   options={[
                                       { value: 'najnovije', label: 'Najnovije' },
                                       { value: 'najstarije', label: 'Najstarije' }
                                   ]}
                                   isSearchable={false}
                                   styles={{
                                       control: (base) => ({
                                           ...base,
                                           minHeight: 32,
                                           fontSize: 14
                                       }),
                                       dropdownIndicator: (base) => ({
                                           ...base,
                                           padding: 4
                                       }),
                                       valueContainer: (base) => ({
                                           ...base,
                                           padding: '0 6px'
                                       })
                                   }}
                               />
                           </div>
                       </div>
           
            <div className={styles.container}>
                <LijeviBaner />
                <div className={styles.articleItemsWrapper}>
                    {loading ? (
                        <LoadingScreen /> // Loading screen component
                    ) : error ? (
                        <p>{error}</p>
                    ) : (
                        currentNovosti.map((novost, index) => (
                        <ArticleItem key={index} film={novost?.film} novost={novost} />
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

export default IzSvijetaFilma;
