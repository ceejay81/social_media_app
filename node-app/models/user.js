// models/User.js
const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const UserSchema = new Schema({
  username: { type: String, required: true, unique: true },
  email: { type: String, required: true, unique: true },  // Add email field
  password: { type: String, required: true }
});

module.exports = mongoose.model('User', UserSchema);
