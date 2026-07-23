<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Confirmation</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; }
        .certificate { border: 2px solid #000; padding: 40px; max-width: 800px; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header strong { display: block; }
        .title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin: 25px 0; }
        .content { text-align: justify; }
        .center { text-align: center; margin: 20px 0; }
        .signature { margin-top: 40px; font-size: 12px; }
    </style>
</head>
<body>
<div class="certificate">
    <div class="header">
        <div><strong>COC-R03-NUE-{{ date('m-d-Y', strtotime($record->census_date)) }}-{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
        <div>
            Republic of the Philippines <br>
            Office of the President <br>
            <strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong> <br>
            <strong>NUEVA ECIJA PROVINCIAL OFFICE</strong> <br>
            Burgos Ave., Old Capitol Bldg., Cabanatuan City, Nueva Ecija <br>
            Tel. No. 044-950-0088
        </div>
    </div>

    <div style="text-align: right; margin-bottom: 20px;">
        <strong>CONFIRMED:</strong><br>
        DONATO B. BUMACAS, PhD.<br>
        DMO V/Provincial Officer<br>
        <em>NOT VALID WITHOUT SEAL</em>
    </div>

    <div class="title">CERTIFICATE OF CONFIRMATION</div>

    <div class="content">
        <p><strong>BE IT KNOWN</strong></p>
        <p class="center">
            that<br><br>
            <strong style="font-size: 16px; text-decoration: underline;">
                {{ strtoupper($record->first_name . ' ' . $record->last_name) }}
            </strong>
        </p>

        <p>
            Is a Bonafide member of the <strong>{{ strtoupper($record->ip_group) }}</strong> Indigenous Cultural Communities
            as certified by their IP Leader <strong>DOMINADOR A. CEPIAN</strong> of Barangay {{ $record->barangay }},
            {{ $record->municipality }}, {{ $record->province }}.
        </p>

        <p>
            That this Office hereby presents and confirms the membership of {{ $record->sex == 'Male' ? 'Mr.' : 'Ms.' }}
            {{ $record->last_name }} with the <strong>{{ strtoupper($record->ip_group) }}</strong> IP/ICC and is entitled
            to all rights, benefits, and privileges under RA 8371 and related laws.
        </p>

        <p>
            Issued this <strong>{{ date('jS') }}</strong> day of <strong>{{ date('F Y', strtotime($record->census_date)) }}</strong>,
            upon request of {{ $record->sex == 'Male' ? 'Mr.' : 'Ms.' }} {{ $record->last_name }} for identification of
            ETHNICITY/IP group membership.
        </p>
    </div>

    <div class="signature">
        Recommending Confirmation:<br><br>
        <strong>ENGR. JONELYN D. BANG-OT</strong><br>
        OIC-Administrative Officer IV as per Memo Order no. R3-{{ date('Y') }}-07-294
    </div>
</div>
</body>
</html>
