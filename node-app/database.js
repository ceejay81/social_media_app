const mongoose = require('mongoose');

// Replace <dbname> with the name of your database
const uri = 'mongodb://localhost:27017/social_media_app';

mongoose.connect(uri, {
  useNewUrlParser: true,
  useUnifiedTopology: true,
})
.then(() => console.log('MongoDB connected successfully'))
.catch(err => console.error('Failed to connect to MongoDB', err));
