import React from 'react';
import { Link } from 'react-router-dom';
import styles from './css/Breadcrumb.module.css';

const Breadcrumb = ({ items }) => {
    return (
        <div className={styles.breadcrumbContainer}>
            <div className={styles.innerContainer}>
                <h1 className={styles.pageTitle}>{items[items.length - 1]?.name || 'Početna'}</h1>
                <div className={styles.breadcrumb}>
                    {items.map((item, index) => {
                        const isLast = index === items.length - 1;
                        return (
                            <span key={item.link} className={styles.breadcrumbItem}>
                                {/* Display '>' only for non-first items */}
                                {index > 0 && ' > '}
                                {isLast ? (
                                    <span className={styles.currentPage}>{item.name}</span>
                                ) : (
                                    <Link to={item.link} className={styles.breadcrumbLink}>{item.name}</Link>
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
