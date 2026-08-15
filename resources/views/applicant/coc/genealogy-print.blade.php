<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCIP Genealogy Form</title>
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
    <style>

* { margin:0; padding:0; box-sizing:border-box; }
html, body { background: #f0f0f0; }

.form-scroll-wrapper {
    width: 100%;
    overflow-x: auto;
    overflow-y: visible;
    -webkit-overflow-scrolling: touch; 
}

.form-page {
    width: 980px;           
    min-width: 980px;       
    margin: 20px auto;
    background: #fff;
    padding: 14px 16px 18px;
    font-family: Arial, sans-serif;
    font-size: 10px;
    color: #000;
    box-shadow: 0 2px 16px rgba(0,0,0,0.15);
}

/* ── HEADER ─────────────────────────────────── */
.gen-header {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    margin-bottom: 8px;
}
.gen-hdr-left {
    flex: 0 0 225px;
    font-size: 10px;
    line-height: 2;
}
.gen-hdr-left .ai {
    border: none;
    border-bottom: 1px solid #000;
    width: 135px;
    font-size: 10px;
    background: transparent;
    outline: none;
    vertical-align: bottom;
}
.gen-hdr-center {
    flex: 0 0 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 4px;
}
.gen-title {
    border: 2px solid #000;
    padding: 7px 16px;
    font-size: 17px;
    font-weight: bold;
    letter-spacing: 2px;
}
.gen-hdr-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 3px;
}
.form-code {
    border: 1px solid #000;
    padding: 2px 8px;
    font-size: 9px;
    font-weight: bold;
    white-space: nowrap;    /* prevent wrapping of form code */
}
.instructions {
    font-size: 9px;
    line-height: 1.65;
    text-align: left;
    max-width: 220px;       /* prevent instructions from being too wide */
}

/* ── TREE CONTAINER ─────────────────────────── */
.tree-area {
    position: relative;
    width: 100%;
}
.tree-svg {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    overflow: visible;
    z-index: 0;
}

/* ── PERSON UNIT ─────────────────────────────
   = bordered box (title only) + fields below  */
.pu {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
}

