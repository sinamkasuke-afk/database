// tix.js

// Generate ticket number
function generateTicketNumber() {
  const random = Math.floor(100000 + Math.random() * 900000); // 6-digit number
  const date = new Date();
  const year = date.getFullYear();

  return `NU-${year}-${random}`;
}

// Get or create ticket number
function getTicketNumber() {
  let ticket = localStorage.getItem("ticketNumber");

  if (!ticket) {
    ticket = generateTicketNumber();
    localStorage.setItem("ticketNumber", ticket);
  }

  return ticket;
}

// Run when page loads
document.addEventListener("DOMContentLoaded", function () {

  // 🔥 Reset ticket every time success page loads
  localStorage.removeItem("ticketNumber");

  const ticketElement = document.getElementById("ticket-number");

  if (ticketElement) {
    const newTicket = getTicketNumber();
    ticketElement.textContent = newTicket;
  }
});