/* eslint-disable no-unused-vars */
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/AdminDashboard.module.css';
import { Helmet } from 'react-helmet';
import MDEditor, { commands } from '@uiw/react-md-editor';
import Select from 'react-select';

const AdminDashboard = () => {
    const [imagePreview, setImagePreview] = useState("");
    const [imagePreview2, setImagePreview2] = useState("");
    const [imagePreview3, setImagePreview3] = useState("");
    const [bazaFile, setBazaFile] = useState(null);
    const [folderFiles, setFolderFiles] = useState([]);
    const [films, setFilms] = useState([]);
    const [novosti, setNovosti] = useState([]);
    const [poruke, setPoruke] = useState([]);
    const [newFilm, setNewFilm] = useState({
        title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '', releaseDate: '',
        duration: 0, reditelj: '', comment: 0, opis:'', type: 'film', tipMjesta: 'uskoro', od: '', do: '' 
    });
    const [newNovost, setNewNovost] = useState({
        filmId: '', title: '', kreator: '', tekst: '', tipNovosti: 'novost', image:'',
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
                        const response = await axios.get('https://unafilm.onrender.com/server/filmovi' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                        setFilms(response.data);
                    } catch (error) {
                        console.error('Error fetching films:', error);
                    }
                }
                else{
                    try {
                        const response = await fetch(`https://unafilm.onrender.com/server/filmovi/search/${searchTerm}` , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
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
                    const response = await axios.get('https://unafilm.onrender.com/server/novosti' , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                    setNovosti(response.data);
                } catch (error) {
                    console.error('Error fetching novosti:', error);
                }
            }
            else{
                try {
                    const response = await fetch(`https://unafilm.onrender.com/server/novosti/search/${searchTerm2}` , {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
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
        formData.append('releaseDate', newFilm.releaseDate);
        formData.append('comment', newFilm.comment);
        formData.append('opis', newFilm.opis);
        formData.append('type', newFilm.type);
        formData.append('tipMjesta', newFilm.tipMjesta);
        formData.append('od', newFilm.od);
        formData.append('do', newFilm.do);

    
    
        // Dodaj slike (ako postoje)
        if (newFilm.imageUrl instanceof File) {
            formData.append('image1', newFilm.imageUrl); // Prva slika
        }
        if (newFilm.imageUrl2 instanceof File) {
            formData.append('image2', newFilm.imageUrl2); // Druga slika
        }
    
        try {
            // Pošaljemo formData (film i slike) na backend
            const response = await axios.post('https://unafilm.onrender.com/server/filmovi', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data', // Moramo postaviti ovaj header za upload fajlova
                    'x-api-key': 'admin'
                }
            });
    
            // Ako je uspešno, ažuriraj filmsku listu
            fetchFilms();
            setSelectedFilm(null);
            setNewFilm({
                title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '', releaseDate: '',
                duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro',
                opis:''
            });
            setSelectedOption('films')
            console.log('Film created successfully:', response.data);

             const notification = document.createElement("div");
        notification.innerText = "Film kreiran!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#4BB543";
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
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
        formData.append('releaseDate', newFilm.releaseDate);
        formData.append('comment', newFilm.comment);
        formData.append('type', newFilm.type);
        formData.append('tipMjesta', newFilm.tipMjesta);
        formData.append('opis', newFilm.opis);
        formData.append('od', newFilm.od);
        formData.append('do', newFilm.do);

        // Dodaj slike (ako postoje i ako su fajlovi)
        if (newFilm.imageUrl instanceof File) {
            formData.append('image1', newFilm.imageUrl); // Dodaj prvu sliku
        }
        
    
        if (newFilm.imageUrl2 instanceof File) {
            formData.append('image2', newFilm.imageUrl2); // Dodaj drugu sliku
        }
    
        try {
            // Pošaljemo formData sa filmom na backend
            const response = await axios.put(`https://unafilm.onrender.com/server/filmovi/${selectedFilm.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data' ,// Postavljanje headera za fajlove
                    'x-api-key': 'admin'
                }
            });
    
            // Ako je uspešno, ažuriraj filmsku listu
            fetchFilms();
            setSelectedFilm(null);
            setNewFilm({
                title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '', releaseDate: '',
                duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro',
                opis:''
            });
            setSelectedOption('films')
            console.log('Film updated successfully:', response.data);
            const notification = document.createElement("div");
        notification.innerText = "Film updejtan!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#007bff";
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
        } catch (error) {
            console.error('Error updating film:', error);
        }
    };
    
    
    const handleCreateNovost = async () => {
    const formData = new FormData();

    // Dodaj podatke
    formData.append('title', newNovost.title);
    formData.append('kreator', newNovost.kreator);
    formData.append('tekst', newNovost.tekst);
    formData.append('tipNovosti', newNovost.tipNovosti);

    // Ako postoji filmId i nije prazan
    if (newNovost.filmId) {
        formData.append('filmId', newNovost.filmId);
    }

    // Dodaj sliku ako je File objekat
    if (newNovost.image instanceof File) {
        formData.append('image', newNovost.image);
    }

    try {
        const response = await axios.post('https://unafilm.onrender.com/server/novosti', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'x-api-key': 'admin'
            }
        });

        fetchNovosti();
        setSelectedNovost(null);
        setNewNovost({ filmId: '', title: '', kreator: '', tekst: '', tipNovosti: 'novost', image: '' });
        setSelectedOption('novosti');
        console.log('Novost created successfully:', response.data);

        const notification = document.createElement("div");
        notification.innerText = "Novost kreirana!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#4BB543";
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
    } catch (error) {
        console.error('Error creating novost:', error);
    }
};

    
    const handleUpdateNovost = async () => {
    const formData = new FormData();

    // Dodaj podatke
    formData.append('title', newNovost.title);
    formData.append('kreator', newNovost.kreator);
    formData.append('tekst', newNovost.tekst);
    formData.append('tipNovosti', newNovost.tipNovosti);

    // Ako postoji filmId i nije prazan
    if (newNovost.filmId) {
        formData.append('filmId', newNovost.filmId);
    }

    // Dodaj sliku ako je File objekat
    if (newNovost.image instanceof File) {
        formData.append('image', newNovost.image);
    }

    try {
        const response = await axios.put(`https://unafilm.onrender.com/server/novosti/${selectedNovost.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'x-api-key': 'admin'

            }
        });

        fetchNovosti();
        setSelectedNovost(null);
        setNewNovost({ filmId: '', title: '', kreator: '', tekst: '', tipNovosti: 'novost', image: '' });
        setSelectedOption('novosti');
        console.log('Novost updated successfully:', response.data);

        const notification = document.createElement("div");
        notification.innerText = "Novost updejtana!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#007bff";
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
    } catch (error) {
        console.error('Error updating novost:', error);
    }
};

    



    const fetchFilms = async () => {
        try {
            const response = await axios.get('https://unafilm.onrender.com/server/filmovi', {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
            setFilms(response.data);
        } catch (error) {
            console.error('Error fetching films:', error);
        }
    };

    const fetchNovosti = async () => {
        try {
            const response = await axios.get('https://unafilm.onrender.com/server/novosti', {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
            setNovosti(response.data);
        } catch (error) {
            console.error('Error fetching novosti:', error);
        }
    };

    const fetchPoruke = async () => {
        try {
            const response = await axios.get('https://unafilm.onrender.com/server/poruke', {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
            setPoruke(response.data);
        } catch (error) {
            console.error('Error fetching poruke:', error);
        }
    };


    const handleDeleteFilm = async (id) => {
        const confirmed = window.confirm('Da li ste sigurni da želite obrisati ovaj film?');
        if (confirmed) {
            try {
                await axios.delete(`https://unafilm.onrender.com/server/filmovi/${id}`, {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                await fetchFilms();

                 const notification = document.createElement("div");
        notification.innerText = "Film obrisan!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#e53935"; // red color
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
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
                await axios.delete(`https://unafilm.onrender.com/server/novosti/${id}`, {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                await fetchNovosti();

                 const notification = document.createElement("div");
        notification.innerText = "Novost obrisana!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#e53935"; // red color
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
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
                await axios.delete(`https://unafilm.onrender.com/server/poruke/${id}`, {
                    headers: {
                        'x-api-key': 'admin'
                    } // API endpoint for movies
                });
                await fetchPoruke();

                 const notification = document.createElement("div");
        notification.innerText = "Poruka obrisana!";
        notification.style.position = "fixed";
        notification.style.top = "120px";
        notification.style.right = "20px";
        notification.style.background = "#e53935"; // red color
        notification.style.color = "#fff";
        notification.style.padding = "16px 24px";
        notification.style.borderRadius = "8px";
        notification.style.boxShadow = "0 2px 8px rgba(0,0,0,0.15)";
        notification.style.fontSize = "1rem";
        notification.style.zIndex = "9999";
        notification.style.transition = "opacity 0.5s";
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
            document.body.removeChild(notification);
            }, 500);
        }, 2000);
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
  const regexList = [
    /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([^&\n\s]+)/,
    /(?:https?:\/\/)?(?:www\.)?youtube\.com\/embed\/([^&\n\s]+)/,
    /(?:https?:\/\/)?(?:www\.)?youtube\.com\/v\/([^&\n\s]+)/,
    /(?:https?:\/\/)?(?:www\.)?youtube\.com\/shorts\/([^&\n\s]+)/,
    /(?:https?:\/\/)?(?:www\.)?youtu\.be\/([^&\n\s]+)/
  ];

  for (const regex of regexList) {
    const match = url.match(regex);
    if (match && match[1]) {
      return `https://www.youtube.com/embed/${match[1]}`;
    }
  }

  return url; // Ako nije validan YouTube URL
};

      
      const handleSelectedOption = (opt) => {
        setNewFilm({
            title: '', description: '', trailerUrl: '', imageUrl: '', imageUrl2: '', releaseDate: '',
            duration: 0, reditelj: '', comment: 0, type: 'film', tipMjesta: 'uskoro',
            opis:'', od: '', do: ''
        });      
        setNewNovost({
            filmId: '', title: '', kreator: '', tekst: '', tekst2: '', tekst3: '', tekst4: '', image: '',
            slika1: '', slika2: '', slika3: '', tipNovosti: 'novost'
        });

        setImagePreview("");
        setImagePreview2("");
        setImagePreview3("");
        
         setSelectedOption(opt);
      }

    const handleSkiniBazu = async () => {
        const confirmed = window.confirm('Da li ste sigurni da želite skinuti bazu?');
        if (confirmed) {
            try {
                const response = await axios.get('https://unafilm.onrender.com/server/download/database', {
                    responseType: 'blob',
                    headers: {
                        'x-api-key': 'admin'
                    }
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
        } else {
            console.log('Baza nije skinuta!');
        }
    }

    const handleSkiniFolder = async () => {
        const confirmed = window.confirm('Da li ste sigurni da želite skinuti folder?');
        if (confirmed) {
            try {
                const response = await axios.get('https://unafilm.onrender.com/server/download/uploads', {
                    responseType: 'blob',
                    headers: {
                        'x-api-key': 'admin'
                    }
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
        } else {
            console.log('Folder nije skinut!');
        }

    }

    const handleBazaChange = (e) => {
        setBazaFile(e.target.files[0]);
    };
    
    const handleFolderChange = (e) => {
        setFolderFiles([...e.target.files]); // Array jer može biti više fajlova
    };

    const handleUploadBaza = async () => {
        if (!bazaFile) return alert("Odaberi bazu!");
    
        const formData = new FormData();
        formData.append('database', bazaFile);
    
        try {
            const res = await fetch('https://unafilm.onrender.com/server/upload/database', {
                method: 'POST',
                body: formData,
                 headers: {
                        'x-api-key': 'admin'
                    }
            });
    
            if (res.ok) alert('Baza uspješno uploadovana!');
            else alert('Greška pri uploadu baze!');
        } catch (err) {
            console.error(err);
            alert('Greška u mreži!');
        }
    };
    
    const handleUploadFolder = async () => {
        if (!folderFiles.length) return alert("Odaberi folder!");
    
        const formData = new FormData();
        folderFiles.forEach(file => {
            formData.append('uploads', file, file.webkitRelativePath);
        });
    
        try {
            const res = await fetch('https://unafilm.onrender.com/server/upload/uploads', {
                method: 'POST',
                body: formData,
                headers: {
                        'x-api-key': 'admin'
                    }
            });
    
            if (res.ok) alert('Folder uspješno uploadovan!');
            else alert('Greška pri uploadu foldera!');
        } catch (err) {
            console.error(err);
            alert('Greška u mreži!');
        }
    };
    
    const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        const previewURL = URL.createObjectURL(file);
        setNewNovost({
            ...newNovost,
            image: file,
        });

        setImagePreview(previewURL);
    }
};

const handleImage2Change = (e)=>{
    const file = e.target.files[0];

     if (file) {
        setNewFilm({ ...newFilm, imageUrl: file });
        const previewURL = URL.createObjectURL(file);
        setImagePreview2(previewURL);
     }

};
const handleImage3Change = (e)=>{
    const file = e.target.files[0];

     if (file) {
        setNewFilm({ ...newFilm, imageUrl2: file });
        const previewURL = URL.createObjectURL(file);
        setImagePreview3(previewURL);
     }

};

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
                                <img src='https://unafilm.ba/unaFilm141-2.png'></img>
                            </li>
                            <li className={styles.li2}></li>
                            <li className={styles.li2}></li>
                            <li className={styles.li} onClick={() => handleLogout()}>Logout</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('pretragaFilmova')}>Pretraga Filmova</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('pretragaNovosti')}>Pretraga Novosti</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('poruke')}>Sve Poruke</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('createFilm')}>Kreiraj Film</li>
                            <li className={styles.li} onClick={() => handleSelectedOption('createNovost')}>Kreiraj Novost</li>
                           {/* <li className={styles.li} onClick={() => handleSkiniBazu()}>Skini Bazu</li>                       
                          {/*  <li className={styles.li} onClick={() => handleSkiniFolder()}>Skini Folder Svih Slika</li>        
                           {/* <li className={styles.li} onClick={() => handleSelectedOption('uploadBaza')}>Uploduj Bazu</li>                       
                          {/* <li className={styles.li} onClick={() => handleSelectedOption('uploadFolder')}>Uploduj Folder Svih Slika</li>*/}       
                            <li className={styles.li2}></li>
                            <li className={styles.li2}></li>
                            <li className={styles.li2}></li>


                        </ul>
                    </nav>
                </aside>
                <main className={styles.content}>

                {selectedOption === 'uploadBaza' &&
                <section className={styles.updateSection}>
                    <h3 className={styles.sectionTitle}>Upload Baze</h3>
                    <div className={styles.formGroup}>
                        <label className={styles.formLabel}>Baza</label>
                        <input
                            type="file"
                            className={styles.formInput}
                            onChange={handleBazaChange}
                        />
                    </div>

                    <button className={styles.updateButton} onClick={handleUploadBaza}>
                        Upload Baza
                    </button>
                </section>
            }

            {selectedOption === 'uploadFolder' &&
                <section className={styles.updateSection}>
                    <h3 className={styles.sectionTitle}>Upload Foldera Slika</h3>
                    <div className={styles.formGroup}>
                        <label className={styles.formLabel}>Folder</label>
                        <input
                            type="file"
                            name="uploads"
                            className={styles.formInput}
                            webkitdirectory="true"
                            directory="true"
                            multiple
                            onChange={handleFolderChange}
                        />
                    </div>

                    <button className={styles.updateButton} onClick={handleUploadFolder}>
                        Upload Foldera
                    </button>
                </section>
            }


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
                                        <td className={styles.td}> <a className={styles.link} href={`/arhiva/film/${film.uuid}`}> {film.title} </a> </td>
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
                                            <td className={styles.td}><a className={styles.link} href={`/novosti/film/${novost.uuid}`}>{novost.title} </a> </td>
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

                   

                    {selectedOption === 'createFilm' && (
                        <section className={styles.updateSection}>
                            <h3 className={styles.h3}>Kreiraj Film</h3>
                            <div className={styles.div}>
                                <label className={styles.label}>Naslov Filma/Serije</label>
                                <input className={styles.input} type="text" placeholder="ime" value={newFilm.title} onChange={(e) => setNewFilm({ ...newFilm, title: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Deskripcija</label>
                                <input className={styles.input} type="text" placeholder="deskripcija" value={newFilm.description} onChange={(e) => setNewFilm({ ...newFilm, description: e.target.value })} />
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
                                <label className={styles.label}>Velika Slika</label>
                                <input
                                    className={styles.input}
                                    type="file"
                                    onChange={handleImage2Change}
                                />
                            </div>
                            <div className={styles.div}>
                                <img src={imagePreview2} alt="Preview" className={styles.imagePreview} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Mala Slika</label>
                                <input
                                    className={styles.input}
                                    type="file"
                                    onChange={handleImage3Change}
                                />
                            </div>
                            <div className={styles.div}>
                                <img src={imagePreview3} alt="Preview" className={styles.imagePreview} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Datum izlaska</label>
                                <input className={styles.input} type="date" placeholder="Release Date" value={newFilm.releaseDate} onChange={(e) => setNewFilm({ ...newFilm, releaseDate: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Trajanje filma/serije</label>
                                <input className={styles.input} type="number" placeholder="" value={newFilm.duration} onChange={(e) => setNewFilm({ ...newFilm, duration: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Reditelj</label>
                                <input className={styles.input} type="text" placeholder="Reditelj" value={newFilm.reditelj} onChange={(e) => setNewFilm({ ...newFilm, reditelj: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Broj Komentara</label>
                                <input className={styles.input} type="number" placeholder="" value={newFilm.comment} onChange={(e) => setNewFilm({ ...newFilm, comment: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Tip</label>
                                <select className={styles.select}
                                    value={newFilm.type}
                                    onChange={(e) => setNewFilm({ ...newFilm, type: e.target.value })}
                                >
                                    <option value="film">Film</option>
                                    <option value="serija">Serija</option>
                                </select>
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Mjesto na Stranici</label>
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
                                <label className={styles.label}>Datum od u kinima</label>
                                <input className={styles.input} type="date" placeholder="Release Date" value={newFilm.od} onChange={(e) => setNewFilm({ ...newFilm, od: e.target.value })} />
                            </div>

                            <div className={styles.div}>
                                <label className={styles.label}>Datum do u kinima</label>
                                <input className={styles.input} type="date" placeholder="Release Date" value={newFilm.do} onChange={(e) => setNewFilm({ ...newFilm, do: e.target.value })} />
                            </div>

                            <div className={styles.div}>
                                <label className={styles.label}>Opis</label>
                                 <div data-color-mode="light">
                                    <MDEditor
   value={newFilm.opis}
      onChange={(value) => setNewFilm({ ...newFilm, opis: value })}
        height={600}

  commands={[
    ...commands.getCommands(),

    // Komanda za sliku
    {
      name: "insertImage",
      keyCommand: "insertImage",
      buttonProps: { "aria-label": "Insert image tag" },
      icon: <span>🖼️</span>,
      execute: (state, api) => {
        const imageUrl = prompt("Unesite URL slike:");
        if (!imageUrl) return;

        const altText = state.selectedText || "description";
        const newText = `<img src="${imageUrl}" alt="${altText}" width="85%" style="display: block; margin: 0 auto;" />`;

        api.replaceSelection(newText);
      },
    },

    // Komanda za YouTube video
    {
      name: "insertIframe",
      keyCommand: "insertIframe",
      buttonProps: { "aria-label": "Insert iframe tag" },
      icon: <span>🎬</span>,
      execute: (state, api) => {
        let videoUrl = prompt("Unesite YouTube link (npr: https://www.youtube.com/watch?v=VIDEO_ID):");
        if (!videoUrl) return;

        // Izvuci video ID iz bilo kog formata YouTube linka
        const videoIdMatch = videoUrl.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([^&]+)/);
        const videoId = videoIdMatch ? videoIdMatch[1] : null;

        if (!videoId) {
          alert("Neispravan YouTube link!");
          return;
        }

        const newText = `<style>
    iframe.responsive-yt {
    width: 850px;
    height: 450px;
    }

  @media (max-width: 768px) {
    iframe.responsive-yt {
       height: 180px !important;
       width: 90% !important; 
    }
  }
</style> 

<iframe class="responsive-yt" width="560" height="315" src="https://www.youtube.com/embed/${videoId}" title="Trailer" frameborder="0" style="display: block; margin: 0 auto; border-radius: 10px; margin-bottom:20px" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;

        api.replaceSelection(newText);
      },
    },

    {
  name: "insertMultipleImages",
  keyCommand: "insertMultipleImages",
  buttonProps: { "aria-label": "Insert multiple images" },
  icon: <span>🖼️</span>,
  execute: async (state, api) => {
    let addMore = true;
    const images = [];

    while (addMore) {
      const count = parseInt(prompt("Koliko slika želite dodati?"));
      if (isNaN(count) || count <= 0) {
        addMore = confirm("Niste unijeli ispravan broj slika. Želite li pokušati ponovo?");
        continue;
      }

      for (let i = 0; i < count; i++) {
        const imageUrl = prompt(`Unesite URL slike ${i + 1}:`);
        if (!imageUrl) {
          addMore = confirm("Niste unijeli URL slike. Želite li pokušati ponovo?");
          break;
        }
        images.push(imageUrl);
      }

      if (addMore) {
        addMore = confirm("Želite li unijeti još slika?");
      }
    }

    if (images.length > 0) {
      let gridHtml = "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;'>";

      images.forEach((imageUrl) => {
        gridHtml += `<img src="${imageUrl}" alt="description" style="max-width: 100%; height: auto; border-radius: 10px;"/>`;
      });

      gridHtml += "</div>";
      
      api.replaceSelection(gridHtml);
    }
  },
},

{
  name: "insertStyledParagraph",
  keyCommand: "insertStyledParagraph",
  buttonProps: { "aria-label": "Insert styled paragraph" },
  icon: <span>📝</span>,
  execute: (state, api) => {
    const text = prompt("Unesite tekst koji će biti ispod slike:");
    if (!text) return;

    const newText = `<p style="display:flex; margin: 0 auto; font-size:14px; align-items:center; justify-content:center">${text}</p>`;

    api.replaceSelection(newText);
  },
},


  ]}
/>
                                </div>         
                             </div>

                                     

                            <button className={styles.button} onClick={handleCreateFilm}>Create Film</button>
                        </section>
                    )}
             


                    {selectedOption === 'updateFilm' && (
    <section className={styles.updateSection}>
        <h3 className={styles.sectionTitle}>Ažuriraj Film</h3>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Naslov Filma/Serije</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.title}
                onChange={(e) => setNewFilm({ ...newFilm, title: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Deskripcija</label>
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
            <label className={styles.formLabel}>Velika Slika</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={handleImage2Change}
            />
        </div>
        <div className={styles.formGroup}>
            <img src={imagePreview2 || newFilm.imageUrl} alt="Preview" className={styles.imagePreview} />
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Mala Slika</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={handleImage3Change}
            />
        </div>

        <div className={styles.formGroup}>
            <img src={imagePreview3|| newFilm.imageUrl2} alt="Preview" className={styles.imagePreview} />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Datum Izlaska</label>
            <input
                className={styles.formInput}
                type="date"
                value={newFilm.releaseDate}
                onChange={(e) => setNewFilm({ ...newFilm, releaseDate: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Trajanje Filma/Serije</label>
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
            <label className={styles.formLabel}>Broj Komentara</label>
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
            <label className={styles.formLabel}>Mjesto na Stranici</label>
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
            <label className={styles.formLabel}>Datum od u kinima</label>
            <input
                className={styles.formInput}
                type="date"
                value={newFilm.od}
                onChange={(e) => setNewFilm({ ...newFilm, od: e.target.value })}
            />
        </div>

          <div className={styles.formGroup}>
            <label className={styles.formLabel}>Datum do u kinima</label>
            <input
                className={styles.formInput}
                type="date"
                value={newFilm.do}
                onChange={(e) => setNewFilm({ ...newFilm, do: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Opis</label>
           
            <div data-color-mode="light">
    
    <MDEditor
   value={newFilm.opis}
      onChange={(value) => setNewFilm({ ...newFilm, opis: value })}
        height={600}

  commands={[
    ...commands.getCommands(),

    // Komanda za sliku
    {
      name: "insertImage",
      keyCommand: "insertImage",
      buttonProps: { "aria-label": "Insert image tag" },
      icon: <span>🖼️</span>,
      execute: (state, api) => {
        const imageUrl = prompt("Unesite URL slike:");
        if (!imageUrl) return;

        const altText = state.selectedText || "description";
        const newText = `<img src="${imageUrl}" alt="${altText}" width="85%" style="display: block; margin: 0 auto;" />`;

        api.replaceSelection(newText);
      },
    },

    // Komanda za YouTube video
  {
      name: "insertIframe",
      keyCommand: "insertIframe",
      buttonProps: { "aria-label": "Insert iframe tag" },
      icon: <span>🎬</span>,
      execute: (state, api) => {
        let videoUrl = prompt("Unesite YouTube link (npr: https://www.youtube.com/watch?v=VIDEO_ID):");
        if (!videoUrl) return;

        // Izvuci video ID iz bilo kog formata YouTube linka
        const videoIdMatch = videoUrl.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([^&]+)/);
        const videoId = videoIdMatch ? videoIdMatch[1] : null;

        if (!videoId) {
          alert("Neispravan YouTube link!");
          return;
        }

        const newText = `<style>
    iframe.responsive-yt {
    width: 850px;
    height: 450px;
    }

  @media (max-width: 768px) {
    iframe.responsive-yt {
      height: 180px !important;
       width: 90% !important; 
    }
  }
</style> 

<iframe class="responsive-yt" width="560" height="315" src="https://www.youtube.com/embed/${videoId}" title="Trailer" frameborder="0" style="display: block; margin: 0 auto; border-radius: 10px; margin-bottom:20px" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;

        api.replaceSelection(newText);
      },
    },

     {
  name: "insertMultipleImages",
  keyCommand: "insertMultipleImages",
  buttonProps: { "aria-label": "Insert multiple images" },
  icon: <span>🖼️</span>,
  execute: async (state, api) => {
    let addMore = true;
    const images = [];

    while (addMore) {
      const count = parseInt(prompt("Koliko slika želite dodati?"));
      if (isNaN(count) || count <= 0) {
        addMore = confirm("Niste unijeli ispravan broj slika. Želite li pokušati ponovo?");
        continue;
      }

      for (let i = 0; i < count; i++) {
        const imageUrl = prompt(`Unesite URL slike ${i + 1}:`);
        if (!imageUrl) {
          addMore = confirm("Niste unijeli URL slike. Želite li pokušati ponovo?");
          break;
        }
        images.push(imageUrl);
      }

      if (addMore) {
        addMore = confirm("Želite li unijeti još slika?");
      }
    }

    if (images.length > 0) {
      let gridHtml = "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;'>";

      images.forEach((imageUrl) => {
        gridHtml += `<img src="${imageUrl}" alt="description" style="max-width: 100%; height: auto; border-radius: 10px;"/>`;
      });

      gridHtml += "</div>";
      
      api.replaceSelection(gridHtml);
    }
  },
},

{
  name: "insertStyledParagraph",
  keyCommand: "insertStyledParagraph",
  buttonProps: { "aria-label": "Insert styled paragraph" },
  icon: <span>📝</span>,
  execute: (state, api) => {
    const text = prompt("Unesite tekst koji će biti ispod slike:");
    if (!text) return;

    const newText = `<p style="display:flex; margin: 0 auto; font-size:14px; align-items:center; justify-content:center">${text}</p>`;

    api.replaceSelection(newText);
  },
},

  ]}
/>
  </div>
        </div>

    

        <button className={styles.updateButton} onClick={handleUpdateFilm}>Update Film</button>
    </section>
)}


{selectedOption === 'updateNovost' && (
    <section className={styles.updateSection}>
        <h3 className={styles.sectionTitle}>Ažuriraj Novost</h3>
        {/* Film Selection */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Izaberi Film vezan za Novost ako je potrebno</label>
               <Select
    
    value={films.find(f => f.id === newNovost.filmId)}
    onChange={(selectedOption) =>
        setNewNovost({ ...newNovost, filmId: selectedOption?.id || "" })
    }
    options={films}
    getOptionLabel={(e) => e.title}
    getOptionValue={(e) => e.id}
/>
        </div>

        {/* Title */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Naslov Novosti</label>
            <input
                className={styles.formInput}
                type="text"
                value={newNovost.title}
                onChange={(e) => setNewNovost({ ...newNovost, title: e.target.value })}
            />
        </div>

        {/* Kreator */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Kreator Preuzete ili Kreirane Novosti</label>
            <input
                className={styles.formInput}
                type="text"
                value={newNovost.kreator}
                onChange={(e) => setNewNovost({ ...newNovost, kreator: e.target.value })}
            />
        </div>

        {/* Text 1 */}
        <div className={styles.formGroup}>
  <label className={styles.formLabel}>Tekst Novosti</label>
  <div data-color-mode="light">
    <MDEditor
  value={newNovost.tekst}
  onChange={(value) => setNewNovost({ ...newNovost, tekst: value })}
height={600}
  commands={[
    ...commands.getCommands(),

    // Komanda za sliku
    {
      name: "insertImage",
      keyCommand: "insertImage",
      buttonProps: { "aria-label": "Insert image tag" },
      icon: <span>🖼️</span>,
      execute: (state, api) => {
        const imageUrl = prompt("Unesite URL slike:");
        if (!imageUrl) return;

        const altText = state.selectedText || "description";
        const newText = `<img src="${imageUrl}" alt="${altText}" width="85%" style="display: block; margin: 0 auto;" />`;

        api.replaceSelection(newText);
      },
    },

    // Komanda za YouTube video
  {
      name: "insertIframe",
      keyCommand: "insertIframe",
      buttonProps: { "aria-label": "Insert iframe tag" },
      icon: <span>🎬</span>,
      execute: (state, api) => {
        let videoUrl = prompt("Unesite YouTube link (npr: https://www.youtube.com/watch?v=VIDEO_ID):");
        if (!videoUrl) return;

        // Izvuci video ID iz bilo kog formata YouTube linka
        const videoIdMatch = videoUrl.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([^&]+)/);
        const videoId = videoIdMatch ? videoIdMatch[1] : null;

        if (!videoId) {
          alert("Neispravan YouTube link!");
          return;
        }

        const newText = `<style>
    iframe.responsive-yt {
    width: 850px;
    height: 450px;
    }

  @media (max-width: 768px) {
    iframe.responsive-yt {
       height: 180px !important;
       width: 90% !important; 
    }
  }
</style> 

<iframe class="responsive-yt" width="560" height="315" src="https://www.youtube.com/embed/${videoId}" title="Trailer" frameborder="0" style="display: block; margin: 0 auto; border-radius: 10px; margin-bottom:20px" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;

        api.replaceSelection(newText);
      },
    },

     {
  name: "insertMultipleImages",
  keyCommand: "insertMultipleImages",
  buttonProps: { "aria-label": "Insert multiple images" },
  icon: <span>🖼️</span>,
  execute: async (state, api) => {
    let addMore = true;
    const images = [];

    while (addMore) {
      const count = parseInt(prompt("Koliko slika želite dodati?"));
      if (isNaN(count) || count <= 0) {
        addMore = confirm("Niste unijeli ispravan broj slika. Želite li pokušati ponovo?");
        continue;
      }

      for (let i = 0; i < count; i++) {
        const imageUrl = prompt(`Unesite URL slike ${i + 1}:`);
        if (!imageUrl) {
          addMore = confirm("Niste unijeli URL slike. Želite li pokušati ponovo?");
          break;
        }
        images.push(imageUrl);
      }

      if (addMore) {
        addMore = confirm("Želite li unijeti još slika?");
      }
    }

    if (images.length > 0) {
      let gridHtml = "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;'>";

      images.forEach((imageUrl) => {
        gridHtml += `<img src="${imageUrl}" alt="description" style="max-width: 100%; height: auto; border-radius: 10px;"/>`;
      });

      gridHtml += "</div>";
      
      api.replaceSelection(gridHtml);
    }
  },
},

{
  name: "insertStyledParagraph",
  keyCommand: "insertStyledParagraph",
  buttonProps: { "aria-label": "Insert styled paragraph" },
  icon: <span>📝</span>,
  execute: (state, api) => {
    const text = prompt("Unesite tekst koji će biti ispod slike:");
    if (!text) return;

    const newText = `<p style="display:flex; margin: 0 auto; font-size:14px; align-items:center; justify-content:center">${text}</p>`;

    api.replaceSelection(newText);
  },
},

  ]}
/>
  </div>
</div>

      {/* Image URL */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Glavna Slika Novosti ako je potrebna</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={handleImageChange}
            />
        </div>

         <div className={styles.formGroup}> 
            <img src={imagePreview || newNovost.image} alt="Preview" className={styles.imagePreview} />
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
            <label className={styles.formLabel}>Izaberi Film vezan za Novost ako je potrebno</label>
           <Select
    value={films.find(f => f.id === newNovost.filmId)}
    onChange={(selectedOption) =>
        setNewNovost({ ...newNovost, filmId: selectedOption?.id || "" })
    }
    options={films}
    getOptionLabel={(e) => e.title}
    getOptionValue={(e) => e.id}
/>
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Naslov Novosti</label>
            <input
                className={styles.formInput}
                type="text"
                placeholder="Naslov"
                value={newNovost.title}
                onChange={(e) => setNewNovost({ ...newNovost, title: e.target.value })}
            />
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Kreator Preuzete ili Kreirane Novosti</label>
            <input
                className={styles.formInput}
                type="text"
                placeholder="Kreator"
                value={newNovost.kreator}
                onChange={(e) => setNewNovost({ ...newNovost, kreator: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
    <label className={styles.formLabel}>Glavna Slika Novosti ako je potrebna</label>
    <input
        className={styles.formInput}
        type="file"
        onChange={handleImageChange}
    />
</div>

<div className={styles.formGroup}>
            <img  src={imagePreview} alt="Preview" className={styles.imagePreview} />
        </div>


        
                <div className={styles.formGroup}>
  <label className={styles.formLabel}>Tekst Novosti</label>
  <div data-color-mode="light">
   <MDEditor
  value={newNovost.tekst}
  onChange={(value) => setNewNovost({ ...newNovost, tekst: value })}
  height={600}
  commands={[
    ...commands.getCommands(),

    // Komanda za sliku
    {
      name: "insertImage",
      keyCommand: "insertImage",
      buttonProps: { "aria-label": "Insert image tag" },
      icon: <span>🖼️</span>,
      execute: (state, api) => {
        const imageUrl = prompt("Unesite URL slike:");
        if (!imageUrl) return;

        const altText = state.selectedText || "description";
        const newText = `<img src="${imageUrl}" alt="${altText}" width="85%" style="display: block; margin: 0 auto;" />`;

        api.replaceSelection(newText);
      },
    },

    // Komanda za YouTube video
   {
      name: "insertIframe",
      keyCommand: "insertIframe",
      buttonProps: { "aria-label": "Insert iframe tag" },
      icon: <span>🎬</span>,
      execute: (state, api) => {
        let videoUrl = prompt("Unesite YouTube link (npr: https://www.youtube.com/watch?v=VIDEO_ID):");
        if (!videoUrl) return;

        // Izvuci video ID iz bilo kog formata YouTube linka
        const videoIdMatch = videoUrl.match(/(?:youtube\.com\/.*v=|youtu\.be\/)([^&]+)/);
        const videoId = videoIdMatch ? videoIdMatch[1] : null;

        if (!videoId) {
          alert("Neispravan YouTube link!");
          return;
        }

        const newText = `<style>
    iframe.responsive-yt {
    width: 850px;
    height: 450px;
    }

  @media (max-width: 768px) {
    iframe.responsive-yt {
       height: 180px !important;
       width: 90% !important; 
    }
  }
</style> 

<iframe class="responsive-yt" width="560" height="315" src="https://www.youtube.com/embed/${videoId}" title="Trailer" frameborder="0" style="display: block; margin: 0 auto; border-radius: 10px; margin-bottom:20px" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;

        api.replaceSelection(newText);
      },
    },

     {
  name: "insertMultipleImages",
  keyCommand: "insertMultipleImages",
  buttonProps: { "aria-label": "Insert multiple images" },
  icon: <span>🖼️</span>,
  execute: async (state, api) => {
    let addMore = true;
    const images = [];

    while (addMore) {
      const count = parseInt(prompt("Koliko slika želite dodati?"));
      if (isNaN(count) || count <= 0) {
        addMore = confirm("Niste unijeli ispravan broj slika. Želite li pokušati ponovo?");
        continue;
      }

      for (let i = 0; i < count; i++) {
        const imageUrl = prompt(`Unesite URL slike ${i + 1}:`);
        if (!imageUrl) {
          addMore = confirm("Niste unijeli URL slike. Želite li pokušati ponovo?");
          break;
        }
        images.push(imageUrl);
      }

      if (addMore) {
        addMore = confirm("Želite li unijeti još slika?");
      }
    }

    if (images.length > 0) {
      let gridHtml = "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;'>";

      images.forEach((imageUrl) => {
        gridHtml += `<img src="${imageUrl}" alt="description" style="max-width: 100%; height: auto; border-radius: 10px;"/>`;
      });

      gridHtml += "</div>";
      
      api.replaceSelection(gridHtml);
    }
  },
},

{
  name: "insertStyledParagraph",
  keyCommand: "insertStyledParagraph",
  buttonProps: { "aria-label": "Insert styled paragraph" },
  icon: <span>📝</span>,
  execute: (state, api) => {
    const text = prompt("Unesite tekst koji će biti ispod slike:");
    if (!text) return;

    const newText = `<p style="display:flex; margin: 0 auto; font-size:14px; align-items:center; justify-content:center">${text}</p>`;

    api.replaceSelection(newText);
  },
},

  ]}
/>


  </div>
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
