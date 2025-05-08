const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');
const { v4: uuidv4 } = require('uuid'); // Dodaj ako koristiš vanjski UUID generator (nije obavezno s Sequelize)

const Film = sequelize.define('Film', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,  // Osigurava automatski inkrement ID
      },
       uuid: {
        type: DataTypes.UUID,
        defaultValue: DataTypes.UUIDV4, // Generira UUID automatski
        allowNull: true,
    },
    title: {//
        type: DataTypes.STRING,
        allowNull: true,
        defaultValue: "moj film",
    },
    description: {//
        type: DataTypes.TEXT,
        allowNull: true,
    },
    trailerUrl: {//
        type: DataTypes.STRING,
        allowNull: true,
    },
    imageUrl: {//
        type: DataTypes.STRING,
        allowNull: true,
    },
    imageUrl2: {//
        type: DataTypes.STRING,
        allowNull: true,
    },
    releaseDate: {//
        type: DataTypes.DATE,
        allowNull: true,
        defaultValue: DataTypes.NOW,
    },
    duration: {//
        type: DataTypes.INTEGER,
        allowNull: true,
    },
    reditelj: {//
        type: DataTypes.STRING,
        allowNull: true,
    },
    comment: {//
        type: DataTypes.INTEGER,
        allowNull: true,
    },
    type:{
        type:DataTypes.ENUM('serija', 'film'),
        allowNull:true,
    },
    tipMjesta: {
        type: DataTypes.ENUM('uskoro', 'trenutno', 'arhiva'),
        allowNull: true,  
    },
    opis: {//
        type: DataTypes.TEXT,
        allowNull: true,
    },
    od: {
        type: DataTypes.DATE,
        allowNull: true,
    },
    do: {
        type: DataTypes.DATE,
        allowNull: true,
    },
    createdAt: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
    
}, {
    tableName: 'filmovi',
    timestamps: false,
});


module.exports = Film;