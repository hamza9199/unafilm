const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance')

const Film = sequelize.define('Film', {
    title: {
        type: DataTypes.STRING,
        allowNull: false,
        trim: true
    },
    director: {
        type: DataTypes.STRING,
        allowNull: false,
        trim: true
    },
    genre: {
        type: DataTypes.STRING,
        allowNull: false,
        trim: true
    },
    releaseDate: {
        type: DataTypes.DATE,
        allowNull: false
    },
    duration: {
        type: DataTypes.INTEGER, 
        allowNull: false
    },
    language: {
        type: DataTypes.STRING,
        allowNull: false,
        trim: true
    },
    imdbRating: {
        type: DataTypes.FLOAT,
        validate: {
            min: 0,
            max: 10
        }
    },
    posterUrl: {
        type: DataTypes.STRING,
        trim: true
    },
    description: {
        type: DataTypes.TEXT,
        trim: true
    },
    createdAt: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW
    }
}, {
    tableName: 'films',
    timestamps: false 
});

module.exports = Film;