/* the bordered box — just the title label */
.pu-box {
    border: 1px solid #000;
    padding: 3px 4px 3px;
    background: #fff;
    cursor: pointer;
    position: relative;
    z-index: 1;
    transition: background 0.12s;
    min-height: 32px;
}
.pu-box:hover { background: #f2fbec; }

.pu-title {
    font-size: 8.5px;
    font-weight: bold;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pu-name {
    width: 100%;
    border: none;
    border-bottom: 1px solid #777;
    font-size: 8.5px;
    outline: none;
    background: transparent;
    margin-top: 2px;
    display: block;
}

/* fields below the box */
.pu-fields { padding-top: 2px; width: 100%; }

.pu-frow {
    display: flex;
    align-items: baseline;
    gap: 2px;
    margin-top: 1px;
    white-space: nowrap;
}
.pu-flabel {
    font-size: 8.5px;
    flex-shrink: 0;
}
.pu-finput {
    flex: 1;
    border: none;
    border-bottom: 1px solid #000;
    font-size: 8.5px;
    outline: none;
    background: transparent;
    min-width: 0;
}

/* ── COUPLE (two person-units + = sign) ──────── */
.couple {
    display: flex;
    align-items: flex-start;
    flex: 1;
    min-width: 0;
}
.couple-eq {
    font-size: 11px;
    font-weight: bold;
    padding: 9px 2px 0;
    flex-shrink: 0;
    align-self: flex-start;
}

/* ── ROW LAYOUTS ─────────────────────────────── */

/* GG row: 4 couples across */
.gg-row {
    display: flex;
    width: 100%;
    gap: 0;
}
.gg-gap-mid { width: 22px; flex-shrink: 0; }
.gg-gap-sm  { width: 3px;  flex-shrink: 0; }

/* spacers between rows */
.sp-gg-gp  { height: 36px; }
.sp-gp-par { height: 30px; }
.sp-par-app{ height: 30px; }

/* GP row: 2 couples across */
.gp-row {
    display: flex;
    width: 100%;
    gap: 0;
}
.gp-gap-mid { width: 22px; flex-shrink: 0; }

/* Par row: 2 units, inset */
.par-row {
    display: flex;
    width: 100%;
}
.par-cell {
    flex: 1;
    display: flex;
    justify-content: center;
}
.par-cell .pu { width: 200px; flex: none; }

/* App row: centered */
.app-row {
    display: flex;
    justify-content: center;
}
.app-row .pu { width: 190px; flex: none; }

/* ── FOOTER ──────────────────────────────────── */
.gen-footer {
    display: flex;
    gap: 14px;
    margin-top: 14px;
    padding-top: 10px;
    border-top: 1px solid #ccc;
    font-size: 9px;
}
.f-validated  { flex: 1.2; }
.f-subscribed { flex: 1.0; }
.f-attested   { flex: 1.2; }

.f-title { font-size: 10px; font-weight: bold; margin-bottom: 6px; }

.f-sig-line  { border-bottom: 1px solid #000; width: 190px; margin-bottom: 2px; }
.f-sig-label { font-size: 8px; font-style: italic; text-align: center; width: 190px; }

.f-cert {
    font-size: 8.5px;
    line-height: 1.6;
    margin-top: 10px;
}
.f-blank { display: inline-block; border-bottom: 1px solid #000; vertical-align: bottom; }
.f-sub   { font-size: 9px; line-height: 2.1; }
.f-doc   { font-size: 9px; line-height: 2.0; margin-top: 8px; }
.f-db    { display: inline-block; border-bottom: 1px solid #000; width: 44px; vertical-align: bottom; }
.f-att   { font-size: 8.5px; line-height: 1.7; }
.f-att-line  { border-bottom: 1px solid #000; margin-bottom: 2px; }
.f-oath { text-align: center; margin-top: 18px; }
.f-oath-line { border-bottom: 1px solid #000; width: 190px; margin: 0 auto 2px; }

/* ── MODAL ───────────────────────────────────── */
.gn-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.gn-mbox {
    background: #fff;
    border: 1.5px solid #333;
    padding: 20px 22px;
    width: 270px;
    position: relative;
    border-radius: 2px;
    box-shadow: 0 4px 22px rgba(0,0,0,0.28);
    font-family: Arial, sans-serif;
    font-size: 11px;
}
.gn-close {
    position: absolute;
    top: 6px; right: 10px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    color: #555;
    line-height: 1;
}
.gn-close:hover { color: #000; }
.gn-mtitle {
    font-weight: bold;
    font-size: 13px;
    border-bottom: 1px solid #000;
    padding-bottom: 6px;
    margin-bottom: 10px;
}
.gn-mfield { margin-bottom: 8px; }
.gn-mlabel { font-size: 8.5px; color: #666; font-weight: bold; text-transform: uppercase; margin-bottom: 1px; }
.gn-mvalue { font-size: 12px; border-bottom: 1px solid #ddd; padding-bottom: 2px; min-height: 18px; }
    </style>
</head>
<body>

{{-- ── KEY FIX: wrap in scroll container ── --}}
<div class="form-scroll-wrapper">
<div class="form-page">

    <!-- ════ HEADER ════════════════════════════ -->
    <div class="gen-header">
        <div class="gen-hdr-left">
            Republic of the Philippines<br>
            Province of <input type="text" class="ai" style="width:133px;"><br>
            Municipality of <input type="text" class="ai" style="width:116px;"><br>
            Barangay of <input type="text" class="ai" style="width:127px;">
        </div>
        <div class="gen-hdr-center">
            <div class="gen-title">GENEALOGY</div>
        </div>
        <div class="gen-hdr-right">
            <div class="form-code">NCIP COC Form 2</div>
            <div class="instructions">
                <strong><em>Instructions:</em></strong><br>
                1. Use mother's maiden name.<br>
                2. Complete entry in the Place of Origin (Barangay, Municipality, Province).<br>
                3. Strictly NO ERASURES.
            </div>
        </div>
    </div>

    <!-- ════ FAMILY TREE ═══════════════════════ -->
    <div class="tree-area" id="treeArea">

        <!-- SVG overlay for connecting lines -->
        <svg class="tree-svg" id="treeSvg"></svg>

        <!-- ── GG ROW ─────────────────────────── -->
        <div class="gg-row">

            <!-- COUPLE 1 → grandfather1 -->
            <div class="couple" id="ggc1">
                <div class="pu" id="great-grandfather1" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandfather</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
                <span class="couple-eq">=</span>
                <div class="pu" id="great-grandmother1" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandmother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>

            <div class="gg-gap-sm"></div>

            <!-- COUPLE 2 → grandmother1 -->
            <div class="couple" id="ggc2">
                <div class="pu" id="great-grandfather2" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandfather</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
                <span class="couple-eq">=</span>
                <div class="pu" id="great-grandmother2" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandmother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>

            <!-- Mid gap -->
            <div class="gg-gap-mid"></div>

            <!-- COUPLE 3 → grandfather2 -->
            <div class="couple" id="ggc3">
                <div class="pu" id="great-grandfather3" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandfather</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
                <span class="couple-eq">=</span>
                <div class="pu" id="great-grandmother3" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandmother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>

            <div class="gg-gap-sm"></div>

            <!-- COUPLE 4 → grandmother2 -->
            <div class="couple" id="ggc4">
                <div class="pu" id="great-grandfather4" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandfather</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
                <span class="couple-eq">=</span>
                <div class="pu" id="great-grandmother4" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Great Grandmother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>

        </div><!-- /gg-row -->

        <div class="sp-gg-gp"></div>

        <!-- ── GP ROW ─────────────────────────── -->
        <div class="gp-row">

            <!-- Paternal grandparents (left) -->
            <div class="couple" id="gpc1">
                <div class="pu" id="grandfather1" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Grandfather</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
                <span class="couple-eq">=</span>
                <div class="pu" id="grandmother1" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Grandmother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>

            <div class="gp-gap-mid"></div>

            <!-- Maternal grandparents (right) -->
            <div class="couple" id="gpc2">
                <div class="pu" id="grandfather2" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Grandfather</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
                <span class="couple-eq">=</span>
                <div class="pu" id="grandmother2" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Grandmother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>

        </div><!-- /gp-row -->

        <div class="sp-gp-par"></div>

        <!-- ── PARENTS ROW ───────────────────── -->
        <div class="par-row">
            <div class="par-cell">
                <div class="pu" id="father" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Applicant's Father</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>
            <div class="par-cell">
                <div class="pu" id="mother" onclick="showDetail(this)">
                    <div class="pu-box">
                        <div class="pu-title">Applicant's Mother</div>
                        <input type="text" class="pu-name">
                    </div>
                    <div class="pu-fields">
                        <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                        <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                    </div>
                </div>
            </div>
        </div><!-- /par-row -->

        <div class="sp-par-app"></div>

        <!-- ── APPLICANT ─────────────────────── -->
        <div class="app-row">
            <div class="pu" id="applicant" onclick="showDetail(this)">
                <div class="pu-box">
                    <div class="pu-title">Name of Applicant</div>
                    <input type="text" class="pu-name">
                </div>
                <div class="pu-fields">
                    <div class="pu-frow"><span class="pu-flabel">IPs/ICCs</span><input type="text" class="pu-finput"></div>
                    <div class="pu-frow"><span class="pu-flabel">Place of Origin</span><input type="text" class="pu-finput"></div>
                </div>
            </div>
        </div>

    </div><!-- /tree-area -->

    <!-- ════ FOOTER ════════════════════════════ -->
    <div class="gen-footer">

        <!-- Validated by -->
        <div class="f-validated">
            <div class="f-title">Validated by:</div>
            <div style="margin-top:20px;">
                <div class="f-sig-line"></div>
                <div class="f-sig-label">NCIP Investigating Officer (PO/SC/CO)</div>
                <div class="f-sig-label"><em>(Signature over printed name)</em></div>
            </div>
            <div class="f-cert">
                I hereby certify upon penalties of perjury that the information appearing above
                are true and correct of my personal knowledge based on authentic records.
            </div>
            <div style="text-align:center;margin-top:14px;">
                <div class="f-sig-line" style="margin:0 auto;"></div>
                <div class="f-sig-label">Applicant</div>
            </div>
        </div>

        <!-- Subscribed and Sworn -->
        <div class="f-subscribed">
            <div class="f-sub"><strong>SUBSCRIBED AND SWORN</strong> to before me this
                <span class="f-blank" style="width:24px;">&nbsp;</span> day of
                <span class="f-blank" style="width:56px;">&nbsp;</span>,
                <span class="f-blank" style="width:34px;">&nbsp;</span>
            </div>
            <div class="f-sub">at <span class="f-blank" style="width:148px;">&nbsp;</span>, Philippines.</div>
            <div class="f-doc">
                Doc No. <span class="f-db">&nbsp;</span><br>
                Page No. <span class="f-db">&nbsp;</span><br>
                Book No. <span class="f-db">&nbsp;</span><br>
                Series of <span class="f-db">&nbsp;</span>
            </div>
        </div>

        <!-- Attested by -->
        <div class="f-attested">
            <div class="f-title">Attested by:</div><br>
            <div class="f-att">
                <div class="f-att-line" style="margin-bottom:3px;"></div>
                Tribal Elder/Leader/Punong Barangay<br>
                <span style="font-size:7.5px;">(SIGNATURE OVER PRINTED NAME)</span><br>
                Address: <span style="font-size:7.5px;">__________________________________________ &nbsp;</span>
            </div>
            <div class="f-oath">
                <br>
                <div class="f-oath-line"></div>
                Person Administering Oath<br>
                <em style="font-size:7.5px;">Not Valid Without Seal</em>
            </div>
        </div>

    </div>
</div><!-- /form-page -->
</div><!-- /form-scroll-wrapper -->

<!-- ════ MODAL ══════════════════════════════════ -->
<div id="gnModal" class="gn-modal">
    <div class="gn-mbox">
        <span class="gn-close" onclick="closeDetail()">&times;</span>
        <div class="gn-mtitle" id="gnMTitle"></div>
        <div class="gn-mfield">
            <div class="gn-mlabel">Full Name</div>
            <div class="gn-mvalue" id="gnMName"></div>
        </div>
        <div class="gn-mfield">
            <div class="gn-mlabel">IPs / ICCs</div>
            <div class="gn-mvalue" id="gnMIp"></div>
        </div>
        <div class="gn-mfield">
            <div class="gn-mlabel">Place of Origin</div>
            <div class="gn-mvalue" id="gnMOrigin"></div>
        </div>
    </div>
</div>

<script>
/* ══════════════════════════════════════════════
   SVG CONNECTOR LINES
   Drawn via JavaScript after DOM render
   ══════════════════════════════════════════════ */
function boxGeom(id) {
    const pu   = document.getElementById(id);
    const box  = pu.querySelector('.pu-box');
    const area = document.getElementById('treeArea');
    const br   = box.getBoundingClientRect(); // title box only — top edge + center-x
    const pr   = pu.getBoundingClientRect();  // whole unit incl. fields — bottom edge
    const ar   = area.getBoundingClientRect();
    return {
        top:  br.top    - ar.top,   // incoming lines land at top of title box
        bot:  pr.bottom - ar.top,   // outgoing lines start below Place of Origin
        cx:   br.left   - ar.left + br.width / 2,
        left: br.left   - ar.left,
        right:br.right  - ar.left,
    };
}

function ln(svg, x1, y1, x2, y2) {
    const l = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    l.setAttribute('x1', Math.round(x1)); l.setAttribute('y1', Math.round(y1));
    l.setAttribute('x2', Math.round(x2)); l.setAttribute('y2', Math.round(y2));
    l.setAttribute('stroke', '#000');
    l.setAttribute('stroke-width', '1');
    svg.appendChild(l);
}

function drawConnectors() {
    const svg  = document.getElementById('treeSvg');
    const area = document.getElementById('treeArea');
    svg.innerHTML = '';
    svg.setAttribute('height', area.offsetHeight + 10);

    /* helper: couple → child */
    function coupleToChild(idA, idB, idC) {
        const a = boxGeom(idA), b = boxGeom(idB), c = boxGeom(idC);
        const midY = a.bot + (c.top - a.bot) * 0.5;
        ln(svg, a.cx, a.bot, a.cx, midY);
        ln(svg, b.cx, b.bot, b.cx, midY);
        ln(svg, a.cx, midY, b.cx, midY);
        const mx = (a.cx + b.cx) / 2;
        ln(svg, mx, midY, c.cx, midY);
        ln(svg, c.cx, midY, c.cx, c.top);
    }

    // GG couples → Grandparents
    coupleToChild('great-grandfather1', 'great-grandmother1', 'grandfather1');
    coupleToChild('great-grandfather2', 'great-grandmother2', 'grandmother1');
    coupleToChild('great-grandfather3', 'great-grandmother3', 'grandfather2');
    coupleToChild('great-grandfather4', 'great-grandmother4', 'grandmother2');

    // Grandparent couples → Parents
    coupleToChild('grandfather1', 'grandmother1', 'father');
    coupleToChild('grandfather2', 'grandmother2', 'mother');

    // Parents → Applicant
    coupleToChild('father', 'mother', 'applicant');
}

window.addEventListener('load', drawConnectors);
window.addEventListener('resize', drawConnectors);

/* ══════════════════════════════════════════════
   FILL TREE WITH BACKEND DATA
   ══════════════════════════════════════════════ */
function fillReadonlyTree(step3, step4) {
    const leftMap = {
        "father":             ["father_first_name","father_last_name","father_ipgroup","father_origin"],
        "grandfather1":       ["paternal_grandfather_first_name","paternal_grandfather_last_name","paternal_grandfather_ipgroup","paternal_grandfather_origin"],
        "grandmother1":       ["paternal_grandmother_first_name","paternal_grandmother_last_name","paternal_grandmother_ipgroup","paternal_grandmother_origin"],
        "great-grandfather1": ["great_grandfather_grandfather_first_name","great_grandfather_grandfather_last_name","great_grandfather_grandfather_ipgroup","great_grandfather_grandfather_origin"],
        "great-grandmother1": ["great_grandmother_grandfather_first_name","great_grandmother_grandfather_last_name","great_grandmother_grandfather_ipgroup","great_grandmother_grandfather_origin"],
        "great-grandfather2": ["great_grandfather_grandmother_first_name","great_grandfather_grandmother_last_name","great_grandfather_grandmother_ipgroup","great_grandfather_grandmother_origin"],
        "great-grandmother2": ["great_grandmother_grandmother_first_name","great_grandmother_grandmother_last_name","great_grandmother_grandmother_ipgroup","great_grandmother_grandmother_origin"],
    };
    Object.entries(leftMap).forEach(([id, keys]) => {
        const el = document.getElementById(id); if (!el) return;
        el.querySelector(".pu-name").value = ((step3[keys[0]]||'') + ' ' + (step3[keys[1]]||'')).trim();
        const fi = el.querySelectorAll(".pu-finput");
        if (fi[0]) fi[0].value = step3[keys[2]] || '';
        if (fi[1]) fi[1].value = step3[keys[3]] || '';
    });

    const rightMap = {
        "mother":             ["mother_first_name","mother_last_name","mother_ipgroup","mother_origin"],
        "grandfather2":       ["maternal_grandfather_first_name","maternal_grandfather_last_name","maternal_grandfather_ipgroup","maternal_grandfather_origin"],
        "grandmother2":       ["maternal_grandmother_first_name","maternal_grandmother_last_name","maternal_grandmother_ipgroup","maternal_grandmother_origin"],
        "great-grandfather3": ["great_grandfather_grandfather_mother_first_name","great_grandfather_grandfather_mother_last_name","great_grandfather_grandfather_mother_ipgroup","great_grandfather_grandfather_mother_origin"],
        "great-grandmother3": ["great_grandmother_grandfather_mother_first_name","great_grandmother_grandfather_mother_last_name","great_grandmother_grandfather_mother_ipgroup","great_grandmother_grandfather_mother_origin"],
        "great-grandfather4": ["great_grandfather_grandmother_mother_first_name","great_grandfather_grandmother_mother_last_name","great_grandfather_grandmother_mother_ipgroup","great_grandfather_grandmother_mother_origin"],
        "great-grandmother4": ["great_grandmother_grandmother_mother_first_name","great_grandmother_grandmother_mother_last_name","great_grandmother_grandmother_mother_ipgroup","great_grandmother_grandmother_mother_origin"],
    };
    Object.entries(rightMap).forEach(([id, keys]) => {
        const el = document.getElementById(id); if (!el) return;
        el.querySelector(".pu-name").value = ((step4[keys[0]]||'') + ' ' + (step4[keys[1]]||'')).trim();
        const fi = el.querySelectorAll(".pu-finput");
        if (fi[0]) fi[0].value = step4[keys[2]] || '';
        if (fi[1]) fi[1].value = step4[keys[3]] || '';
    });

    // Applicant
    const ae = document.getElementById("applicant");
    ae.querySelector(".pu-name").value = ((step3.applicant_first_name||'') + ' ' + (step3.applicant_last_name||'')).trim();
    const af = ae.querySelectorAll(".pu-finput");
    if (af[0]) af[0].value = step3.applicant_ipgroup || '';
    if (af[1]) af[1].value = step3.applicant_origin  || '';

    // Address
    const ai = document.querySelectorAll(".gen-hdr-left .ai");
    if (ai[0]) ai[0].value = step3.province     || '';
    if (ai[1]) ai[1].value = step3.municipality || '';
    if (ai[2]) ai[2].value = step3.barangay     || '';

    document.querySelectorAll("input").forEach(i => i.setAttribute("readonly", true));

    // Redraw lines after data fills (in case heights change)
    setTimeout(drawConnectors, 50);
}

/* ══════════════════════════════════════════════
   MODAL
   ══════════════════════════════════════════════ */
function showDetail(el) {
    const title   = el.querySelector('.pu-title').textContent;
    const name    = el.querySelector('.pu-name').value;
    const inputs  = el.querySelectorAll('.pu-finput');
    const ip      = inputs[0] ? inputs[0].value : '';
    const origin  = inputs[1] ? inputs[1].value : '';

    document.getElementById('gnMTitle').textContent  = title;
    document.getElementById('gnMName').textContent   = name   || '—';
    document.getElementById('gnMIp').textContent     = ip     || '—';
    document.getElementById('gnMOrigin').textContent = origin || '—';
    document.getElementById('gnModal').style.display = 'flex';
}

function closeDetail() { document.getElementById('gnModal').style.display = 'none'; }

window.onclick = e => { if (e.target === document.getElementById('gnModal')) closeDetail(); };

/* ══════════════════════════════════════════════
   BLADE DATA INJECTION — DO NOT REMOVE
   ══════════════════════════════════════════════ */
const step3 = @json($step3);
const step4 = @json($step4);
window.addEventListener("load", function() { fillReadonlyTree(step3, step4); });
</script>
</body>
</html>