import React from 'react';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import styles from './css/Kontakt.module.css';
import Breadcrumb from '../komponente/Breadcrumb';

const Kontakt = () => {
    return (
        <>
            <Header />
            <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: 'Kontakt', link: '/kontakt' },
                ]}
            />
            <div className={styles.container}>
                <div className={styles.header}>
                    <div className={styles.card}>
                        <h4 className={styles.cardTitle}>Head of Marketing and Distribution:</h4>
                        <p className={styles.cardText}>Denis Samardžić</p>
                        <p className={styles.cardText}>Email: <a href="mailto:denis.samardzic@unafilm.ba" className="text-blue-600">denis.samardzic@unafilm.ba</a></p>
                    </div>
                    
                    <div className={styles.card}>
                        <h4 className={styles.cardTitle}>Booking Manager and Sales Assistant:</h4>
                        <p className={styles.cardText}>Emir Serdarević</p>
                        <p className={styles.cardText}>Email: <a href="mailto:emir.serdarevic@unafilm.ba" className="text-blue-600">emir.serdarevic@unafilm.ba</a></p>
                    </div>
                </div>
                
                <div className={styles.formSection}>
                    <h2 className="text-xl font-semibold mb-4">Kontaktirajte nas</h2>
                    <form>
                        <div className="mb-4">
                            <label className={styles.formLabel}>Ime</label>
                            <input type="text" className={styles.formInput} placeholder="Unesite ime" required />
                        </div>
                        <div className="mb-4">
                            <label className={styles.formLabel}>Email</label>
                            <input type="email" className={styles.formInput} placeholder="Unesite email" required />
                        </div>
                        <div className="mb-4">
                            <label className={styles.formLabel}>Poruka</label>
                            <textarea className={styles.formTextarea} placeholder="Unesite poruku" required></textarea>
                        </div>
                        <button type="submit" className={styles.submitButton}>Pošalji</button>
                    </form>
                </div>
                
                {/* Google Map Embed */}
                <div className={styles.mapContainer}>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d64707.83268762878!2d17.870404933900435!3d44.213060074133494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475ee3c8ef5aca51%3A0x1349cf962bbe5fc2!2sCineStar%20Cinemas%20Zenica%20(Ekran%20family%20centar)!5e0!3m2!1sen!2sba!4v1743175874423!5m2!1sen!2sba" width="100%" height="450" style={{ border: 0 }} allowFullScreen="" loading="lazy" referrerPolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <Footer />
        </>
    );
};

export default Kontakt;
