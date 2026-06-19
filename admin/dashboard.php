<?php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$file = __DIR__ . '/queries.json';
$queries = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($queries)) $queries = [];

// Mark all as read when dashboard is opened
foreach ($queries as &$q) $q['read'] = true;
file_put_contents($file, json_encode($queries, JSON_PRETTY_PRINT));

$total  = count($queries);
$today  = date('d M Y');
$todayCount = count(array_filter($queries, fn($q) => str_starts_with($q['time'], $today)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Dashboard – Thakurji Associates</title>
<link rel="icon" type="image/svg+xml" href="../favicon.svg"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:#f4f7fc;min-height:100vh}
/* Sidebar */
.sidebar{position:fixed;top:0;left:0;width:230px;height:100vh;background:#0b1a2e;padding:24px 16px;display:flex;flex-direction:column;gap:4px;z-index:10}
.s-logo{display:flex;align-items:center;gap:10px;padding:0 8px;margin-bottom:28px}
.s-logo-icon{width:38px;height:38px;background:#d4a843;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;color:#0b1a2e;flex-shrink:0}
.s-logo-text{font-size:12px;font-weight:700;color:#fff;line-height:1.3}
.s-logo-text small{display:block;font-size:9px;color:#d4a843;letter-spacing:.5px}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;color:rgba(255,255,255,.6);font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:.15s}
.nav-item.active,.nav-item:hover{background:rgba(212,168,67,.12);color:#d4a843}
.nav-item i{width:18px;text-align:center}
.logout{margin-top:auto;color:rgba(255,255,255,.4) !important}
.logout:hover{background:rgba(255,80,80,.1) !important;color:#f87171 !important}
/* Main */
.main{margin-left:230px;padding:32px}
.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px}
.topbar h1{font-size:20px;font-weight:700;color:#0b1a2e}
.topbar span{font-size:13px;color:#7a8fa8}
.badge-new{background:#d4a843;color:#0b1a2e;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;margin-left:8px}
/* Stats */
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px}
.stat{background:#fff;border-radius:12px;padding:20px 22px;box-shadow:0 2px 8px rgba(0,0,0,.06)}
.stat .num{font-size:28px;font-weight:800;color:#0b1a2e}
.stat .lbl{font-size:12px;color:#7a8fa8;margin-top:2px}
.stat .icon{font-size:20px;color:#d4a843;margin-bottom:8px}
/* Search */
.search-bar{background:#fff;border-radius:10px;padding:10px 16px;display:flex;align-items:center;gap:10px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.05)}
.search-bar i{color:#7a8fa8;font-size:14px}
.search-bar input{border:none;outline:none;font-size:14px;font-family:'Poppins',sans-serif;color:#0b1a2e;flex:1}
.search-bar input::placeholder{color:#7a8fa8}
/* Table */
.table-wrap{background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden}
.table-head{display:grid;grid-template-columns:180px 140px 1fr 160px 120px;gap:12px;padding:14px 20px;background:#f8fafc;font-size:11px;font-weight:700;color:#7a8fa8;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #e8edf3}
.table-row{display:grid;grid-template-columns:180px 140px 1fr 160px 120px;gap:12px;padding:16px 20px;border-bottom:1px solid #f0f4f8;align-items:start;transition:.15s}
.table-row:last-child{border-bottom:none}
.table-row:hover{background:#fafbfd}
.cell-name{font-size:14px;font-weight:600;color:#0b1a2e}
.cell-name small{display:block;font-size:12px;font-weight:400;color:#7a8fa8;margin-top:2px}
.cell-phone{font-size:13px;color:#1e2d40}
.cell-phone a{color:#0b1a2e;text-decoration:none}
.cell-phone a:hover{color:#d4a843}
.cell-msg{font-size:12px;color:#7a8fa8;line-height:1.5}
.tag{display:inline-block;background:rgba(212,168,67,.12);color:#a8831f;font-size:11px;font-weight:600;padding:3px 8px;border-radius:6px}
.cell-time{font-size:11px;color:#7a8fa8}
.empty{text-align:center;padding:60px 20px;color:#7a8fa8}
.empty i{font-size:36px;color:#d4a843;margin-bottom:12px;display:block}
.wa-btn{display:inline-flex;align-items:center;gap:5px;background:#25d366;color:#fff;font-size:11px;font-weight:600;padding:5px 10px;border-radius:6px;text-decoration:none;margin-top:6px}
.wa-btn:hover{background:#1dbb57}
@media(max-width:900px){
  .sidebar{width:60px;padding:16px 8px}
  .s-logo-text,.nav-item span{display:none}
  .s-logo{justify-content:center}
  .main{margin-left:60px;padding:20px 16px}
  .stats{grid-template-columns:1fr 1fr}
  .table-head,.table-row{grid-template-columns:1fr 1fr}
}
</style>
</head>
<body>

<div class="sidebar">
  <div class="s-logo">
    <div class="s-logo-icon">T</div>
    <div class="s-logo-text">Thakurji<br>Associates<small>ADMIN</small></div>
  </div>
  <a class="nav-item active" href="dashboard.php"><i class="fa fa-inbox"></i><span>Queries</span></a>
  <a class="nav-item" href="../index.html" target="_blank"><i class="fa fa-globe"></i><span>View Website</span></a>
  <a class="nav-item logout" href="logout.php"><i class="fa fa-right-from-bracket"></i><span>Logout</span></a>
</div>

<div class="main">
  <div class="topbar">
    <h1>Client Queries <span class="badge-new"><?= $total ?> Total</span></h1>
    <span><i class="fa fa-calendar"></i> <?= date('d M Y') ?></span>
  </div>

  <div class="stats">
    <div class="stat">
      <div class="icon"><i class="fa fa-inbox"></i></div>
      <div class="num"><?= $total ?></div>
      <div class="lbl">Total Queries</div>
    </div>
    <div class="stat">
      <div class="icon"><i class="fa fa-calendar-day"></i></div>
      <div class="num"><?= $todayCount ?></div>
      <div class="lbl">Today</div>
    </div>
    <div class="stat">
      <div class="icon"><i class="fa fa-whatsapp fab"></i></div>
      <div class="num"><?= $total ?></div>
      <div class="lbl">WhatsApp Sent</div>
    </div>
  </div>

  <div class="search-bar">
    <i class="fa fa-magnifying-glass"></i>
    <input type="text" id="search" placeholder="Search by name, phone, or service…" oninput="filterRows()"/>
  </div>

  <div class="table-wrap">
    <?php if (empty($queries)): ?>
    <div class="empty">
      <i class="fa fa-inbox"></i>
      <p>No queries yet. They will appear here when someone fills the form.</p>
    </div>
    <?php else: ?>
    <div class="table-head">
      <div>Client</div>
      <div>Phone</div>
      <div>Message</div>
      <div>Service</div>
      <div>Time</div>
    </div>
    <div id="rows">
    <?php foreach (array_reverse($queries) as $q):
      $wa = 'https://wa.me/91' . preg_replace('/\D/', '', $q['phone']);
    ?>
    <div class="table-row" data-search="<?= strtolower($q['name'].' '.$q['phone'].' '.($q['service'] ?? '')) ?>">
      <div class="cell-name">
        <?= $q['name'] ?>
        <?php if (!empty($q['email'])): ?>
        <small><?= $q['email'] ?></small>
        <?php endif; ?>
      </div>
      <div class="cell-phone">
        <a href="tel:<?= $q['phone'] ?>"><?= $q['phone'] ?></a>
        <br>
        <a class="wa-btn" href="<?= $wa ?>" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
      </div>
      <div class="cell-msg"><?= $q['message'] ?: '—' ?></div>
      <div><span class="tag"><?= $q['service'] ?: 'Not specified' ?></span></div>
      <div class="cell-time"><?= $q['time'] ?></div>
    </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
function filterRows(){
  var q = document.getElementById('search').value.toLowerCase();
  document.querySelectorAll('#rows .table-row').forEach(function(r){
    r.style.display = r.dataset.search.includes(q) ? '' : 'none';
  });
}
</script>
</body>
</html>
