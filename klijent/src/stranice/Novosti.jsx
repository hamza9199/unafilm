/* eslint-disable no-useless-escape */
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Novosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import Helmet from 'react-helmet'; // Import Helmet for managing document head
import ReactMarkdown from 'react-markdown'; // Uvozimo ReactMarkdown za renderovanje Markdown sadržaja
import LoadingScreen from '../komponente/LoadingScreen';
import Select from 'react-select';

const ArticleItem = ({ film, novost }) => {
    return (
        <div className={styles.articleItem}>
            <article className={styles.post}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <a href={`/novosti/film/${novost.uuid}`} rel="bookmark">
                        <img
                            width="300"
                            height="133"
                            src={novost.film ? film.imageUrl : novost.image} // Ensure this is correct, otherwise use film.imageUrl properly
                            className={styles.entryImage}
                            alt='Film image'
                            decoding="async"
                        />
                        </a>
                    </div>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={styles.entryTitle}>
                            <a href={`/novosti/film/${novost.uuid}`} rel="bookmark">
                                {novost.title}
                            </a>
                        </h1>
                        <div className={styles.entryInfo}>
                            <span className={styles.entryAuthor}>By {novost.kreator}</span>
                            <span>/</span>
                            <span className={styles.entryDate}>{new Date(novost.datumKreiranja).toLocaleDateString()}</span>
                        </div>
                        <div className={styles.entrySummary}>
                  <p>
  {
    novost.tekst && (
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
    )
    ||
     film?.opis && ( // Provjera da li film.opis nije null ili prazan
      // Provjera da li postoje neprihvaćeni tagovi (<iframe>, <style>, <div>, <img>) ili Markdown tagovi
      /<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/i.test(film.opis) || /[<#\*\-_\[\]]/i.test(film.opis)
        ? film.opis
            .replace(/<(iframe|style|div|img)[\s\S]*?>[\s\S]*?<\/\1>/g, '') // Uklanjanje iframe, style, div, img tagova
            .replace(/<[^>]*>/g, '') // Uklanjanje svih drugih HTML tagova
            .replace(/[\*\#\<_\-_\[\]\>]/g, '') // Uklanjanje Markdown specijalnih znakova
            .substring(0, 300) // Ograničavanje teksta na 300 karaktera
            + (film.opis.length > 300 ? '...' : '') // Dodavanje tri tačke ako je tekst duži od 300 karaktera
        : film.opis
            .replace(/<[^>]*>/g, '') // Ako nema neprihvaćenih tagova, uklanjamo sve HTML tagove
            .replace(/[\*\#\<_\-_\[\]\>]/g, '') // Uklanjanje Markdown specijalnih znakova
            .substring(0, 300) // Ograničavanje teksta na 300 karaktera
            + (film.opis.length > 300 ? '...' : '') // Dodavanje tri tačke ako je tekst duži od 300 karaktera
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

const Novosti = () => {
    const [novosti, setNovosti] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [sortOrder, setSortOrder] = useState('najnovije'); // Default sort order
    const novostiPerPage = 13;

    useEffect(() => {
        const fetchNovosti = async () => {
            try {
                const response = await axios.get('https://unafilm.onrender.com/server/novosti/', {
                    headers: {
                        'x-api-key': 'admin'
                    }
                });
                // Sortiraj po datumu kreiranja (najnoviji prvi)
                const sorted = response.data.sort((a, b) => new Date(b.datumKreiranja) - new Date(a.datumKreiranja));
                setNovosti(sorted);
                setLoading(false);
            } catch {
                setError('Failed to fetch articles');
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

    if (loading) return <LoadingScreen />;
    if (error) return <p>{error}</p>;

    return (
        <>
            <Header />
            <Helmet>
                <title>Novosti - Una Film</title>
                <meta name="description" content="Novosti - Una Film Distribucija" />
                <meta name="keywords" content="Novosti, Una Film, distribucija filmova" />
                <meta name="author" content="Una Film" />
            </Helmet>
            <Breadcrumb items={[{ name: 'Una Film Distribucija', link: '/' }, { name: 'Novosti', link: '/novosti' }]} />
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
                    {currentNovosti.map((novost, index) => (
                        <ArticleItem key={index} film={novost?.film} novost={novost} />
                    ))}
                </div>
            </div>
            <div className={styles.paginationWrapper}>
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
                        <span className={styles.nextPage} onClick={() => handlePageChange(currentPage + 1)}>
                            Next »
                        </span>
                    )}
                </nav>
            </div>
            <Footer />
        </>
    );
};

export default Novosti;
