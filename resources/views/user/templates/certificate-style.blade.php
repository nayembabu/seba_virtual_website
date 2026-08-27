<style>
    @font-face {
        font-family: LCALLIG;
        src: url("{{ url('assets/old-birth') }}/font/lucidacalligraphyitalic.ttf");
    }
    @font-face {
        font-family: MAHFUJ;
        src: url("{{ url('assets/old-birth') }}/font/Mahfuj-Signature.ttf");
    }
    @font-face {
        font-family: SOLAIMANLIPI;
        src: url("{{ url('assets/old-birth') }}/font/SolaimanLipi_22-02-2012.ttf");
    }
    @font-face {
        font-family: BANGLA;
        src: url("{{ url('assets/old-birth') }}/font/Bangla.ttf");
    }
    @font-face {
        font-family: NIKOSH;
        src: url("{{ url('assets/old-birth') }}/font/Nikosh.ttf");
    }

    *,
    ::before,
    ::after {
        box-sizing: border-box; /* 1 */
        border-width: 0; /* 2 */
        border-style: solid; /* 2 */
        border-color: #e5e7eb; /* 2 */
    }

    ::before,
    ::after {
        --tw-content: "";
    }

    html {
        line-height: 1.5; /* 1 */
        -webkit-text-size-adjust: 100%; /* 2 */ /* 3 */
        tab-size: 4; /* 3 */
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; /* 4 */
        font-feature-settings: normal; /* 5 */
        font-variation-settings: normal; /* 6 */
    }

    body {
        margin: 0; /* 1 */
        line-height: inherit; /* 2 */
    }

    hr {
        height: 0; /* 1 */
        color: inherit; /* 2 */
        border-top-width: 1px; /* 3 */
    }

    abbr:where([title]) {
        -webkit-text-decoration: underline dotted;
        text-decoration: underline dotted;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-size: inherit;
        font-weight: inherit;
    }

    a {
        color: inherit;
        text-decoration: inherit;
    }

    b,
    strong {
        font-weight: bolder;
    }

    code,
    kbd,
    samp,
    pre {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; /* 1 */
        font-size: 1em; /* 2 */
    }

    small {
        font-size: 80%;
    }

    sub,
    sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
    }

    sub {
        bottom: -0.25em;
    }

    sup {
        top: -0.5em;
    }

    table {
        text-indent: 0; /* 1 */
        border-color: inherit; /* 2 */
        border-collapse: collapse; /* 3 */
    }

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit; /* 1 */
        font-size: 100%; /* 1 */
        font-weight: inherit; /* 1 */
        line-height: inherit; /* 1 */
        color: inherit; /* 1 */
        margin: 0; /* 2 */
        padding: 0; /* 3 */
    }

    /*
    Remove the inheritance of text transform in Edge and Firefox.
    */

    button,
    select {
        text-transform: none;
    }

    /*
    1. Correct the inability to style clickable types in iOS and Safari.
    2. Remove default button styles.
    */

    button,
    [type="button"],
    [type="reset"],
    [type="submit"] {
        -webkit-appearance: button; /* 1 */
        background-color: transparent; /* 2 */
        background-image: none; /* 2 */
    }

    :-moz-focusring {
        outline: auto;
    }

    :-moz-ui-invalid {
        box-shadow: none;
    }

    progress {
        vertical-align: baseline;
    }

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
        height: auto;
    }

    [type="search"] {
        -webkit-appearance: textfield; /* 1 */
        outline-offset: -2px; /* 2 */
    }

    ::-webkit-search-decoration {
        -webkit-appearance: none;
    }

    ::-webkit-file-upload-button {
        -webkit-appearance: button; /* 1 */
        font: inherit; /* 2 */
    }

    summary {
        display: list-item;
    }
    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
        margin: 0;
    }

    fieldset {
        margin: 0;
        padding: 0;
    }

    legend {
        padding: 0;
    }

    ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    textarea {
        resize: vertical;
    }
    input::placeholder,
    textarea::placeholder {
        opacity: 1; /* 1 */
        color: #9ca3af; /* 2 */
    }

    button,
    [role="button"] {
        cursor: pointer;
    }

    :disabled {
        cursor: default;
    }
    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block; /* 1 */
        vertical-align: middle; /* 2 */
    }
    img,
    video {
        max-width: 100%;
        height: auto;
    }

    [hidden] {
        display: none;
    }

    *,
    ::before,
    ::after {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
    }

    ::backdrop {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
    }
    .__input {
        height: 2.5rem;
        width: 100%;
        border-radius: 0.375rem;
        border-width: 1px;
        --tw-border-opacity: 1;
        border-color: rgb(229 231 235 / var(--tw-border-opacity));
        --tw-bg-opacity: 1;
        background-color: rgb(243 244 246 / var(--tw-bg-opacity));
        padding: 0.25rem;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        font-weight: 700 !important;
        outline: 2px solid transparent;
        outline-offset: 2px;
    }
    .__FromInput {
        width: 100%;
        border-radius: 0.375rem;
        border-width: 1px;
        --tw-border-opacity: 1;
        border-color: rgb(229 231 235 / var(--tw-border-opacity));
        --tw-bg-opacity: 1;
        background-color: rgb(243 244 246 / var(--tw-bg-opacity));
        padding-top: 1rem;
        padding-bottom: 1rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        font-weight: 700;
        outline: 2px solid transparent;
        outline-offset: 2px;
    }
    .__lable {
        font-weight: 700;
        text-transform: capitalize;
    }
    .__btn {
        cursor: pointer;
        border-radius: 0.375rem;
        --tw-bg-opacity: 1;
        background-color: rgb(126 34 206 / var(--tw-bg-opacity));
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        padding-left: 2rem;
        padding-right: 2rem;
        font-weight: 500;
        text-transform: capitalize;
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }
    .__btn:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(107 33 168 / var(--tw-bg-opacity));
    }
    .invisible {
        visibility: hidden;
    }
    .absolute {
        position: absolute;
    }
    .relative {
        position: relative;
    }
    .sticky {
        position: sticky;
    }
    .left-0 {
        left: 0px;
    }
    .right-0 {
        right: 0px;
    }
    .right-2 {
        right: 0.5rem;
    }
    .top-0 {
        top: 0px;
    }
    .top-2 {
        top: 0.5rem;
    }
    .top-\[45px\] {
        top: 45px;
    }
    .z-0 {
        z-index: 0;
    }
    .z-50 {
        z-index: 50;
    }
    .z-\[999\] {
        z-index: 999;
    }
    .mx-\[2px\] {
        margin-left: 2px;
        margin-right: 2px;
    }
    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }
    .my-10 {
        margin-top: 2.5rem;
        margin-bottom: 2.5rem;
    }
    .my-2 {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .my-20 {
        margin-top: 5rem;
        margin-bottom: 5rem;
    }
    .my-4 {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .mb-1 {
        margin-bottom: 0.25rem;
    }
    .mb-5 {
        margin-bottom: 1.25rem;
    }
    .ml-3 {
        margin-left: 0.75rem;
    }
    .mr-\[22px\] {
        margin-right: 22px;
    }
    .mr-\[62px\] {
        margin-right: 62px;
    }
    .mt-1 {
        margin-top: 0.25rem;
    }
    .mt-10 {
        margin-top: 2.5rem;
    }
    .mt-2 {
        margin-top: 0.5rem;
    }
    .mt-4 {
        margin-top: 1rem;
    }
    .mt-5 {
        margin-top: 1.25rem;
    }
    .mt-\[175px\] {
        margin-top: 175px;
    }
    .mt-\[180px\] {
        margin-top: 180px;
    }
    .mt-\[31px\] {
        margin-top: 31px;
    }
    .flex {
        display: flex;
    }
    .grid {
        display: grid;
    }
    .\!h-0 {
        height: 0px !important;
    }
    .h-10 {
        height: 2.5rem;
    }
    .h-16 {
        height: 4rem;
    }
    .h-40 {
        height: 10rem;
    }
    .h-5 {
        height: 1.25rem;
    }
    .h-8 {
        height: 2rem;
    }
    .h-\[100vh\] {
        height: 100vh;
    }
    .h-\[35px\] {
        height: 35px;
    }
    .h-\[890px\] {
        height: 890px;
    }
    .h-full {
        height: 100%;
    }
    .\!w-0 {
        width: 0px !important;
    }
    .\!w-\[130px\] {
        width: 130px !important;
    }
    .\!w-\[140px\] {
        width: 140px !important;
    }
    .\!w-full {
        width: 100% !important;
    }
    .w-0 {
        width: 0px;
    }
    .w-10 {
        width: 2.5rem;
    }
    .w-2\/4 {
        width: 50%;
    }
    .w-36 {
        width: 9rem;
    }
    .w-4 {
        width: 1rem;
    }
    .w-\[1000px\] {
        width: 1000px;
    }
    .w-\[1024px\] {
        width: 1024px;
    }
    .w-\[130px\] {
        width: 130px;
    }
    .w-\[134px\] {
        width: 134px;
    }
    .w-\[140px\] {
        width: 140px;
    }
    .w-\[150px\] {
        width: 150px;
    }
    .w-\[178px\] {
        width: 178px;
    }
    .w-\[221px\] {
        width: 221px;
    }
    .w-\[230px\] {
        width: 230px;
    }
    .w-\[27\.80px\] {
        width: 27.8px;
    }
    .w-\[28\.30px\] {
        width: 28.3px;
    }
    .w-\[29\.80px\] {
        width: 29.8px;
    }
    .w-\[30rem\] {
        width: 30rem;
    }
    .w-\[46\%\] {
        width: 46%;
    }
    .w-\[512px\] {
        width: 512px;
    }
    .w-\[660px\] {
        width: 660px;
    }
    .w-fit {
        width: -moz-fit-content;
        width: fit-content;
    }
    .w-full {
        width: 100%;
    }
    .\!max-w-\[130px\] {
        max-width: 130px !important;
    }
    .\!max-w-\[140px\] {
        max-width: 140px !important;
    }
    .-translate-x-20 {
        --tw-translate-x: -5rem;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }
    .-translate-x-\[15px\] {
        --tw-translate-x: -15px;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }
    .-translate-y-40 {
        --tw-translate-y: -10rem;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }
    .-translate-y-\[42px\] {
        --tw-translate-y: -42px;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }
    .translate-x-\[10px\] {
        --tw-translate-x: 10px;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }
    .translate-y-\[45px\] {
        --tw-translate-y: 45px;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    .flex-row {
        flex-direction: row;
    }
    .flex-col {
        flex-direction: column;
    }
    .items-center {
        align-items: center;
    }
    .justify-start {
        justify-content: flex-start;
    }
    .justify-end {
        justify-content: flex-end;
    }
    .justify-center {
        justify-content: center;
    }
    .justify-between {
        justify-content: space-between;
    }
    .gap-1 {
        gap: 0.25rem;
    }
    .gap-10 {
        gap: 2.5rem;
    }
    .gap-2 {
        gap: 0.5rem;
    }
    .gap-3 {
        gap: 0.75rem;
    }
    .gap-4 {
        gap: 1rem;
    }
    .gap-5 {
        gap: 1.25rem;
    }
    .gap-6 {
        gap: 1.5rem;
    }
    .gap-7 {
        gap: 1.75rem;
    }
    .gap-\[26px\] {
        gap: 26px;
    }
    .gap-\[2px\] {
        gap: 2px;
    }
    .gap-\[70px\] {
        gap: 70px;
    }
    .\!overflow-hidden {
        overflow: hidden !important;
    }
    .overflow-hidden {
        overflow: hidden;
    }
    .rounded-lg {
        border-radius: 0.5rem;
    }
    .rounded-md {
        border-radius: 0.375rem;
    }
    .rounded-sm {
        border-radius: 0.125rem;
    }
    .border {
        border-width: 1px;
    }
    .border-r {
        border-right-width: 1px;
    }
    .border-black {
        --tw-border-opacity: 1;
        border-color: rgb(0 0 0 / var(--tw-border-opacity));
    }
    .\!bg-\[\#3B76BC\] {
        --tw-bg-opacity: 1 !important;
        background-color: rgb(59 118 188 / var(--tw-bg-opacity)) !important;
    }
    .\!bg-pink-600 {
        --tw-bg-opacity: 1 !important;
        background-color: rgb(219 39 119 / var(--tw-bg-opacity)) !important;
    }
    .bg-\[\#0B0189\] {
        --tw-bg-opacity: 1;
        background-color: rgb(11 1 137 / var(--tw-bg-opacity));
    }
    .bg-\[\#3B76BC\] {
        --tw-bg-opacity: 1;
        background-color: rgb(59 118 188 / var(--tw-bg-opacity));
    }
    .bg-black {
        --tw-bg-opacity: 1;
        background-color: rgb(0 0 0 / var(--tw-bg-opacity));
    }
    .bg-purple-500 {
        --tw-bg-opacity: 1;
        background-color: rgb(168 85 247 / var(--tw-bg-opacity));
    }
    .bg-purple-700 {
        --tw-bg-opacity: 1;
        background-color: rgb(126 34 206 / var(--tw-bg-opacity));
    }
    .bg-slate-50 {
        --tw-bg-opacity: 1;
        background-color: rgb(248 250 252 / var(--tw-bg-opacity));
    }
    .bg-slate-900 {
        --tw-bg-opacity: 1;
        background-color: rgb(15 23 42 / var(--tw-bg-opacity));
    }
    .bg-white {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }
    .bg-cover {
        background-size: cover;
    }
    .bg-no-repeat {
        background-repeat: no-repeat;
    }
    .object-cover {
        object-fit: cover;
    }
    .p-10 {
        padding: 2.5rem;
    }
    .p-2 {
        padding: 0.5rem;
    }
    .p-3 {
        padding: 0.75rem;
    }
    .p-5 {
        padding: 1.25rem;
    }
    .px-10 {
        padding-left: 2.5rem;
        padding-right: 2.5rem;
    }
    .px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .px-5 {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
    .px-\[2px\] {
        padding-left: 2px;
        padding-right: 2px;
    }
    .py-1 {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }
    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    .pl-\[9px\] {
        padding-left: 9px;
    }
    .pr-\[27px\] {
        padding-right: 27px;
    }
    .pr-\[60px\] {
        padding-right: 60px;
    }
    .pr-\[7px\] {
        padding-right: 7px;
    }
    .text-left {
        text-align: left;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .\!font-bangla {
        font-family: BANGLA !important;
    }
    .\!font-lcallig {
        font-family: LCALLIG !important;
    }
    .\!font-mono {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
    }
    .\!font-nikosh {
        font-family: NIKOSH !important;
    }
    .\!text-\[11\.50px\] {
        font-size: 11.5px !important;
    }
    .\!text-\[11\.5px\] {
        font-size: 11.5px !important;
    }
    .\!text-\[12\.50px\] {
        font-size: 12.5px !important;
    }
    .\!text-\[13px\] {
        font-size: 13px !important;
    }
    .\!text-\[14px\] {
        font-size: 14px !important;
    }
    .\!text-\[15\.50px\] {
        font-size: 15.5px !important;
    }
    .\!text-\[16\.50px\] {
        font-size: 16.5px !important;
    }
    .\!text-\[17\.50px\] {
        font-size: 17.5px !important;
    }
    .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    .text-\[11\.50px\] {
        font-size: 11.5px;
    }
    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }
    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }
    .\!font-bold {
        font-weight: 700 !important;
    }
    .\!font-extrabold {
        font-weight: 800 !important;
    }
    .font-bold {
        font-weight: 700;
    }
    .font-medium {
        font-weight: 500;
    }
    .font-semibold {
        font-weight: 600;
    }
    .capitalize {
        text-transform: capitalize;
    }
    .\!text-white {
        --tw-text-opacity: 1 !important;
        color: rgb(255 255 255 / var(--tw-text-opacity)) !important;
    }
    .text-black {
        --tw-text-opacity: 1;
        color: rgb(0 0 0 / var(--tw-text-opacity));
    }
    .text-purple-600 {
        --tw-text-opacity: 1;
        color: rgb(147 51 234 / var(--tw-text-opacity));
    }
    .text-red-600 {
        --tw-text-opacity: 1;
        color: rgb(220 38 38 / var(--tw-text-opacity));
    }
    .text-white {
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }
    .opacity-0 {
        opacity: 0;
    }
    .opacity-100 {
        opacity: 1;
    }
    .opacity-20 {
        opacity: 0.2;
    }
    .shadow-lg {
        --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }
    .shadow-xl {
        --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }
    .outline-none {
        outline: 2px solid transparent;
        outline-offset: 2px;
    }
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
    .duration-200 {
        transition-duration: 200ms;
    }
    .ease-in-out {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    code {
        font-family: source-code-pro, Menlo, Monaco, Consolas, "Courier New", monospace;
    }

    .before\:absolute::before {
        content: var(--tw-content);
        position: absolute;
    }

    .before\:-right-\[15px\]::before {
        content: var(--tw-content);
        right: -15px;
    }

    .before\:-top-\[15px\]::before {
        content: var(--tw-content);
        top: -15px;
    }

    .before\:h-\[920px\]::before {
        content: var(--tw-content);
        height: 920px;
    }

    .before\:w-\[687px\]::before {
        content: var(--tw-content);
        width: 687px;
    }

    .before\:rounded-sm::before {
        content: var(--tw-content);
        border-radius: 0.125rem;
    }

    .before\:border-\[2px\]::before {
        content: var(--tw-content);
        border-width: 2px;
    }

    .before\:border-black::before {
        content: var(--tw-content);
        --tw-border-opacity: 1;
        border-color: rgb(0 0 0 / var(--tw-border-opacity));
    }

    .before\:content-\[\'\'\]::before {
        --tw-content: "";
        content: var(--tw-content);
    }

    .after\:absolute::after {
        content: var(--tw-content);
        position: absolute;
    }

    .after\:right-0::after {
        content: var(--tw-content);
        right: 0px;
    }

    .after\:top-0::after {
        content: var(--tw-content);
        top: 0px;
    }

    .after\:h-full::after {
        content: var(--tw-content);
        height: 100%;
    }

    .after\:w-full::after {
        content: var(--tw-content);
        width: 100%;
    }

    .after\:rounded-sm::after {
        content: var(--tw-content);
        border-radius: 0.125rem;
    }

    .after\:border-\[1\.9px\]::after {
        content: var(--tw-content);
        border-width: 1.9px;
    }

    .after\:border-black::after {
        content: var(--tw-content);
        --tw-border-opacity: 1;
        border-color: rgb(0 0 0 / var(--tw-border-opacity));
    }

    .after\:content-\[\'\'\]::after {
        --tw-content: "";
        content: var(--tw-content);
    }

    .last\:border-none:last-child {
        border-style: none;
    }

    .hover\:bg-purple-800:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(107 33 168 / var(--tw-bg-opacity));
    }

    .hover\:\!text-gray-700:hover {
        --tw-text-opacity: 1 !important;
        color: rgb(55 65 81 / var(--tw-text-opacity)) !important;
    }

    .hover\:text-gray-700:hover {
        --tw-text-opacity: 1;
        color: rgb(55 65 81 / var(--tw-text-opacity));
    }

    .disabled\:bg-slate-400:disabled {
        --tw-bg-opacity: 1;
        background-color: rgb(148 163 184 / var(--tw-bg-opacity));
    }
</style>