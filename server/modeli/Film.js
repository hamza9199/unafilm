const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');


const Film = sequelize.define('Film', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,  // Osigurava automatski inkrement ID
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
    
    createdAt: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
    
}, {
    tableName: 'filmovi',
    timestamps: false,
});


module.exports = Film;