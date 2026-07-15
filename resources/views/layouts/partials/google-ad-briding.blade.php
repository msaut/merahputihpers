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
    $enable = config('services.adsense.enable', env('ADSENSE_ENABLE', false));
    $client = config('services.adsense.client', env('ADSENSE_CLIENT'));
    $slot = config('services.adsense.slot', env('ADSENSE_SLOT'));

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

    {{-- Load script once (async) -- keep it here so include remains "self contained".
         AdSense will ignore duplicate loads in most cases, but this is still best-effort. --}}
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adClient }}" crossorigin="anonymous"></script>
@endif

