<?php
// ============================================================
//  vues/admin/style.php  —  VUE (partiel) : styles du back-office
//  Inclus dans le <head> de chaque page admin.
// ============================================================
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
:root {
    --accent: #ff6b35;
    --accent-dim: rgba(255, 107, 53, 0.08);
    --accent-glow: rgba(255, 107, 53, 0.18);
    --bg: #f8fafc;
    --surface: #ffffff;
    --surface-2: #f1f5f9;
    --border: #e2e8f0;
    --border-light: #cbd5e1;
    --text: #0f172a;
    --text-muted: #475569;
    --text-dim: #94a3b8;
    --danger: #ef4444;
    --danger-dim: rgba(239, 68, 68, 0.08);
    --success: #10b981;
    --success-dim: rgba(16, 185, 129, 0.08);
    --nav-w: 240px;
    --radius: 12px;
    --radius-sm: 8px;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Outfit', sans-serif;
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

/* ── Grilles réutilisables ──
   Elles remplacent les anciens styles écrits directement dans le HTML
   (style="display:grid;..."). Écrits ici, ils peuvent être repliés en
   une seule colonne sur mobile par les @media du bas de ce fichier —
   ce qui était impossible avec un style écrit dans la balise. */

/* Deux champs côte à côte dans un formulaire */
.form-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

/* Bandeau de 3 statistiques (page Messages) */
.stats-3col {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 24px;
}

/* Barre de filtres (boutons alignés qui passent à la ligne si besoin) */
.filtres {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 20px;
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

/* Les actions qui MODIFIENT la base sont des formulaires POST (et non des
   liens), pour qu'elles ne puissent pas être déclenchées par une simple URL.
   Ce formulaire ne doit pas casser l'alignement des boutons : on le rend
   transparent pour la mise en page. */
.form-action { display: inline; margin: 0; padding: 0; }

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
.badge-done  { background: rgba(90,120,200,0.15); color: #5a78c8; border: 1px solid rgba(90,120,200,0.30); }
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

/* ============================================================
   RESPONSIVE DE L'ADMINISTRATION
   ------------------------------------------------------------
   On utilise EXACTEMENT les mêmes points de rupture que le site
   client (voir public/css/styles.css) :

     991.98px = TABLETTE | 767.98px = PETIT ÉCRAN | 575.98px = MOBILE

   Idée générale : sur ordinateur le menu est une colonne fixée à
   gauche ; en dessous de 768px il devient une barre horizontale en
   haut, et le contenu prend toute la largeur. Les tableaux, eux,
   défilent horizontalement plutôt que de s'écraser.
============================================================ */

/* ── Tablette ── */
@media (max-width: 991.98px) {
    :root {
        --nav-w: 200px;
    }

    .page {
        padding: 32px 24px 60px;
    }

    /* 4 colonnes → 2 colonnes */
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    /* Les blocs côte à côte passent l'un sous l'autre */
    .two-col {
        grid-template-columns: 1fr;
    }
}

/* ── Petit écran / grand mobile ── */
@media (max-width: 767.98px) {
    body {
        flex-direction: column;
    }

    /* Les grilles réutilisables passent sur une seule colonne */
    .form-2col,
    .stats-3col {
        grid-template-columns: 1fr;
    }

    /* Le menu latéral devient une barre horizontale en haut de page */
    .nav {
        width: 100%;
        min-height: auto;
        position: static;
        padding: 15px 16px;
        border-right: none;
        border-bottom: 1px solid var(--border);
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .nav-logo {
        margin-bottom: 0;
        padding-left: 0;
        font-size: 16px;
        width: 100%;
        text-align: center;
    }

    /* Les intertitres ("Principal", "Catalogue") n'ont plus de sens
       une fois le menu à l'horizontale : on les masque. */
    .nav-section {
        display: none;
    }

    .nav-link {
        padding: 6px 10px;
        font-size: 12px;
    }

    .nav-bottom {
        margin-top: 0;
        border-top: none;
        padding-top: 0;
        width: auto;
    }

    .page {
        margin-left: 0;
        max-width: 100%;
        padding: 24px 16px 60px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        margin-bottom: 20px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .two-col, .form-grid {
        grid-template-columns: 1fr;
        gap: 12px;
        padding: 16px 12px;
    }

    /* Tableaux : on les laisse défiler horizontalement plutôt que
       d'écraser les colonnes (elles deviendraient illisibles). */
    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        min-width: 760px;
    }

    /* ── COLONNE "ACTIONS" TOUJOURS VISIBLE ──
       Problème : "Actions" est la DERNIÈRE colonne de tous les tableaux.
       Comme le tableau défile horizontalement sur petit écran, il fallait
       faire défiler jusqu'au bout pour atteindre "Modifier" / "Supprimer".

       Solution : "position: sticky" avec "right: 0" colle cette colonne
       au bord droit. Le reste du tableau défile DESSOUS, les boutons
       restent donc toujours accessibles sans défiler.

       Le fond (background) est obligatoire : sans lui, on verrait les
       autres colonnes défiler par transparence sous les boutons. */
    thead th:last-child,
    tbody td:last-child {
        position: sticky;
        right: 0;
        /* L'ombre à gauche montre que le tableau défile sous la colonne */
        box-shadow: -6px 0 8px -5px rgba(15, 23, 42, 0.18);
    }

    thead th:last-child {
        background: var(--surface-2);
        z-index: 2;
    }

    tbody td:last-child {
        background: var(--surface);
        z-index: 1;
    }

    /* Au survol la ligne change de couleur : la colonne figée doit
       suivre, sinon elle resterait blanche au milieu d'une ligne grise. */
    tbody tr:hover td:last-child {
        background: var(--surface-2);
    }

    /* Exception : la ligne "Aucun résultat" occupe toute la largeur
       (attribut colspan). Elle ne doit pas être figée à droite. */
    tbody td[colspan] {
        position: static;
        background: transparent;
        box-shadow: none;
    }

    .topbar {
        position: static;
        padding: 10px 16px;
    }

    /* Fenêtres (modales) : elles ne doivent pas toucher les bords,
       et doivent pouvoir défiler si elles sont plus hautes que l'écran. */
    .modal-overlay {
        padding: 16px;
        overflow-y: auto;
        align-items: flex-start;
    }

    .modal {
        padding: 20px;
        margin: auto;
        max-height: none;
    }

    .modal-footer {
        flex-wrap: wrap;
    }
}

/* ── Mobile ── */
@media (max-width: 575.98px) {
    .page {
        padding: 18px 12px 50px;
    }

    .page-header h2 {
        font-size: 19px;
    }

    /* Menu : les liens s'étalent sur toute la largeur */
    .nav {
        padding: 12px 10px;
    }

    .nav-link {
        padding: 5px 8px;
        font-size: 11.5px;
        gap: 6px;
    }

    /* Les icônes du menu prennent de la place pour rien sur mobile */
    .nav-link svg {
        display: none;
    }

    /* Boutons d'action : ils passent à la ligne au lieu de déborder */
    .actions {
        gap: 4px;
    }

    .btn {
        padding: 6px 11px;
        font-size: 12px;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 11px;
    }

    .modal {
        padding: 16px;
    }

    .modal h3 {
        font-size: 15px;
    }

    /* Les 2 boutons de la fenêtre prennent toute la largeur :
       plus faciles à toucher au doigt. */
    .modal-footer {
        flex-direction: column-reverse;
        gap: 8px;
    }

    .modal-footer .btn {
        width: 100%;
        justify-content: center;
    }

    .form-grid {
        padding: 14px 10px;
    }

    .form-footer {
        padding: 14px 12px;
    }

    .stat-card {
        padding: 14px 16px;
        gap: 12px;
    }

    .stat-value {
        font-size: 20px;
    }

    /* Empêche un débordement horizontal de toute la page */
    .card-header {
        flex-wrap: wrap;
        gap: 8px;
    }
}
</style>
