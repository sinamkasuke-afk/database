
const ICONS = {
  dashboard: '<svg viewBox="0 0 24 24"><path d="M3 11.5 12 4l9 7.5v8a1.5 1.5 0 0 1-1.5 1.5H15v-6H9v6H4.5A1.5 1.5 0 0 1 3 19.5v-8Z"/></svg>',

  reservation: '<svg viewBox="0 0 24 24"><path d="M7 2h2v3h6V2h2v3h2.5A2.5 2.5 0 0 1 22 7.5v12A2.5 2.5 0 0 1 19.5 22h-15A2.5 2.5 0 0 1 2 19.5v-12A2.5 2.5 0 0 1 4.5 5H7V2Zm13 8H4v9.5c0 .3.2.5.5.5h15c.3 0 .5-.2.5-.5V10ZM6 12h3v3H6v-3Zm5 0h3v3h-3v-3Zm5 0h2v3h-2v-3ZM6 16h3v2H6v-2Zm5 0h3v2h-3v-2Z"/></svg>',

  calendar: '<svg viewBox="0 0 24 24"><path d="M7 2h2v3h6V2h2v3h2.5A2.5 2.5 0 0 1 22 7.5v12A2.5 2.5 0 0 1 19.5 22h-15A2.5 2.5 0 0 1 2 19.5v-12A2.5 2.5 0 0 1 4.5 5H7V2Zm13 8H4v9.5c0 .3.2.5.5.5h15c.3 0 .5-.2.5-.5V10Z"/></svg>',

  history: '<svg viewBox="0 0 24 24"><path d="M12 5a7 7 0 1 1-6.32 4H3l3.7-4.2L10.4 9H7.9A5 5 0 1 0 12 7V5Zm-1 4h2v4l3 1.8-1 1.7-4-2.4V9Z"/></svg>',

  logout: '<svg viewBox="0 0 24 24"><path d="M4 4h9v2H6v12h7v2H4V4Zm12.6 4.4L22 14l-5.4 5.6-1.4-1.4L18.1 15H10v-2h8.1l-2.9-3.2 1.4-1.4Z"/></svg>'
};

function getData() {

  let d = localStorage.getItem('nuRequests');

  if (!d) {
    return [];
  }

  return JSON.parse(d);
}

function saveData(d) {
  localStorage.setItem('nuRequests', JSON.stringify(d));
}

function counts() {

  let d = getData();

  return {
    total: d.length,
    pending: d.filter(x => x[6] == 'pending').length,
    approved: d.filter(x => x[6] == 'approved').length,
    declined: d.filter(x => x[6] == 'declined').length
  };
}

function badge(s) {
  return `<span class="badge ${s}">
    ${s[0].toUpperCase() + s.slice(1)}
  </span>`;
}

function sidebar(active) {

  return `<aside class="sidebar">

    <div class="side-content">

      <div class="brand">
        <img class="brand-logo" src="nu-logo.png" alt="NU Logo">

        <h1>
          NATIONAL<br>
          UNIVERSITY<br>
          MANILA
        </h1>
      </div>

      <p class="system">
        FACILITIES RESERVATION SYSTEM
      </p>

      <div class="line"></div>

      <nav class="nav">

        <a class="${active == 'dashboard' ? 'active' : ''}" href="dashboard.php">
          <span class="icon">${ICONS.dashboard}</span>
          Dashboard
        </a>

        <a class="${active == 'reservation' ? 'active' : ''}" href="reservation.php">
          <span class="icon">${ICONS.reservation}</span>
          Reservation Requests
        </a>

        <a class="${active == 'calendar' ? 'active' : ''}" href="calendar.php">
          <span class="icon">${ICONS.calendar}</span>
          Calendar
        </a>

        <a class="${active == 'history' ? 'active' : ''}" href="history.php">
          <span class="icon">${ICONS.history}</span>
          History
        </a>

        <a href="logout.html">
          <span class="icon">${ICONS.logout}</span>
          Logout
        </a>

      </nav>

      <img class="bulldog" src="bulldog.png" alt="NU Bulldog">

    </div>

    <div class="contact">
      <h3>PFMO Contact</h3>
      <p>☎ (02) 8527-4630 loc. 113</p>
      <p>✉ pfmo@nu.edu.ph</p>
    </div>

  </aside>`;
}

function topbar() {

  return `<header class="topbar">

    <div>
      <h2>Welcome, Admin!</h2>
      <p>Physical Facilities Management Office</p>
    </div>

    <div class="user">

      <div class="avatar">A</div>

      <div>
        <b>Admin User</b>
        <small>Administrator</small>
      </div>

    </div>

  </header>`;
}
function initShell(active) {

  document.querySelector('.layout')
    .insertAdjacentHTML('afterbegin', sidebar(active));

  document.querySelector('.main')
    .insertAdjacentHTML('afterbegin', topbar());

  document.querySelectorAll('[data-ico]')
    .forEach(e => e.innerHTML = ICONS[e.dataset.ico] || '');
}