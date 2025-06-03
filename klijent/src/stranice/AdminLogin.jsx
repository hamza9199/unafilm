import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/AdminLogin.module.css';
import { Helmet } from 'react-helmet';
import { FaEye, FaEyeSlash } from 'react-icons/fa';

const AdminLogin = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        setError('');

        try {
           const response = await axios.post(
            'https://unafilm.onrender.com/server/admin/login',
            {
                username,
                password
            },
            {
                headers: {
                    'x-api-key': 'admin'
                }
            }
        );


            if (response.data.message === 'Login successful') {
                localStorage.setItem('adminToken', "992299"); // Save token to local storage
                navigate('/admin');
                window.location.reload(); // Reload the page to reflect the new state
            }
        } catch (err) {
            setError(err.response?.data?.error || 'Login failed. Please try again.');
        }
    };

    return (
        <>
            <Header />
            <Helmet>
                <title>Admin Login - Una Film</title>
                <meta name="description" content="Admin login page for Una Film" />
                <meta name="keywords" content="admin, login, Una Film" />
            </Helmet>
            <div className={styles.container}>
                <div className={styles.container2}>
                    <h2 className={styles.title}>Admin Login</h2>
                    <form onSubmit={handleLogin} className={styles.form}>
                        <div className={styles.inputGroup}>
                            <label htmlFor="username">Korisničko Ime</label>
                            <input
                                type="text"
                                id="username"
                                value={username}
                                onChange={(e) => setUsername(e.target.value)}
                                required
                                className={styles.input}
                            />
                        </div>
                        <div className={styles.inputGroup} style={{ position: 'relative' }}>
                            <label htmlFor="password">Lozinka</label>
                            <input
                                type={showPassword ? "text" : "password"}
                                id="password"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                                className={styles.input2}
                                style={{ paddingRight: '25px' }}
                            />
                            <button
                                type="button"
                                onClick={() => setShowPassword((prev) => !prev)}
                                className={styles.togglePasswordBtn}
                                tabIndex={-1}
                                aria-label={showPassword ? "Sakrij lozinku" : "Prikaži lozinku"}
                            >
                                {showPassword ? <FaEyeSlash /> : <FaEye />}
                            </button>
                        </div>
                        {error && <p className={styles.error}>{error}</p>}
                        <button type="submit" onClick={handleLogin} className={styles.button}>Login</button>
                    </form>
                </div>
            </div>
            <Footer />
        </>
    );
};

export default AdminLogin;