<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
:root {
    --accent: #ff6b00;
    --accent-dim: rgba(255,107,0,0.12);
    --accent-glow: rgba(255,107,0,0.25);
    --bg: #0d0d0d;
    --surface: #161616;
    --surface-2: #1e1e1e;
    --border: #272727;
    --border-light: #313131;
    --text: #f0f0f0;
    --text-muted: #888;
    --text-dim: #555;
    --danger: #e05463;
    --danger-dim: rgba(224,84,99,0.12);
    --success: #4caf7d;
    --success-dim: rgba(76,175,125,0.12);
    --nav-w: 220px;
    --radius: 10px;
    --radius-sm: 6px;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    line-height: 1.6;
    min-height: 100vh;
    display: flex;
}

/* ── NAV ── */
.nav {
    width: var(--nav-w);
    min-height: 100vh;
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0;
    padding: 28px 16px;
    gap: 4px;
    z-index: 100;
}

.nav-logo {
    font-size: 17px;
    font-weight: 700;
    letter-spacing: -0.4px;
    color: var(--text);
    margin-bottom: 28px;
    padding-left: 8px;
}

.nav-logo span { color: var(--accent); }

.nav-section {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-dim);
    padding: 14px 8px 6px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    color: var(--text-muted);
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.15s;
    position: relative;
}

.nav-link:hover { background: var(--surface-2); color: var(--text); }

.nav-link.active {
    background: var(--accent-dim);
    color: var(--accent);
    border: 1px solid var(--accent-glow);
}

.nav-link svg { flex-shrink: 0; }

.nav-badge {
    margin-left: auto;
    background: var(--accent);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 20px;
    min-width: 18px;
    text-align: center;
}

.nav-bottom {
    margin-top: auto;
    border-top: 1px solid var(--border);
    padding-top: 14px;
}

/* ── PAGE ── */
.page {
    margin-left: var(--nav-w);
    flex: 1;
    padding: 40px 36px 80px;
    max-width: calc(100% - var(--nav-w));
}

.page-header {
    margin-bottom: 32px;
    display: flex;
    align-items: baseline;
    gap: 12px;
}

.page-header h2 {
    font-size: 22px;
    font-weight: 600;
    letter-spacing: -0.4px;
}

.page-sub { color: var(--text-dim); font-size: 13px; }

/* ── STATS GRID ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 28px;
}

.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-sm);
    background: var(--surface-2);
    border: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    flex-shrink: 0;
}
.stat-icon.orange { background: var(--accent-dim); border-color: var(--accent-glow); color: var(--accent); }

.stat-label {
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    color: var(--text-dim);
    margin-bottom: 2px;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    font-family: 'DM Mono', monospace;
    color: var(--text);
    line-height: 1;
}

.stat-badge {
    font-size: 11px;
    color: var(--accent);
    margin-top: 3px;
}

/* ── CARDS ── */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
}

.two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* ── LIST ITEMS ── */
.list-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--border);
    transition: background 0.1s;
}
.list-item:last-child { border-bottom: none; }
.list-item:hover { background: var(--surface-2); }
.list-item.unread { background: rgba(255,107,0,0.03); }

.list-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--border-light);
    margin-top: 6px;
    flex-shrink: 0;
}
.list-dot.dot-on { background: var(--accent); }

.list-body { flex: 1; min-width: 0; }
.list-title { font-size: 13px; font-weight: 500; color: var(--text); }
.list-meta { font-weight: 400; color: var(--text-dim); font-size: 12px; }
.list-preview { font-size: 12px; color: var(--text-dim); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* ── TABLE ── */
.table-wrap {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
}

table { width: 100%; border-collapse: collapse; }

thead th {
    background: var(--surface-2);
    padding: 10px 16px;
    text-align: left;
    font-size: 10.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--text-dim);
    border-bottom: 1px solid var(--border);
}

tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    color: var(--text-muted);
    vertical-align: middle;
    font-size: 13px;
}

tbody tr:last-child td { border-bottom: none; }
tbody tr:hover { background: var(--surface-2); }
tbody tr.unread td { color: var(--text); font-weight: 500; }

/* ── BUTTONS ── */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-size: 12.5px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    border: none;
    transition: opacity 0.15s, transform 0.1s;
    white-space: nowrap;
}
.btn:hover { opacity: 0.82; transform: translateY(-1px); }
.btn:active { transform: translateY(0); }
.btn-sm { padding: 4px 10px; font-size: 11.5px; }
.btn-primary { background: var(--accent); color: #fff; }
.btn-ghost { background: var(--surface-2); border: 1px solid var(--border-light); color: var(--text-muted); }
.btn-danger { background: var(--danger-dim); border: 1px solid rgba(224,84,99,0.25); color: var(--danger); }
.btn-success { background: var(--success-dim); border: 1px solid rgba(76,175,125,0.3); color: var(--success); }

.actions { display: flex; gap: 5px; flex-wrap: wrap; }

/* ── BADGE STATUS ── */
.badge {
    display: inline-block;
    padding: 2px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.badge-wait  { background: rgba(255,107,0,0.15); color: var(--accent); }
.badge-ok    { background: var(--success-dim); color: var(--success); border: 1px solid rgba(76,175,125,0.3); }
.badge-no    { background: var(--danger-dim); color: var(--danger); border: 1px solid rgba(224,84,99,0.25); }
.badge-dot   {
    display: inline-block;
    width: 7px; height: 7px;
    border-radius: 50%;
    margin-right: 5px;
    vertical-align: middle;
}

/* ── ALERT ── */
.alert {
    padding: 12px 16px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.alert.success { background: var(--success-dim); border: 1px solid rgba(76,175,125,0.3); color: var(--success); }
.alert.danger  { background: var(--danger-dim); border: 1px solid rgba(224,84,99,0.25); color: var(--danger); }

/* ── FORM ── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    padding: 20px;
}

.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.full { grid-column: 1 / -1; }

.form-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--text-dim);
}

.form-input, .form-select, .form-textarea {
    padding: 10px 14px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    color: var(--text);
    border-radius: var(--radius-sm);
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    transition: border-color 0.15s;
    outline: none;
}
.form-textarea { resize: vertical; min-height: 90px; }
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-dim);
}
.form-select option { background: var(--surface-2); }

.form-footer {
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 10px;
}

/* ── EMPTY ── */
.empty-sm {
    padding: 32px 20px;
    text-align: center;
    color: var(--text-dim);
    font-size: 13px;
}

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--border-light); border-radius: 3px; }

/* ── TOPBAR ── */
.topbar {
    height: 52px;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 20px;
    justify-content: flex-end;
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 50;
}

.topbar-user {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
}

.avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--accent-dim);
    border: 1px solid var(--accent-glow);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: var(--accent);
}

/* modal */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.65);
    z-index: 200;
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; }

.modal {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    width: 100%;
    max-width: 480px;
    padding: 28px;
}
.modal h3 { font-size: 16px; font-weight: 600; margin-bottom: 16px; }
.modal-footer { display: flex; gap: 10px; margin-top: 20px; justify-content: flex-end; }
</style>
