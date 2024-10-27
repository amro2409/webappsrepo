const mongoose = require('mongoose');

const connectDB = async () => {
    try {
        await mongoose.connect('mongodb+srv://alkamaliamro:alkamaliamro@cluster0.kwanzlc.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0'
             //,{ useNewUrlParser: true, useUnifiedTopology: true }
            );
        console.log('MongoDB connected');
    } catch (error) {
        console.error('MongoDB connection failed:', error.message);
        process.exit(1);
    }
};

module.exports = connectDB;

