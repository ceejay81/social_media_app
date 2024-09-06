import { Component, ElementRef, ViewChild, AfterViewInit } from '@angular/core';

@Component({
  selector: 'app-home',
  standalone: true,
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements AfterViewInit {
  @ViewChild('messages') messages!: ElementRef;
  @ViewChild('messagesNotification') messagesNotification!: ElementRef;
  @ViewChild('messageSearch') messageSearch!: ElementRef;

  menuItems: HTMLElement[] = [];

  ngAfterViewInit() {
    this.menuItems = Array.from(document.querySelectorAll('.menu-item'));
    this.initializeMenuItems();
    this.initializeMessagesNotification();
    this.initializeMessageSearch();
  }

  initializeMenuItems() {
    this.menuItems.forEach((item) => {
      item.addEventListener('click', () => {
        this.changeActiveItem();
        item.classList.add('active');

        if (item.id !== 'notifications') {
          (document.querySelector('.notifications-popup') as HTMLElement).style.display = 'none';
        } else {
          (document.querySelector('.notifications-popup') as HTMLElement).style.display = 'block';
          (document.querySelector('#notifications .notification-count') as HTMLElement).style.display = 'none';
        }
      });
    });
  }

  changeActiveItem() {
    this.menuItems.forEach((item) => {
      item.classList.remove('active');
    });
  }

  initializeMessageSearch() {
    this.messageSearch.nativeElement.addEventListener('keyup', this.searchMessage.bind(this));
  }

  searchMessage() {
    const val = this.messageSearch.nativeElement.value.toLowerCase();
    const messages = this.messages.nativeElement.querySelectorAll('.message');

    messages.forEach((chat: HTMLElement) => {
      let name = chat.querySelector('h5')?.textContent?.toLowerCase();
      chat.style.display = name && name.includes(val) ? 'flex' : 'none';
    });
  }

  initializeMessagesNotification() {
    this.messagesNotification.nativeElement.addEventListener('click', () => {
      this.messages.nativeElement.style.boxShadow = '0 0 1rem var(--color-primary)';
      this.messagesNotification.nativeElement.querySelector('.notification-count').style.display = 'none';
      setTimeout(() => {
        this.messages.nativeElement.style.boxShadow = 'none';
      }, 2000);
    });
  }
}
