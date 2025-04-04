import React, {useState} from 'react';
import styles from './css/TrejleriNovosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';


const ArticleItem = ({ src, alt, link, title, author, date, categories, summary }) => {
    return (
        <div className={styles.articleItem}>
            <article className={`${styles.post} post-1020 post type-post status-publish format-standard has-post-thumbnail category-iz-svijeta-filma category-novosti h-entry hentry h-as-article`}>
                <div className={styles.row}>
                    <div className={`${styles.entryThumb} col-md-5 col-xs-5 has-thumb`}>
                        <img
                            width="300"
                            height="133"
                            src={src}
                            className="attachment-medium size-medium wp-post-image"
                            alt={alt}
                            decoding="async"
                        />
                    </div>
                    <div className={`${styles.entryContent} col-md-7 col-xs-7 has-thumb`}>
                        <h1 className={`${styles.entryTitle} entry-title p-name`} itemprop="name headline">
                            <a href={link} rel="bookmark" className="u-url url" itemprop="url">
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
                            <a className="url u-url" href={link}>
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


const TrejleriNovosti = () => {
    const articles = Array.from({ length: 30 }, (_, index) => ({
        src: "https://unafilm.ba/wp-content/uploads/2025/03/Cover-Te-sitnice-u-kinima-1500x667-1-1024x455-1-300x133.jpg",
        alt: "Te sitnice",
        link: `/novosti/traileri/film/:id`,
        title: `Te sitnice – Povijesna drama ${index + 1}`,
        author: { name: "unafilm", link:"/novosti/traileri/film/:id" },
        date: "March 24, 2025",
        categories: [{ name: "Novosti", link: "/novosti/traileri/film/:id" }],
        summary: "Opis filma....."
    }));

    const [currentPage, setCurrentPage] = useState(1);
    const articlesPerPage = 15;
    const totalPages = Math.ceil(articles.length / articlesPerPage);

    const handlePageChange = (page) => {
        if (page > 0 && page <= totalPages) {
            setCurrentPage(page);
        }
    };

    const currentArticles = articles.slice(
        (currentPage - 1) * articlesPerPage,
        currentPage * articlesPerPage
    );

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

export default TrejleriNovosti;