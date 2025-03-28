import React from 'react';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/Onama.module.css';
import Breadcrumb from '../komponente/Breadcrumb';

const Onama = () => {
    const images = [
        "https://unafilm.ba/wp-content/uploads/2022/05/img_56-1.jpg",
        "https://unafilm.ba/wp-content/uploads/2022/05/img_58-1.jpg",
        "https://unafilm.ba/wp-content/uploads/2022/05/img_57-1.jpg",
        "https://unafilm.ba/wp-content/uploads/2022/05/img_52-1.jpg",
        "https://unafilm.ba/wp-content/uploads/2022/05/img_54-1.jpg",
        "https://unafilm.ba/wp-content/uploads/2022/05/img_53-1.jpg"
    ];

    return (
        <>
            <Header />
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: 'O nama', link: '/o-nama' },
                ]}
            />
            <section className={styles.mainContent}>
                <div className={styles.container}>
                    <div className={styles.row}>
                        <div className={styles.col12}>
                            <div className={styles.pageContent}>
                                <p>
                                    UNA FILM distribuira filmove studija Paramount, Universal i brojne naslove nezavisne i domaće produkcije na teritoriju cijele Bosne i Hercegovine.
                                </p>
                                <p>
                                    UNA FILM distributes the movies from studios Paramount, Universal and numerous independent and local films on the territory of Bosnia and Herzegovina.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div className={styles.row}>
                        <div className={styles.galleryGrid}>
                            {images.map((src, index) => (
                                <div key={index} className={styles.gridItem}>
                                    <a href={src} target="_blank" rel="noopener noreferrer">
                                        <img src={src} alt={`Gallery item ${index + 1}`} />
                                    </a>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>
            <Footer />
        </>
    );
};

export default Onama;
