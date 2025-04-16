import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/AdminDashboard.module.css';
import { Helmet } from 'react-helmet';
import MDEditor from '@uiw/react-md-editor';

const AdminDashboard = () => {
    const [films, setFilms] = useState([]);
    const [novosti, setNovosti] = useState([]);
    const [poruke, setPoruke] = useState([]);
    const [newFilm, setNewFilm] = useState({
        title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '',
        duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro', opis:''
    });
    const [newNovost, setNewNovost] = useState({
        filmId: '', title: '', kreator: '', tekst: '', tekst2: '', tekst3: '', tekst4: '',
        slika1: '', slika2: '', slika3: '', tipNovosti: 'novost'
    });
    const [selectedFilm, setSelectedFilm] = useState(null);
    const [selectedNovost, setSelectedNovost] = useState(null);
    const [selectedOption, setSelectedOption] = useState('');
    const [searchTerm, setSearchTerm] = useState('');
    const [searchTerm2, setSearchTerm2] = useState('');

;
    useEffect(() => {
        fetchFilms();
        fetchNovosti();
        fetchPoruke();
    }, []);

    const handleSearchInputChange = (e) => {
        setSearchTerm(e.target.value);
    };
    const handleSearchInputChange2 = (e) => {
        setSearchTerm2(e.target.value);
    };

    const handleSearchSubmit = (e) => {
        e.preventDefault();
        // Navigate to the search results page with the query
        
    };

    useEffect(() => {
            const fetchArticles = async () => {
                if (!searchTerm.trim()) {
                    try {
                        const response = await axios.get('https://unafilm-production.up.railway.app/server/filmovi');
                        setFilms(response.data);
                    } catch (error) {
                        console.error('Error fetching films:', error);
                    }
                }
                else{
                    try {
                        const response = await fetch(`https://unafilm-production.up.railway.app/server/filmovi/search/${searchTerm}`);
                        const data = await response.json();
        
                        if (response.ok) {
                            setFilms(data);
                        } 
                    } catch {
                        console.error('Error fetching articles. Please try again later.');
                    } 
                }
            };

           
    
            fetchArticles();
    }, [searchTerm]);

    useEffect(() => {
        const fetchArticles2 = async () => {
            if (!searchTerm2.trim()) {
                try {
                    const response = await axios.get('https://unafilm-production.up.railway.app/server/novosti');
                    setNovosti(response.data);
                } catch (error) {
                    console.error('Error fetching novosti:', error);
                }
            }
            else{
                try {
                    const response = await fetch(`https://unafilm-production.up.railway.app/server/novosti/search/${searchTerm2}`);
                    const data = await response.json();

                    if (response.ok) {
                        setNovosti(data);
                    } 
                } catch {
                    console.error('Error fetching articles. Please try again later.');
                } 
            }
        };

       

        fetchArticles2();
    }, [searchTerm2]);

       

 
    
    const handleCreateFilm = async () => {
        const formData = new FormData();
    
        // Dodaj filmove podatke
        formData.append('title', newFilm.title);
        formData.append('description', newFilm.description);
        formData.append('trailerUrl', newFilm.trailerUrl);
        formData.append('duration', newFilm.duration);
        formData.append('reditelj', newFilm.reditelj);
        formData.append('comment', newFilm.comment);
        formData.append('type', newFilm.type);
        formData.append('tipMjesta', newFilm.tipMjesta);
        formData.append('opis', newFilm.opis);

    
    
        // Dodaj slike (ako postoje)
        if (newFilm.imageUrl) {
            formData.append('image1', newFilm.imageUrl); // Prva slika
        }
        if (newFilm.imageUrl2) {
            formData.append('image2', newFilm.imageUrl2); // Druga slika
        }
    
        try {
            // Pošaljemo formData (film i slike) na backend
            const response = await axios.post('https://unafilm-production.up.railway.app/server/filmovi', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data' // Moramo postaviti ovaj header za upload fajlova
                }
            });
    
            // Ako je uspešno, ažuriraj filmsku listu
            fetchFilms();
            setSelectedFilm(null);
            setNewFilm({
                title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '',
                duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro',
                opis:''
            });
            setSelectedOption('films')
            console.log('Film created successfully:', response.data);
        } catch (error) {
            console.error('Error creating film:', error);
        }
    };
    
    
    
    const handleUpdateFilm = async () => {
        const formData = new FormData();
    
        // Dodaj filmove podatke
        formData.append('title', newFilm.title);
        formData.append('description', newFilm.description);
        formData.append('trailerUrl', newFilm.trailerUrl);
        formData.append('duration', newFilm.duration);
        formData.append('reditelj', newFilm.reditelj);
        formData.append('comment', newFilm.comment);
        formData.append('type', newFilm.type);
        formData.append('tipMjesta', newFilm.tipMjesta);
        formData.append('opis', newFilm.opis);

        // Dodaj slike (ako postoje i ako su fajlovi)
        if (newFilm.imageUrl instanceof File) {
            formData.append('image1', newFilm.imageUrl); // Dodaj prvu sliku
        } else if (newFilm.imageUrl) {
            formData.append('image1', newFilm.imageUrl); // Ako je putanja, koristi to
        }
    
        if (newFilm.imageUrl2 instanceof File) {
            formData.append('image2', newFilm.imageUrl2); // Dodaj drugu sliku
        } else if (newFilm.imageUrl2) {
            formData.append('image2', newFilm.imageUrl2); // Ako je putanja, koristi to
        }
    
        try {
            // Pošaljemo formData sa filmom na backend
            const response = await axios.put(`https://unafilm-production.up.railway.app/server/filmovi/${selectedFilm.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data' // Postavljanje headera za fajlove
                }
            });
    
            // Ako je uspešno, ažuriraj filmsku listu
            fetchFilms();
            setSelectedFilm(null);
            setNewFilm({
                title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '',
                duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro',
                opis:''
            });
            setSelectedOption('films')
            console.log('Film updated successfully:', response.data);
        } catch (error) {
            console.error('Error updating film:', error);
        }
    };
    
    
    const handleCreateNovost = async () => {
        const formData = new FormData();
    
        // Dodaj novost podatke
        formData.append('title', newNovost.title);
        formData.append('kreator', newNovost.kreator);
        formData.append('tekst', newNovost.tekst);
        formData.append('tekst2', newNovost.tekst2);
        formData.append('tekst3', newNovost.tekst3);
        formData.append('tekst4', newNovost.tekst4);
        formData.append('tipNovosti', newNovost.tipNovosti);
        formData.append('filmId', newNovost.filmId);


        
        // Dodaj slike (ako postoje i ako su fajlovi)
        if (newNovost.slika1 instanceof File) {
            formData.append('slika1', newNovost.slika1); // Dodaj prvu sliku
        } else if (newNovost.slika1) {
            formData.append('slika1', newNovost.slika1); // Ako je putanja, koristi to
        }
    
        if (newNovost.slika2 instanceof File) {
            formData.append('slika2', newNovost.slika2); // Dodaj drugu sliku
        } else if (newNovost.slika2) {
            formData.append('slika2', newNovost.slika2); // Ako je putanja, koristi to
        }
    
        if (newNovost.slika3 instanceof File) {
            formData.append('slika3', newNovost.slika3); // Dodaj treću sliku
        } else if (newNovost.slika3) {
            formData.append('slika3', newNovost.slika3); // Ako je putanja, koristi to
        }
    
        try {
            // Pošaljemo formData sa novostima na backend
            const response = await axios.post('https://unafilm-production.up.railway.app/server/novosti', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data' // Postavljanje headera za fajlove
                }
            });
    
            // Ako je uspešno, ažuriraj listu novosti
            fetchNovosti();
            setSelectedNovost(null);
            setNewNovost({
                filmId: '', title: '', kreator: '', tekst: '', tekst2: '', tekst3: '', tekst4: '',
                slika1: '', slika2: '', slika3: '', tipNovosti: 'novost'
            });
            setSelectedOption('novosti')
            console.log('Novost created successfully:', response.data);
        } catch (error) {
            console.error('Error creating novost:', error);
        }
    };
    
    
    const handleUpdateNovost = async () => {
        const formData = new FormData();
    
        // Dodaj novost podatke
        formData.append('title', newNovost.title);
        formData.append('kreator', newNovost.kreator);
        formData.append('tekst', newNovost.tekst);
        formData.append('tekst2', newNovost.tekst2);
        formData.append('tekst3', newNovost.tekst3);
        formData.append('tekst4', newNovost.tekst4);
        formData.append('tipNovosti', newNovost.tipNovosti);
        formData.append('filmId', newNovost.filmId);
    
        // Dodaj slike (ako postoje i ako su fajlovi)
        if (newNovost.slika1 instanceof File) {
            formData.append('slika1', newNovost.slika1); // Dodaj prvu sliku
        } else if (newNovost.slika1) {
            formData.append('slika1', newNovost.slika1); // Ako je putanja, koristi to
        }
    
        if (newNovost.slika2 instanceof File) {
            formData.append('slika2', newNovost.slika2); // Dodaj drugu sliku
        } else if (newNovost.slika2) {
            formData.append('slika2', newNovost.slika2); // Ako je putanja, koristi to
        }
    
        if (newNovost.slika3 instanceof File) {
            formData.append('slika3', newNovost.slika3); // Dodaj treću sliku
        } else if (newNovost.slika3) {
            formData.append('slika3', newNovost.slika3); // Ako je putanja, koristi to
        }
    
        try {
            // Pošaljemo formData sa novostima na backend
            const response = await axios.put(`https://unafilm-production.up.railway.app/server/novosti/${selectedNovost.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data' // Postavljanje headera za fajlove
                }
            });
    
            // Ako je uspešno, ažuriraj listu novosti
            fetchNovosti();
            setSelectedNovost(null);
            setNewNovost({
                filmId: '', title: '', kreator: '', tekst: '', tekst2: '', tekst3: '', tekst4: '',
                slika1: '', slika2: '', slika3: '', tipNovosti: 'novost'
            });
            setSelectedOption('novosti')
            console.log('Novost updated successfully:', response.data);
        } catch (error) {
            console.error('Error updating novost:', error);
        }
    };
    
    



    const fetchFilms = async () => {
        try {
            const response = await axios.get('https://unafilm-production.up.railway.app/server/filmovi');
            setFilms(response.data);
        } catch (error) {
            console.error('Error fetching films:', error);
        }
    };

    const fetchNovosti = async () => {
        try {
            const response = await axios.get('https://unafilm-production.up.railway.app/server/novosti');
            setNovosti(response.data);
        } catch (error) {
            console.error('Error fetching novosti:', error);
        }
    };

    const fetchPoruke = async () => {
        try {
            const response = await axios.get('https://unafilm-production.up.railway.app/server/poruke');
            setPoruke(response.data);
        } catch (error) {
            console.error('Error fetching novosti:', error);
        }
    };


    const handleDeleteFilm = async (id) => {
        const confirmed = window.confirm('Da li ste sigurni da želite obrisati ovaj film?');
        if (confirmed) {
            try {
                await axios.delete(`https://unafilm-production.up.railway.app/server/filmovi/${id}`);
                fetchFilms();
            } catch (error) {
                console.error('Error deleting film:', error);
            }
        } else {
            console.log('Film nije obrisan!');
        }
    };
    
    const handleDeleteNovost = async (id) => {
        const confirmed = window.confirm('Da li ste sigurni da želite obrisati ovu novost?');
        if (confirmed) {
            try {
                await axios.delete(`https://unafilm-production.up.railway.app/server/novosti/${id}`);
                fetchNovosti();
            } catch (error) {
                console.error('Error deleting novost:', error);
            }
        } else {
            console.log('Novost nije obrisana!');
        }
    };
    
    const handleDeletePoruke = async (id) => {
        const confirmed = window.confirm('Da li ste sigurni da želite obrisati ovu poruku?');
        if (confirmed) {
            try {
                await axios.delete(`https://unafilm-production.up.railway.app/server/poruke/${id}`);
                fetchPoruke();
            } catch (error) {
                console.error('Error deleting poruka:', error);
            }
        } else {
            console.log('Poruka nije obrisana!');
        }
    };
    

    const handleLogout = () => {
        localStorage.removeItem('adminToken'); // Remove user data from local storage
        window.location.href = '/'; // Redirect to the login page
    };

    const convertToEmbedUrl = (url) => {
        const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/([^/\n\s]+)|(?:.*[?&]v=([^&\n\s]+))|(?:.*[?&]embed=([^&\n\s]+))|(?:.*[?&]watch\?v=([^&\n\s]+)))(?:[^\s]*)?)/;
        const match = url.match(regex);
        if (match) {
          const videoId = match[1] || match[2] || match[3] || match[4];
          return `https://www.youtube.com/embed/${videoId}`;
        }
        return url; // If it's not a valid YouTube URL, return the original URL.
      };
      
      const handleSelectedOption = (opt) => {
        setNewFilm({
            title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '',
            duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro',
            opis:''
        });      
        setNewNovost({
            filmId: '', title: '', kreator: '', tekst: '', tekst2: '', tekst3: '', tekst4: '',
            slika1: '', slika2: '', slika3: '', tipNovosti: 'novost'
        });
        
         setSelectedOption(opt);
      }

    const handleSkiniBazu = async () => {
        try {
            const response = await axios.get('https://unafilm-production.up.railway.app/server/download/database', {
                responseType: 'blob',
            });
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'database.sqlite'); // Specify the file name
            document.body.appendChild(link);
            link.click();
        } catch (error) {
            console.error('Error downloading database:', error);
        }
    }

    const handleSkiniFolder = async () => {
        try {
            const response = await axios.get('https://unafilm-production.up.railway.app/server/download/uploads', {
                responseType: 'blob',
            });
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'uploads.zip'); // Specify the file name
            document.body.appendChild(link);
            link.click();
        } catch (error) {
            console.error('Error downloading folder:', error);
        }
    }

    return (
        <>
            <Header />
            <Helmet>
                <title>Admin Dashboard - Una Film</title>
                <meta name="description" content="Admin dashboard for managing films, news, and messages." />
                <meta name="keywords" content="admin, dashboard, Una Film, films, news, messages" />
                <meta name="author" content="Una Film" />
                

            </Helmet>
            <div className={styles.container}>
                <aside className={styles.sidebar}>
                    <nav className={styles.nav}>
                        <ul className={styles.ul}>
                            <li className={styles.li2}>
                                <img src='https://unafilm.ba/wp-content/uploads/2024/12/unaFilm141-2.png'></img>
                            </li>
                            <li className={styles.li2}></li>
                            <li className={styles.li2}></li>
                            <li className={styles.li} onClick={() => handleLogout()}>Logout</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('pretragaFilmova')}>Pretraga Filmova</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('pretragaNovosti')}>Pretraga Novosti</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('poruke')}>Sve Poruke</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('createFilm')}>Kreiraj Film</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('createNovost')}>Kreiraj Novost</li>
                            <li className={styles.li} onClick={() => handleSkiniBazu()}>Skini Bazu</li>                       
                            <li className={styles.li} onClick={() => handleSkiniFolder()}>Skini Folder Svih Slika</li>                                              
                            <li className={styles.li2}></li>
                            <li className={styles.li2}></li>
                            <li className={styles.li2}></li>


                        </ul>
                    </nav>
                </aside>
                <main className={styles.content}>

                    {selectedOption === 'pretragaFilmova' && 
                        <section className={styles.section}>
                        <h2 className={styles.h2}>Filmovi</h2>
                         <div className={`${styles.searchBox} `}>
                                                        <form onSubmit={handleSearchSubmit}>
                                                            <input
                                                                type="text"
                                                                placeholder="Pretraži..."
                                                                value={searchTerm}
                                                                onChange={handleSearchInputChange}
                                                            />
                                                        </form>
                                                    </div>
                        <table className={styles.table}>
                            <thead className={styles.thead}>
                                <tr className={styles.tr}>
                                    <th className={styles.th}>Title</th>
                                    <th className={styles.th}>Actions</th>
                                </tr>
                            </thead>
                            <tbody className={styles.tbody}>
                                {films.map((film) => (
                                    <tr key={film.id} className={styles.tr}>
                                        <td className={styles.td}>{film.title}</td>
                                        <td className={styles.td}>
                                            <a className={styles.button} onClick={() => {
                                                setSelectedFilm(film); 
                                                setNewFilm(film); // Pre-populate form with selected film's data
                                                setSelectedOption('updateFilm');
                                            }}>
                                        <svg
                                        fill="#000000"
                                        height="20px"
                                        width="20px"
                                        version="1.1"
                                        id="Capa_1"
                                        viewBox="0 0 24.758 24.758"
                                        xmlSpace="preserve"
                                        >
                                        <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                                        <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                            <g id="c188_arrow">
                                                <path
                                                id="_x3C_Group_x3E__6_"
                                                d="M12.527,0.003c0.013,0,0.015,0,0.019,0c0.007,0,0.007,0,0.009,0c0,0,0,0,0.004,0l0,0 c0.002,0,0.008,0,0.01,0c0.004,0,0.004,0,0.004,0s0,0,0.003,0c0.026-0.006,0.035-0.002,0.054-0.002 c3.205,0,6.32,1.271,8.621,3.503l2.536-2.569c0.122-0.123,0.31-0.16,0.461-0.094c0.159,0.065,0.264,0.219,0.264,0.392v8.351 c0,0.234-0.19,0.424-0.422,0.424h-8.246c-0.005,0-0.013,0-0.019,0c-0.236,0-0.424-0.189-0.424-0.424 c0-0.159,0.085-0.296,0.212-0.367l2.499-2.533c-1.482-1.432-3.418-2.213-5.539-2.213c-4.332,0.022-7.858,3.572-7.858,7.97 c0.034,4.328,3.58,7.849,7.979,7.849l-0.009,4.468h-0.06C5.844,24.756,0.29,19.24,0.247,12.378 C0.247,5.609,5.75,0.062,12.527,0.003z"
                                                />
                                            </g>
                                            <g id="Capa_1_6_"></g>
                                            </g>
                                        </g>
                                        </svg>
                                            </a>
                                            <a className={styles.button} onClick={() => handleDeleteFilm(film.id)}>
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>                                           
                                             </a>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </section>
                    }


                    {selectedOption === 'pretragaNovosti' && (
                        <section className={styles.section}>
                            <h2 className={styles.h2}>Novosti</h2>
                            <div className={`${styles.searchBox} `}>
                                                        <form onSubmit={handleSearchSubmit}>
                                                            <input
                                                                type="text"
                                                                placeholder="Pretraži..."
                                                                value={searchTerm2}
                                                                onChange={handleSearchInputChange2}
                                                            />
                                                        </form>
                                                    </div>
                            <table className={styles.table}>
                                <thead className={styles.thead}>
                                    <tr className={styles.tr}>
                                        <th className={styles.th}>Title</th>
                                        <th className={styles.th}>Actions</th>
                                    </tr>
                                </thead>
                                <tbody className={styles.tbody}>
                                    {novosti.map((novost) => (
                                        <tr key={novost.id} className={styles.tr}>
                                            <td className={styles.td}>{novost.title}</td>
                                            <td className={styles.td}>
                                                <a className={styles.button} onClick={() => {
                                                    setSelectedNovost(novost);
                                                    setNewNovost(novost); // Pre-populate form with selected novost's data
                                                    setSelectedOption('updateNovost');
                                                }}>
                                                     <svg
                                        fill="#000000"
                                        height="20px"
                                        width="20px"
                                        version="1.1"
                                        id="Capa_1"
                                        viewBox="0 0 24.758 24.758"
                                        xmlSpace="preserve"
                                        >
                                        <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                                        <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                            <g id="c188_arrow">
                                                <path
                                                id="_x3C_Group_x3E__6_"
                                                d="M12.527,0.003c0.013,0,0.015,0,0.019,0c0.007,0,0.007,0,0.009,0c0,0,0,0,0.004,0l0,0 c0.002,0,0.008,0,0.01,0c0.004,0,0.004,0,0.004,0s0,0,0.003,0c0.026-0.006,0.035-0.002,0.054-0.002 c3.205,0,6.32,1.271,8.621,3.503l2.536-2.569c0.122-0.123,0.31-0.16,0.461-0.094c0.159,0.065,0.264,0.219,0.264,0.392v8.351 c0,0.234-0.19,0.424-0.422,0.424h-8.246c-0.005,0-0.013,0-0.019,0c-0.236,0-0.424-0.189-0.424-0.424 c0-0.159,0.085-0.296,0.212-0.367l2.499-2.533c-1.482-1.432-3.418-2.213-5.539-2.213c-4.332,0.022-7.858,3.572-7.858,7.97 c0.034,4.328,3.58,7.849,7.979,7.849l-0.009,4.468h-0.06C5.844,24.756,0.29,19.24,0.247,12.378 C0.247,5.609,5.75,0.062,12.527,0.003z"
                                                />
                                            </g>
                                            <g id="Capa_1_6_"></g>
                                            </g>
                                        </g>
                                        </svg>
                                                </a>
                                                <a className={styles.button} onClick={() => handleDeleteNovost(novost.id)}>
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>                                           

                                                </a>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </section>
                    )}

                    {selectedOption === 'poruke' && (
                        <section className={styles.section}>
                            <h2 className={styles.h2}>Poruke</h2>
                            <table className={styles.table}>
                                <thead className={styles.thead}>
                                    <tr className={styles.tr}>
                                        <th className={styles.th}>Ime</th>
                                        <th className={styles.th}>Email</th>
                                        <th className={styles.th}>Poruka</th>
                                        <th className={styles.th}>Actions</th>
                                    </tr>
                                </thead>
                                <tbody className={styles.tbody}>
                                    {poruke.map((poruka) => (
                                        <tr key={poruka.id} className={styles.tr}>
                                            <td className={styles.td}>{poruka.ime}</td>
                                            <td className={styles.td}>{poruka.email}</td>
                                            <td className={styles.td}>{poruka.poruka}</td>
                                            <td className={styles.td}>
                                
                                                <a className={styles.button} onClick={() => handleDeletePoruke(poruka.id)}>
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>                                           

                                                </a>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </section>
                    )}

                    {selectedOption === 'films' && (
                        <section className={styles.section}>
                            <h2 className={styles.h2}>Filmovi</h2>
                            <table className={styles.table}>
                                <thead className={styles.thead}>
                                    <tr className={styles.tr}>
                                        <th className={styles.th}>Title</th>
                                        <th className={styles.th}>Actions</th>
                                    </tr>
                                </thead>
                                <tbody className={styles.tbody}>
                                    {films.map((film) => (
                                        <tr key={film.id} className={styles.tr}>
                                            <td className={styles.td}>{film.title}</td>
                                            <td className={styles.td}>
                                                <a className={styles.button} onClick={() => {
                                                    setSelectedFilm(film); 
                                                    setNewFilm(film); // Pre-populate form with selected film's data
                                                    setSelectedOption('updateFilm');
                                                }}>
                                                     <svg
                                        fill="#000000"
                                        height="20px"
                                        width="20px"
                                        version="1.1"
                                        id="Capa_1"
                                        viewBox="0 0 24.758 24.758"
                                        xmlSpace="preserve"
                                        >
                                        <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                                        <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                            <g id="c188_arrow">
                                                <path
                                                id="_x3C_Group_x3E__6_"
                                                d="M12.527,0.003c0.013,0,0.015,0,0.019,0c0.007,0,0.007,0,0.009,0c0,0,0,0,0.004,0l0,0 c0.002,0,0.008,0,0.01,0c0.004,0,0.004,0,0.004,0s0,0,0.003,0c0.026-0.006,0.035-0.002,0.054-0.002 c3.205,0,6.32,1.271,8.621,3.503l2.536-2.569c0.122-0.123,0.31-0.16,0.461-0.094c0.159,0.065,0.264,0.219,0.264,0.392v8.351 c0,0.234-0.19,0.424-0.422,0.424h-8.246c-0.005,0-0.013,0-0.019,0c-0.236,0-0.424-0.189-0.424-0.424 c0-0.159,0.085-0.296,0.212-0.367l2.499-2.533c-1.482-1.432-3.418-2.213-5.539-2.213c-4.332,0.022-7.858,3.572-7.858,7.97 c0.034,4.328,3.58,7.849,7.979,7.849l-0.009,4.468h-0.06C5.844,24.756,0.29,19.24,0.247,12.378 C0.247,5.609,5.75,0.062,12.527,0.003z"
                                                />
                                            </g>
                                            <g id="Capa_1_6_"></g>
                                            </g>
                                        </g>
                                        </svg>
                                                </a>
                                                <a className={styles.button} onClick={() => handleDeleteFilm(film.id)}>
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>                                           

                                                </a>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </section>
                    )}

                    {selectedOption === 'novosti' && (
                        <section className={styles.section}>
                            <h2 className={styles.h2}>Novosti</h2>
                            <table className={styles.table}>
                                <thead className={styles.thead}>
                                    <tr className={styles.tr}>
                                        <th className={styles.th}>Title</th>
                                        <th className={styles.th}>Actions</th>
                                    </tr>
                                </thead>
                                <tbody className={styles.tbody}>
                                    {novosti.map((novost) => (
                                        <tr key={novost.id} className={styles.tr}>
                                            <td className={styles.td}>{novost.title}</td>
                                            <td className={styles.td}>
                                                <a className={styles.button} onClick={() => {
                                                    setSelectedNovost(novost);
                                                    setNewNovost(novost); // Pre-populate form with selected novost's data
                                                    setSelectedOption('updateNovost');
                                                }}>
                                                     <svg
                                        fill="#000000"
                                        height="20px"
                                        width="20px"
                                        version="1.1"
                                        id="Capa_1"
                                        viewBox="0 0 24.758 24.758"
                                        xmlSpace="preserve"
                                        >
                                        <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                                        <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                            <g id="c188_arrow">
                                                <path
                                                id="_x3C_Group_x3E__6_"
                                                d="M12.527,0.003c0.013,0,0.015,0,0.019,0c0.007,0,0.007,0,0.009,0c0,0,0,0,0.004,0l0,0 c0.002,0,0.008,0,0.01,0c0.004,0,0.004,0,0.004,0s0,0,0.003,0c0.026-0.006,0.035-0.002,0.054-0.002 c3.205,0,6.32,1.271,8.621,3.503l2.536-2.569c0.122-0.123,0.31-0.16,0.461-0.094c0.159,0.065,0.264,0.219,0.264,0.392v8.351 c0,0.234-0.19,0.424-0.422,0.424h-8.246c-0.005,0-0.013,0-0.019,0c-0.236,0-0.424-0.189-0.424-0.424 c0-0.159,0.085-0.296,0.212-0.367l2.499-2.533c-1.482-1.432-3.418-2.213-5.539-2.213c-4.332,0.022-7.858,3.572-7.858,7.97 c0.034,4.328,3.58,7.849,7.979,7.849l-0.009,4.468h-0.06C5.844,24.756,0.29,19.24,0.247,12.378 C0.247,5.609,5.75,0.062,12.527,0.003z"
                                                />
                                            </g>
                                            <g id="Capa_1_6_"></g>
                                            </g>
                                        </g>
                                        </svg>
                                                </a>
                                                <a className={styles.button} onClick={() => handleDeleteNovost(novost.id)}>
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>                                           

                                                </a>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </section>
                    )}

                    {selectedOption === 'createFilm' && (
                        <section className={styles.updateSection}>
                            <h3 className={styles.h3}>Kreiraj Film</h3>
                            <div className={styles.div}>
                                <label className={styles.label}>Title</label>
                                <input className={styles.input} type="text" placeholder="Title" value={newFilm.title} onChange={(e) => setNewFilm({ ...newFilm, title: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Description</label>
                                <input className={styles.input} type="text" placeholder="Description" value={newFilm.description} onChange={(e) => setNewFilm({ ...newFilm, description: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Trailer URL</label>
                                <input className={styles.input} type="text" placeholder="Trailer URL" value={newFilm.trailerUrl} onChange={(e) => {
                                    const trailerUrl = e.target.value;
                                    const embedUrl = convertToEmbedUrl(trailerUrl);
                                    setNewFilm({ ...newFilm, trailerUrl: embedUrl });
                                    }} />
                            </div>                    
                            <div className={styles.div}>
                                <label className={styles.label}>Image</label>
                                <input
                                    className={styles.input}
                                    type="file"
                                    onChange={(e) => setNewFilm({ ...newFilm, imageUrl: e.target.files[0] })}
                                />
                            </div>
                            <div className={styles.div}>
                                <img src={newFilm.imageUrl} alt="Preview" className={styles.imagePreview} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Image 2</label>
                                <input
                                    className={styles.input}
                                    type="file"
                                    onChange={(e) => setNewFilm({ ...newFilm, imageUrl2: e.target.files[0] })}
                                />
                            </div>
                            <div className={styles.div}>
                                <img src={newFilm.imageUrl2} alt="Preview" className={styles.imagePreview} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Release Date</label>
                                <input className={styles.input} type="date" placeholder="Release Date" value={newFilm.releaseDate} onChange={(e) => setNewFilm({ ...newFilm, releaseDate: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Trajanje</label>
                                <input className={styles.input} type="number" placeholder="Trajanje" value={newFilm.duration} onChange={(e) => setNewFilm({ ...newFilm, duration: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Reditelj</label>
                                <input className={styles.input} type="text" placeholder="Author" value={newFilm.reditelj} onChange={(e) => setNewFilm({ ...newFilm, reditelj: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Comment</label>
                                <input className={styles.input} type="text" placeholder="Comment" value={newFilm.comment} onChange={(e) => setNewFilm({ ...newFilm, comment: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Type</label>
                                <select className={styles.select}
                                    value={newFilm.type}
                                    onChange={(e) => setNewFilm({ ...newFilm, type: e.target.value })}
                                >
                                    <option value="film">Film</option>
                                    <option value="serija">Serija</option>
                                </select>
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Location Type</label>
                                <select className={styles.select}
                                    value={newFilm.tipMjesta}
                                    onChange={(e) => setNewFilm({ ...newFilm, tipMjesta: e.target.value })}
                                >
                                    <option value="uskoro">Uskoro u kinima</option>
                                    <option value="trenutno">Trenutno u kinima</option>
                                    <option value="arhiva">Arhiva</option>

                                </select>
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Opis</label>
                                <input className={styles.input} type="text" placeholder="Opis" value={newFilm.opis} onChange={(e) => setNewFilm({ ...newFilm, opis: e.target.value })} />
                            </div>

                            <button className={styles.button} onClick={handleCreateFilm}>Create Film</button>
                        </section>
                    )}
             


                    {selectedOption === 'updateFilm' && (
    <section className={styles.updateSection}>
        <h3 className={styles.sectionTitle}>Ažuriraj Film</h3>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Title</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.title}
                onChange={(e) => setNewFilm({ ...newFilm, title: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Description</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.description}
                onChange={(e) => setNewFilm({ ...newFilm, description: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Trailer URL</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.trailerUrl}
                onChange={(e) => {
                    const trailerUrl = e.target.value;
                    const embedUrl = convertToEmbedUrl(trailerUrl);
                    setNewFilm({ ...newFilm, trailerUrl: embedUrl });
                  }}
            />
        </div>

       

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Image URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewFilm({ ...newFilm, imageUrl: e.target.files[0]  })}
            />
        </div>
        <div className={styles.formGroup}>
            <img src={newFilm.imageUrl} alt="Preview" className={styles.imagePreview} />
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Image URL2</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewFilm({ ...newFilm, imageUrl2: e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={newFilm.imageUrl2} alt="Preview" className={styles.imagePreview} />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Release Date</label>
            <input
                className={styles.formInput}
                type="date"
                value={newFilm.releaseDate}
                onChange={(e) => setNewFilm({ ...newFilm, releaseDate: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Duration</label>
            <input
                className={styles.formInput}
                type="number"
                value={newFilm.duration}
                onChange={(e) => setNewFilm({ ...newFilm, duration: e.target.value })}
            />
        </div>

       

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Reditelj</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.reditelj}
                onChange={(e) => setNewFilm({ ...newFilm, reditelj: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Comment</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.comment}
                onChange={(e) => setNewFilm({ ...newFilm, comment: e.target.value })}
            />
        </div>

       

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Tip</label>
            <select
                className={styles.formSelect}
                value={newFilm.type}
                onChange={(e) => setNewFilm({ ...newFilm, type: e.target.value })}
            >
                <option value="film">Film</option>
                <option value="serija">Serija</option>
            </select>
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Location Type</label>
            <select
                className={styles.formSelect}
                value={newFilm.tipMjesta}
                onChange={(e) => setNewFilm({ ...newFilm, tipMjesta: e.target.value })}
            >
               <option value="uskoro">Uskoro u kinima</option>
                                    <option value="trenutno">Trenutno u kinima</option>
                                    <option value="arhiva">Arhiva</option>
            </select>
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Opis</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.opis}
                onChange={(e) => setNewFilm({ ...newFilm, opis: e.target.value })}
            />
        </div>

        <button className={styles.updateButton} onClick={handleUpdateFilm}>Update Film</button>
    </section>
)}


{selectedOption === 'updateNovost' && (
    <section className={styles.updateSection}>
        <h3 className={styles.sectionTitle}>Ažuriraj Novost</h3>
        {/* Film Selection */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Film</label>
            <select
                className={styles.formSelect}
                value={newNovost.filmId}
                onChange={(e) => setNewNovost({ ...newNovost, filmId: e.target.value })}
            >
                <option value="">Select a Film</option>
                {films.map((film) => (
                    <option key={film.id} value={film.id}>
                        {film.title}
                    </option>
                ))}
            </select>
        </div>

        {/* Title */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Title</label>
            <input
                className={styles.formInput}
                type="text"
                value={newNovost.title}
                onChange={(e) => setNewNovost({ ...newNovost, title: e.target.value })}
            />
        </div>

        {/* Kreator */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Kreator</label>
            <input
                className={styles.formInput}
                type="text"
                value={newNovost.kreator}
                onChange={(e) => setNewNovost({ ...newNovost, kreator: e.target.value })}
            />
        </div>

        {/* Text 1 */}
        <div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 1</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst}
      onChange={(value) => setNewNovost({ ...newNovost, tekst: value })}
    />
  </div>
</div>

        {/* Text 2 */}
        <div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 2</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst2}
      onChange={(value) => setNewNovost({ ...newNovost, tekst2: value })}
    />
  </div>
</div>

        {/* Text 3 */}
        <div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 3</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst3}
      onChange={(value) => setNewNovost({ ...newNovost, tekst3: value })}
    />
  </div>
</div>

        {/* Text 4 */}
        <div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 4</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst4}
      onChange={(value) => setNewNovost({ ...newNovost, tekst4: value })}
    />
  </div>
</div>


        {/* Image 1 URL */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 1 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika1: e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={newNovost.slika1} alt="Preview" className={styles.imagePreview} />
        </div>

        {/* Image 2 URL */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 2 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika2: e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={newNovost.slika2} alt="Preview" className={styles.imagePreview} />
        </div>

        {/* Image 3 URL */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 3 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika3: e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={newNovost.slika3} alt="Preview" className={styles.imagePreview} />
        </div>

        {/* Type of News */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Tip Novosti</label>
            <select
                className={styles.formSelect}
                value={newNovost.tipNovosti}
                onChange={(e) => setNewNovost({ ...newNovost, tipNovosti: e.target.value })}
            >
                <option value="novost">Obicna Novost</option>
                <option value="svijetfilma">Novost iz svijeta filma</option>
                <option value="trailer">Trailer Novost</option>
            </select>
        </div>

        <button className={styles.updateButton} onClick={handleUpdateNovost}>Update Novost</button>
    </section>
)}



{selectedOption === 'createNovost' && (
    <section className={styles.createSection}>
        <h3 className={styles.sectionTitle}>Kreiraj Novost</h3>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Film</label>
            <select
                className={styles.formSelect}
                value={newNovost.filmId}
                onChange={(e) => setNewNovost({ ...newNovost, filmId: e.target.value })}
            >
                <option value="">Select a Film</option>
                {films.map((film) => (
                    <option key={film.id} value={film.id}>
                        {film.title}
                    </option>
                ))}
            </select>
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Title</label>
            <input
                className={styles.formInput}
                type="text"
                placeholder="Title"
                value={newNovost.title}
                onChange={(e) => setNewNovost({ ...newNovost, title: e.target.value })}
            />
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Kreator</label>
            <input
                className={styles.formInput}
                type="text"
                placeholder="Kreator"
                value={newNovost.kreator}
                onChange={(e) => setNewNovost({ ...newNovost, kreator: e.target.value })}
            />
        </div>
        <div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 1</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst}
      onChange={(value) => setNewNovost({ ...newNovost, tekst: value })}
    />
  </div>
</div>
<div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 2</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst2}
      onChange={(value) => setNewNovost({ ...newNovost, tekst2: value })}
    />
  </div>
</div>
<div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 3</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst3}
      onChange={(value) => setNewNovost({ ...newNovost, tekst3: value })}
    />
  </div>
</div>
<div className={styles.formGroup}>
  <label className={styles.formLabel}>Text 4</label>
  <div data-color-mode="light">
    <MDEditor
      value={newNovost.tekst4}
      onChange={(value) => setNewNovost({ ...newNovost, tekst4: value })}
    />
  </div>
</div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 1 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika1: e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={newNovost.slika1} alt="Preview" className={styles.imagePreview} />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 2 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika2:  e.target.files[0] })}
            />
        </div>
        <div className={styles.formGroup}>
            <img src={newNovost.slika2} alt="Preview" className={styles.imagePreview} />
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 3 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika3:  e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={newNovost.slika3} alt="Preview" className={styles.imagePreview} />
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Tip Novosti</label>
            <select
                className={styles.formSelect}
                value={newNovost.tipNovosti}
                onChange={(e) => setNewNovost({ ...newNovost, tipNovosti: e.target.value })}
            >
                <option value="novost">Obicna Novost</option>
                <option value="svijetfilma">Novost iz svijeta filma</option>
                <option value="trailer">Trailer Novost</option>

            </select>
        </div>
        <button className={styles.createButton} onClick={handleCreateNovost}>Create Novost</button>
    </section>
)}

                </main>
            </div>
            <Footer />
        </>
    );
};

export default AdminDashboard;
