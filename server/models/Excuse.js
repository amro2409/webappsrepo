const mongoose = require('mongoose');

const excuseSchema = new mongoose.Schema({
    studentId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
    reason: { type: String, required: true },
    date: { type: Date, required: true },
    status: { type: String, enum: ['pending', 'approved', 'rejected'], default: 'pending' },
    supportingDocument: { type: String }  // URL or path to the document
});

module.exports = mongoose.model('Excuse', excuseSchema);