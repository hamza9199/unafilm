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
        allowNull: false,
    },
    title: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    kreator: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    tekst: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    tekst2: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    tekst3: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    tekst4: {
        type: DataTypes.STRING,
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
        allowNull: false,
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
