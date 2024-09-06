import { Component, AfterViewInit } from '@angular/core';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css']
})
export class AuthComponent implements AfterViewInit {

  isSignUp: boolean = false;  // Track whether the form is for sign-up or sign-in
  name: string = '';
  email: string = '';
  password: string = '';

  constructor(private authService: AuthService, private router: Router) {}

  ngAfterViewInit() {
    this.initializeSignUpSignIn();
  }

  initializeSignUpSignIn() {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    if (signUpButton && signInButton && container) {
      signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
        this.isSignUp = true;  // Set form to sign-up
      });

      signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
        this.isSignUp = false;  // Set form to sign-in
      });
    }
  }

  toggleForm() {
    this.isSignUp = !this.isSignUp; // Toggle between sign-up and sign-in forms
  }

  onSubmit() {
    if (this.isSignUp) {
      // Call signup method from AuthService
      this.authService.signup(this.name, this.email, this.password).subscribe(
        response => {
          console.log('Registered successfully');
          // Redirect to home page or dashboard after successful registration
          this.router.navigate(['/home']);
        },
        error => {
          console.error('Registration failed', error);
          // Display error message
          alert('Registration failed. Please try again.');
        }
      );
    } else {
      // Call login method from AuthService
      this.authService.login(this.email, this.password).subscribe(
        response => {
          console.log('Logged in successfully');
          // Redirect to home page or dashboard after successful login
          this.router.navigate(['/home']);
        },
        error => {
          console.error('Login failed', error);
          // Display error message
          alert('Login failed. Please check your credentials and try again.');
        }
      );
    }
  }
}
