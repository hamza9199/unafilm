const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');
const Film = require('../modeli/Film');  

const Novost = sequelize.define('Novost', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,  
    },
    filmId: {
        type: DataTypes.INTEGER,  
        allowNull: true,
        references: {
            model: Film,
            key: 'id',
        },
        onDelete: 'CASCADE',
        onUpdate: 'CASCADE',

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
