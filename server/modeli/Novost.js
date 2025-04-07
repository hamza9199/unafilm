const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');
const Film = require('../modeli/Film');  

const Novost = sequelize.define('Novost', {
    filmId: {
        type: DataTypes.INTEGER,  
        references: {
            model: Film,  
            key: 'id',
        },
        allowNull: true,
    },
    title: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    kreator: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    tekst: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    tekst2: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    tekst3: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    tekst4: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    slika1: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    slika2: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    slika3: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    tipNovosti: {
        type: DataTypes.STRING,
        allowNull: true,
        validate: {
            isIn: [['novost', 'svijetfilma', 'trailer']],
        },
    },
    datumKreiranja: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
}, {
    tableName: 'novosti',
    timestamps: false,
});

Novost.belongsTo(Film, { foreignKey: 'filmId', as: 'film' });

module.exports = Novost;
