import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-post',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './post.component.html',
  styleUrl: './post.component.scss'
})
export class PostComponent {
  @Input() post: any; // Replace 'any' with a proper Post interface

  onLike() {
    // Implement like functionality
    console.log('Liked post:', this.post.id);
  }

  onComment() {
    // Implement comment functionality
    console.log('Commenting on post:', this.post.id);
  }

  onShare() {
    // Implement share functionality
    console.log('Sharing post:', this.post.id);
  }
}
