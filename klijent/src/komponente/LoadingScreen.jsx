import React from "react";
import styles from "./css/LoadingScreen.module.css";

const LoadingScreen = () => {
  return (
    <div className={styles.amyPageLoad + " " + styles.loaded}>
      <div className={styles.amyPageLoadWrapper}>
        {[...Array(8)].map((_, i) => (
          <div key={i} className={`${styles.bar} ${styles["bar" + (i + 1)]}`}></div>
        ))}
      </div>
    </div>
  );
};

export default LoadingScreen;