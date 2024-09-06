import { Component, AfterViewInit } from '@angular/core';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';  // Import Router for navigation

@Component({
  selector: 'app-auth',
  standalone: true,
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
      });

      signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
      });
    }
  }

  toggleForm() {
    this.isSignUp = !this.isSignUp;
  }

  onSubmit() {
    if (this.isSignUp) {
      // Call authService method for registration
      this.authService.signup(this.name, this.email, this.password).subscribe(
        response => {
          console.log('Registered successfully');
          this.router.navigate(['/home']);  // Redirect to home page after successful registration
        },
        error => {
          console.error('Registration failed', error);
          alert('Registration failed. Please try again.');
        }
      );
    } else {
      // Call authService method for login
      this.authService.login(this.email, this.password).subscribe(
        response => {
          console.log('Logged in successfully');
          this.router.navigate(['/home']);  // Redirect to home page after successful login
        },
        error => {
          console.error('Login failed', error);
          alert('Login failed. Please check your credentials and try again.');
        }
      );
    }
  }
}
