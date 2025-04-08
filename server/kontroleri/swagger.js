const swaggerJsDoc = require('swagger-jsdoc');
const swaggerUi = require('swagger-ui-express');

const swaggerDefinition = {
  openapi: '3.0.0',
    info: {
        title: 'API Documentation',
        version: '1.0.0',
        description: 'API documentation for the project',
    },
    servers: [
        {
            url: 'http://localhost:3000',
            description: 'Development server',
        },    
    ],
};


const options = {
    swaggerDefinition,
    apis: ['./kontroleri/*.js'],
};

const swaggerSpec = swaggerJsDoc(options);


module.exports = app => {
    app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));
};