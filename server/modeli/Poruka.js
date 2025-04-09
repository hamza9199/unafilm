const { DataTypes } = require('sequelize');
const sequelize = require('../sequelizeInstance');

const Poruka = sequelize.define('Poruka', {
    ime: {
        type: DataTypes.STRING,
        allowNull: false,
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
        validate: {
            isEmail: true,
        },
    },
    poruka: {
        type: DataTypes.TEXT,
        allowNull: false,
    },
    createdAt: {
        type: DataTypes.DATE,
        defaultValue: DataTypes.NOW,
    },
}, {
    tableName: 'poruke',
    timestamps: false,
});

module.exports = Poruka;