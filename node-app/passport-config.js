// passport-config.js
const LocalStrategy = require('passport-local').Strategy;
const bcrypt = require('bcryptjs');
const User = require('./models/User');

module.exports = function(passport) {
  passport.use(new LocalStrategy(
    { usernameField: 'login' }, // Use 'login' field for both email and username
    async function(login, password, done) {
      try {
        // Find user by username or email
        const user = await User.findOne({ 
          $or: [{ username: login }, { email: login }] 
        });

        if (!user) {
          return done(null, false, { message: 'No user with that username or email' });
        }

        // Match password
        const isMatch = await bcrypt.compare(password, user.password);
        if (isMatch) {
          return done(null, user);
        } else {
          return done(null, false, { message: 'Password incorrect' });
        }
      } catch (err) {
        return done(err);
      }
    }
  ));

  passport.serializeUser(function(user, done) {
    done(null, user.id);
  });

  passport.deserializeUser(async function(id, done) {
    try {
      const user = await User.findById(id);
      done(null, user);
    } catch (err) {
      done(err);
    }
  });
};
