import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/Novosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import Helmet from 'react-helmet'; // Import Helmet for managing document head
import ReactMarkdown from 'react-markdown'; // Uvozimo ReactMarkdown za renderovanje Markdown sadržaja

const ArticleItem = ({ film, novost }) => {
    return (
        <div className={styles.articleItem}>
            <article className={styles.post}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <a href={`/novosti/film/${novost.id}`} rel="bookmark">
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
                            <a href={`/novosti/film/${novost.id}`} rel="bookmark">
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
    /<(iframe|style)[\s\S]*?>[\s\S]*?<\/\1>/i.test(novost.tekst) // Provjera da li postoji <iframe> ili <style>
      ? 'Trailer Filma'
      : novost.tekst.replace(/[#*>]/g, '').length > 300 
          ? `${novost.tekst.replace(/[#*>]/g, '').substring(0, 300)}...` 
          : novost.tekst.replace(/[#*>]/g, '')
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
    const novostiPerPage = 15;

    useEffect(() => {
        const fetchNovosti = async () => {
            try {
                const response = await axios.get('https://unafilm-production.up.railway.app/server/novosti/');
                setNovosti(response.data);
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

    if (loading) return <p>Loading...</p>;
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
            <div className={styles.container}>
                <LijeviBaner />
                <div className={styles.articleItemsWrapper}>
                    {currentNovosti.map((novost, index) => (
                        <ArticleItem key={index} film={novost?.film} novost={novost} />
                    ))}
                </div>
              
            </div>
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
            <Footer />
        </>
    );
};

export default Novosti;
