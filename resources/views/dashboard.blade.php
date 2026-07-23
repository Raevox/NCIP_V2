@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root {
    --green-900: #1a3d0f;
    --green-700: #2d6a1f;
    --green-500: #3E7B27;
    --green-400: #52a033;
    --green-300: #7cc05a;
    --green-100: #e8f5e2;
    --green-50:  #f4fbf0;

    --sand-100: #f7f5f0;
    --sand-200: #ede9e0;

    --text-dark: #1a1f16;
    --text-mid:  #4a5245;
    --text-soft: #8a9485;

    --white: #ffffff;
    --shadow-sm: 0 1px 4px rgba(30,60,20,0.07);
    --shadow-md: 0 4px 18px rgba(30,60,20,0.10);

    --radius-sm: 8px;
    --radius-md: 14px;
    --radius-lg: 20px;
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

body, .dashboard-content {
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin: 10px;
}

/* ── Header ─────────────────────────────── */
.dashboard-header {
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.dashboard-header h2 {
    font-size: 26px;
    font-weight: 700;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.4px;
}

.dashboard-header h2 i {
    background: var(--green-500);
    color: #fff;
    width: 38px; height: 38px;
    border-radius: var(--radius-sm);
    display: grid;
    place-items: center;
    font-size: 16px;
}

.header-date {
    font-size: 13px;
    color: var(--text-soft);
    font-weight: 500;
    background: var(--white);
    border: 1px solid var(--sand-200);
    padding: 6px 14px;
    border-radius: 20px;
}

/* ── Stats Grid ──────────────────────────── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 24px 22px 20px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--sand-200);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.stat-card-accent {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--radius-md) var(--radius-md) 0 0;
}

.stat-card:nth-child(1) .stat-card-accent { background: linear-gradient(90deg, #3E7B27, #7cc05a); }
.stat-card:nth-child(2) .stat-card-accent { background: linear-gradient(90deg, #2196a8, #43c6d4); }
.stat-card:nth-child(3) .stat-card-accent { background: linear-gradient(90deg, #d97706, #f5c842); }
.stat-card:nth-child(4) .stat-card-accent { background: linear-gradient(90deg, #9333ea, #c084fc); }

.stat-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
}

.stat-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-soft);
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.stat-icon-wrap {
    width: 36px; height: 36px;
    border-radius: var(--radius-sm);
    display: grid; place-items: center;
    font-size: 15px;
}

.stat-card:nth-child(1) .stat-icon-wrap { background: var(--green-100); color: var(--green-500); }
.stat-card:nth-child(2) .stat-icon-wrap { background: #e0f7fa; color: #2196a8; }
.stat-card:nth-child(3) .stat-icon-wrap { background: #fff8e1; color: #d97706; }
.stat-card:nth-child(4) .stat-icon-wrap { background: #f3e8ff; color: #9333ea; }

.stat-value {
    font-size: 38px;
    font-weight: 700;
    line-height: 1;
    color: var(--text-dark);
    font-variant-numeric: tabular-nums;
    font-family: 'DM Mono', monospace;
    letter-spacing: -1px;
}

.stat-footer {
    margin-top: 10px;
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.stat-card:nth-child(1) .stat-footer { color: var(--green-500); }
.stat-card:nth-child(2) .stat-footer { color: #2196a8; }
.stat-card:nth-child(3) .stat-footer { color: #d97706; }
.stat-card:nth-child(4) .stat-footer { color: #9333ea; }

/* ── Charts Grid ─────────────────────────── */
.charts-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

.chart-wrapper {
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 24px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--sand-200);
    display: flex;
    flex-direction: column;
}

.chart-wrapper h3 {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.chart-wrapper h3 i { color: var(--green-500); font-size: 14px; }

.chart-subtitle {
    font-size: 12px;
    color: var(--text-soft);
    margin-bottom: 20px;
    flex-shrink: 0;
}

/* Monthly chart */
.chart-container {
    position: relative;
    height: 280px;
    width: 100%;
}

/* Tribe chart — scrollable so bars never get squished */
.tribe-chart-scroll {
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    flex: 1;
}

.tribe-chart-scroll::-webkit-scrollbar          { height: 4px; }
.tribe-chart-scroll::-webkit-scrollbar-track    { background: var(--green-50); border-radius: 4px; }
.tribe-chart-scroll::-webkit-scrollbar-thumb    { background: var(--green-300); border-radius: 4px; }

/* Inner wrapper — grows horizontally when many tribes */
.tribe-chart-inner {
    position: relative;
    height: 240px;
    min-width: 300px;
    width: 100%;
}

.no-data {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 240px;
    color: var(--text-soft);
    gap: 10px;
}

.no-data i  { font-size: 40px; opacity: 0.25; }
.no-data p  { font-size: 14px; }

/* ── Tribe Legend ────────────────────────── */
.tribe-legend {
    margin-top: 14px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 130px;
    overflow-y: auto;
    flex-shrink: 0;
}

.tribe-legend::-webkit-scrollbar       { width: 4px; }
.tribe-legend::-webkit-scrollbar-track { background: var(--green-50); border-radius: 4px; }
.tribe-legend::-webkit-scrollbar-thumb { background: var(--green-300); border-radius: 4px; }

.tribe-legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12.5px;
    color: var(--text-mid);
    font-weight: 500;
}

.tribe-legend-dot {
    width: 10px; height: 10px;
    border-radius: 3px;
    flex-shrink: 0;
}

.tribe-legend-bar-track {
    flex: 1;
    background: var(--sand-200);
    border-radius: 20px;
    height: 6px;
    overflow: hidden;
}

.tribe-legend-bar-fill {
    height: 100%;
    border-radius: 20px;
    transition: width 1s cubic-bezier(0.4,0,0.2,1);
}

.tribe-legend-count {
    font-family: 'DM Mono', monospace;
    font-size: 12px;
    color: var(--text-soft);
    min-width: 24px;
    text-align: right;
}

/* ── Recent Applications ─────────────────── */
.recent-applications {
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 24px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--sand-200);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.section-header h3 {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-header h3 i { color: var(--green-500); font-size: 14px; }

.section-badge {
    background: var(--green-100);
    color: var(--green-500);
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.3px;
}

.applications-table {
    width: 100%;
    border-collapse: collapse;
}

.applications-table thead tr { border-bottom: 1.5px solid var(--sand-200); }

.applications-table th {
    padding: 10px 14px;
    text-align: left;
    font-weight: 600;
    color: var(--text-soft);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    white-space: nowrap;
}

.applications-table td {
    padding: 13px 14px;
    border-bottom: 1px solid var(--sand-100);
    font-size: 13.5px;
    color: var(--text-dark);
    vertical-align: middle;
}

.applications-table tbody tr:last-child td { border-bottom: none; }
.applications-table tbody tr { transition: background 0.15s; }
.applications-table tbody tr:hover { background-color: var(--green-50); }

.applicant-cell { display: flex; align-items: center; gap: 10px; }

.applicant-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-400), var(--green-700));
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    letter-spacing: 0.5px;
}

