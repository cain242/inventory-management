<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zimmet Tutanağı #<?= $assignment['id'] ?></title>
    <style>
        /* ===== Genel Stil ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            background: #fff;
            padding: 40px;
            line-height: 1.6;
        }

        .document {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 48px;
        }

        /* ===== Başlık ===== */
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }
        .header .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header .document-title {
            font-size: 18px;
            font-weight: 600;
            color: #2563eb;
            margin-top: 8px;
        }
        .header .document-no {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        /* ===== Bilgi Kutuları ===== */
        .info-section {
            margin-bottom: 28px;
        }
        .info-section .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 32px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }
        .info-row .label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }
        .info-row .value {
            font-size: 13px;
            color: #1e293b;
            font-weight: 600;
        }

        /* ===== Açıklama ===== */
        .notes-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 28px;
        }
        .notes-section .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
        }
        .notes-section p {
            font-size: 13px;
            color: #334155;
        }

        /* ===== Taahhüt Metni ===== */
        .agreement {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 40px;
            font-size: 12px;
            color: #1e40af;
            line-height: 1.7;
        }

        /* ===== İmza Alanı ===== */
        .signature-area {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            margin-top: 60px;
        }
        .signature-box {
            text-align: center;
        }
        .signature-box .role {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 60px;
        }
        .signature-box .line {
            border-top: 1px solid #94a3b8;
            padding-top: 8px;
        }
        .signature-box .name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
        .signature-box .date {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }

        /* ===== Footer ===== */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }

        /* ===== Yazdır Butonu ===== */
        .print-actions {
            text-align: center;
            margin-bottom: 24px;
        }
        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 32px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .print-btn:hover {
            background: #1d4ed8;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            margin-left: 12px;
            transition: background 0.2s;
        }
        .back-btn:hover {
            background: #e2e8f0;
        }

        /* ===== Print CSS ===== */
        @media print {
            body {
                padding: 0;
                background: #fff;
            }
            .document {
                border: none;
                padding: 20px;
                max-width: 100%;
            }
            .print-actions {
                display: none !important;
            }
            nav, footer, .navbar, .btn, button:not(.no-hide) {
                display: none !important;
            }
            .header {
                border-bottom-color: #000;
            }
            .agreement {
                background: #fff;
                border-color: #000;
                color: #000;
            }
            .notes-section {
                background: #fff;
            }
        }
    </style>
</head>
<body>

    <!-- Yazdır Butonu -->
    <div class="print-actions">
        <button class="print-btn" onclick="window.print()">
            🖨️ Yazdır
        </button>
        <a href="/admin/assignments/<?= $assignment['id'] ?>" class="back-btn">
            ← Geri Dön
        </a>
    </div>

    <div class="document">

        <!-- Başlık -->
        <div class="header">
            <div class="company-name">Envanter Yönetim Sistemi</div>
            <div class="document-title">Zimmet Teslim Tutanağı</div>
            <div class="document-no">Tutanak No: ZMT-<?= str_pad($assignment['id'], 5, '0', STR_PAD_LEFT) ?> &middot; Tarih: <?= date('d.m.Y') ?></div>
        </div>

        <!-- Personel Bilgileri -->
        <div class="info-section">
            <div class="section-title">Teslim Alan — Personel Bilgileri</div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="label">Ad Soyad</span>
                    <span class="value"><?= esc($assignment['staff_name'] ?? 'Bilinmiyor') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Zimmet Tarihi</span>
                    <span class="value"><?= $assignment['assigned_at'] ? date('d.m.Y H:i', strtotime($assignment['assigned_at'])) : '—' ?></span>
                </div>
            </div>
        </div>

        <!-- Cihaz Bilgileri -->
        <div class="info-section">
            <div class="section-title">Teslim Edilen Cihaz Bilgileri</div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="label">Cihaz Adı</span>
                    <span class="value"><?= esc($assignment['inventory_name'] ?? '—') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Marka</span>
                    <span class="value"><?= esc($assignment['brand'] ?? '—') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Seri No</span>
                    <span class="value"><?= esc($assignment['serial_no'] ?? '—') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Talep No</span>
                    <span class="value">#<?= $assignment['request_id'] ?? '—' ?></span>
                </div>
            </div>
        </div>

        <!-- Notlar -->
        <?php if (!empty($assignment['notes'])): ?>
        <div class="notes-section">
            <div class="section-title">Notlar</div>
            <p><?= esc($assignment['notes']) ?></p>
        </div>
        <?php endif ?>

        <!-- Taahhüt Metni -->
        <div class="agreement">
            İşbu tutanak ile yukarıda bilgileri yazılı cihaz/ekipman, belirtilen personele zimmetlenmiştir.
            Personel, kendisine teslim edilen cihazı özenle kullanmayı, herhangi bir arıza veya kayıp
            durumunda derhal bilgi vermeyi ve görev sonunda eksiksiz olarak iade etmeyi taahhüt eder.
        </div>

        <!-- İmza Alanı -->
        <div class="signature-area">
            <div class="signature-box">
                <div class="role">Teslim Eden (Yönetici)</div>
                <div class="line">
                    <div class="name"><?= esc($assignment['approver_name'] ?? '________________') ?></div>
                    <div class="date">Tarih: <?= $assignment['assigned_at'] ? date('d.m.Y', strtotime($assignment['assigned_at'])) : '__.__.____' ?></div>
                </div>
            </div>
            <div class="signature-box">
                <div class="role">Teslim Alan (Personel)</div>
                <div class="line">
                    <div class="name"><?= esc($assignment['staff_name'] ?? '________________') ?></div>
                    <div class="date">Tarih: <?= $assignment['assigned_at'] ? date('d.m.Y', strtotime($assignment['assigned_at'])) : '__.__.____' ?></div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Bu belge Envanter Yönetim Sistemi tarafından otomatik olarak oluşturulmuştur. &middot;
            Oluşturulma: <?= date('d.m.Y H:i') ?>
        </div>

    </div>

</body>
</html>
