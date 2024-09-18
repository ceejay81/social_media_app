import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { PostComponent } from '../post/post.component';
import { PostService } from '../services/post.service';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, FormsModule, PostComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent implements OnInit {
  posts: any[] = [];
  newPostContent: string = '';

  constructor(private postService: PostService) {}

  ngOnInit() {
    this.loadPosts();
  }

  loadPosts() {
    this.postService.getPosts().subscribe(
      (posts) => {
        this.posts = posts;
      },
      (error) => {
        console.error('Error fetching posts:', error);
        // Handle error (e.g., show error message to user)
      }
    );
  }

  onCreatePost() {
    if (this.newPostContent.trim()) {
      this.postService.createPost(this.newPostContent).subscribe(
        (newPost) => {
          this.posts.unshift(newPost);
          this.newPostContent = '';
        },
        (error) => {
          console.error('Error creating post:', error);
          // Handle error (e.g., show error message to user)
        }
      );
    }
  }
}
