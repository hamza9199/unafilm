import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styles from './css/RelatedArticle.module.css';

const RelatedArticle = () => {
    const [articles, setArticles] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchArticles = async () => {
            try {
                const response = await axios.get('https://unafilm-34ky.onrender.com/server/novosti' , {
                    headers: {
                        'x-api-key': 'admin'
                    } 
                });
             const novosti = response.data.sort(() => Math.random() - 0.5).slice(0, 3);

                setArticles(novosti); 
                setLoading(false);
            } catch (err) {
                setError(err.message);
                setLoading(false);
            }
        };

        fetchArticles();
    }, []);

    if (loading) {
        return <p>Loading...</p>;
    }

    if (error) {
        return <p>Error: {error}</p>;
    }

    return (
        <div className={styles.entryRelated}>
            <h3 className={styles.relatedTitle}>Related Article</h3>
            <div className={styles.amyRelated}>
                <div className={styles.row}>
                    {articles.map((article, index) => (
                        <article key={index} className={`${styles.colMd4} ${styles.article}`}>
                            <div className={styles.entryThumb}>
                                <a href={`/novosti/film/${article.uuid}`} className={styles.articleLink}>
                                    
                                <img
                                    width="360"
                                    height="203"
                                    src={article.film ? article.film.imageUrl : article.image}
                                    alt=""
                                    className={styles.articleImage}
                                />
                                </a>
                            </div>
                            <h3 className={styles.entryTitle}>
                                <a href={`/novosti/film/${article.uuid}`}className={styles.articleLink}>
                                    {article.title}
                                </a>
                            </h3>
                            <div className={styles.entryInfo}>
                                <span className={styles.entryDate}>{new Date(article.datumKreiranja).toLocaleDateString()}</span>
                                <span>/</span>
                                <span className={styles.entryComment}>{article.film ? article.film.comment : Math.floor(Math.random() * 1000 + 1)} komentara</span>
                            </div>
                        </article>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default RelatedArticle;
