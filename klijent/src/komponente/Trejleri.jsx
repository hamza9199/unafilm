import React from 'react';
import styles from './css/Trejleri.module.css';

const Trejleri = () => {
    const trailers = [
        {
            id: 8,
            title: "M3GUN 2.0",
            videoUrl: "https://www.youtube.com/embed/xm2IBrrYYCA",
            thumbnail: "https://i.ytimg.com/vi/xm2IBrrYYCA/mqdefault.jpg",
        },
        {
            id: 7,
            title: "IGRA STRAHA",
            videoUrl: "https://www.youtube.com/embed/N62dwe_3COQ",
            thumbnail: "https://i.ytimg.com/vi/N62dwe_3COQ/mqdefault.jpg",
        },
        {
            id: 5,
            title: "LOŠI MOMCI 2",
            videoUrl: "https://www.youtube.com/embed/IQb7Gcn2Zjw",
            thumbnail: "https://i.ytimg.com/vi/IQb7Gcn2Zjw/mqdefault.jpg",
        },
        {
            id: 6,
            title: "KLOVN",
            videoUrl: "https://www.youtube.com/embed/11zlrgmHsZ4",
            thumbnail: "https://i.ytimg.com/vi/11zlrgmHsZ4/mqdefault.jpg",
        },
        {
            id: 3,
            title: "PRASAK",
            videoUrl: "https://www.youtube.com/embed/rjOsC5W9W6o",
            thumbnail: "https://i.ytimg.com/vi/rjOsC5W9W6o/maxresdefault.jpg",
        },
        {
            id: 4,
            title: "NOVOCAINE",
            videoUrl: "https://www.youtube.com/embed/WWSnYxBBT70",
            thumbnail: "https://i.ytimg.com/vi/WWSnYxBBT70/maxresdefault.jpg",
        },
    ];

    return (
        <>
        
        <div className={styles.container}>
            <h2 className={styles.heading}>Trailer & Video</h2>
            <div className={styles.trailerGrid}>
                {trailers.map((trailer) => (
                    <div key={trailer.id} className={styles.trailerItem}>
                        <a href={trailer.videoUrl} target="_blank" rel="noopener noreferrer">
                            <div className={styles.thumbnailContainer}>
                                <img
                                    src={trailer.thumbnail}
                                    alt={trailer.title}
                                    className={styles.thumbnail}
                                />
                                <div className={styles.overlay}>
                                    <p className={styles.playIcon}>▶</p>
                                </div>
                            </div>
                            <h3 className={styles.title}>{trailer.title}</h3>
                        </a>
                    </div>
                ))}
            </div>
        </div>

        </>
    );
};

export default Trejleri;
