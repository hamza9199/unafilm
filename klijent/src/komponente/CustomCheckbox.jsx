import React from 'react';
import styles from './css/CustomCheckbox.module.css';

const CustomCheckbox = ({ label, checked, onChange }) => {
    return (
        <label className={styles.checkboxContainer}>
            {label}
            <input type="checkbox" checked={checked} onChange={onChange} />
            <span className={styles.checkmark}></span>
        </label>
    );
};

export default CustomCheckbox;
