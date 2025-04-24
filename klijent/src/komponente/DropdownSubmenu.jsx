import React from 'react';
import * as DropdownMenu from '@radix-ui/react-dropdown-menu';
import styles from './css/DropdownSubmenu.module.css';
import { ChevronDownIcon } from '@radix-ui/react-icons';
import { Link } from 'react-router-dom';

const DropdownSubmenu = ({ label, items }) => {
    return (
        <DropdownMenu.Root>
            <DropdownMenu.Trigger className={styles.trigger}>
                {label} <ChevronDownIcon />
            </DropdownMenu.Trigger>

            <DropdownMenu.Content className={styles.content} sideOffset={5}>
                <div className={styles.itemsWrapper}>
                    {items.map((item, idx) => (
                        <DropdownMenu.Item key={idx} className={styles.item} asChild>
                            <Link to={item.href}>{item.label}</Link>
                        </DropdownMenu.Item>
                    ))}
                </div>
            </DropdownMenu.Content>
        </DropdownMenu.Root>
    );
};

export default DropdownSubmenu;
