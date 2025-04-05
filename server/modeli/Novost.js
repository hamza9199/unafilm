const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');
const Film = require('./Film');  // Importovanje modela Film

const Novost = sequelize.define('Novost', {
    film: {
        type: DataTypes.INTEGER,  // ID filma kao poveznica
        references: {
            model: Film,  // Veza sa Film modelom
            key: 'id',
        },
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
    trailer: {
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

// Definisanje odnosa između Novost i Film modela
Novost.belongsTo(Film, { foreignKey: 'film' });

module.exports = Novost;
