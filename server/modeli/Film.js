const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');

const Film = sequelize.define('Film', {
    title: {
        type: DataTypes.STRING,
        allowNull: true,
        defaultValue: "moj film",
    },
    description: {
        type: DataTypes.TEXT,
        allowNull: true,
    },
    trailerUrl: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    detailsUrl: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    imageUrl: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    imageUrl2: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    imageSrc:{
        type: DataTypes.STRING,
        allowNull: true,
    },
    imageAlt:{
        type: DataTypes.STRING,
        allowNull: true,
    },
    videoSrc:{
        type: DataTypes.STRING,
        allowNull: true,
    },
    thumbnail:{
        type: DataTypes.STRING,
        allowNull: true,
    },
    releaseDate: {
        type: DataTypes.DATE,
        allowNull: true,
        defaultValue: DataTypes.NOW,

    },
    duration: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    categories: {
        type: DataTypes.JSON,
        allowNull: true,
    },
    author: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    comment: {
        type: DataTypes.INTEGER,
        allowNull: true,
    },
    content: {
        type: DataTypes.JSON,
        allowNull: true,
    },
    preuzeto: {
        type: DataTypes.STRING,
        allowNull: true,
    },
    summary:{
        type: DataTypes.TEXT,
        allowNull: true,
    },
    date:{
        type: DataTypes.DATE,
        allowNull:true,
        defaultValue: DataTypes.NOW,

    },
    link:{
        type:DataTypes.STRING,
        allowNull:true,
    },
    alt:{
        type:DataTypes.STRING,
        allowNull:true,
    },
    type:{
        type:DataTypes.STRING,
        allowNull:true,
    },
    tipMjesta: {
        type: DataTypes.ENUM('uskoro', 'trenutno', 'arhiva'),
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