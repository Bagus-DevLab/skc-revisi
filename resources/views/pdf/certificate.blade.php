<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; text-align: center; padding: 50px; border: 15px solid #2563eb; }
        .title { font-size: 50px; font-weight: bold; color: #1e40af; margin-bottom: 20px; }
        .subtitle { font-size: 20px; color: #6b7280; }
        .name { font-size: 35px; font-weight: bold; margin: 30px 0; border-bottom: 2px solid #000; display: inline-block; padding: 0 50px; }
        .course { font-size: 24px; color: #1f2937; margin-bottom: 50px; }
        .footer { margin-top: 50px; font-size: 14px; color: #9ca3af; }
        .signature { margin-top: 40px; font-weight: bold; font-size: 18px; }
    </style>
</head>
<body>
    <div class="subtitle">SERTIFIKAT KELULUSAN</div>
    <div class="title">SkillConnect.id</div>
    
    <p class="subtitle">Diberikan dengan bangga kepada:</p>
    <div class="name">{{ $name }}</div>
    
    <p class="subtitle">Telah menyelesaikan kursus online:</p>
    <div class="course">"{{ $course_title }}"</div>
    
    <div class="signature">
        <p>Direktur SkillConnect</p>
        <br><br>
        <p>( Sandhika Galih )</p>
    </div>

    <div class="footer">
        ID Sertifikat: {{ $cert_id }} | Diterbitkan pada: {{ $date }}
    </div>
</body>
</html>