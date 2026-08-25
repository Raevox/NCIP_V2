@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --g5:#2E7D46;--g6:#2d6a1f;--g4:#52a335;--g1:#e6f5de;--g05:#f4fbf0;--g2:#c5deb8;
    --ink:#131a0e;--ink2:#3d4a36;--ink3:#6b7a62;--ink4:#9aa891;
    --ln:#e6ede3;--bg:#f8faf6;--wh:#ffffff;
    --r14:14px;--r9:9px;--r6:6px;
    --sd:0 1px 4px rgba(19,26,14,.07);--sdm:0 4px 18px rgba(19,26,14,.10);--sdl:0 8px 32px rgba(19,26,14,.13);
    --ease:all .2s cubic-bezier(.4,0,.2,1);
}
.np{font-family:'DM Sans',sans-serif;color:var(--ink);max-width:940px;margin:0 auto;padding-bottom:60px;}

/* Header */
.np-hd{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:28px;flex-wrap:wrap;}
.np-hd-l{display:flex;align-items:center;gap:16px;}
.np-hd-icon{width:54px;height:54px;background:var(--g5);border-radius:14px;display:grid;place-items:center;
    color:#fff;font-size:22px;box-shadow:0 4px 14px rgba(62,123,39,.3);position:relative;flex-shrink:0;}
.np-hd-icon.ringing{animation:np-ring .5s ease;}
@keyframes np-ring{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-12deg)}40%,80%{transform:rotate(12deg)}}
.np-badge-icon{position:absolute;top:-7px;right:-7px;background:#ef4444;color:#fff;font-size:9.5px;
    font-weight:700;padding:2px 5px;border-radius:20px;min-width:19px;text-align:center;
    border:2px solid var(--wh);line-height:1.3;display:none;}
.np-hd-text h1{font-family:'Sora',sans-serif;font-size:22px;font-weight:800;letter-spacing:-.5px;margin:0 0 4px;color:var(--ink);}
.np-hd-meta{display:flex;align-items:center;gap:8px;font-size:12.5px;color:var(--ink3);}
.np-hd-sep{color:var(--ln);}
.np-pill-unread{display:inline-flex;align-items:center;gap:4px;background:#fef3c7;color:#92400e;
    font-size:11px;font-weight:700;padding:2px 9px;border-radius:20px;}
