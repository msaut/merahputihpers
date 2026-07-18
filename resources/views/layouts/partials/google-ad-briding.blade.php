@php
    /**
     * Google AdSense "bridging" helper (async).
     *
     * Config sources (can be set via .env):
     * - services.adsense.client
     * - services.adsense.slot
     * - services.adsense.enable
     *
     * Fallbacks:
     * - ADSENSE_CLIENT, ADSENSE_SLOT, ADSENSE_ENABLE
     */
    $enable = config('services.adsense.enable', env('ADSENSE_ENABLE', true));
    $client = config('services.adsense.client', env('ADSENSE_CLIENT', 'ca-pub-3497744917263603'));
    $slot = config('services.adsense.slot', env('ADSENSE_SLOT', '1234567890'));

    // Allow override per include
    $adClient = $adClient ?? $client;
    $adSlot = $adSlot ?? $slot;

    // Ad dimensions: default responsive-ish. For AdSense, 'data-ad-format="auto"' usually works.
    $adFormat = $adFormat ?? 'auto';

@endphp

@if($enable && !empty($adClient) && !empty($adSlot))
    {{-- Auto ad wrapper -- can be placed inside sidebar/top/bottom --}}
    <div class="google-adsense google-adsense--sidebar my-3" aria-label="Iklan Google">
        <ins
            class="adsbygoogle"
            style="display:block"
            data-ad-client="{{ $adClient }}"
            data-ad-slot="{{ $adSlot }}"
            data-ad-format="{{ $adFormat }}"
            data-full-width-responsive="true"
        ></ins>

        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    {{-- Load script once (async). Per AdSense docs, this should be before rendering <ins>. --}}
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adClient }}" crossorigin="anonymous"></script>

@endif

