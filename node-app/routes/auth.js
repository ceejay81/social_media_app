// routes/auth.js
const express = require('express');
const router = express.Router();
const passport = require('passport');
const bcrypt = require('bcryptjs');
const User = require('../models/User');

// Sign Up
router.post('/signup', async (req, res) => {
  const { username, email, password } = req.body; // Include email
  try {
    const hashedPassword = await bcrypt.hash(password, 10);
    const newUser = new User({ username, email, password: hashedPassword });
    await newUser.save();
    res.status(201).send('User registered');
  } catch (err) {
    res.status(500).send('Error registering user');
  }
});

// Login
router.post('/login', passport.authenticate('local'), (req, res) => {
  res.send('Logged in');
});

// Logout
router.get('/logout', (req, res) => {
  req.logout();
  res.send('Logged out');
});

module.exports = router;
