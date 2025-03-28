import React from 'react';
import styles from './css/Novosti.module.css';
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Breadcrumb from '../komponente/Breadcrumb';
import LijeviBaner from '../komponente/LijeviBaner';

const Novosti = () => {
    return (
        <>
        <Header/>
        <Breadcrumb
                items={[
                    { name: 'Una Film Distribucija', link: '/' },
                    { name: 'Novosti', link: '/novosti' },
                ]}
            />

        <div>
        <LijeviBaner/>

        </div>
        <Footer/>
        </>
    );
};

export default Novosti;