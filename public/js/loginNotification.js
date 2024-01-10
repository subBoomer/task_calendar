document.addEventListener('DOMContentLoaded', function() {
    const notificationBox = document.getElementById('notificationBox');
    const closeButton = document.getElementById('closeButton');

    function closeNotification() {
        setTimeout(() => {
            notificationBox.style.display = 'none';
        }, 5000); // Adjust the delay time (in milliseconds) here
    }

    closeButton.addEventListener('click', () => {
        notificationBox.style.display = 'none';
    });

    closeNotification();
});
