<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 12px 16px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #000; }

        /* Match the reference form's balanced placement on a legal page. */
        .form-page {
            /* Use margins on an auto-width block so Dompdf reserves space on both sides. */
            width: auto;
            margin: 0 30px;
            padding: 60px 0 6px;
        }

        .gen-header {
            width: 100%;
            margin-bottom: 10px;
            table-layout: fixed;
        }
        .gen-header td { vertical-align: top; word-wrap: break-word; overflow-wrap: break-word; }
        .gen-title {
            border: 2px solid #000;
            padding: 6px 14px;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
        }
        .form-code {
            border: 1px solid #000;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 4px;
        }
        .hdr-left-line { line-height: 1.9; font-size: 10px; }
        .hdr-left-line span {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 110px;
        }
        .instructions { font-size: 10px; line-height: 1.5; text-align: right; }

        table.tree { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        table.tree td { text-align: center; vertical-align: top; padding: 0; word-wrap: break-word; overflow-wrap: break-word; }

        /* ── person box (matches preview's .pu-box / .pu-fields) ── */
        .pbox {
            border: 1px solid #000;
            padding: 3px;
            height: 76px;
            font-size: 9px;
            text-align: center;
            margin: 0 2px;
        }
        .pbox .ptitle {
            font-weight: bold;
            font-size: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pbox .pname {
            border-bottom: 1px solid #777;
            min-height: 11px;
            font-size: 12px;
            margin-top: 2px;
            padding-bottom: 1px;
        }
        .pfields { padding: 4px 0 0; }
        .pfields .pfield {
            text-align: left;
            font-size: 10px;
            margin-top: 3px;
            white-space: nowrap;
            overflow: hidden;
        }
        .pfields .pfield span {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 52%;
            min-width: 0;
        }

        /* ── couple unit: box = box (matches preview's .couple / .couple-eq) ── */
        table.couple { width: 100%; border-collapse: collapse; table-layout: fixed; }
        table.couple td { vertical-align: top; padding: 0; overflow: hidden; }
        table.couple .eq-sign {
            width: 12px;
            min-width: 12px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            padding-top: 9px;
        }

        /* Lines join two parents to their child without crossing other branches. */
        .two-to-one-connector { height: 30px; position: relative; }
        .two-to-one-connector .source-left,
        .two-to-one-connector .source-right,
        .two-to-one-connector .child-line {
            position: absolute;
            border-left: 1px solid #000;
            width: 1px;
        }
        .two-to-one-connector .source-left { left: 24%; top: 0; height: 11px; }
        .two-to-one-connector .source-right { left: 76%; top: 0; height: 11px; }
        .two-to-one-connector .join-line {
            position: absolute;
            left: 24%; top: 10px; width: 52%;
            border-top: 1px solid #000;
            height: 1px;
        }
        .two-to-one-connector .child-line { left: 50%; top: 10px; height: 20px; }

        .gen-footer { width: 100%; margin-top: 16px; border-top: 1px solid #ccc; padding-top: 8px; }
        .gen-footer td { vertical-align: top; font-size: 10px; padding: 0 6px; }
        .f-title { font-weight: bold; font-size: 13px; margin-bottom: 6px; }
        .f-sig-line { border-bottom: 1px solid #000; width: 150px; margin: 16px auto 2px; }
        .f-attested-line { border-bottom: 1px solid #000; width: 100%; margin: 20px 0 6px; }
        .f-sig-label { font-size: 10px; text-align: center; font-style: italic; }
    </style>
</head>
<body>

@php
    function pbox($data, $firstKey, $lastKey, $ipKey, $originKey, $title) {
        $name = trim(($data[$firstKey] ?? '') . ' ' . ($data[$lastKey] ?? ''));
        $ip = $data[$ipKey] ?? '';
        $origin = $data[$originKey] ?? '';
        return '
        <div class="person-unit">
            <div class="pbox">
                <div class="ptitle">' . e($title) . '</div>
                <div class="pname">' . e($name ?: '&nbsp;') . '</div>
                <div class="pfields">
                    <div class="pfield">IPs/ICCs: <span>' . e($ip) . '</span></div>
                    <div class="pfield">Place of Origin: <span>' . e($origin) . '</span></div>
                </div>
            </div>
        </div>';
    }

    // Wraps two person boxes into a "box = box" couple unit, matching the preview's married-pair styling.
    function coupleUnit($left, $right) {
        return '
        <table class="couple">
            <tr>
                <td style="width:47%;">' . $left . '</td>
                <td class="eq-sign">=</td>
                <td style="width:47%;">' . $right . '</td>
            </tr>
        </table>';
    }

    function twoToOneConnector() {
        return '<div class="two-to-one-connector">
            <i class="source-left"></i><i class="source-right"></i>
            <i class="join-line"></i><i class="child-line"></i>
        </div>';
    }
@endphp

<div class="form-page">

    <!-- HEADER -->
    <table class="gen-header">
        <tr>
            <td style="width:35%;">
                <div class="hdr-left-line">
                    Republic of the Philippines<br>
                    Province of <span>{{ $step3['province'] ?? '' }}</span><br>
                    Municipality of <span>{{ $step3['municipality'] ?? '' }}</span><br>
                    Barangay of <span>{{ $step3['barangay'] ?? '' }}</span>
                </div>
            </td>
            <td style="width:25%; text-align:center;">
                <div class="gen-title">GENEALOGY</div>
            </td>
            <td style="width:40%; text-align:right;">
                <div class="form-code">NCIP COC Form 2</div>
                <div class="instructions">
                    <strong><em>Instructions:</em></strong><br>
                    1. Use mother's maiden name.<br>
                    2. Complete entry in the Place of Origin (Barangay, Municipality, Province).<br>
                    3. Strictly NO ERASURES.
                </div>
            </td>
        </tr>
    </table>

    <!-- FAMILY TREE -->
    <table class="tree">
        <!-- GG ROW: 4 married couples, each "great-grandfather = great-grandmother" -->
        <tr>
            <td style="width:25%">
                {!! coupleUnit(
                    pbox($step3, 'great_grandfather_grandfather_first_name','great_grandfather_grandfather_last_name','great_grandfather_grandfather_ipgroup','great_grandfather_grandfather_origin','Great Grandfather'),
                    pbox($step3, 'great_grandmother_grandfather_first_name','great_grandmother_grandfather_last_name','great_grandmother_grandfather_ipgroup','great_grandmother_grandfather_origin','Great Grandmother')
                ) !!}
            </td>
            <td style="width:25%">
                {!! coupleUnit(
                    pbox($step3, 'great_grandfather_grandmother_first_name','great_grandfather_grandmother_last_name','great_grandfather_grandmother_ipgroup','great_grandfather_grandmother_origin','Great Grandfather'),
                    pbox($step3, 'great_grandmother_grandmother_first_name','great_grandmother_grandmother_last_name','great_grandmother_grandmother_ipgroup','great_grandmother_grandmother_origin','Great Grandmother')
                ) !!}
            </td>
            <td style="width:25%">
                {!! coupleUnit(
                    pbox($step4, 'great_grandfather_grandfather_mother_first_name','great_grandfather_grandfather_mother_last_name','great_grandfather_grandfather_mother_ipgroup','great_grandfather_grandfather_mother_origin','Great Grandfather'),
                    pbox($step4, 'great_grandmother_grandfather_mother_first_name','great_grandmother_grandfather_mother_last_name','great_grandmother_grandfather_mother_ipgroup','great_grandmother_grandfather_mother_origin','Great Grandmother')
                ) !!}
            </td>
            <td style="width:25%">
                {!! coupleUnit(
                    pbox($step4, 'great_grandfather_grandmother_mother_first_name','great_grandfather_grandmother_mother_last_name','great_grandfather_grandmother_mother_ipgroup','great_grandfather_grandmother_mother_origin','Great Grandfather'),
                    pbox($step4, 'great_grandmother_grandmother_mother_first_name','great_grandmother_grandmother_mother_last_name','great_grandmother_grandmother_mother_ipgroup','great_grandmother_grandmother_mother_origin','Great Grandmother')
                ) !!}
            </td>
        </tr>

        <!-- Each great-grandparent couple connects only to its matching grandparent. -->
        <tr>
            <td>{!! twoToOneConnector() !!}</td>
            <td>{!! twoToOneConnector() !!}</td>
            <td>{!! twoToOneConnector() !!}</td>
            <td>{!! twoToOneConnector() !!}</td>
        </tr>

        <!-- GP ROW -->
        <tr>
            <td colspan="2">
                {!! coupleUnit(
                    pbox($step3, 'paternal_grandfather_first_name','paternal_grandfather_last_name','paternal_grandfather_ipgroup','paternal_grandfather_origin','Grandfather'),
                    pbox($step3, 'paternal_grandmother_first_name','paternal_grandmother_last_name','paternal_grandmother_ipgroup','paternal_grandmother_origin','Grandmother')
                ) !!}
            </td>
            <td colspan="2">
                {!! coupleUnit(
                    pbox($step4, 'maternal_grandfather_first_name','maternal_grandfather_last_name','maternal_grandfather_ipgroup','maternal_grandfather_origin','Grandfather'),
                    pbox($step4, 'maternal_grandmother_first_name','maternal_grandmother_last_name','maternal_grandmother_ipgroup','maternal_grandmother_origin','Grandmother')
                ) !!}
            </td>
        </tr>

        <!-- Each grandparent pair connects only to its corresponding parent. -->
        <tr>
            <td colspan="2">{!! twoToOneConnector() !!}</td>
            <td colspan="2">{!! twoToOneConnector() !!}</td>
        </tr>

        <!-- PARENTS ROW (no equals sign, matches preview's par-row; width constrained like GP row) -->
        <tr>
            <td colspan="2">
                <div style="width:42%; margin:0 auto;">
                    {!! pbox($step3, 'father_first_name','father_last_name','father_ipgroup','father_origin',"Applicant's Father") !!}
                </div>
            </td>
            <td colspan="2">
                <div style="width:42%; margin:0 auto;">
                    {!! pbox($step4, 'mother_first_name','mother_last_name','mother_ipgroup','mother_origin',"Applicant's Mother") !!}
                </div>
            </td>
        </tr>

        <!-- Applicant's father and mother connect to the applicant. -->
        <tr>
            <td colspan="4">{!! twoToOneConnector() !!}</td>
        </tr>

        <!-- APPLICANT ROW -->
        <tr>
            <td colspan="4">
                <div style="width:20%; margin:0 auto;">
                    {!! pbox($step3, 'applicant_first_name','applicant_last_name','applicant_ipgroup','applicant_origin','Name of Applicant') !!}
                </div>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <table class="gen-footer">
        <tr>
            <td style="width:33%;">
                <div class="f-title">Validated by:</div>
                <div class="f-sig-line"></div>
                <div class="f-sig-label">NCIP Investigating Officer (PO/SC/CO)</div>
                <div class="f-sig-label"><em>(Signature over printed name)</em></div>
                <p style="margin-top:10px;">I hereby certify upon penalties of perjury that the information appearing above are true and correct of my personal knowledge based on authentic records.</p>
                <div class="f-sig-line"></div>
                <div class="f-sig-label">Applicant</div>
            </td>
            <td style="width:33%;">
                <p><strong>SUBSCRIBED AND SWORN</strong> to before me this ______ day of ____________, ______</p>
                <p>at ________________________, Philippines.</p>
                <p style="margin-top:8px;">
                    Doc No. ______<br>
                    Page No. ______<br>
                    Book No. ______<br>
                    Series of ______
                </p>
            </td>
            <td style="width:33%;">
                <div class="f-title">Attested by:</div>
                <div class="f-attested-line"></div>
                <p>Tribal Elder/Leader/Punong Barangay</p>
                <p class="f-sig-label" style="text-align:left;">(SIGNATURE OVER PRINTED NAME)</p>
                <p>Address: <span class="f-sig-label" style="font-style:normal;">_________________________________&nbsp;</span></p><br>
                <div class="f-sig-line" style="margin-top:20px;"></div>
                <p style="text-align:center;">Person Administering Oath</p>
                <p style="text-align:center;"><em>Not Valid Without Seal</em></p>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
