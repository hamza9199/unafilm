import React, { useState, useEffect } from 'react';  
import styles from './css/FilmTrejler.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';
import RelatedArticle from '../komponente/RelatedArticle';

const FilmTrejler = () => {
    const [movie, setMovie] = useState(null);

    const articles = [
        {
            title: "Five Nights at Freddy’s 2 (teaser trailer)",
            link: "https://unafilm.ba/2025/04/04/five-nights-at-freddys-2-teaser-trailer/",
            imageSrc: "https://unafilm.ba/wp-content/uploads/2025/04/Untitled-1.png",
            imageAlt: "Five Nights at Freddy's 2 teaser trailer",
            date: "April 4, 2025",
            comment: "0 Comment"
        },
        {
            title: "PREDSTAVLJAMO TRAILER: GOLI PIŠTOLJ",
            link: "https://unafilm.ba/2025/04/04/predstavljamo-trailer-goli-pistolj/",
            imageSrc: "https://unafilm.ba/wp-content/uploads/2025/04/hq720.jpg",
            imageAlt: "Goli Pistolj trailer",
            date: "April 4, 2025",
            comment: "0 Comment"
        },
        {
            title: "TRAILER: M3GUN 2.0",
            link: "https://unafilm.ba/2025/04/03/trailer-m3gun-2-0/",
            imageSrc: "https://unafilm.ba/wp-content/uploads/2025/04/maxresdefault.jpg",
            imageAlt: "M3Gun 2.0 trailer",
            date: "April 3, 2025",
            comment: "0 Comment"
        }
    ];

    useEffect(() => {
        // Simulating an API call to get movie data
        const fetchMovieData = () => {
            // Simulating database structure with structured data (instead of HTML content)
            setMovie({
                title: "Christopher Landon: “Horor i komedija imaju dosta toga sličnog”",
                link: "https://unafilm.ba/2025/04/04/christopher-landon-horor-i-komedija-imaju-dosta-toga-slicnog/",
                imageSrc: "https://unafilm.ba/wp-content/uploads/2025/04/Christopher-Landon-_article.jpg",
                imageAlt: "Christopher Landon Article Image",
                date: "April 4, 2025",
                comment: "0 Comment",
                content: [
                    { type: "text", text: "Blumhouse voli riskirati i podržava projekte koje bi mnogi odbili..." },
                    { type: "image", src: "https://kinofilm.hr/wp-content/uploads/2025/03/Cover-Igra-straha-u-kinima-1500x667-2-1024x455.jpg", alt: "Igra straha - u kinima", caption: "Scena iz filma “Igra straha” (Foto: Universal Pictures)" },
                    { type: "text", text: "U Igri straha udovica..." },
                    { type: "image", src: "https://kinofilm.hr/wp-content/uploads/2025/03/Cover-Igra-straha-u-kinima-1500x667-2-1024x455.jpg", alt: "Igra straha - u kinima", caption: "Scena iz filma “Igra straha” (Foto: Universal Pictures)" },
                    { type: "text", text: "U Igri straha udovica..." },
                    { type: "trailer", src: "https://www.youtube.com/embed/xyz123", title: "Igra straha Trailer" },
                    { type: "text", text: "Film je snimljen prema scenariju..." }
                ],
                preuzeto: "www.kinofilm.hr",
            });
        };

        fetchMovieData(); 
    }, []);

    if (!movie) {
        return <div>Loading...</div>; 
    }

    return (
        <>
            <Header/>
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: movie.title, link: '/novosti/traileri/film/:id' },
                ]}
            />

            <div className={styles.container}>
                <LijeviBaner/>
                <div className={styles.pageContent}>
                    <article id="post-1045" className={styles.article}>
                        <div className={styles.entryTop}>
                            <div className={styles.entryThumb}>
                                <img 
                                    width="990" 
                                    height="440" 
                                    src={movie.imageSrc} 
                                    className={styles.img}
                                    alt={movie.imageAlt}
                                    decoding="async" 
                                />
                            </div>
                        </div>
                        <div className={styles.entryBottom}>
                            <div className={styles.entryMeta}>
                                <div className={styles.entryDate}>
                                    <span className={styles.day}>{movie.date.split(' ')[0]}</span>
                                    <span className={styles.month}>{movie.date.split(' ')[1]}</span>
                                </div>
                                <div className={styles.entryComment}>
                                    <i className="fa fa-comments" aria-hidden="true"></i> {movie.comment}
                                </div>
                            </div>
                            <div className={styles.entryLeft}>
                                <h1 className={styles.entryTitle}>
                                    <a 
                                        href={movie.link} 
                                        className={styles.entryLink}
                                        itemProp="url"
                                    >
                                        {movie.title}
                                    </a>
                                </h1>
                                <div className={styles.entryContent}>
                                    {movie.content.map((item, index) => {
                                        switch (item.type) {
                                            
                                            case 'trailer':
                                                return (
                                                    <div key={index} className={styles.videoWrapper}>
                                                        <iframe 
                                                            width="560" 
                                                            height="315" 
                                                            src={item.src} 
                                                            title={item.title} 
                                                            frameBorder="0" 
                                                            allowFullScreen
                                                        ></iframe>
                                                    </div>
                                                );
                                           
                                                
                                            default:
                                                return null;
                                        }
                                    })}
                                </div>
                            </div>
                        </div>
                        <RelatedArticle articles={articles} />
                    </article>
                </div>
            </div>

            <Footer/>
        </>
    );
};

export default FilmTrejler;
