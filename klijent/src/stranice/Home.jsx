import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Novosti from '../komponente/Novosti';
import Trejleri from '../komponente/Trejleri';
import Istaknuto from '../komponente/Istaknuto';
import Uskoro from '../komponente/Uskoro';
import Trenutno from '../komponente/Trenutno';
import styles from './css/Home.module.css';
import { Helmet } from 'react-helmet';
import { Carousel } from '../komponente/Carusel';
import React, { useEffect, useState } from 'react';
import axios from 'axios';

function Home() {
  const [carouselData, setCarouselData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchFilms = async () => {
      try {
        const uskoroRes = await axios.get('https://unafilm-34ky.onrender.com/server/filmovi/uskoro', {
          headers: { 'x-api-key': 'admin' }
        });
        const trenutnoRes = await axios.get('https://unafilm-34ky.onrender.com/server/filmovi/trenutno', {
          headers: { 'x-api-key': 'admin' }
        });
        const combined = [...uskoroRes.data, ...trenutnoRes.data];
        const shuffled = combined.sort(() => Math.random() - 0.5).slice(0, 6);
        const carouselItems = shuffled.map(film => ({
          src: film.imageUrl,
          alt: film.title || '',
          uuid: film.uuid,
          title: film.title,
          opis: film.opis,
          trailerUrl: film.trailerUrl
        }));
        setCarouselData(carouselItems);
        setLoading(false);
      } catch  {
        setError('Greška pri učitavanju filmova');
        setLoading(false);
      }
    };
    fetchFilms();
  }, []);

 

  return (
    <>
      <Header />
      <Helmet>
        <title>Početna - Una Film Distribucija</title>
        <meta name="description" content="Dobrodošli na zvaničnu stranicu Una Film Distribucija. Istražite najnovije filmove i serije." />
        <link rel="canonical" href="https://www.unafilm.ba/" />
        <meta name="keywords" content="Una Film, filmovi, serije, distribucija, kino, trejleri" />
        <meta name="author" content="Una Film" />
        <meta property="og:title" content="Početna - Una Film Distribucija" />
        <meta property="og:description" content="Dobrodošli na zvaničnu stranicu Una Film Distribucija. Istražite najnovije filmove i serije." />
        <meta property="og:url" content="https://www.unafilm.ba/" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://www.unafilm.ba/unaFilm141-2.png" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Početna - Una Film Distribucija" />
        <meta name="twitter:description" content="Dobrodošli na zvaničnu stranicu Una Film Distribucija. Istražite najnovije filmove i serije." />
        <meta name="twitter:image" content="https://www.unafilm.ba/unaFilm141-2.png" />
      </Helmet>
      {loading ? (
        <div style={{textAlign: 'center', margin: '40px'}}>Učitavanje...</div>
      ) : error ? (
        <div style={{textAlign: 'center', margin: '40px'}}>{error}</div>
      ) : (
        <div style={{position: 'relative'}}>
          <Carousel
            data={carouselData}
            
          />
          
        </div>
      )}
      <div className={styles.kon}>
        <Trenutno/>
        <Uskoro/>
      </div>
      <Trejleri/>
      <Novosti/>
      <Footer />
    </>
  );
}

export default Home;