import React from 'react';
import styles from './css/RelatedArticle.module.css';

const RelatedArticle = ({ articles }) => {
    return (
        <div className={styles.entryRelated}>
            <h3 className={styles.relatedTitle}>Related Article</h3>
            <div className={styles.amyRelated}>
                <div className={styles.row}>
                    {articles.map((article, index) => (
                        <article key={index} className={`${styles.colMd4} ${styles.article}`}>
                            <div className={styles.entryThumb}>
                                <img
                                    width="360"
                                    height="203"
                                    src={article.imageSrc}
                                    alt={article.imageAlt}
                                    className={styles.articleImage}
                                />
                            </div>
                            <h3 className={styles.entryTitle}>
                                <a href={article.link} className={styles.articleLink}>
                                    {article.title}
                                </a>
                            </h3>
                            <div className={styles.entryInfo}>
                                <span className={styles.entryDate}>{article.date}</span>
                                <span>/</span>
                                <span className={styles.entryComment}>{article.comment}</span>
                            </div>
                        </article>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default RelatedArticle;
