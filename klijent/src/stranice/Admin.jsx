import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/AdminDashboard.module.css';
import storage from "../context/firebase"

const AdminDashboard = () => {
    const [films, setFilms] = useState([]);
    const [novosti, setNovosti] = useState([]);
    const [newFilm, setNewFilm] = useState({
        title: '', description: '', trailerUrl: '', detailsUrl: '', imageUrl: '', imageUrl2: '',
        imageSrc: '', imageAlt: '', videoSrc: '', thumbnail: '', 
        duration: '', categories: '', author: '', comment: 0, content: '',
        preuzeto: '', summary: '',  link: '', alt: '', type: 'movie', tipMjesta: 'uskoro'
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
                if (!searchTerm.trim()) return; // Prevent API call if the search term is empty
                try {
                    const response = await fetch(`http://localhost:3000/server/filmovi/search/${searchTerm}`);
                    const data = await response.json();
    
                    if (response.ok) {
                        setFilms(data);
                    } 
                } catch {
                    console.error('Error fetching articles. Please try again later.');
                } 
            };

           
    
            fetchArticles();
    }, [searchTerm]);

    useEffect(() => {
        const fetchArticles2 = async () => {
            if (!searchTerm2.trim()) return; // Prevent API call if the search term is empty
            try {
                const response = await fetch(`http://localhost:3000/server/novosti/search/${searchTerm2}`);
                const data = await response.json();

                if (response.ok) {
                    setNovosti(data);
                } 
            } catch {
                console.error('Error fetching articles. Please try again later.');
            } 
        };

       

        fetchArticles2();
    }, [searchTerm2]);

       

    const upload = (items, callback) => {
        let uploadedCount = 0;
        const uploadedUrls = {};
    
        items.forEach((item) => {
            const fileName = new Date().getTime() + item.label + item.file.name;
            const uploadTask = storage.ref(`/items/${fileName}`).put(item.file);
    
            uploadTask.on(
                "state_changed",
                (snapshot) => {
                    const progress =
                        (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log("Upload is " + progress + "% complete");
                },
                (error) => {
                    console.error("Error uploading file:", error);
                },
                () => {
                    uploadTask.snapshot.ref.getDownloadURL().then((url) => {
                        uploadedUrls[item.label] = url;
                        uploadedCount++;
    
                        if (uploadedCount === items.length) {
                            callback(uploadedUrls);
                        }
                    });
                }
            );
        });
    };
    
    const handleCreateFilm = async () => {
        const itemsToUpload = [
            { file: newFilm.imageUrl, label: "imageUrl" },
            { file: newFilm.imageUrl2, label: "imageUrl2" },
        ];
    
        upload(itemsToUpload, async (uploadedUrls) => {
            const updatedFilm = { ...newFilm, ...uploadedUrls };
    
            try {
                await axios.post('http://localhost:3000/server/filmovi', updatedFilm);
                fetchFilms();
            } catch (error) {
                console.error('Error creating film:', error);
            }
        });
    };
    
    const handleUpdateFilm = async () => {
        const itemsToUpload = [];
        if (newFilm.imageUrl instanceof File) {
            itemsToUpload.push({ file: newFilm.imageUrl, label: "imageUrl" });
        }
        if (newFilm.imageUrl2 instanceof File) {
            itemsToUpload.push({ file: newFilm.imageUrl2, label: "imageUrl2" });
        }

        if (itemsToUpload.length > 0) {
            upload(itemsToUpload, async (uploadedUrls) => {
                const updatedFilm = { ...newFilm, ...uploadedUrls };

                try {
                    await axios.put(`http://localhost:3000/server/filmovi/${selectedFilm.id}`, updatedFilm);
                    fetchFilms();
                    setSelectedFilm(null);
                } catch (error) {
                    console.error('Error updating film:', error);
                }
            });
        } else {
            try {
                await axios.put(`http://localhost:3000/server/filmovi/${selectedFilm.id}`, newFilm);
                fetchFilms();
                setSelectedFilm(null);
            } catch (error) {
                console.error('Error updating film:', error);
            }
        }
    };
    
    const handleCreateNovost = async () => {
        const itemsToUpload = [
            { file: newNovost.slika1, label: "slika1" },
            { file: newNovost.slika2, label: "slika2" },
            { file: newNovost.slika3, label: "slika3" },
        ];
    
        upload(itemsToUpload, async (uploadedUrls) => {
            const updatedNovost = { ...newNovost, ...uploadedUrls };
    
            try {
                await axios.post('http://localhost:3000/server/novosti', updatedNovost);
                fetchNovosti();
            } catch (error) {
                console.error('Error creating novost:', error);
            }
        });
    };
    
    const handleUpdateNovost = async () => {
        const itemsToUpload = [];
        if (newNovost.slika1 instanceof File) {
            itemsToUpload.push({ file: newNovost.slika1, label: "slika1" });
        }
        if (newNovost.slika2 instanceof File) {
            itemsToUpload.push({ file: newNovost.slika2, label: "slika2" });
        }
        if (newNovost.slika3 instanceof File) {
            itemsToUpload.push({ file: newNovost.slika3, label: "slika3" });
        }

        if (itemsToUpload.length > 0) {
            upload(itemsToUpload, async (uploadedUrls) => {
                const updatedNovost = { ...newNovost, ...uploadedUrls };

                try {
                    await axios.put(`http://localhost:3000/server/novosti/${selectedNovost.id}`, updatedNovost);
                    fetchNovosti();
                    setSelectedNovost(null);
                } catch (error) {
                    console.error('Error updating novost:', error);
                }
            });
        } else {
            try {
                await axios.put(`http://localhost:3000/server/novosti/${selectedNovost.id}`, newNovost);
                fetchNovosti();
                setSelectedNovost(null);
            } catch (error) {
                console.error('Error updating novost:', error);
            }
        }
    };
    



    const fetchFilms = async () => {
        try {
            const response = await axios.get('http://localhost:3000/server/filmovi');
            setFilms(response.data);
        } catch (error) {
            console.error('Error fetching films:', error);
        }
    };

    const fetchNovosti = async () => {
        try {
            const response = await axios.get('http://localhost:3000/server/novosti');
            setNovosti(response.data);
        } catch (error) {
            console.error('Error fetching novosti:', error);
        }
    };


    const handleDeleteFilm = async (id) => {
        try {
            await axios.delete(`http://localhost:3000/server/filmovi/${id}`);
            fetchFilms();
        } catch (error) {
            console.error('Error deleting film:', error);
        }
    };

    const handleDeleteNovost = async (id) => {
        try {
            await axios.delete(`http://localhost:3000/server/novosti/${id}`);
            fetchNovosti();
        } catch (error) {
            console.error('Error deleting novost:', error);
        }
    };

    const handleLogout = () => {
        localStorage.removeItem('adminToken'); // Remove user data from local storage
        window.location.href = '/'; // Redirect to the login page
    };

    return (
        <>
            <Header />
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
                            <li className={styles.li} onClick={() => setSelectedOption('films')}>Svi Filmovi</li>
                            <li className={styles.li} onClick={() => setSelectedOption('novosti')}>Sve Novosti</li>
                            <li className={styles.li} onClick={() => setSelectedOption('createFilm')}>Kreiraj Film</li>
                            <li className={styles.li} onClick={() => setSelectedOption('createNovost')}>Kreiraj Novost</li>
                            <li className={styles.li} onClick={() => setSelectedOption('pretragaFilmova')}>Pretraga Filmova</li>
                            <li className={styles.li} onClick={() => setSelectedOption('pretragaNovosti')}>Pretraga Novosti</li>
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
                                            <button className={styles.button} onClick={() => {
                                                setSelectedFilm(film); 
                                                setNewFilm(film); // Pre-populate form with selected film's data
                                                setSelectedOption('updateFilm');
                                            }}>Ažuriraj</button>
                                            <button className={styles.button} onClick={() => handleDeleteFilm(film.id)}>Obriši</button>
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
                                                <button className={styles.button} onClick={() => {
                                                    setSelectedNovost(novost);
                                                    setNewNovost(novost); // Pre-populate form with selected novost's data
                                                    setSelectedOption('updateNovost');
                                                }}>Ažuriraj</button>
                                                <button className={styles.button} onClick={() => handleDeleteNovost(novost.id)}>Obriši</button>
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
                                                <button className={styles.button} onClick={() => {
                                                    setSelectedFilm(film); 
                                                    setNewFilm(film); // Pre-populate form with selected film's data
                                                    setSelectedOption('updateFilm');
                                                }}>Ažuriraj</button>
                                                <button className={styles.button} onClick={() => handleDeleteFilm(film.id)}>Obriši</button>
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
                                                <button className={styles.button} onClick={() => {
                                                    setSelectedNovost(novost);
                                                    setNewNovost(novost); // Pre-populate form with selected novost's data
                                                    setSelectedOption('updateNovost');
                                                }}>Ažuriraj</button>
                                                <button className={styles.button} onClick={() => handleDeleteNovost(novost.id)}>Obriši</button>
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
                                <input className={styles.input} type="text" placeholder="Trailer URL" value={newFilm.trailerUrl} onChange={(e) => setNewFilm({ ...newFilm, trailerUrl: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Details URL</label>
                                <input className={styles.input} type="text" placeholder="Details URL" value={newFilm.detailsUrl} onChange={(e) => setNewFilm({ ...newFilm, detailsUrl: e.target.value })} />
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
                                <label className={styles.label}>Image 2</label>
                                <input
                                    className={styles.input}
                                    type="file"
                                    onChange={(e) => setNewFilm({ ...newFilm, imageUrl2: e.target.files[0] })}
                                />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Image Src</label>
                                <input className={styles.input} type="text" placeholder="Image Src" value={newFilm.imageSrc} onChange={(e) => setNewFilm({ ...newFilm, imageSrc: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Image Alt</label>
                                <input className={styles.input} type="text" placeholder="Image Alt" value={newFilm.imageAlt} onChange={(e) => setNewFilm({ ...newFilm, imageAlt: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Video Src</label>
                                <input className={styles.input} type="text" placeholder="Video Src" value={newFilm.videoSrc} onChange={(e) => setNewFilm({ ...newFilm, videoSrc: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Thumbnail</label>
                                <input className={styles.input} type="text" placeholder="Thumbnail" value={newFilm.thumbnail} onChange={(e) => setNewFilm({ ...newFilm, thumbnail: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Release Date</label>
                                <input className={styles.input} type="text" placeholder="Release Date" value={newFilm.releaseDate} onChange={(e) => setNewFilm({ ...newFilm, releaseDate: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Duration</label>
                                <input className={styles.input} type="text" placeholder="Duration" value={newFilm.duration} onChange={(e) => setNewFilm({ ...newFilm, duration: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Categories</label>
                                <input className={styles.input} type="text" placeholder="Categories" value={newFilm.categories} onChange={(e) => setNewFilm({ ...newFilm, categories: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Author</label>
                                <input className={styles.input} type="text" placeholder="Author" value={newFilm.author} onChange={(e) => setNewFilm({ ...newFilm, author: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Comment</label>
                                <input className={styles.input} type="text" placeholder="Comment" value={newFilm.comment} onChange={(e) => setNewFilm({ ...newFilm, comment: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Content</label>
                                <textarea className={styles.textarea} placeholder="Content" value={newFilm.content} onChange={(e) => setNewFilm({ ...newFilm, content: e.target.value })}></textarea>
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Preuzeto</label>
                                <input className={styles.input} type="text" placeholder="Preuzeto" value={newFilm.preuzeto} onChange={(e) => setNewFilm({ ...newFilm, preuzeto: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Summary</label>
                                <textarea className={styles.textarea} placeholder="Summary" value={newFilm.summary} onChange={(e) => setNewFilm({ ...newFilm, summary: e.target.value })}></textarea>
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Date</label>
                                <input className={styles.input} type="text" placeholder="Date" value={newFilm.date} onChange={(e) => setNewFilm({ ...newFilm, date: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Link</label>
                                <input className={styles.input} type="text" placeholder="Link" value={newFilm.link} onChange={(e) => setNewFilm({ ...newFilm, link: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Alt</label>
                                <input className={styles.input} type="text" placeholder="Alt" value={newFilm.alt} onChange={(e) => setNewFilm({ ...newFilm, alt: e.target.value })} />
                            </div>
                            <div className={styles.div}>
                                <label className={styles.label}>Type</label>
                                <select className={styles.select}
                                    value={newFilm.type}
                                    onChange={(e) => setNewFilm({ ...newFilm, type: e.target.value })}
                                >
                                    <option value="movie">Movie</option>
                                    <option value="show">Show</option>
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
                onChange={(e) => setNewFilm({ ...newFilm, trailerUrl: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Details URL</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.detailsUrl}
                onChange={(e) => setNewFilm({ ...newFilm, detailsUrl: e.target.value })}
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
            <label className={styles.formLabel}>Image URL2</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewFilm({ ...newFilm, imageUrl2: e.target.files[0] })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Image Src</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.imageSrc}
                onChange={(e) => setNewFilm({ ...newFilm, imageSrc: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Image Alt</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.imageAlt}
                onChange={(e) => setNewFilm({ ...newFilm, imageAlt: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Video Src</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.videoSrc}
                onChange={(e) => setNewFilm({ ...newFilm, videoSrc: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Thumbnail</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.thumbnail}
                onChange={(e) => setNewFilm({ ...newFilm, thumbnail: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Release Date</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.releaseDate}
                onChange={(e) => setNewFilm({ ...newFilm, releaseDate: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Duration</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.duration}
                onChange={(e) => setNewFilm({ ...newFilm, duration: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Categories</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.categories}
                onChange={(e) => setNewFilm({ ...newFilm, categories: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Author</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.author}
                onChange={(e) => setNewFilm({ ...newFilm, author: e.target.value })}
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
            <label className={styles.formLabel}>Content</label>
            <textarea
                className={styles.formTextarea}
                value={newFilm.content}
                onChange={(e) => setNewFilm({ ...newFilm, content: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Preuzeto</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.preuzeto}
                onChange={(e) => setNewFilm({ ...newFilm, preuzeto: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Summary</label>
            <textarea
                className={styles.formTextarea}
                value={newFilm.summary}
                onChange={(e) => setNewFilm({ ...newFilm, summary: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Date</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.date}
                onChange={(e) => setNewFilm({ ...newFilm, date: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Link</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.link}
                onChange={(e) => setNewFilm({ ...newFilm, link: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Alt</label>
            <input
                className={styles.formInput}
                type="text"
                value={newFilm.alt}
                onChange={(e) => setNewFilm({ ...newFilm, alt: e.target.value })}
            />
        </div>

        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Type</label>
            <select
                className={styles.formSelect}
                value={newFilm.type}
                onChange={(e) => setNewFilm({ ...newFilm, type: e.target.value })}
            >
                <option value="movie">Movie</option>
                <option value="show">Show</option>
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
            <textarea
                className={styles.formTextarea}
                value={newNovost.tekst}
                onChange={(e) => setNewNovost({ ...newNovost, tekst: e.target.value })}
            />
        </div>

        {/* Text 2 */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Text 2</label>
            <textarea
                className={styles.formTextarea}
                value={newNovost.tekst2}
                onChange={(e) => setNewNovost({ ...newNovost, tekst2: e.target.value })}
            />
        </div>

        {/* Text 3 */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Text 3</label>
            <textarea
                className={styles.formTextarea}
                value={newNovost.tekst3}
                onChange={(e) => setNewNovost({ ...newNovost, tekst3: e.target.value })}
            />
        </div>

        {/* Text 4 */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Text 4</label>
            <textarea
                className={styles.formTextarea}
                value={newNovost.tekst4}
                onChange={(e) => setNewNovost({ ...newNovost, tekst4: e.target.value })}
            />
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

        {/* Image 2 URL */}
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Slika 2 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika2: e.target.files[0] })}
            />
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
            <textarea
                className={styles.formTextarea}
                placeholder="Tekst 1"
                value={newNovost.tekst}
                onChange={(e) => setNewNovost({ ...newNovost, tekst: e.target.value })}
            ></textarea>
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Text 2</label>
            <textarea
                className={styles.formTextarea}
                placeholder="Tekst 2"
                value={newNovost.tekst2}
                onChange={(e) => setNewNovost({ ...newNovost, tekst2: e.target.value })}
            ></textarea>
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Text 3</label>
            <textarea
                className={styles.formTextarea}
                placeholder="Tekst 3"
                value={newNovost.tekst3}
                onChange={(e) => setNewNovost({ ...newNovost, tekst3: e.target.value })}
            ></textarea>
        </div>
        <div className={styles.formGroup}>
            <label className={styles.formLabel}>Text 4</label>
            <textarea
                className={styles.formTextarea}
                placeholder="Tekst 4"
                value={newNovost.tekst4}
                onChange={(e) => setNewNovost({ ...newNovost, tekst4: e.target.value })}
            ></textarea>
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
            <label className={styles.formLabel}>Slika 2 URL</label>
            <input
                className={styles.formInput}
                type="file"
                onChange={(e) => setNewNovost({ ...newNovost, slika2:  e.target.files[0] })}
            />
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
