import React from 'react';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/Onama.module.css';
import Breadcrumb from '../komponente/Breadcrumb';
import slika1 from './../assets/img_52-1.jpg'; // Adjust the path as necessary
import slika2 from './../assets/img_53-1.jpg'; // Adjust the path as necessary
import slika3 from './../assets/img_54-1.jpg'; // Adjust the path as necessary
import slika4 from './../assets/img_56-1.jpg'; // Adjust the path as necessary
import slika5 from './../assets/img_57-1.jpg'; // Adjust the path as necessary
import slika6 from './../assets/img_58-1.jpg'; // Adjust the path as necessary
import Helmet from 'react-helmet'; // Import Helmet for managing document head



const Onama = () => {
    const images = [
        slika1,
        slika2,
        slika3,
        slika4,
        slika5,
        slika6,
    ];

    return (
        <>
            <Header />
            <Helmet>
                <title>O nama - Una Film</title>
                <meta name="description" content="O nama - Una Film Distribucija" />
                <meta name="keywords" content="O nama, Una Film, distribucija filmova" />
                <meta name="author" content="Una Film" />
            </Helmet>
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