.applicant-name { font-weight: 600; color: var(--text-dark); font-size: 13.5px; }

.tribe-badge {
    background: var(--green-100);
    color: var(--green-700);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}

.status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }

.status-badge.pending         { background: #fff8e1; color: #b45309; }
.status-badge.pending::before  { background: #f59e0b; }
.status-badge.approved         { background: #ecfdf5; color: #065f46; }
.status-badge.approved::before { background: #10b981; }
.status-badge.processing         { background: #eff6ff; color: #1d4ed8; }
.status-badge.processing::before { background: #3b82f6; }
.status-badge.rejected         { background: #fef2f2; color: #991b1b; }
.status-badge.rejected::before { background: #ef4444; }
.status-badge.admin\ approval         { background: #f5f3ff; color: #5b21b6; }
.status-badge.admin\ approval::before { background: #7c3aed; }
.status-badge.returned         { background: #fff7ed; color: #9a3412; }
.status-badge.returned::before { background: #f97316; }
.status-badge.declined         { background: #fef2f2; color: #991b1b; }
.status-badge.declined::before { background: #ef4444; }

.date-text {
    color: var(--text-soft);
    font-size: 12.5px;
    font-family: 'DM Mono', monospace;
}

.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    border: 1.5px solid var(--green-300);
    border-radius: var(--radius-sm);
    color: var(--green-500);
    font-size: 12px;
    font-weight: 600;
    background: var(--white);
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
}

.btn-view:hover { background: var(--green-500); color: #fff; border-color: var(--green-500); }

.no-recent-apps { text-align: center; padding: 48px 20px; color: var(--text-soft); }
.no-recent-apps i { font-size: 40px; opacity: 0.2; margin-bottom: 12px; display: block; }
.no-recent-apps p { font-size: 14px; }

/* ── Responsive ──────────────────────────── */
@media (max-width: 1200px) {
    .stats-grid  { grid-template-columns: repeat(2, 1fr); }
    .charts-grid { grid-template-columns: 1fr; }
    .tribe-chart-inner { height: 280px; }
}

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .stat-value { font-size: 28px; }
    .applications-table { font-size: 12px; }
    .applications-table th,
    .applications-table td { padding: 10px; }
    .applicant-avatar { display: none; }
    /* Allow horizontal scroll on small screens so bars stay readable */
    .tribe-chart-inner { min-width: 380px; }
}

@media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr; }
}
</style>

<div class="dashboard-content">

    {{-- Header --}}
    <div class="dashboard-header">
        <h2>
            <i class="fas fa-chart-line"></i>
            Dashboard Overview
        </h2>
        <span class="header-date">
            <i class="fas fa-calendar-alt" style="margin-right:6px;color:var(--green-500);"></i>
            {{ now()->format('F d, Y') }}
        </span>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-accent"></div>
            <div class="stat-top">
                <span class="stat-label">Total Users</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-footer"><i class="fas fa-check-circle"></i> Active accounts</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-accent"></div>
            <div class="stat-top">
                <span class="stat-label">Total IP Records</span>
                <div class="stat-icon-wrap"><i class="fas fa-folder-open"></i></div>
            </div>
            <div class="stat-value">{{ $totalIpRecords }}</div>
            <div class="stat-footer"><i class="fas fa-check-circle"></i> Registered records</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-accent"></div>
            <div class="stat-top">
                <span class="stat-label">Total COC Issued</span>
                <div class="stat-icon-wrap"><i class="fas fa-certificate"></i></div>
            </div>
            <div class="stat-value">{{ $totalCOC }}</div>
            <div class="stat-footer"><i class="fas fa-check-circle"></i> Completed</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-accent"></div>
            <div class="stat-top">
                <span class="stat-label">Pending Review</span>
                <div class="stat-icon-wrap"><i class="fas fa-hourglass-half"></i></div>
            </div>
            <div class="stat-value">{{ $totalPending }}</div>
            <div class="stat-footer"><i class="fas fa-clock"></i> Awaiting action</div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="charts-grid">

        {{-- Monthly Line Chart --}}
        <div class="chart-wrapper">
            <h3><i class="fas fa-calendar-days"></i> Monthly Applications</h3>
            <p class="chart-subtitle">Last 12 months overview</p>
            <div class="chart-container" id="monthlyChartArea">
                <canvas id="monthlyLineChart"></canvas>
            </div>
        </div>

        {{-- Tribe Vertical Bar Chart --}}
        <div class="chart-wrapper">
            <h3><i class="fas fa-layer-group"></i> Applications by Tribe</h3>
            <p class="chart-subtitle">Distribution across indigenous groups</p>

            {{-- Scrollable wrapper keeps bars patayo at hindi nag-ooverlap --}}
            <div class="tribe-chart-scroll">
                <div class="tribe-chart-inner" id="tribeChartArea">
                    <canvas id="tribeBarChart"></canvas>
                </div>
            </div>

            <div class="tribe-legend" id="tribeLegend"></div>
        </div>
    </div>

    {{-- Recent Applications --}}
    <div class="recent-applications">
        <div class="section-header">
            <h3><i class="fas fa-clock-rotate-left"></i> Recent Applications</h3>
            <span class="section-badge">Latest 5</span>
        </div>

        @if($recentApplications->count() > 0)
            <div style="overflow-x: auto;">
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Tribe</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $app)
                            @php
                                $firstName   = $app->applicant->first_name ?? 'N/A';
                                $lastName    = $app->applicant->last_name  ?? '';
                                $initials    = strtoupper(substr($firstName,0,1) . substr($lastName,0,1));
                                $statusClass = strtolower($app->coc_status ?? 'pending');
                            @endphp
                            <tr>
                                <td>
                                    <div class="applicant-cell">
                                        <div class="applicant-avatar">{{ $initials }}</div>
                                        <span class="applicant-name">{{ $firstName }} {{ $lastName }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="tribe-badge">{{ $app->applicant->tribe ?? ($app->tribe ?? 'Unknown') }}</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $app->coc_status ?? 'Pending' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="date-text">
                                        {{ $app->created_at ? $app->created_at->format('M d, Y') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.applicants.coc.view', $app->id) }}" class="btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-recent-apps">
                <i class="fas fa-inbox"></i>
                <p>No recent applications found</p>
            </div>
        @endif
    </div>
</div>

<script>
const tribeLabels   = @json($chartLabels);
const tribeData     = @json($chartData);
const monthlyLabels = @json($monthlyData['labels']);
const monthlyData   = @json($monthlyData['data']);

const tribePalette = [
    '#3E7B27','#52a033','#7cc05a','#2d6a1f','#a8d98a',
    '#1a3d0f','#b8e6a0','#4a8c35','#6db54d','#9ed17c'
];

/* ── Monthly Line Chart ─────────────────────────────────── */
const ctxLine = document.getElementById('monthlyLineChart');

if (!monthlyLabels.length) {
    document.getElementById('monthlyChartArea').innerHTML =
        `<div class="no-data"><i class="fas fa-chart-line"></i><p>No data available</p></div>`;
} else {
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Applications',
                data: monthlyData,
                borderColor: '#3E7B27',
                backgroundColor: 'rgba(62,123,39,0.08)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.45,
                pointRadius: 4,
                pointBackgroundColor: '#3E7B27',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a3d0f',
                    titleFont: { family: 'DM Sans', size: 13, weight: '600' },
                    bodyFont:  { family: 'DM Sans', size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        title: (items) => items[0].label,
                        label: (item)  => `  ${item.parsed.y} application${item.parsed.y !== 1 ? 's' : ''}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize:1, precision:0, font:{family:'DM Mono',size:11}, color:'#8a9485' },
                    grid:  { color:'rgba(0,0,0,0.04)', drawBorder:false }
                },
                x: {
                    ticks: { font:{family:'DM Sans',size:11}, color:'#8a9485', maxRotation:0, autoSkip:true, maxTicksLimit:7 },
                    grid:  { display: false }
                }
            }
        }
    });
}

/* ── Tribe VERTICAL Bar Chart ───────────────────────────── */
const ctxBar  = document.getElementById('tribeBarChart');
const innerEl = document.getElementById('tribeChartArea');

if (!tribeLabels.length) {
    innerEl.innerHTML =
        `<div class="no-data"><i class="fas fa-chart-bar"></i><p>No tribe data available</p></div>`;
} else {
    /*
     * Dynamically widen the inner container so each bar gets ~56 px.
     * The outer .tribe-chart-scroll will then scroll horizontally on small screens.
     */
    const perBar    = 56;
    const computed  = Math.max(300, tribeLabels.length * perBar + 60);
    if (computed > innerEl.offsetWidth) {
        innerEl.style.width = computed + 'px';
    }

    const colors = tribeLabels.map((_, i) => tribePalette[i % tribePalette.length]);

    new Chart(ctxBar, {
        type: 'bar',                      // ← vertical (default, NO indexAxis:'y')
        data: {
            labels: tribeLabels,
            datasets: [{
                label: 'Applications',
                data: tribeData,
                backgroundColor: colors.map(c => c + 'cc'),
                borderColor: colors,
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 32,
                maxBarThickness: 48,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a3d0f',
                    titleFont: { family: 'DM Sans', size: 13, weight: '600' },
                    bodyFont:  { family: 'DM Sans', size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (item) => `  ${item.parsed.y} application${item.parsed.y !== 1 ? 's' : ''}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize:1, precision:0, font:{family:'DM Mono',size:11}, color:'#8a9485' },
                    grid:  { color:'rgba(0,0,0,0.04)', drawBorder:false }
                },
                x: {
                    ticks: {
                        font: { family:'DM Sans', size:11, weight:'500' },
                        color: '#4a5245',
                        maxRotation: 30,   /* slight tilt so long names don't overlap */
                        autoSkip: false
                    },
                    grid: { display: false }
                }
            }
        }
    });

    /* ── Custom Legend with animated progress bars ─────── */
    const maxVal   = Math.max(...tribeData);
    const legendEl = document.getElementById('tribeLegend');

    tribeLabels.forEach((tribe, i) => {
        const count = tribeData[i];
        const color = tribePalette[i % tribePalette.length];
        const pct   = maxVal > 0 ? Math.round((count / maxVal) * 100) : 0;

        const item = document.createElement('div');
        item.className = 'tribe-legend-item';
        item.innerHTML = `
            <div class="tribe-legend-dot" style="background:${color}"></div>
            <span style="min-width:90px;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${tribe}">${tribe}</span>
            <div class="tribe-legend-bar-track">
                <div class="tribe-legend-bar-fill" style="width:0%;background:${color}" data-width="${pct}%"></div>
            </div>
            <span class="tribe-legend-count">${count}</span>
        `;
        legendEl.appendChild(item);
    });

    setTimeout(() => {
        document.querySelectorAll('.tribe-legend-bar-fill').forEach(el => {
            el.style.width = el.dataset.width;
        });
    }, 300);
}
</script>

@endsection