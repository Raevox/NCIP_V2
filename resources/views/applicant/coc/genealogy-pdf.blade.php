<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 8px; color: #000; }

        .form-page { width: 100%; padding: 10px; }

        .gen-header {
            width: 100%;
            margin-bottom: 10px;
        }
        .gen-header td { vertical-align: top; }
        .gen-title {
            border: 2px solid #000;
            padding: 6px 14px;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
        }
        .form-code {
            border: 1px solid #000;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 4px;
        }
        .hdr-left-line { line-height: 1.9; font-size: 9px; }
        .hdr-left-line span {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 110px;
        }
        .instructions { font-size: 7.5px; line-height: 1.5; text-align: right; }

        table.tree { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.tree td { text-align: center; vertical-align: top; padding: 0; }

        .pbox {
            border: 1px solid #000;
            padding: 3px;
            font-size: 7px;
            text-align: center;
            margin: 0 2px;
        }
        .pbox .ptitle { font-weight: bold; font-size: 6.5px; }
        .pbox .pname {
            border-bottom: 1px solid #777;
            min-height: 10px;
            font-size: 7px;
            margin-top: 2px;
            padding-bottom: 1px;
        }
        .pbox .pfield {
            text-align: left;
            font-size: 6.5px;
            margin-top: 2px;
        }
        .pbox .pfield span {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 60%;
        }

        .connector-h { padding-top: 4px; }
        .connector-h .line {
            border-top: 1px solid #000;
            width: 50%;
            margin: 0 auto;
            height: 1px;
        }
        .connector-v .tick {
            border-left: 1px solid #000;
            width: 1px;
            height: 10px;
            margin: 0 auto;
        }

        .gen-footer { width: 100%; margin-top: 16px; border-top: 1px solid #ccc; padding-top: 8px; }
        .gen-footer td { vertical-align: top; font-size: 7.5px; padding: 0 6px; }
        .f-title { font-weight: bold; font-size: 8px; margin-bottom: 6px; }
        .f-sig-line { border-bottom: 1px solid #000; width: 150px; margin: 16px auto 2px; }
        .f-sig-label { font-size: 6.5px; text-align: center; font-style: italic; }
    </style>
</head>
<body>

@php
    function pbox($data, $firstKey, $lastKey, $ipKey, $originKey, $title) {
        $name = trim(($data[$firstKey] ?? '') . ' ' . ($data[$lastKey] ?? ''));
        $ip = $data[$ipKey] ?? '';
        $origin = $data[$originKey] ?? '';
        return '
        <div class="pbox">
            <div class="ptitle">' . e($title) . '</div>
            <div class="pname">' . e($name ?: '&nbsp;') . '</div>
            <div class="pfield">IPs/ICCs: <span>' . e($ip) . '</span></div>
            <div class="pfield">Origin: <span>' . e($origin) . '</span></div>
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
        <!-- GG ROW -->
        <tr>
            <td style="width:12.5%">{!! pbox($step3, 'great_grandfather_grandfather_first_name','great_grandfather_grandfather_last_name','great_grandfather_grandfather_ipgroup','great_grandfather_grandfather_origin','Great Grandfather') !!}</td>
            <td style="width:12.5%">{!! pbox($step3, 'great_grandmother_grandfather_first_name','great_grandmother_grandfather_last_name','great_grandmother_grandfather_ipgroup','great_grandmother_grandfather_origin','Great Grandmother') !!}</td>
            <td style="width:12.5%">{!! pbox($step3, 'great_grandfather_grandmother_first_name','great_grandfather_grandmother_last_name','great_grandfather_grandmother_ipgroup','great_grandfather_grandmother_origin','Great Grandfather') !!}</td>
            <td style="width:12.5%">{!! pbox($step3, 'great_grandmother_grandmother_first_name','great_grandmother_grandmother_last_name','great_grandmother_grandmother_ipgroup','great_grandmother_grandmother_origin','Great Grandmother') !!}</td>
            <td style="width:12.5%">{!! pbox($step4, 'great_grandfather_grandfather_mother_first_name','great_grandfather_grandfather_mother_last_name','great_grandfather_grandfather_mother_ipgroup','great_grandfather_grandfather_mother_origin','Great Grandfather') !!}</td>
            <td style="width:12.5%">{!! pbox($step4, 'great_grandmother_grandfather_mother_first_name','great_grandmother_grandfather_mother_last_name','great_grandmother_grandfather_mother_ipgroup','great_grandmother_grandfather_mother_origin','Great Grandmother') !!}</td>
            <td style="width:12.5%">{!! pbox($step4, 'great_grandfather_grandmother_mother_first_name','great_grandfather_grandmother_mother_last_name','great_grandfather_grandmother_mother_ipgroup','great_grandfather_grandmother_mother_origin','Great Grandfather') !!}</td>
            <td style="width:12.5%">{!! pbox($step4, 'great_grandmother_grandmother_mother_first_name','great_grandmother_grandmother_mother_last_name','great_grandmother_grandmother_mother_ipgroup','great_grandmother_grandmother_mother_origin','Great Grandmother') !!}</td>
        </tr>

        <!-- CONNECTOR: GG -> GP -->
        <tr class="connector-h">
            <td colspan="2"><div class="line"></div></td>
            <td colspan="2"><div class="line"></div></td>
            <td colspan="2"><div class="line"></div></td>
            <td colspan="2"><div class="line"></div></td>
        </tr>
        <tr class="connector-v">
            <td colspan="2"><div class="tick"></div></td>
            <td colspan="2"><div class="tick"></div></td>
            <td colspan="2"><div class="tick"></div></td>
            <td colspan="2"><div class="tick"></div></td>
        </tr>

        <!-- GP ROW -->
        <tr>
            <td colspan="2">{!! pbox($step3, 'paternal_grandfather_first_name','paternal_grandfather_last_name','paternal_grandfather_ipgroup','paternal_grandfather_origin','Grandfather') !!}</td>
            <td colspan="2">{!! pbox($step3, 'paternal_grandmother_first_name','paternal_grandmother_last_name','paternal_grandmother_ipgroup','paternal_grandmother_origin','Grandmother') !!}</td>
            <td colspan="2">{!! pbox($step4, 'maternal_grandfather_first_name','maternal_grandfather_last_name','maternal_grandfather_ipgroup','maternal_grandfather_origin','Grandfather') !!}</td>
            <td colspan="2">{!! pbox($step4, 'maternal_grandmother_first_name','maternal_grandmother_last_name','maternal_grandmother_ipgroup','maternal_grandmother_origin','Grandmother') !!}</td>
        </tr>

        <!-- CONNECTOR: GP -> Parents -->
        <tr class="connector-h">
            <td colspan="4"><div class="line"></div></td>
            <td colspan="4"><div class="line"></div></td>
        </tr>
        <tr class="connector-v">
            <td colspan="4"><div class="tick"></div></td>
            <td colspan="4"><div class="tick"></div></td>
        </tr>

        <!-- PARENTS ROW -->
        <tr>
            <td colspan="4">{!! pbox($step3, 'father_first_name','father_last_name','father_ipgroup','father_origin',"Applicant's Father") !!}</td>
            <td colspan="4">{!! pbox($step4, 'mother_first_name','mother_last_name','mother_ipgroup','mother_origin',"Applicant's Mother") !!}</td>
        </tr>

        <!-- CONNECTOR: Parents -> Applicant -->
        <tr class="connector-h">
            <td colspan="8"><div class="line"></div></td>
        </tr>
        <tr class="connector-v">
            <td colspan="8"><div class="tick"></div></td>
        </tr>

        <!-- APPLICANT ROW -->
        <tr>
            <td colspan="8" style="width:25%; margin:0 auto;">
                <div style="width:25%; margin:0 auto;">
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
                <p>Tribal Elder/Leader/Punong Barangay</p>
                <div class="f-sig-line"></div>
                <p>Address: Council of Elders/IP Leader/Punong Barangay</p>
                <div class="f-sig-line" style="margin-top:20px;"></div>
                <p style="text-align:center;">Person Administering Oath</p>
                <p style="text-align:center;"><em>Not Valid Without Seal</em></p>
            </td>
        </tr>
    </table>

</div>
</body>
</html>