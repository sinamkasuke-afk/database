<?php
include "api/db.php";

$approved = $conn->query("
  SELECT * FROM reservations
  WHERE LOWER(TRIM(status)) = 'approved'
  ORDER BY reservation_date ASC, start_time ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendar</title>

  <link rel="stylesheet" href="base.css" />
  <link rel="stylesheet" href="calendar.css" />
</head>

<body>

<div class="layout">
  <main class="main">
    <section class="content">

      <div class="page-title-row">
        <div class="title-left">
          <div class="title-icon" data-ico="calendar"></div>
          <div>
            <h1>Calendar</h1>
            <p>View approved facility reservations.</p>
          </div>
        </div>
      </div>

      <div class="calendar-layout">

        <div class="card calendar-card">
          <div class="cal-head">
            <div class="cal-btns">
              <button type="button" onclick="changeMonth(-1)">‹</button>
              <button type="button" onclick="changeMonth(1)">›</button>
              <button type="button" onclick="goToday()">Today</button>
            </div>

            <h2 id="monthTitle"></h2>

            <div class="view-btns">
              <button type="button" class="active">Month</button>
              <button type="button">Week</button>
              <button type="button">Day</button>
            </div>
          </div>

          <div id="calendarGrid" class="calendar-grid"></div>
        </div>

        <aside>
          <div class="side-card legend">
            <h3>Legend</h3>
            <p><span class="dot blue"></span>Approved Reservation</p>
          </div>

          <div class="side-card">
            <h3>Upcoming Reservations</h3>

            <?php while($row = $approved->fetch_assoc()): ?>
              <div class="upcoming">
                <b><?php echo $row["event_name"]; ?></b><br><br>
                <?php echo date("M d", strtotime($row["reservation_date"])); ?>
                •
                <?php echo $row["venue_name"]; ?>
              </div>
            <?php endwhile; ?>
          </div>
        </aside>

      </div>

    </section>

    <footer class="footer">
      © 2026 National University Manila<br />
      Physical Facilities Management Office
    </footer>
  </main>
</div>

<script src="app.js"></script>

<script>
initShell("calendar");

const events = [
<?php
$calendarEvents = $conn->query("
  SELECT * FROM reservations
  WHERE LOWER(TRIM(status)) = 'approved'
  ORDER BY reservation_date ASC, start_time ASC
");

while($row = $calendarEvents->fetch_assoc()):
?>
  {
    day: <?php echo date("j", strtotime($row["reservation_date"])); ?>,
    month: <?php echo date("n", strtotime($row["reservation_date"])) - 1; ?>,
    year: <?php echo date("Y", strtotime($row["reservation_date"])); ?>,
    title: "<?php echo addslashes($row["event_name"]); ?>",
    venue: "<?php echo addslashes($row["venue_name"]); ?>",
    time: "<?php echo date("g:i A", strtotime($row["start_time"])); ?>"
  },
<?php endwhile; ?>
];

let today = new Date();
let m = today.getMonth();
let y = today.getFullYear();

const names = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function renderCal() {
  const monthTitle = document.getElementById("monthTitle");
  const calendarGrid = document.getElementById("calendarGrid");

  monthTitle.textContent = `${names[m]} ${y}`;

  let first = new Date(y, m, 1).getDay();
  let days = new Date(y, m + 1, 0).getDate();

  let html = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
    .map(day => `<div class="day-name">${day}</div>`)
    .join("");

  for (let i = 0; i < first; i++) {
    html += `<div class="day"></div>`;
  }

  for (let d = 1; d <= days; d++) {
    let dayEvents = events.filter(e =>
      e.day === d &&
      e.month === m &&
      e.year === y
    );

    html += `
      <div class="day ${dayEvents.length > 0 ? "reserved-day" : ""}">
        <span>${d}</span>
    `;

    dayEvents.forEach(e => {
      html += `
        <div class="event blue">
          ${e.time}<br>
          ${e.title}<br>
          ${e.venue}
        </div>
      `;
    });

    html += `</div>`;
  }

  calendarGrid.innerHTML = html;
}

function changeMonth(num) {
  m += num;

  if (m < 0) {
    m = 11;
    y--;
  }

  if (m > 11) {
    m = 0;
    y++;
  }

  renderCal();
}

function goToday() {
  today = new Date();
  m = today.getMonth();
  y = today.getFullYear();
  renderCal();
}

renderCal();
</script>

</body>
</html>