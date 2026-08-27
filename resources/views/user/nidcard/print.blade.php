@extends('user.layouts.app')

@section('title', 'Smart NID Card - ' . $englishName)

@section('content')

    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-header nid-card-header">
            <div class="nid-header-inner">
                <div class="nid-header-icon">🪪</div>
                <div>
                    <h4 class="nid-title">Smart National ID Card</h4>
                    <p class="nid-subtitle">Bangladesh Election Commission</p>
                </div>
            </div>
            <a href="{{ route('user.nid-card.index') }}" class="nid-back-btn">
                ← Back to List
            </a>
        </div>

        <div class="card-body nid-card-body">

            {{-- NID Card Preview --}}
            <div class="nid-preview-wrapper">
                <div class="nid-scale-container">
                    <div id="__next" data-reactroot="" style="width: 800px">
                        <div class="flex" style="padding-left:70px;padding-right:70px;">

                            {{-- FRONT SIDE --}}
                            <div id="front_side" class="id_side" style="display: inline-block;">
                                <div id="font_text" class="absolute">
                                    <div class="nameBan title font_family">নাম</div>
                                    <div class="nameBan main_text font_family">{{ $banglaName }}</div>
                                    <div class="nameEn title">Name</div>
                                    <div class="nameEn main_text">{{ $englishName }}</div>
                                    <div class="fatherName title font_family">পিতা</div>
                                    <div class="fatherName main_text font_family">{{ $fatherName }}</div>
                                    <div class="motherName title font_family">মাতা</div>
                                    <div class="motherName main_text font_family">{{ $motherName }}</div>
                                    <div class="dateOfBirth">
                                        <div class="date_title en_title">Date Of Birth</div>
                                        <div class="date_number en_title">{{ $formattedDob }}</div>
                                    </div>
                                    <div class="nid">
                                        <div class="nid_title en_title">NID No.</div>
                                        <div class="nid_number en_title">{{ $formattedNid }}</div>
                                    </div>
                                </div>
                                <img class="test_img" src="{{ asset('assets/smart_card/test.svg') }}" alt="">
                                <div id="user_img">
                                    <img class="user_img" src="{{ asset($photoBase64) }}" alt="User Photo">
                                    <div class="overflow_dob">
                                        {{ !empty($dateOfBirth) ? \Carbon\Carbon::parse($dateOfBirth)->format('d/m/Y') : '' }}
                                    </div>
                                </div>
                                <div id="sing_img_div">
                                    <img id="sign_img" class="sign_img" src="{{ asset($signatureBase64) }}" alt="Signature">
                                </div>
                                <div id="front_img">
                                    <img id="overflow_img" src="{{ asset('assets/smart_card/overflow.svg') }}" alt="">
                                    <img class="side_img" src="{{ asset('assets/smart_card/fronts.svg') }}" alt="">
                                </div>
                            </div>

                            {{-- BACK SIDE --}}
                            <div id="back_side" class="id_side" style="display: inline-block;">
                                <img id="user_img_two" class="user_img" src="{{ asset($photoBase64) }}" alt="User Photo">
                                <div id="back_img">
                                    <img class="side_img" src="{{ asset('assets/smart_card/back.svg') }}" alt="">
                                    <img class="overflow_back" src="{{ asset('assets/smart_card/overflow_back.svg') }}" alt="">
                                    <div class="address" style="font-size: 10px!important; line-height: 10px;">{{ $address }}</div>

                                    <div class="back_text_one">
                                    <span class="fist_line_one back_line_one" style="top: 2.5px!important">
                                        Blood Group:
                                        <span class="result_one bloodGroup">
                                            {{ ($bloodGroup && $bloodGroup !== 'N/A') ? $bloodGroup : ' ' }}
                                        </span>
                                    </span>
                                        <span class="second_line_one back_line_one">
                                        Place of Birth:
                                        <span class="result_one place_of_birth">
                                            {{ ($birthPlaceEn && $birthPlaceEn !== 'N/A') ? strtoupper($birthPlaceEn) : ' ' }}
                                        </span>
                                    </span>
                                        <span class="third_line_one back_line_one">
                                        Issue Date:
                                        <span class="result_one date_of_issue">
                                            {{ ($issueDate && $issueDate !== 'N/A') ? $issueDate : ' ' }}
                                        </span>
                                    </span>
                                    </div>

                                    <div class="back_text">
                                        <div class="first_line back_line">
                                            @php
                                                $line1 = ['I','B','G','D','5','5','0','1','6','7','8','7','7'];
                                                $icons = array_fill(0, 13, 'icon');
                                            @endphp
                                            <div class="f_line_icon">I</div>
                                            <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/></div>
                                            <div class="f_line_icon">B</div>
                                            <div class="f_line_icon">G</div>
                                            <div class="f_line_icon">D</div>
                                            <div class="f_line_icon">5</div>
                                            <div class="f_line_icon">5</div>
                                            <div class="f_line_icon">0</div>
                                            <div class="f_line_icon">1</div>
                                            <div class="f_line_icon">6</div>
                                            <div class="f_line_icon">7</div>
                                            <div class="f_line_icon">8</div>
                                            <div class="f_line_icon">7</div>
                                            <div class="f_line_icon">7</div>
                                            <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/></div>
                                            <div class="f_line_icon">4</div>
                                            <div class="f_line_icon">2</div>
                                            @for($i = 0; $i < 13; $i++)
                                                <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/></div>
                                            @endfor
                                        </div>

                                        <div class="second_line back_line">
                                            @foreach(['3','2','3','1','5','9','3','F','4','6','5','4','4','4','5','B','G','D'] as $char)
                                                <div class="f_line_icon">{{ $char }}</div>
                                            @endforeach
                                            @for($i = 0; $i < 11; $i++)
                                                <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/></div>
                                            @endfor
                                            <div class="f_line_icon">7</div>
                                        </div>

                                        <div class="third_line back_line">
                                            @php
                                                $name = strtoupper($englishName);
                                                $name_parts = explode(' ', $name);
                                                if (count($name_parts) > 1) {
                                                    $formatted_name = end($name_parts) . '<' . $name_parts[0];
                                                } else {
                                                    $formatted_name = $name_parts[0] . '<';
                                                }
                                                $max_length = 30;
                                                $padding_needed = $max_length - strlen($formatted_name);
                                                if ($padding_needed > 0) {
                                                    $formatted_name .= str_repeat('<', $padding_needed);
                                                }
                                            @endphp
                                            @for($i = 0; $i < strlen($formatted_name); $i++)
                                                @php $char = $formatted_name[$i]; @endphp
                                                @if($char === '<')
                                                    <div class="f_line_icon for_last"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/></div>
                                                @elseif($char === 'I')
                                                    <div class="f_line_icon for_last i_letters">{{ $char }}</div>
                                                @else
                                                    <div class="f_line_icon for_last">{{ $char }}</div>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    <div style="position: absolute; top: 13px; left: 20px; transform: rotate(180deg); width: 290px; height: 38px">
                                        <canvas id="barcode"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Panel --}}
            <div class="nid-info-panel">
                <div class="nid-info-grid">
                    <div class="nid-info-item">
                        <span class="nid-info-label">Full Name (EN)</span>
                        <span class="nid-info-value">{{ $englishName }}</span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">Full Name (BN)</span>
                        <span class="nid-info-value">{{ $banglaName }}</span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">NID Number</span>
                        <span class="nid-info-value nid-badge">{{ $formattedNid }}</span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">Date of Birth</span>
                        <span class="nid-info-value">{{ $formattedDob }}</span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">Father's Name</span>
                        <span class="nid-info-value">{{ $fatherName }}</span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">Mother's Name</span>
                        <span class="nid-info-value">{{ $motherName }}</span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">Blood Group</span>
                        <span class="nid-info-value">
                        @if($bloodGroup && $bloodGroup !== 'N/A')
                                <span class="blood-badge">{{ $bloodGroup }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                    </span>
                    </div>
                    <div class="nid-info-item">
                        <span class="nid-info-label">Issue Date</span>
                        <span class="nid-info-value">{{ $issueDate !== 'N/A' ? $issueDate : '—' }}</span>
                    </div>
                    <div class="nid-info-item nid-info-full">
                        <span class="nid-info-label">Address</span>
                        <span class="nid-info-value">{{ $address }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="nid-actions">
                <button onclick="window.print()" class="nid-btn nid-btn-primary">
                    🖨️ Print Card
                </button>
                <a href="{{ route('user.smartcard.edit', $smartCard->id) }}" class="nid-btn nid-btn-secondary">
                    ✏️ Edit Card
                </a>
                <a href="{{ route('user.nid-card.index') }}" class="nid-btn nid-btn-outline">
                    ← Back to List
                </a>
            </div>

        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/smart_card/nid_css.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/smart_card/e521caf613e4ad87.css') }}">
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600&family=Roboto+Mono:wght@400;700&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* ── Font Faces ─────────────────────────────────────────── */
        @font-face {
            font-family: 'Cambria Math';
            src: url("{{ asset('assets/smart_card/cambria-math.woff') }}") format('woff');
        }
        @font-face {
            font-family: 'TonnyBanglaMJ';
            src: url('{{ asset('assets/smart_card/TonnyBanglaMJ-Bold.woff') }}') format('woff');
            font-weight: bold;
        }
        @font-face {
            font-family: 'TonnyBanglaMJ';
            src: url('{{ asset('assets/smart_card/TonnyBanglaMJ-Regular.woff') }}') format('woff');
            font-weight: normal;
        }

        /* ── Card Header ─────────────────────────────────────────── */
        .nid-card-header {
            background: linear-gradient(135deg, #1a3a6b 0%, #2d6a2d 100%);
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: none;
        }
        .nid-header-inner {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .nid-header-icon { font-size: 2rem; }
        .nid-title {
            color: #fff;
            font-family: 'Roboto Slab', serif;
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: .3px;
        }
        .nid-subtitle {
            color: rgba(255,255,255,.7);
            font-size: .78rem;
            margin: 2px 0 0;
            letter-spacing: .5px;
        }
        .nid-back-btn {
            color: rgba(255,255,255,.85);
            font-size: .82rem;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.3);
            padding: 6px 14px;
            border-radius: 6px;
            transition: all .2s;
        }
        .nid-back-btn:hover {
            background: rgba(255,255,255,.15);
            color: #fff;
            text-decoration: none;
        }

        /* ── Card Body ───────────────────────────────────────────── */
        .nid-card-body {
            background: #f0f4f8;
            padding: 2rem 1.75rem;
        }

        /* ── NID Preview Wrapper ─────────────────────────────────── */
        .nid-preview-wrapper {
            background: linear-gradient(160deg, #1a3a6b 0%, #0f2340 100%);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(26,58,107,.35);
            margin-bottom: 2rem;
            position: relative;
        }
        .nid-preview-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(255,255,255,.06) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 20%, rgba(45,106,45,.15) 0%, transparent 50%);
            pointer-events: none;
        }
        .nid-scale-container {
            transform: scale(0.62);
            transform-origin: center center;
            display: block;
            width: 800px;
            position: relative;
            z-index: 1;
        }

        /* ── NID card existing styles ────────────────────────────── */
        .f_line_icon,
        .f_line_icon.for_last {
            font-family: "Roboto Mono", serif;
        }
        .f_line_icon { transform: scaleY(1.1); }

        span.result_one.bloodGroup {
            position: fixed;
            width: 100%;
            top: -1.5px;
            left: 37px;
        }
        .title.font_family {
            font-size: 8.5px;
            font-weight: bold;
            transform: scale(1, 1.05);
        }
        .nameBan.main_text.font_family {
            margin-bottom: 3px;
            text-shadow: 0 0 black;
            font-weight: bold;
        }
        .main_text.font_family {
            font-size: 10.5px;
            line-height: 10px;
            transform: scale(1, 1.05);
            font-family: 'SolaimanLipi', sans-serif;
        }
        .nameEn.title {
            font-size: 6.5px;
            font-family: arial;
            font-weight: 600;
            line-height: 8px;
            transform: scale(1, 1.1);
        }
        .nameEn.main_text {
            font-size: 7.8px;
            font-weight: 600;
            line-height: 15px;
            transform: scale(1, 1.1);
        }
        .fatherName.title.font_family { line-height: 5px; margin-top: 2px; }
        .fatherName.main_text.font_family { line-height: 18px; }
        .motherName.title.font_family { line-height: 1px; margin-top: 3px; }
        .motherName.main_text.font_family { line-height: 22px; }
        .dateOfBirth { margin-top: 0px; }
        .nid { line-height: 6px; margin-top: -10px; }
        #overflow_img { left: 1.7px; }
        canvas { width: 100%; height: 100%; }

        /* ── Info Panel ──────────────────────────────────────────── */
        .nid-info-panel {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            border: 1px solid #e2e8f0;
        }
        .nid-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem 1.5rem;
        }
        .nid-info-full { grid-column: 1 / -1; }
        .nid-info-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .nid-info-label {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #7a8fa6;
        }
        .nid-info-value {
            font-size: .92rem;
            font-weight: 600;
            color: #1e2d3d;
            font-family: 'Noto Sans', sans-serif;
        }
        .nid-badge {
            font-family: 'Roboto Mono', monospace;
            background: #eef2ff;
            color: #3d5af1;
            padding: 2px 8px;
            border-radius: 5px;
            font-size: .85rem;
            display: inline-block;
        }
        .blood-badge {
            background: #fff0f0;
            color: #c0392b;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: .85rem;
            border: 1px solid #f5c6cb;
        }

        /* ── Action Buttons ──────────────────────────────────────── */
        .nid-actions {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
        }
        .nid-btn {
            padding: 9px 20px;
            border-radius: 8px;
            font-size: .88rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: .2px;
        }
        .nid-btn-primary {
            background: linear-gradient(135deg, #1a3a6b, #2d6a2d);
            color: #fff;
            box-shadow: 0 3px 10px rgba(26,58,107,.3);
        }
        .nid-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(26,58,107,.4); }
        .nid-btn-secondary {
            background: #f59e0b;
            color: #fff;
            box-shadow: 0 3px 10px rgba(245,158,11,.25);
        }
        .nid-btn-secondary:hover { background: #d97706; color: #fff; text-decoration: none; transform: translateY(-1px); }
        .nid-btn-outline {
            background: #fff;
            color: #4a5568;
            border: 1.5px solid #cbd5e0;
        }
        .nid-btn-outline:hover { background: #f7fafc; color: #2d3748; text-decoration: none; }

        /* ── Print ───────────────────────────────────────────────── */
        @media print {
            .nid-card-header,
            .nid-info-panel,
            .nid-actions,
            .nid-back-btn { display: none !important; }
            .nid-preview-wrapper {
                background: white !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            .nid-scale-container { transform: scale(1) !important; }
            .card, .card-custom { box-shadow: none !important; margin: 0 !important; }
            .nid-card-body { background: white !important; padding: 0 !important; }
            @page { size: letter; margin: 0; }
        }

        /* ── Responsive ──────────────────────────────────────────── */
        @media (max-width: 768px) {
            .nid-scale-container { transform: scale(0.36); width: 800px; }
            .nid-preview-wrapper { padding: 1rem .5rem; min-height: 200px; }
            .nid-card-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .nid-actions { flex-direction: column; }
            .nid-btn { justify-content: center; }
        }
        @media (max-width: 480px) {
            .nid-scale-container { transform: scale(0.28); }
            .nid-preview-wrapper { min-height: 160px; }
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/smart_card/bwip-js-min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hub3_code = `<pin>{{ $pin }}</pin><n>{{ str_replace(' ', '+', strtoupper($englishName)) }}</n><DOB>{{ !empty($dateOfBirth) ? \Carbon\Carbon::parse($dateOfBirth)->format('Y-m-d') : '' }}</DOB><FP></FP><F>Right Index</F><TYPE></TYPE><V>2.0</V><ds>302d02150094b24c767848fa594a7fd2e53345eac2747180d8421bf6d7d00b287472b18c0631e2a85aadd76f759188</ds>`;

            const canvas = document.getElementById('barcode');
            if (!canvas) return;

            canvas.width  = 300;
            canvas.height = 60;

            try {
                bwipjs.toCanvas(canvas, {
                    bcid:         'pdf417',
                    text:         hub3_code,
                    scale:        2,
                    columns:      13,
                    eclevel:      5,
                    rowheight:    4,
                    paddingwidth:  0,
                    paddingheight: 0,
                    includetext:  false
                });
            } catch (e) {
                console.error('Barcode error:', e);
            }
        });
    </script>
@endpush