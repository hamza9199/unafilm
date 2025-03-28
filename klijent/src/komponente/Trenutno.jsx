import React from 'react';
import styles from './css/Trenutno.module.css';
import Slider from 'react-slick'; 
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css'; 

const Trenutno = () => {
  const settings = {
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    infinite: true,
    arrows: false,

  };

  const films = [
    {
      title: "PETI SEPTEMBAR",
      releaseDate: "March 27, 2025",
      link: "https://unafilm.ba/movie/peti-septembar/",
      imageUrl: "https://unafilm.ba/wp-content/uploads/2025/02/NVC_INTL_2025x3000_Online_Operation_TSR_1_Sheet_BIH-scaled-174x300_c.jpg",
      duration: "01 sati 35 minuta",
      description: "Film „Peti septembar“ govori o ključnom trenutku koji je zauvijek promenio medijski prenos i čiji uticaj u emitovanju vijesti uživo ..."
    },
    {
      title: "PETI SEPTEMBAR",
      releaseDate: "March 27, 2025",
      link: "https://unafilm.ba/movie/peti-septembar/",
      imageUrl: "https://unafilm.ba/wp-content/uploads/2025/02/NVC_INTL_2025x3000_Online_Operation_TSR_1_Sheet_BIH-scaled-174x300_c.jpg",
      duration: "01 sati 35 minuta",
      description: "Film „Peti septembar“ govori o ključnom trenutku koji je zauvijek promenio medijski prenos i čiji uticaj u emitovanju vijesti uživo ..."
    },{
      title: "PETI SEPTEMBAR",
      releaseDate: "March 27, 2025",
      link: "https://unafilm.ba/movie/peti-septembar/",
      imageUrl: "https://unafilm.ba/wp-content/uploads/2025/02/NVC_INTL_2025x3000_Online_Operation_TSR_1_Sheet_BIH-scaled-174x300_c.jpg",
      duration: "01 sati 35 minuta",
      description: "Film „Peti septembar“ govori o ključnom trenutku koji je zauvijek promenio medijski prenos i čiji uticaj u emitovanju vijesti uživo ..."
    },{
      title: "PETI SEPTEMBAR",
      releaseDate: "March 27, 2025",
      link: "https://unafilm.ba/movie/peti-septembar/",
      imageUrl: "https://unafilm.ba/wp-content/uploads/2025/02/NVC_INTL_2025x3000_Online_Operation_TSR_1_Sheet_BIH-scaled-174x300_c.jpg",
      duration: "01 sati 35 minuta",
      description: "Film „Peti septembar“ govori o ključnom trenutku koji je zauvijek promenio medijski prenos i čiji uticaj u emitovanju vijesti uživo ..."
    },{
      title: "PETI SEPTEMBAR",
      releaseDate: "March 27, 2025",
      link: "https://unafilm.ba/movie/peti-septembar/",
      imageUrl: "https://unafilm.ba/wp-content/uploads/2025/02/NVC_INTL_2025x3000_Online_Operation_TSR_1_Sheet_BIH-scaled-174x300_c.jpg",
      duration: "01 sati 35 minuta",
      description: "Film „Peti septembar“ govori o ključnom trenutku koji je zauvijek promenio medijski prenos i čiji uticaj u emitovanju vijesti uživo ..."
    },{
      title: "PETI SEPTEMBAR",
      releaseDate: "March 27, 2025",
      link: "https://unafilm.ba/movie/peti-septembar/",
      imageUrl: "https://unafilm.ba/wp-content/uploads/2025/02/NVC_INTL_2025x3000_Online_Operation_TSR_1_Sheet_BIH-scaled-174x300_c.jpg",
      duration: "01 sati 35 minuta",
      description: "Film „Peti septembar“ govori o ključnom trenutku koji je zauvijek promenio medijski prenos i čiji uticaj u emitovanju vijesti uživo ..."
    },
  ];


  return (
    <div>
      <h2 className={styles.title}>Trenutno u kinima</h2>
    <div className={styles.container}>
      <Slider {...settings}>
        
          
        
        {films.map((film, index) => (
          <div 
            className={styles.movieItem} 
            key={index}
          >
            <div className={styles.movieFront}></div>
            <div className={styles.movieFront}>
              <a href={film.link} className={styles.moviePoster}>
                <img 
                  src={film.imageUrl}
                  alt={film.title}
                  className={styles.movieImage}
                />
              </a>

                
            </div>

            <a href={film.link}>{film.title}</a>
            <p className={styles.releaseDate}>{film.releaseDate}</p>

            <div className={styles.movieContent}>
                <h3 className={styles.movieTitle}>
                  <a href={film.link}>{film.title}</a>
                </h3>

                <p className={styles.duration}>{film.duration}</p>
                <p className={styles.description}>{film.description}</p>
                <p className={styles.releaseDate}>Datum izlaska:  {film.releaseDate}</p>
                <a href={film.link} className={styles.watchButton}>
                 Gledaj

                </a>
                <a href={film.link} className={styles.infoButton}>
                 Info

                </a>
              </div>

          </div>

          
          
        ))}

        
      </Slider>

     
    </div>
    </div>
  );
};

export default Trenutno;