.np-pill-ok{display:inline-flex;align-items:center;gap:5px;color:#0ea371;font-weight:700;font-size:12px;}
.np-btn-markall{display:none;align-items:center;gap:8px;padding:10px 20px;background:var(--wh);
    border:1.5px solid var(--g2);border-radius:var(--r9);color:var(--g5);font-family:'DM Sans',sans-serif;
    font-size:13px;font-weight:700;cursor:pointer;transition:var(--ease);white-space:nowrap;}
.np-btn-markall:hover{background:var(--g05);border-color:var(--g5);box-shadow:0 0 0 3px rgba(62,123,39,.1);}

/* Shell */
.np-shell{background:var(--wh);border:1px solid var(--ln);border-radius:18px;overflow:hidden;box-shadow:var(--sd);}

/* Tabs */
.np-tabs{display:flex;padding:14px 18px 0;border-bottom:1.5px solid var(--ln);
    overflow-x:auto;scrollbar-width:none;background:var(--wh);gap:2px;}
.np-tabs::-webkit-scrollbar{display:none;}
.np-tab{display:inline-flex;align-items:center;gap:7px;padding:9px 16px 11px;background:transparent;border:none;
    color:var(--ink3);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;
    border-bottom:2.5px solid transparent;margin-bottom:-1.5px;transition:var(--ease);white-space:nowrap;
    border-radius:6px 6px 0 0;}
.np-tab:hover{color:var(--g5);background:var(--g05);}
.np-tab.active{color:var(--g5);border-bottom-color:var(--g5);font-weight:700;}

/* Progress */
.np-prog{height:2px;background:var(--ln);position:relative;overflow:hidden;display:none;}
.np-prog.on{display:block;}
.np-prog::after{content:'';position:absolute;top:0;left:-40%;width:40%;height:100%;
    background:linear-gradient(90deg,transparent,var(--g5),transparent);
    animation:np-slide 1.2s ease-in-out infinite;}
@keyframes np-slide{0%{left:-40%}100%{left:100%}}

/* Body */
.np-body{padding:16px 18px 20px;}

/* Skeleton */
.np-skel{display:flex;flex-direction:column;gap:9px;}
.np-skel-card{display:flex;align-items:flex-start;gap:14px;padding:16px;border:1px solid var(--ln);
    border-radius:var(--r14);animation:np-shim 1.4s ease-in-out infinite;}
@keyframes np-shim{0%,100%{background:var(--wh)}50%{background:#f4f6f3}}
.np-skel-icon{width:44px;height:44px;min-width:44px;border-radius:11px;background:var(--ln);flex-shrink:0;}
.np-skel-body{flex:1;display:flex;flex-direction:column;gap:8px;padding-top:2px;}
.np-skel-ln{height:10px;background:var(--ln);border-radius:5px;}

/* Empty */
.np-empty{text-align:center;padding:72px 20px;}
.np-empty-ring{width:80px;height:80px;border-radius:50%;background:var(--g05);border:2px dashed var(--g2);
    display:grid;place-items:center;margin:0 auto 18px;font-size:32px;color:var(--g4);}
.np-empty h3{font-family:'Sora',sans-serif;font-size:15px;font-weight:700;margin:0 0 6px;color:var(--ink2);}
.np-empty p{font-size:13px;color:var(--ink4);margin:0;}

/* Error */
.np-err{text-align:center;padding:60px 20px;}
.np-err-ring{width:72px;height:72px;border-radius:50%;background:#fef2f2;border:2px dashed #fca5a5;
    display:grid;place-items:center;margin:0 auto 16px;font-size:28px;color:#ef4444;}
.np-err h3{font-size:15px;font-weight:700;margin:0 0 6px;color:var(--ink2);}
.np-err p{font-size:13px;color:var(--ink4);margin:0 0 16px;}
.np-retry{padding:9px 20px;background:var(--wh);border:1.5px solid var(--g5);border-radius:var(--r9);
    color:var(--g5);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;
    cursor:pointer;transition:var(--ease);}
.np-retry:hover{background:var(--g5);color:#fff;}

/* List */
.np-list{display:flex;flex-direction:column;gap:8px;}
.np-btn-del {
    padding:6px;
    width:32px;
    height:32px;
    justify-content:center;
}
/* Card */
.np-card{display:flex;align-items:flex-start;gap:14px;padding:15px 16px;border:1px solid var(--ln);
    border-radius:var(--r14);background:var(--wh);cursor:pointer;
    transition:box-shadow .2s,transform .15s,border-color .2s;position:relative;
    animation:np-in .22s ease both;}
@keyframes np-in{from{opacity:0;transform:translateY(5px)}to{opacity:1;transform:translateY(0)}}
.np-card:nth-child(1){animation-delay:.03s}.np-card:nth-child(2){animation-delay:.06s}
.np-card:nth-child(3){animation-delay:.09s}.np-card:nth-child(4){animation-delay:.12s}
.np-card:nth-child(5){animation-delay:.15s}.np-card:nth-child(6){animation-delay:.18s}
.np-card:hover{box-shadow:var(--sdm);transform:translateY(-1px);border-color:var(--g2);}
.np-card.unread{background:linear-gradient(135deg,var(--g05) 0%,var(--wh) 55%);
    border-left:3px solid var(--tc,var(--g5));padding-left:14px;}

.np-ci{width:44px;height:44px;min-width:44px;border-radius:11px;display:grid;place-items:center;
    color:#fff;font-size:17px;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,.14);}
.np-cb{flex:1;min-width:0;}
.np-cb-top{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:4px;}
.np-cb-head{display:flex;align-items:center;gap:7px;flex:1;min-width:0;}
.np-dot{width:7px;height:7px;min-width:7px;border-radius:50%;flex-shrink:0;box-shadow:0 0 0 3px rgba(62,123,39,.14);}
.np-cb-title{font-family:'Sora',sans-serif;font-size:13.5px;font-weight:700;color:var(--ink);margin:0;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;letter-spacing:-.2px;}
.np-cb-time{font-size:11px;color:var(--ink4);white-space:nowrap;flex-shrink:0;font-weight:500;padding-top:2px;}
.np-cb-msg{font-size:13px;color:var(--ink3);margin:0 0 11px;line-height:1.55;}
.np-cb-foot{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}

/* Badges */
.np-tag-pri{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:var(--r6);
    font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;}
.np-tag-pri.high{background:#fef3c7;color:#92400e;}
.np-tag-pri.normal{background:var(--g1);color:var(--g6);}
.np-tag-pri.low{background:#f3f4f6;color:#4b5563;}
.np-tag-type{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:var(--r6);
    font-size:10px;font-weight:700;letter-spacing:.3px;}

/* Action buttons */
.np-acts{display:flex;gap:6px;align-items:center;margin-left:auto;flex-wrap:wrap;}
.np-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 13px;border-radius:7px;
    font-family:'DM Sans',sans-serif;font-size:11.5px;font-weight:700;cursor:pointer;
    transition:var(--ease);border:1.5px solid transparent;white-space:nowrap;}
.np-btn:disabled{opacity:.5;cursor:not-allowed;pointer-events:none;}
.np-btn-view{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe;}
.np-btn-view:hover:not(:disabled){background:#1d4ed8;color:#fff;border-color:#1d4ed8;box-shadow:0 2px 8px rgba(29,78,216,.3);}
.np-btn-approve{background:var(--g05);color:var(--g6);border-color:var(--g2);}
.np-btn-approve:hover:not(:disabled){background:var(--g5);color:#fff;border-color:var(--g5);box-shadow:0 2px 8px rgba(62,123,39,.3);}
.np-btn-del{background:#fef2f2;color:#dc2626;border-color:#fecaca;padding:5px 10px;}
.np-btn-del:hover:not(:disabled){background:#dc2626;color:#fff;border-color:#dc2626;box-shadow:0 2px 8px rgba(220,38,38,.25);}

/* Pagination */
.np-pager{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;
    border-top:1.5px solid var(--ln);background:var(--bg);flex-wrap:wrap;gap:10px;}
.np-pager-info{font-size:12.5px;color:var(--ink3);font-weight:500;}
.np-pager-btns{display:flex;align-items:center;gap:6px;}
.np-pager-btn{display:inline-flex;align-items:center;gap:5px;padding:7px 15px;background:var(--wh);
    border:1.5px solid var(--ln);border-radius:8px;font-family:'DM Sans',sans-serif;font-size:12.5px;
    font-weight:600;color:var(--ink2);cursor:pointer;transition:var(--ease);}
.np-pager-btn:hover:not(:disabled){border-color:var(--g5);color:var(--g5);background:var(--g05);}
.np-pager-btn:disabled{opacity:.4;cursor:not-allowed;}
.np-pager-cur{padding:7px 14px;background:var(--wh);border:1.5px solid var(--ln);border-radius:8px;
    font-family:'Sora',sans-serif;font-size:12px;font-weight:600;color:var(--ink2);}

/* Toasts */
.np-toasts{position:fixed;bottom:28px;right:24px;z-index:9000;display:flex;flex-direction:column;gap:8px;pointer-events:none;}
.np-toast{display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:12px;
    font-family:'DM Sans',sans-serif;font-size:13.5px;font-weight:600;box-shadow:var(--sdl);
    pointer-events:all;max-width:320px;animation:np-tin .28s cubic-bezier(.34,1.56,.64,1) both;}
@keyframes np-tin{from{opacity:0;transform:translateY(12px) scale(.95)}to{opacity:1;transform:none}}
.np-toast.ok{background:var(--wh);color:#065f46;border:1px solid #a7f3d0;}
.np-toast.err{background:var(--wh);color:#991b1b;border:1px solid #fca5a5;}
.np-toast.inf{background:var(--wh);color:#1e40af;border:1px solid #bfdbfe;}

/* Modal */
.np-overlay{position:fixed;inset:0;background:rgba(13,18,10,.52);z-index:9999;
    display:flex;align-items:center;justify-content:center;padding:16px;
    backdrop-filter:blur(4px);animation:np-oin .18s ease both;}
@keyframes np-oin{from{opacity:0}to{opacity:1}}
.np-modal{background:var(--wh);border-radius:20px;padding:34px 30px 28px;max-width:400px;
    width:100%;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,.22);
    animation:np-min .22s cubic-bezier(.34,1.56,.64,1) both;}
@keyframes np-min{from{transform:translateY(18px) scale(.95);opacity:0}to{transform:none;opacity:1}}
.np-modal-ico{width:66px;height:66px;border-radius:50%;display:grid;place-items:center;
    margin:0 auto 18px;font-size:26px;}
.np-modal-ico.approve{background:var(--g1);color:var(--g6);}
.np-modal-ico.del{background:#fef2f2;color:#dc2626;}
.np-modal h3{font-family:'Sora',sans-serif;font-size:18px;font-weight:800;margin:0 0 9px;
    color:var(--ink);letter-spacing:-.3px;}
.np-modal p{font-size:13.5px;color:var(--ink3);margin:0 0 28px;line-height:1.55;}
.np-modal-btns{display:flex;gap:10px;justify-content:center;}
.np-mbt{padding:10px 26px;border:none;border-radius:var(--r9);font-family:'DM Sans',sans-serif;
    font-size:13.5px;font-weight:700;cursor:pointer;transition:var(--ease);}
.np-mbt.cancel{background:#f3f4f6;color:var(--ink2);}
.np-mbt.cancel:hover{background:#e5e7eb;}
.np-mbt.approve{background:var(--g5);color:#fff;}
.np-mbt.approve:hover{background:var(--g6);box-shadow:0 4px 12px rgba(62,123,39,.35);}
.np-mbt.del{background:#dc2626;color:#fff;}
.np-mbt.del:hover{background:#b91c1c;box-shadow:0 4px 12px rgba(220,38,38,.3);}

@media(max-width:600px){
    .np-card{flex-direction:column}
    .np-cb-top{flex-direction:column;gap:4px}
    .np-acts{margin-left:0}
    .np-cb-title{white-space:normal}
}
</style>

<div class="np">

    {{-- Header --}}
    <div class="np-hd">
        <div class="np-hd-l">
            <div class="np-hd-icon" id="hdIcon">
                <i class="fas fa-bell"></i>
                <span class="np-badge-icon" id="hdBadge"></span>
            </div>
            <div class="np-hd-text">
                <h1>Notifications</h1>
                <div class="np-hd-meta">
                    <span id="unreadLbl"></span>
                    <span class="np-hd-sep">·</span>
                    <span id="totalLbl" style="color:var(--ink4)">Loading…</span>
                </div>
            </div>
        </div>
        <button class="np-btn-markall" id="markAllBtn" onclick="markAllRead()">
            <i class="fas fa-check-double"></i> Mark all read
        </button>
    </div>

    {{-- Shell --}}
    <div class="np-shell">

        {{-- Tabs --}}
        <div class="np-tabs">
            <button class="np-tab active" onclick="switchTab(this,'all')">
                <i class="fas fa-inbox"></i> All
            </button>
<button class="np-tab" onclick="switchTab(this,'coc_approved')">
    <i class="fas fa-check-circle"></i> COC Approved
</button>

<button class="np-tab" onclick="switchTab(this,'coc_approval')">
    <i class="fas fa-file-alt"></i> COC Review
</button>

<button class="np-tab" onclick="switchTab(this,'coc_returned')">
    <i class="fas fa-undo"></i> Returned
</button>

<button class="np-tab" onclick="switchTab(this,'application_forwarded')">
    <i class="fas fa-share"></i> Forwarded
</button>
        </div>

        {{-- Progress --}}
        <div class="np-prog" id="npProg"></div>

        {{-- Content --}}
        <div class="np-body">
            <div id="npContent">
                <div class="np-skel" id="npSkel">
                    @for($i=0;$i<4;$i++)
                    <div class="np-skel-card">
                        <div class="np-skel-icon"></div>
                        <div class="np-skel-body">
                            <div class="np-skel-ln" style="width:{{ rand(40,70) }}%"></div>
                            <div class="np-skel-ln" style="width:{{ rand(65,90) }}%"></div>
                            <div class="np-skel-ln" style="width:{{ rand(30,55) }}%"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div id="npPager"></div>
    </div>
</div>

{{-- Toasts --}}
<div class="np-toasts" id="npToasts"></div>

{{-- Confirm modal --}}
<div class="np-overlay" id="npOverlay" style="display:none" onclick="closeModal()">
    <div class="np-modal" onclick="event.stopPropagation()">
        <div class="np-modal-ico" id="mIco"><i class="fas" id="mIcoI"></i></div>
        <h3 id="mTitle"></h3>
        <p  id="mMsg"></p>
        <div class="np-modal-btns">
            <button class="np-mbt cancel" onclick="closeModal()">Cancel</button>
            <button class="np-mbt" id="mConfirm" onclick="doConfirm()">Confirm</button>
        </div>
    </div>
</div>

<script>
/* ── CSRF (from layout meta tag) ─────────────────────── */
const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

/* Let Laravel build URLs so this page also works when the app is hosted in a subdirectory. */
const NOTIFICATION_URLS = {
    index:       @json(route('api.admin.notifications.index')),
    unreadCount: @json(route('api.admin.notifications.unread-count')),
    markAllRead: @json(route('api.admin.notifications.mark-all-read')),
};

function notificationUrl(id, action='') {
    return `${NOTIFICATION_URLS.index}/${encodeURIComponent(id)}${action ? '/' + action : ''}`;
}

/* ── Type config ─────────────────────────────────────── */
const TYPE_CFG = {
    coc_approved: {
        color:'#0ea371', bg:'#ecfdf5', icon:'check-circle', label:'COC Approved'
    },
    coc_approval: {
        color:'#0284c7', bg:'#f0f9ff', icon:'file-alt', label:'COC Review'
    },
    coc_returned: {
        color:'#d97706', bg:'#fffbeb', icon:'undo', label:'Returned'
    },
    application_forwarded: {
        color:'#7c3aed', bg:'#f5f3ff', icon:'share', label:'Forwarded'
    }
};
const C = t => TYPE_CFG[t] || {color:'#6b7280',bg:'#f9fafb',icon:'bell',label:t};

/* ── State ───────────────────────────────────────────── */
let filter='all', page=1, _pending=null;

/* ─────────────────────────────────────────────────────────────────
   FETCH HELPER
   Critical fixes applied here:
   1. Always sends Accept: application/json → Laravel returns JSON,
      never an HTML redirect page.
   2. Always sends credentials: 'same-origin' → session cookie
      is included so auth middleware doesn't redirect to login.
   3. Always includes X-CSRF-TOKEN → POST/DELETE never get 419.
   4. Parses error responses as JSON so the message bubbles up.
───────────────────────────────────────────────────────────────── */
async function api(url, opts={}) {
    const headers = {
        'Accept':            'application/json',
        'X-Requested-With':  'XMLHttpRequest',
        'X-CSRF-TOKEN':      CSRF,
        ...(opts.headers||{}),
    };
    const response = await fetch(url, { credentials:'same-origin', ...opts, headers });
    const contentType = response.headers.get('content-type') || '';

    if (!contentType.includes('application/json')) {
        throw new Error(`Server returned ${response.status} ${response.statusText} instead of JSON.`);
    }

    const data = await response.json();
    if (!response.ok || data.success === false) {
        throw new Error(data.message || (`HTTP ${response.status}`));
    }

    return data;
}

/* ── Tab ─────────────────────────────────────────────── */
function switchTab(btn, type) {
    filter = type;
    document.querySelectorAll('.np-tab').forEach(t=>t.classList.remove('active'));
    btn.classList.add('active');
    load(1);
}

/* ── Load ────────────────────────────────────────────── */
function load(p=1) {
    page = p;
    prog(true);
    document.getElementById('npPager').innerHTML = '';

    const url = new URL(NOTIFICATION_URLS.index, window.location.origin);
    url.searchParams.set('type', filter);
    url.searchParams.set('page', p);
    url.searchParams.set('per_page', 15);

    api(url.toString())
    .then(data => { prog(false); render(data); syncHeader(data.total); })
    .catch(err  => {
        prog(false);
        document.getElementById('npContent').innerHTML = `
        <div class="np-err">
            <div class="np-err-ring"><i class="fas fa-exclamation-triangle"></i></div>
            <h3>Could not load notifications</h3>
            <p>${esc(err.message)}</p>
            <button class="np-retry" onclick="load(${p})"><i class="fas fa-redo"></i> Retry</button>
        </div>`;
    });
}

/* ── Render ──────────────────────────────────────────── */
function render(data) {
    const items = data.data || [];
    const wrap  = document.getElementById('npContent');

    if (!items.length) {
        wrap.innerHTML = `
        <div class="np-empty">
            <div class="np-empty-ring"><i class="fas fa-inbox"></i></div>
            <h3>No notifications here</h3>
            <p>${filter!=='all'
                ? 'No <strong>'+filter.replace(/_/g,' ')+'</strong> notifications.'
                : "You're all caught up!"}</p>
        </div>`;
        document.getElementById('npPager').innerHTML = '';
        return;
    }

    let html = '<div class="np-list">';
    items.forEach(n => {
        const c   = C(n.type);
        const pri = (n.priority||'normal').toLowerCase();
        const pIco= {high:'exclamation',normal:'minus',low:'arrow-down'}[pri]||'minus';
        const unr = !n.is_read;

        /*
         * ─── BUG FIX (View action was broken) ───────────────────────────
         * WRONG (old code):
         *   const safeUrl = JSON.stringify(n.action_url);
         *   onclick="viewDetail(event, ${n.id}, ${safeUrl})"
         *
         * JSON.stringify wraps the string in double-quotes:
         *   onclick="viewDetail(event, 5, "http://...")"
         * The inner " breaks the HTML attribute → onclick never fires.
         *
         * FIX: Store the URL in a data-url attribute on the card element.
         * The JS reads it with card.dataset.url — no quote escaping needed.
         * ────────────────────────────────────────────────────────────────
         */
        html += `
        <div class="np-card ${unr?'unread':''}" id="nc-${n.id}"
             style="${unr?`--tc:${c.color};`:''}"
             data-id="${n.id}"
             data-url="${esc(n.action_url||'')}"
             onclick="cardClick(event,this)">

            <div class="np-ci" style="background:${c.color}">
                <i class="fas fa-${c.icon}"></i>
            </div>

            <div class="np-cb">
                <div class="np-cb-top">
                    <div class="np-cb-head">
                        ${unr?`<span class="np-dot" style="background:${c.color}"></span>`:''}
                        <h3 class="np-cb-title">${esc(n.title)}</h3>
                    </div>
                    <time class="np-cb-time">${fmtTime(n.created_at)}</time>
                </div>
                <p class="np-cb-msg">${esc(n.message)}</p>
                <div class="np-cb-foot">
                    <span class="np-tag-pri ${pri}">
                        <i class="fas fa-${pIco}"></i> ${pri}
                    </span>
                    <span class="np-tag-type" style="color:${c.color};background:${c.bg}">
                        ${c.label}
                    </span>
                    <div class="np-acts">

   
    ${''}

    ${n.action_url ? `
    <button class="np-btn np-btn-view" data-id="${n.id}"
        onclick="viewDetail(event,this)">
        <i class="fas fa-external-link-alt"></i> View
    </button>` : ''}

    <button class="np-btn np-btn-del"
   onclick="deleteNotif(event,this)"
   data-id="${n.id}">
   <i class="fas fa-trash"></i>
</button>

</div>
                </div>
            </div>
        </div>`;
    });
    html += '</div>';
    wrap.innerHTML = html;
    renderPager(data);
}

/* ── Pagination ──────────────────────────────────────── */
function renderPager(data) {
    const w = document.getElementById('npPager');
    if (!data.last_page || data.last_page<=1) { w.innerHTML=''; return; }
    w.innerHTML = `
    <div class="np-pager">
        <span class="np-pager-info">Showing ${data.from||0}–${data.to||0} of ${data.total||0}</span>
        <div class="np-pager-btns">
            <button class="np-pager-btn" onclick="load(${data.current_page-1})"
                ${data.current_page<=1?'disabled':''}>
                <i class="fas fa-chevron-left"></i> Prev
            </button>
            <span class="np-pager-cur">${data.current_page} / ${data.last_page}</span>
            <button class="np-pager-btn" onclick="load(${data.current_page+1})"
                ${!data.has_more_pages?'disabled':''}>
                Next <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>`;
}

/* ── Header sync ─────────────────────────────────────── */
function syncHeader(knownTotal) {
    api(NOTIFICATION_URLS.unreadCount)
    .then(data => {
        const n   = data.unreadCount || 0;
        const bdg = document.getElementById('hdBadge');
        const ico = document.getElementById('hdIcon');
        const mb  = document.getElementById('markAllBtn');
        const ul  = document.getElementById('unreadLbl');
        const tl  = document.getElementById('totalLbl');

        if (n>0) {
            bdg.textContent = n>99?'99+':n;
            bdg.style.display = 'block';
            ico.classList.add('ringing');
            setTimeout(()=>ico.classList.remove('ringing'),500);
            mb.style.display = 'inline-flex';
            ul.innerHTML = `<span class="np-pill-unread"><i class="fas fa-circle"></i> ${n} unread</span>`;
        } else {
            bdg.style.display = 'none';
            mb.style.display  = 'none';
            ul.innerHTML = `<span class="np-pill-ok"><i class="fas fa-check-circle"></i> All caught up</span>`;
        }
        if (knownTotal!==undefined) tl.textContent = knownTotal + ' total';

        /* topbar badge */
        const tb = document.getElementById('notificationBadge');
        if (tb) {
            if (n>0){tb.textContent=n>99?'99+':n;tb.classList.add('show');}
            else tb.classList.remove('show');
        }
    }).catch(()=>{});
}

/* ── Card body click → mark read ─────────────────────── */
function cardClick(event, card) {
    if (event.target.closest('.np-btn')) return;
    doMarkRead(parseInt(card.dataset.id));
}

/* ── View detail ─────────────────────────────────────── */
/* Reads URL from data-url on the parent card — no onclick param needed */
function viewDetail(event, btn) {
    event.stopPropagation();
    const id   = parseInt(btn.dataset.id);
    const card = document.getElementById('nc-' + id);
    const url  = card ? (card.dataset.url || '') : '';

    doMarkRead(id, () => {
        if (url) window.location.href = url;
        else load(page);
    });
}


function deleteNotif(event, btn) {
    event.stopPropagation();

    const id = parseInt(btn.dataset.id);

    if (!confirm("Delete this notification?")) return;

    api(notificationUrl(id), {method:'DELETE'})
    .then(data => {
        // remove sa UI agad (smooth UX)
        const card = document.getElementById('nc-' + id);
        if (card) card.remove();

        toast('Notification deleted', 'ok');
        syncHeader();

    })
    .catch(err => {
        toast('Delete failed: ' + err.message, 'err');
    });
}
/* ── Mark single as read ─────────────────────────────── */
function doMarkRead(id, cb) {
    api(notificationUrl(id, 'read'), {method:'POST'})
    .then(() => {
        const card = document.getElementById('nc-'+id);
        if (card) {
            card.classList.remove('unread');
            card.removeAttribute('style');
            const dot = card.querySelector('.np-dot');
            if (dot) dot.remove();
        }
        syncHeader();
        if (cb) cb();
    })
    .catch(err => console.error('markRead error:', err));
}

/* ── Mark all read ───────────────────────────────────── */
function markAllRead() {
    api(NOTIFICATION_URLS.markAllRead, {method:'POST'})
    .then(() => { load(page); syncHeader(); toast('All notifications marked as read','ok'); })
    .catch(err => toast('Error: '+err.message,'err'));
}


/* ── Modal ───────────────────────────────────────────── */
function openModal({icoClass,icoType,title,msg,confirmClass,confirmLabel,onConfirm}) {
    document.getElementById('mIco').className  = 'np-modal-ico '+icoType;
    document.getElementById('mIcoI').className = 'fas '+icoClass;
    document.getElementById('mTitle').textContent = title;
    document.getElementById('mMsg').textContent   = msg;
    const cb = document.getElementById('mConfirm');
    cb.className   = 'np-mbt '+confirmClass;
    cb.textContent = confirmLabel;
    _pending = onConfirm;
    document.getElementById('npOverlay').style.display = 'flex';
}
function closeModal(){document.getElementById('npOverlay').style.display='none'; _pending=null;}
function doConfirm(){closeModal(); if(_pending)_pending();}

/* ── Toasts ──────────────────────────────────────────── */
const TICONS={ok:'fa-check-circle',err:'fa-exclamation-circle',inf:'fa-info-circle'};
function toast(msg, type='inf') {
    const w=document.getElementById('npToasts');
    const el=document.createElement('div');
    el.className='np-toast '+type;
    el.innerHTML=`<i class="fas ${TICONS[type]||'fa-info-circle'}"></i> ${esc(msg)}`;
    w.appendChild(el);
    setTimeout(()=>{
        el.style.cssText='opacity:0;transform:translateY(10px);transition:opacity .3s,transform .3s';
        setTimeout(()=>el.remove(),300);
    },3500);
}


function prog(on){document.getElementById('npProg').classList.toggle('on',on);}
function esc(s){
    if(!s) return '';
    const d = document.createElement('div');
    d.textContent = String(s);
    return d.innerHTML;
}
function fmtTime(ds){
    try{
        const d=new Date(ds), df=Math.floor((Date.now()-d)/1000);
        if(df<60)return'Just now';
        if(df<3600)return Math.floor(df/60)+'m ago';
        if(df<86400)return Math.floor(df/3600)+'h ago';
        if(df<604800)return Math.floor(df/86400)+'d ago';
        return d.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
    }catch{return'Recently';}
}


document.addEventListener('DOMContentLoaded',()=>{
    load(1);
    setInterval(()=>load(page), 30_000);
});
</script>

@endsection
