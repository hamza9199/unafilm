import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';

const AdminDashboard = () => {
    const [films, setFilms] = useState([]);
    const [novosti, setNovosti] = useState([]);
    const [newFilm, setNewFilm] = useState({ title: '', description: '' });
    const [newNovost, setNewNovost] = useState({ tekst: '', tipNovosti: '' });

    useEffect(() => {
        fetchFilms();
        fetchNovosti();
    }, []);

    const fetchFilms = async () => {
        try {
            const response = await axios.get('http://localhost:3000/server/filmovi');
            if (Array.isArray(response.data)) {
                setFilms(response.data);
            } else {
                console.error('Expected an array, but received:', response.data);
            }
        } catch (error) {
            console.error('Error fetching films:', error);
        }
    };

    const fetchNovosti = async () => {
        try {
            const response = await axios.get('http://localhost:3000/server/novosti');
            if (Array.isArray(response.data)) {
                setNovosti(response.data);
            } else {
                console.error('Expected an array, but received:', response.data);
            }
        } catch (error) {
            console.error('Error fetching novosti:', error);
        }
    };

    const handleCreateFilm = async () => {
        try {
            await axios.post('http://localhost:3000/server/filmovi', newFilm);
            fetchFilms();
            setNewFilm({ title: '', description: '' });
        } catch (error) {
            console.error('Error creating film:', error);
        }
    };

    const handleCreateNovost = async () => {
        try {
            await axios.post('http://localhost:3000/server/novosti', newNovost);
            fetchNovosti();
            setNewNovost({ tekst: '', tipNovosti: '' });
        } catch (error) {
            console.error('Error creating novost:', error);
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

    return (
        <>
        <Header />
        <div style={{ padding: '20px' }}>
            <h1>Admin Dashboard</h1>

            <section>
                <h2>Films</h2>
                <table border="1" style={{ width: '100%', marginBottom: '20px' }}>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {Array.isArray(films) && films.map((film) => (
                            <tr key={film.id}>
                                <td>{film.title}</td>
                                <td>{film.description}</td>
                                <td>
                                    <button onClick={() => handleDeleteFilm(film.id)}>Delete</button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                <h3>Create Film</h3>
                <input
                    type="text"
                    placeholder="Title"
                    value={newFilm.title}
                    onChange={(e) => setNewFilm({ ...newFilm, title: e.target.value })}
                />
                <input
                    type="text"
                    placeholder="Description"
                    value={newFilm.description}
                    onChange={(e) => setNewFilm({ ...newFilm, description: e.target.value })}
                />
                <button onClick={handleCreateFilm}>Create</button>
            </section>

            <section>
                <h2>Novosti</h2>
                <table border="1" style={{ width: '100%', marginBottom: '20px' }}>
                    <thead>
                        <tr>
                            <th>Text</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {Array.isArray(novosti) && novosti.map((novost) => (
                            <tr key={novost.id}>
                                <td>{novost.tekst}</td>
                                <td>{novost.tipNovosti}</td>
                                <td>
                                    <button onClick={() => handleDeleteNovost(novost.id)}>Delete</button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                <h3>Create Novost</h3>
                <input
                    type="text"
                    placeholder="Text"
                    value={newNovost.tekst}
                    onChange={(e) => setNewNovost({ ...newNovost, tekst: e.target.value })}
                />
                <input
                    type="text"
                    placeholder="Type"
                    value={newNovost.tipNovosti}
                    onChange={(e) => setNewNovost({ ...newNovost, tipNovosti: e.target.value })}
                />
                <button onClick={handleCreateNovost}>Create</button>
            </section>
        </div>

        <Footer />
        </>
    );
};

export default AdminDashboard;
