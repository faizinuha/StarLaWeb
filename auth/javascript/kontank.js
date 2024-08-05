// kontank.js

const btn = document.getElementById('button');

document.getElementById('form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent default form submission

  btn.value = 'Sending...'; // Change button text to indicate sending

  const serviceID = 'default_service'; // Replace with your EmailJS service ID
  const templateID = 'template_ebqbggs'; // Replace with your EmailJS template ID

  emailjs.sendForm(serviceID, templateID, this)
    .then(() => {
      btn.value = 'Send Email'; // Revert button text after successful send
      alert('Email sent successfully!');
      alert('cek You Email');
      window.location.href = '../login.php';
      this.reset(); // Optional: Reset form fields after successful submission
    })
    .catch((err) => {
      btn.value = 'Send Email'; // Revert button text after error
      alert('Failed to send email. Please try again later.');
      console.error('EmailJS send error:', err);
    });
});
