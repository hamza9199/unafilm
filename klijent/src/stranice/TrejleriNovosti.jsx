/* eslint-disable no-useless-escape */
import React, { useState, useEffect } from 'react';
import axios from 'axios'; 
import styles from './css/TrejleriNovosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import Helmet from 'react-helmet'; 
import LoadingScreen from '../komponente/LoadingScreen';
import Select from 'react-select';


const ArticleItem = ({ film, novost }) => {
    return (
        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <a href={`/novosti/traileri/film/${novost.uuid}`} rel="bookmark" >
                        <img
                            width="300"
                            height="133"
                            src={novost.film ? film.imageUrl : novost.image} 
                            className={styles.entryImage}
                            alt={'Film image'}
                            decoding="async"
                        />
                        </a>
                    </div>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={`${styles.entryTitle} entry-title p-name`} itemprop="name headline">
                            <a href={`/novosti/traileri/film/${novost.uuid}`} rel="bookmark" className="u-url url" itemprop="url">
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
                            <a className="url u-url" href={`/novosti/traileri/film/${novost.uuid}`}>
                                <span className={styles.entryDate}>{new Date(novost.datumKreiranja).toLocaleDateString()}</span>
                            </a>
                            <span>/</span>
                            <span className={styles.entryCategory}>
                                {novost.tipNovosti ? (
                                    <span>
                                        <a rel="category tag">
                                            {novost.tipNovosti}
                                        </a>
                                    </span>
                                ) : (
                                    <span>No category</span>  
                                )}
                            </span>
                            <span>/</span>
                            <span className={styles.entryComment}>{novost.film ? film.comment : Math.floor(Math.random() * 1000 + 1)} komentara</span>
                        </div>
                        <div className={`${styles.entrySummary} entry-summary p-summary`} itemprop="description">
                         <p>
  {
    film?.opis && ( 
      /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(film.opis) || /[<#\*\-_\[\]]/i.test(film.opis)
        ? film.opis
            .replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '') 
            .replace(/<[^>]*>/g, '') 
            .replace(/[\*\#\<_\-_\[\]\>]/g, '')
            .substring(0, 300) 
            + (film.opis.length > 300 ? '...' : '') 
        : film.opis
            .replace(/<[^>]*>/g, '') 
            .replace(/[\*\#\<_\-_\[\]\>]/g, '') 
            .substring(0, 300) 
            + (film.opis.length > 300 ? '...' : '') 
    )
    || novost.tekst && (
        /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(novost.tekst) || /[<#\*\-_\[\]]/i.test(novost.tekst) 
      ? novost.tekst
          .replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '') 
          .replace(/<[^>]*>/g, '') 
          .replace(/[\*\#\<_\-_\[\]\>]/g, '') 
          .substring(0, 300) 
          + (novost.tekst.length > 300 ? '...' : '') 
      : novost.tekst
          .replace(/<[^>]*>/g, '') 
          .replace(/[\*\#\<_\-_\[\]\>]/g, '') 
          .substring(0, 300) 
          + (novost.tekst.length > 300 ? '...' : '') 
    )
  }
</p>

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
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null); 
    const [sortOrder, setSortOrder] = useState('najnovije'); 
    
    const novostiPerPage = 13;

    useEffect(() => {
        const fetchNovosti = async () => {
            try {
                const response = await axios.get('https://unafilm-34ky.onrender.com/server/novosti/trailer', {
                    headers: {
                        'x-api-key': 'admin'
                    }
                }); 
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
                <title>Trejleri i novosti - Una Film</title>
                <meta name="description" content="Trejleri i novosti - Una Film" />
                <meta name="keywords" content="filmovi, trejleri, novosti, Una Film" />
                <meta name="author" content="Una Film" />
            </Helmet>
            <Breadcrumb items={[{ name: 'Una Film Distribucija', link: '/' }, { name: 'Novosti', link: '/novosti' }, { name: 'Traileri', link: '/novosti/traileri' }]} />
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
                        <LoadingScreen /> 
                    ) : error ? (
                        <p>{error}</p>
                    ) : (
                        currentNovosti.map((novost, index) => (
                             <ArticleItem key={index} film={novost.film || null} novost={novost} /> ))
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
