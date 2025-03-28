import React from 'react';
import { useLocation, Link } from 'react-router-dom';
import styles from './css/Breadcrumb.module.css';

const Breadcrumb = () => {
    const location = useLocation();
    const pathSegments = location.pathname.split('/').filter(Boolean);

    return (
        <div className={styles.breadcrumbContainer}>
            <div className={styles.innerContainer}>
                <h1 className={styles.pageTitle}>{pathSegments[pathSegments.length - 1] || 'Početna'}</h1>
                <div className={styles.breadcrumb}>
                    <Link to="/" className={styles.homeLink}>Una Film Distribucija</Link>
                    {pathSegments.map((segment, index) => {
                        const path = `/${pathSegments.slice(0, index + 1).join('/')}`;
                        const isLast = index === pathSegments.length - 1;
                        return (
                            <span key={path} className={styles.breadcrumbItem}>
                                {' > '}
                                {isLast ? (
                                    <span className={styles.currentPage}>{segment.replace(/-/g, ' ')}</span>
                                ) : (
                                    <Link to={path} className={styles.breadcrumbLink}>{segment.replace(/-/g, ' ')}</Link>
                                )}
                            </span>
                        );
                    })}
                </div>
            </div>
        </div>
    );
};

export default Breadcrumb;
