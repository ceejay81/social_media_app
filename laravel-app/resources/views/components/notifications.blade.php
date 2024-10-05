<div id="notifications">
    <!-- Notifications will be dynamically inserted here -->
</div>

<script>
window.Echo.private('notifications.' + {{ auth()->id() }})
    .listen('NewNotification', (e) => {
        // Add the new notification to the UI
        const notificationsContainer = document.getElementById('notifications');
        const notificationElement = document.createElement('div');
        notificationElement.textContent = e.notification.data;
        notificationsContainer.prepend(notificationElement);
    });
</script>